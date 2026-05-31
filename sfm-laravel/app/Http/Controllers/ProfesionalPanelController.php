<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMensajeRequest;
use App\Http\Requests\StoreResenaClienteRequest;
use App\Http\Requests\UpdateProfesionalProfileRequest;
use App\Models\Categoria;
use App\Models\Mensaje;
use App\Models\Profesional;
use App\Models\Resena;
use App\Models\ResenaCliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfesionalPanelController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profesional = $user->profesional;

        if (! $profesional) {
            return redirect('/panel/profesional/crear')
                ->with('success', 'Completa tu perfil profesional para empezar.');
        }

        $resenas = Resena::with('user')
            ->where('profesional_id', $profesional->id)
            ->latest()
            ->get();

        $contactosPendientes = $profesional->contactos()->latest()->take(5)->get();
        $mensajesNoLeidos = Mensaje::where('destinatario_id', $user->id)->where('leido', false)->count();

        return view('panel.profesional.index', compact('profesional', 'resenas', 'contactosPendientes', 'mensajesNoLeidos'));
    }

    public function directorio(Request $request)
    {
        $query = Profesional::with('categoria')->enSanMiguel()->orderByDesc('calificacion');

        if ($request->filled('categoria')) {
            $query->whereHas('categoria', fn ($q) => $q->where('nombre_categoria', $request->categoria));
        }

        $profesionales = $query->get();
        $categorias = Categoria::orderBy('nombre_categoria')->pluck('nombre_categoria');

        return view('panel.profesional.directorio', compact('profesionales', 'categorias'));
    }

    public function resenasSistema()
    {
        $resenas = Resena::with(['user', 'profesional.categoria'])->latest()->get();

        return view('panel.profesional.resenas-sistema', compact('resenas'));
    }

    public function resenasClientes()
    {
        $clientes = User::where('tipo_usuario', 'cliente')->orderBy('name')->get();
        $misResenas = ResenaCliente::with('cliente')
            ->where('profesional_user_id', auth()->id())
            ->latest()
            ->get();

        return view('panel.profesional.resenas-clientes', compact('clientes', 'misResenas'));
    }

    public function storeResenaCliente(StoreResenaClienteRequest $request)
    {
        ResenaCliente::updateOrCreate(
            [
                'profesional_user_id' => auth()->id(),
                'cliente_id' => $request->cliente_id,
            ],
            [
                'calificacion' => $request->calificacion,
                'comentario' => $request->comentario,
            ]
        );

        return back()->with('success', 'Reseña sobre el cliente publicada.');
    }

    public function mensajes()
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

        $destinatarios = User::where('tipo_usuario', 'cliente')->orderBy('name')->get();

        return view('panel.profesional.mensajes', compact('mensajes', 'destinatarios', 'mensajesNoLeidos'));
    }

    public function storeMensaje(StoreMensajeRequest $request)
    {
        $profesional = auth()->user()->profesional;

        Mensaje::create([
            'remitente_id' => auth()->id(),
            'destinatario_id' => $request->destinatario_id,
            'profesional_id' => $request->profesional_id ?? $profesional?->id,
            'asunto' => $request->asunto ?: 'Mensaje',
            'cuerpo' => $request->cuerpo,
            'tipo' => 'normal',
        ]);

        return back()->with('success', 'Mensaje enviado.');
    }

    public function destroyMensaje(int $id)
    {
        $mensaje = Mensaje::findOrFail($id);
        $userId = auth()->id();

        if ($mensaje->remitente_id !== $userId && $mensaje->destinatario_id !== $userId) {
            abort(403, 'No puedes eliminar este mensaje.');
        }

        $mensaje->delete();

        return back()->with('success', 'Mensaje eliminado.');
    }

    public function edit()
    {
        $profesional = auth()->user()->profesional;
        $categorias = Categoria::all();

        if (! $profesional) {
            return view('panel.profesional.crear', compact('categorias'));
        }

        return view('panel.profesional.edit', compact('profesional', 'categorias'));
    }

    public function update(UpdateProfesionalProfileRequest $request)
    {
        $data = $request->validated();
        $data['precio_estimado'] = $data['precio_min'];
        $data['ciudad'] = 'San Miguel';

        if ($request->hasFile('foto_archivo')) {
            $path = $request->file('foto_archivo')->store('fotos', 'public');
            $data['foto'] = $path;
            auth()->user()->update(['foto' => $path]);
        }

        unset($data['foto_archivo']);

        $profesional = auth()->user()->profesional;

        if (! $profesional) {
            Profesional::create(array_merge($data, ['user_id' => auth()->id()]));

            if (! empty($data['foto'])) {
                auth()->user()->update(['foto' => $data['foto']]);
            }

            return redirect('/panel/profesional')->with('success', 'Perfil profesional creado.');
        }

        $profesional->update($data);

        return redirect('/panel/profesional')->with('success', 'Perfil actualizado correctamente.');
    }
}
