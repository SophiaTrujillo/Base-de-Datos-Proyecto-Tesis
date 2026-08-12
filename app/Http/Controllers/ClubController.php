<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;

class ClubController extends Controller
{
    // Mostrar todos los clubes
    public function index()
    {
        $clubes = Club::with([
            'responsable:id,nombres,apellidos,correo,fotografia'
        ])->get();

        return response()->json($clubes);
    }

    // Crear un club
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'responsable_id' => 'required|exists:users,id',
            'estado' => 'nullable|boolean',
        ]);

        $club = Club::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'responsable_id' => $request->responsable_id,
            'estado' => $request->estado ?? true,
        ]);

        return response()->json([
            'mensaje' => 'Club creado correctamente.',
            'club' => $club->load('responsable')
        ], 201);
    }

    // Mostrar un club
    public function show(string $id)
    {
        $club = Club::with([
            'responsable:id,nombres,apellidos,correo,fotografia'
        ])->find($id);

        if (!$club) {
            return response()->json([
                'mensaje' => 'Club no encontrado.'
            ], 404);
        }

        return response()->json($club);
    }

    // Actualizar un club
    public function update(Request $request, string $id)
    {
        $club = Club::find($id);

        if (!$club) {
            return response()->json([
                'mensaje' => 'Club no encontrado.'
            ], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'responsable_id' => 'required|exists:users,id',
            'estado' => 'nullable|boolean',
        ]);

        $club->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'responsable_id' => $request->responsable_id,
            'estado' => $request->estado ?? $club->estado,
        ]);

        return response()->json([
            'mensaje' => 'Club actualizado correctamente.',
            'club' => $club->load('responsable')
        ]);
    }

    // Eliminar un club
    public function destroy(string $id)
    {
        $club = Club::find($id);

        if (!$club) {
            return response()->json([
                'mensaje' => 'Club no encontrado.'
            ], 404);
        }

        $club->delete();

        return response()->json([
            'mensaje' => 'Club eliminado correctamente.'
        ]);
    }
}