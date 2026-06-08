<?php



namespace App\Http\Controllers;



use App\Http\Requests\PanelResenaRequest;

use App\Http\Requests\StoreMensajeRequest;

use App\Http\Requests\UpdateClientePerfilRequest;

use App\Models\Categoria;

use App\Models\Contacto;

use App\Models\Mensaje;

use App\Models\Profesional;

use App\Models\Resena;

use App\Models\ServicioAdquirido;

use App\Models\User;

use App\Services\NotificacionService;

use Illuminate\Http\Request;



class ClientePanelController extends Controller

{

    public function index()

    {

        $user = auth()->user();

        $misResenas = Resena::with('profesional.categoria')

            ->where('user_id', $user->id)

            ->latest()

            ->get();



        $profesionalesDestacados = Profesional::with('categoria')

            ->enSanMiguel()

            ->orderByDesc('calificacion')

            ->take(6)

            ->get();



        $mensajesNoLeidos = Mensaje::where('destinatario_id', $user->id)->where('leido', false)->count();



        return view('panel.cliente.index', compact('misResenas', 'profesionalesDestacados', 'mensajesNoLeidos'));

    }



    public function profesionales(Request $request)

    {

        $query = Profesional::with('categoria')->enSanMiguel()->orderByDesc('calificacion');



        if ($request->filled('categoria')) {

            $query->whereHas('categoria', fn ($q) => $q->where('nombre_categoria', $request->categoria));

        }



        if ($request->filled('buscar')) {

            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {

                $q->where('nombre', 'like', "%{$buscar}%")

                    ->orWhere('especialidad', 'like', "%{$buscar}%");

            });

        }



        $profesionales = $query->get();

        $categorias = Categoria::orderBy('nombre_categoria')->pluck('nombre_categoria');



