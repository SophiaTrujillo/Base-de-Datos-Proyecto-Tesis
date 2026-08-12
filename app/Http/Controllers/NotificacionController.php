<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    // Mostrar todas las notificaciones
    public function index()
    {
        $notificaciones = Notificacion::with([
            'usuario:id,nombres,apellidos,correo'
        ])->get();

        return response()->json($notificaciones);
    }

    // Crear una notificación
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo' => 'required|string|max:100',
            'leida' => 'nullable|boolean',
            'fecha' => 'required|date',
        ]);

        $notificacion = Notificacion::create([
            'usuario_id' => $request->usuario_id,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'tipo' => $request->tipo,
            'leida' => $request->leida ?? false,
            'fecha' => $request->fecha,
        ]);

        return response()->json([
            'mensaje' => 'Notificación creada correctamente.',
            'notificacion' => $notificacion->load('usuario')
        ], 201);
    }

    // Mostrar una notificación
    public function show(string $id)
    {
        $notificacion = Notificacion::with('usuario')->find($id);

        if (!$notificacion) {
            return response()->json([
                'mensaje' => 'Notificación no encontrada.'
            ], 404);
        }

        return response()->json($notificacion);
    }

    // Actualizar una notificación
    public function update(Request $request, string $id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {
            return response()->json([
                'mensaje' => 'Notificación no encontrada.'
            ], 404);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tipo' => 'required|string|max:100',
            'leida' => 'nullable|boolean',
            'fecha' => 'required|date',
        ]);

        $notificacion->update([
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'tipo' => $request->tipo,
            'leida' => $request->leida ?? $notificacion->leida,
            'fecha' => $request->fecha,
        ]);

        return response()->json([
            'mensaje' => 'Notificación actualizada correctamente.',
            'notificacion' => $notificacion->load('usuario')
        ]);
    }

    // Eliminar una notificación
    public function destroy(string $id)
    {
        $notificacion = Notificacion::find($id);

        if (!$notificacion) {
            return response()->json([
                'mensaje' => 'Notificación no encontrada.'
            ], 404);
        }

        $notificacion->delete();

        return response()->json([
            'mensaje' => 'Notificación eliminada correctamente.'
        ]);
    }
}