<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMensajeRequest;
use App\Http\Requests\UpdateAdminPerfilRequest;
use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Mensaje;
use App\Models\Profesional;
use App\Models\Resena;
use App\Models\ResenaCliente;
use App\Models\ServicioAdquirido;
use App\Models\User;
use App\Services\NotificacionService;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function index()
    {
        $stats = [
            'clientes' => ['valor' => User::where('tipo_usuario', 'cliente')->count(), 'url' => '/panel/admin/clientes'],
            'usuarios' => ['valor' => User::count(), 'url' => '/panel/admin/usuarios'],
            'profesionales' => ['valor' => Profesional::count(), 'url' => '/panel/admin/profesionales'],
            'reseñas' => ['valor' => Resena::count(), 'url' => '/panel/admin/resenas'],
            'advertencias' => ['valor' => Mensaje::where('tipo', 'advertencia')->count(), 'url' => '/panel/admin/advertencias'],
            'bloqueados' => ['valor' => User::where('bloqueado', true)->count(), 'url' => '/panel/admin/usuarios?filtro=bloqueados'],
        ];

        $profesionales = Profesional::with('categoria', 'user')->orderByDesc('calificacion')->take(8)->get();
        $resenas = Resena::with(['user', 'profesional.categoria'])->latest()->take(5)->get();
        $contactos = Contacto::with('profesional')->latest()->take(5)->get();
        $advertenciasRecientes = Mensaje::with(['remitente', 'destinatario'])
            ->where('tipo', 'advertencia')
            ->latest()
            ->take(5)
            ->get();
        $usuariosBloqueados = User::with('profesional')->where('bloqueado', true)->orderBy('name')->take(5)->get();
        $pagosRecientes = ServicioAdquirido::with(['cliente', 'profesional'])
            ->where('profesional_confirmo_cobro', true)
            ->latest('fecha_cobro')
            ->take(5)
            ->get();

        return view('panel.admin.index', compact(
            'stats', 'profesionales', 'resenas', 'contactos',
            'advertenciasRecientes', 'usuariosBloqueados', 'pagosRecientes'
        ));
    }

    public function profesionales(Request $request)
    {
        $query = Profesional::with('categoria', 'user')->orderBy('nombre');

        if ($request->filled('categoria')) {
            $query->whereHas('categoria', fn ($q) => $q->where('nombre_categoria', $request->categoria));
        }

        $profesionales = $query->get();
        $categorias = Categoria::orderBy('nombre_categoria')->get();

        return view('panel.admin.profesionales', compact('profesionales', 'categorias'));
    }

    public function showProfesional(int $id)
    {
        $profesional = Profesional::with([
            'categoria',
            'user',
            'resenas' => fn ($q) => $q->with('user')->latest(),
        ])->findOrFail($id);

        return view('panel.admin.profesional-show', compact('profesional'));
    }

    public function categorias()
    {
        $categorias = Categoria::with(['profesionales' => fn ($q) => $q->orderByDesc('calificacion')])->get();

        return view('panel.admin.categorias', compact('categorias'));
    }

    public function resenas()
    {
        $resenas = Resena::with(['user', 'profesional.categoria'])->latest()->get();

        return view('panel.admin.resenas', compact('resenas'));
    }

    public function usuarios(Request $request)
    {
        $query = User::with(['profesional', 'serviciosAdquiridos.profesional'])->orderBy('tipo_usuario')->orderBy('name');

        if ($request->filtro === 'bloqueados') {
            $query->where('bloqueado', true);
        }

        $usuarios = $query->get();

        return view('panel.admin.usuarios', compact('usuarios'));
    }

    public function clientes()
    {
        $clientes = User::where('tipo_usuario', 'cliente')
            ->with(['serviciosAdquiridos.profesional', 'advertenciasRecibidas' => fn ($q) => $q->latest()])
            ->orderBy('name')
            ->get();
        $profesionales = Profesional::orderBy('nombre')->get();

        return view('panel.admin.clientes', compact('clientes', 'profesionales'));
    }

    public function reportes()
    {
        $resumen = [
            'total_usuarios' => ['valor' => User::count(), 'url' => '/panel/admin/usuarios'],
            'clientes' => ['valor' => User::where('tipo_usuario', 'cliente')->count(), 'url' => '/panel/admin/clientes'],
            'profesionales' => ['valor' => Profesional::count(), 'url' => '/panel/admin/profesionales'],
            'reseñas' => ['valor' => Resena::count(), 'url' => '/panel/admin/resenas'],
            'mensajes' => ['valor' => Mensaje::count(), 'url' => '/panel/admin/mensajes'],
            'advertencias' => ['valor' => Mensaje::where('tipo', 'advertencia')->count(), 'url' => '/panel/admin/advertencias'],
            'bloqueados' => ['valor' => User::where('bloqueado', true)->count(), 'url' => '/panel/admin/usuarios?filtro=bloqueados'],
        ];

        $porCategoria = Profesional::with('categoria')
            ->get()
            ->groupBy(fn ($p) => $p->categoria->nombre_categoria ?? 'Sin categoría')
            ->map->count()
            ->sortDesc();

        $porZona = Profesional::whereNotNull('zona')
            ->selectRaw('zona, count(*) as total')
            ->groupBy('zona')
            ->pluck('total', 'zona')
            ->sortDesc();

        $maxCategoria = $porCategoria->max() ?: 1;
        $maxZona = $porZona->max() ?: 1;

        $pagos = [
            'pagados' => ServicioAdquirido::where('estado_pago', 'pagado')->count(),
            'pendientes' => ServicioAdquirido::where('estado_pago', 'pendiente')->where('verificado', true)->count(),
            'total_monto' => ServicioAdquirido::where('estado_pago', 'pagado')->sum('monto_pagado'),
        ];

        $topProfesionales = Profesional::with('categoria')
            ->withCount('resenas')
            ->orderByDesc('calificacion')
            ->take(10)
            ->get();

        return view('panel.admin.reportes', compact(
            'resumen', 'porCategoria', 'porZona', 'maxCategoria', 'maxZona', 'pagos', 'topProfesionales'
        ));
    }

    public function showCliente(int $id)
    {
        $cliente = User::where('tipo_usuario', 'cliente')
            ->with([
                'serviciosAdquiridos.profesional.categoria',
                'advertenciasRecibidas' => fn ($q) => $q->with('remitente')->latest(),
                'resenas.profesional',
            ])
            ->findOrFail($id);

        return view('panel.admin.cliente-show', compact('cliente'));
    }

    public function advertencias()
    {
        $advertencias = Mensaje::with(['remitente', 'destinatario.profesional', 'profesional'])
            ->where('tipo', 'advertencia')
            ->latest()
            ->get();

        return view('panel.admin.advertencias', compact('advertencias'));
    }

    public function pagos()
    {
        $pagos = ServicioAdquirido::with(['cliente', 'profesional.categoria'])
            ->where('estado_solicitud', 'aceptada')
            ->orderByDesc('updated_at')
            ->get();

        return view('panel.admin.pagos', compact('pagos'));
    }

    public function toggleBloqueo(int $id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->isAdmin()) {
            return back()->withErrors(['error' => 'No se puede bloquear al administrador.']);
        }

        $usuario->update(['bloqueado' => ! $usuario->bloqueado]);

        $estado = $usuario->bloqueado ? 'bloqueado' : 'desbloqueado';

        return back()->with('success', "Usuario {$estado} correctamente.");
    }

    public function contactos()
    {
        $contactos = Contacto::with(['profesional.categoria', 'user'])->latest()->get();

        return view('panel.admin.contactos', compact('contactos'));
    }

    public function mensajes()
    {
        $user = auth()->user();
        $mensajes = Mensaje::with(['remitente', 'destinatario', 'profesional'])
            ->where(function ($q) use ($user) {
                $q->where('remitente_id', $user->id)->orWhere('destinatario_id', $user->id);
            })
            ->latest()
            ->get();

        return view('panel.admin.mensajes', compact('mensajes'));
    }

    public function enviarAdvertencia(StoreMensajeRequest $request)
    {
        $destinatario = User::findOrFail($request->destinatario_id);

        Mensaje::create([
            'remitente_id' => auth()->id(),
            'destinatario_id' => $destinatario->id,
            'profesional_id' => $request->profesional_id,
            'asunto' => $request->asunto,
            'cuerpo' => $request->cuerpo,
            'tipo' => 'advertencia',
        ]);

        NotificacionService::enviar(
            $destinatario,
            'Advertencia de SFM: '.$request->asunto,
            $request->cuerpo
        );

        return back()->with('success', 'Advertencia enviada correctamente.');
    }

    public function verificarServicio(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'profesional_id' => 'required|exists:profesionales,id',
            'notas' => 'nullable|string|max:500',
        ]);

        ServicioAdquirido::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'profesional_id' => $request->profesional_id,
            ],
            [
                'verificado' => true,
                'verificado_por' => auth()->id(),
                'notas' => $request->notas,
            ]
        );

        return back()->with('success', 'Servicio verificado. El cliente ya puede dejar reseña.');
    }

    public function revocarServicio(int $id)
    {
        ServicioAdquirido::findOrFail($id)->update(['verificado' => false]);

        return back()->with('success', 'Verificación de servicio revocada.');
    }

    public function destroyUsuario(int $id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->isAdmin()) {
            return back()->withErrors(['error' => 'No se puede eliminar al administrador.']);
        }

        $usuario->delete();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }

    public function destroyProfesional(int $id)
    {
        Profesional::findOrFail($id)->delete();

        return back()->with('success', 'Profesional eliminado correctamente.');
    }

    public function destroyResena(int $id)
    {
        $resena = Resena::findOrFail($id);
        $profesional = $resena->profesional;
        $resena->delete();
        $profesional?->actualizarCalificacion();

        return back()->with('success', 'Reseña eliminada.');
    }

    public function perfil()
    {
        return view('panel.admin.perfil', ['user' => auth()->user()]);
    }

    public function updatePerfil(UpdateAdminPerfilRequest $request)
    {
        $user = auth()->user();
        $data = ['name' => $request->name];

        if ($request->hasFile('foto_archivo')) {
            $data['foto'] = $request->file('foto_archivo')->store('fotos', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Perfil de administrador actualizado.');
    }
}
