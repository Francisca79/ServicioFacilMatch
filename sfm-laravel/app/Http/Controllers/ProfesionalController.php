<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfesionalRequest;
use App\Models\Categoria;
use App\Models\Profesional;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfesionalController extends Controller
{
    public function index(Request $request)
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

        if ($request->filled('zona')) {
            $query->where('zona', $request->zona);
        }

        $profesionales = $query->get();
        $categorias = Categoria::orderBy('nombre_categoria')->pluck('nombre_categoria');
        $zonas = \App\Support\ZonasSanMiguel::todas();
        $puedeContratar = auth()->check() && auth()->user()->isCliente();

        return view('profesionales.publico', compact('profesionales', 'categorias', 'zonas', 'puedeContratar'));
    }

    public function show(int $id)
    {
        $profesional = Profesional::with(['categoria', 'resenas.user', 'user'])->enSanMiguel()->findOrFail($id);
        $puedeContratar = auth()->check() && auth()->user()->isCliente();
        $esAdmin = auth()->check() && auth()->user()->isAdmin();

        return view('profesionales.show', compact('profesional', 'puedeContratar', 'esAdmin'));
    }

    public function registro()
    {
        $categorias = Categoria::all();

        return view('registro', compact('categorias'));
    }

    public function store(StoreProfesionalRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            $foto = null;
            if ($request->hasFile('foto_archivo')) {
                $foto = $request->file('foto_archivo')->store('fotos', 'public');
            }

            $user = User::create([
                'name' => $request->nombre,
                'email' => $request->correo,
                'password' => $request->contrasena,
                'telefono' => $request->telefono,
                'ciudad' => 'San Miguel',
                'tipo_usuario' => 'profesional',
                'foto' => $foto,
            ]);

            Profesional::create([
                'user_id' => $user->id,
                'nombre' => $request->nombre,
                'especialidad' => $request->especialidad,
                'precio_estimado' => $request->precio_estimado,
                'precio_min' => $request->precio_estimado,
                'precio_max' => $request->precio_estimado * 2,
                'descripcion' => $request->descripcion,
                'categoria_id' => $request->categoria_id,
                'telefono' => $request->telefono,
                'ciudad' => 'San Miguel',
                'experiencia' => $request->experiencia,
                'modalidad' => $request->modalidad,
                'disponibilidad' => $request->disponibilidad,
                'foto' => $foto,
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect('/')->with('success', 'Cuenta profesional creada. ¡Bienvenido a SFM!');
    }

    public function destroy(int $id)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Solo el administrador puede eliminar perfiles.');
        }

        Profesional::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }
}