        return view('panel.cliente.profesionales', compact('profesionales', 'categorias'));

    }



    public function categorias()

    {

        $categorias = Categoria::with(['profesionales' => fn ($q) => $q->enSanMiguel()->orderByDesc('calificacion')])->get();



        return view('panel.cliente.categorias', compact('categorias'));

    }



    public function contacto(Request $request)

    {

        $query = $request->profesional ? '?profesional='.$request->profesional : '';



        return redirect('/panel/cliente/mensajes'.$query);

    }



    public function resenas()

    {

        $user = auth()->user();

        $profesionales = Profesional::with('categoria')->enSanMiguel()->orderBy('nombre')->get();

        $misResenas = Resena::with('profesional.categoria')->where('user_id', $user->id)->latest()->get();

        $verificados = $profesionales
            ->filter(fn ($p) => $user->puedeResenarProfesional($p->id))
            ->pluck('id')
            ->toArray();

        $servicios = $user->serviciosAdquiridos()
            ->with('profesional.categoria')
            ->where('estado_solicitud', 'aceptada')
            ->orderByDesc('updated_at')
            ->get();



        return view('panel.cliente.resenas', compact('profesionales', 'misResenas', 'verificados', 'servicios'));

    }



    public function storeResena(PanelResenaRequest $request)

    {

        $user = auth()->user();



        if (! $user->puedeResenarProfesional((int) $request->profesional_id)) {

            return back()->withErrors([

                'profesional_id' => 'Solo puedes reseñar cuando el profesional confirme el cobro o tengas historial pagado con él.',

            ]);

        }



        Resena::create([

            'user_id' => $user->id,

            'profesional_id' => $request->profesional_id,

            'calificacion' => $request->calificacion,

            'comentario' => $request->comentario,

        ]);



        $prof = Profesional::with('user')->find($request->profesional_id);

        $prof?->actualizarCalificacion();

        if ($prof?->user) {
            NotificacionService::enviar(
                $prof->user,
                'Nueva reseña en tu perfil',
                "{$user->name} publicó una reseña de {$request->calificacion} estrellas."
            );
        }



        return back()->with('success', 'Reseña publicada correctamente.');

    }



    public function destroyResena(int $id)

    {

        $resena = Resena::where('user_id', auth()->id())->findOrFail($id);

        $profesional = $resena->profesional;

        $resena->delete();

        $profesional?->actualizarCalificacion();



        return back()->with('success', 'Reseña eliminada.');

    }



    public function mensajes(Request $request)

    {

        $user = auth()->user();



        $mensajesNoLeidos = Mensaje::where('destinatario_id', $user->id)->where('leido', false)->count();



        $mensajes = Mensaje::with(['remitente', 'destinatario', 'profesional'])

            ->where(function ($q) use ($user) {

                $q->where('remitente_id', $user->id)->orWhere('destinatario_id', $user->id);

            })

            ->latest()

            ->get();



        Mensaje::where('destinatario_id', $user->id)->where('leido', false)->update(['leido' => true]);



        $profesionales = Profesional::with('categoria')->enSanMiguel()->whereNotNull('user_id')->orderBy('nombre')->get();

        $profesionalId = $request->get('profesional');

        $conversaciones = Mensaje::agruparConversaciones($mensajes, $user->id);

        $serviciosPorConversacion = collect();
        foreach ($conversaciones as $conv) {
            if ($conv['profesional_id']) {
                $serviciosPorConversacion[$conv['clave']] = ServicioAdquirido::paraConversacion(
                    $user->id,
                    $conv['profesional_id']
                );
            }
        }

        return view('panel.cliente.mensajes', compact(
            'conversaciones', 'profesionales', 'profesionalId', 'mensajesNoLeidos', 'serviciosPorConversacion'
        ));

    }



    public function storeMensaje(StoreMensajeRequest $request)

    {

        $user = auth()->user();

        $destinatarioId = $request->destinatario_id;

        $profesionalId = $request->profesional_id;

        $tipo = 'normal';



        if ($request->profesional_id && str_starts_with(trim($request->asunto ?? ''), 'Re:')) {
            $profesional = Profesional::findOrFail($request->profesional_id);
            $servicio = ServicioAdquirido::paraConversacion($user->id, $profesional->id);

            if (! $servicio || ! $servicio->permiteChat()) {
                $motivo = $servicio?->estado_solicitud === 'denegada'
                    ? 'Tu solicitud fue rechazada. Envía una nueva solicitud de servicio para contactar al profesional.'
                    : 'Debes esperar a que el profesional acepte tu solicitud antes de continuar el chat.';

                return back()->withErrors(['cuerpo' => $motivo]);
            }
        }

        if ($request->profesional_id && ! str_starts_with(trim($request->asunto ?? ''), 'Re:')) {

            $profesional = Profesional::with('user')->findOrFail($request->profesional_id);

            $servicioExistente = ServicioAdquirido::paraConversacion($user->id, $profesional->id);
            if ($servicioExistente?->estado_solicitud === 'pendiente') {
                return back()->withErrors(['cuerpo' => 'Ya tienes una solicitud pendiente con este profesional. Espera su respuesta.']);
            }



            if (! $profesional->user_id) {

                return back()->withErrors(['profesional_id' => 'Este profesional no tiene cuenta para recibir mensajes.']);

            }



            $destinatarioId = $profesional->user_id;

            $profesionalId = $profesional->id;

            $tipo = 'solicitud';



            Contacto::create([

                'user_id' => $user->id,

                'profesional_id' => $profesional->id,

                'nombre' => $user->name,

                'correo' => $user->email,

                'mensaje' => $request->cuerpo,

            ]);

        }



        $mensaje = Mensaje::create([

            'remitente_id' => $user->id,

            'destinatario_id' => $destinatarioId,

            'profesional_id' => $profesionalId,

            'asunto' => $request->asunto ?: ($tipo === 'solicitud' ? 'Solicitud de servicio — '.$user->name : 'Mensaje'),

            'cuerpo' => $request->cuerpo,

            'tipo' => $tipo,

        ]);



        if ($tipo === 'solicitud' && $profesionalId) {
            ServicioAdquirido::updateOrCreate(
                ['user_id' => $user->id, 'profesional_id' => $profesionalId],
                [
                    'estado_solicitud' => 'pendiente',
                    'verificado' => false,
                    'verificado_por' => null,
                    'mensaje_id' => $mensaje->id,
                    'estado_pago' => 'pendiente',
                    'notas' => 'Solicitud enviada por mensajería',
                ]
            );
        }



        if ($destinatario = User::find($destinatarioId)) {
            NotificacionService::enviar(
                $destinatario,
                'Nuevo mensaje en SFM',
                "De: {$user->name}\n\n{$request->cuerpo}"
            );
        }



        return back()->with('success', 'Mensaje enviado correctamente.');

    }

    public function destroyMensaje(int $id)
    {
        $mensaje = Mensaje::findOrFail($id);
        $userId = auth()->id();

        if ($mensaje->remitente_id !== $userId && $mensaje->destinatario_id !== $userId) {
            abort(403, 'No puedes eliminar este mensaje.');
        }

        if ($mensaje->tipo === 'advertencia') {
            return back()->withErrors(['error' => 'No puedes eliminar advertencias del administrador.']);
        }

        $mensaje->delete();

        return back()->with('success', 'Mensaje eliminado.');
    }

    public function perfil()

    {

        return view('panel.cliente.perfil', ['user' => auth()->user()]);

    }



    public function updatePerfil(UpdateClientePerfilRequest $request)

    {

        $user = auth()->user();

        $data = $request->validated();



        if ($request->hasFile('foto_archivo')) {

            $data['foto'] = $request->file('foto_archivo')->store('fotos', 'public');

        }



        unset($data['foto_archivo']);

        $user->update($data);



        return back()->with('success', 'Perfil actualizado.');

    }

}


