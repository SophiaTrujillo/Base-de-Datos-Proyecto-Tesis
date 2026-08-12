<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{
    // Mostrar todos los eventos
    public function index()
    {
        $eventos = Evento::with([
            'usuario:id,nombres,apellidos,correo,fotografia'
        ])->get();

        return response()->json($eventos);
    }

    // Crear un evento
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'imagen' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
        ]);

        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'imagen' => $request->imagen,
            'usuario_id' => $request->usuario_id,
        ]);

        return response()->json([
            'mensaje' => 'Evento creado correctamente.',
            'evento' => $evento->load('usuario')
        ], 201);
    }

    // Mostrar un evento
    public function show(string $id)
    {
        $evento = Evento::with([
            'usuario:id,nombres,apellidos,correo,fotografia'
        ])->find($id);

        if (!$evento) {
            return response()->json([
                'mensaje' => 'Evento no encontrado.'
            ], 404);
        }

        return response()->json($evento);
    }

    // Actualizar un evento
    public function update(Request $request, string $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json([
                'mensaje' => 'Evento no encontrado.'
            ], 404);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'imagen' => 'nullable|string',
        ]);

        $evento->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'imagen' => $request->imagen,
        ]);

        return response()->json([
            'mensaje' => 'Evento actualizado correctamente.',
            'evento' => $evento->load('usuario')
        ]);
    }

    // Eliminar un evento
    public function destroy(string $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json([
                'mensaje' => 'Evento no encontrado.'
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'mensaje' => 'Evento eliminado correctamente.'
        ]);
    }
}