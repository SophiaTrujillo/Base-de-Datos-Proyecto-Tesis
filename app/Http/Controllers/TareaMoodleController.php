<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TareaMoodle;

class TareaMoodleController extends Controller
{
    // Mostrar tareas
    public function index()
    {
        $tareas = TareaMoodle::where('estado', true)->get();

        return response()->json($tareas);
    }

    // Crear tarea
    public function store(Request $request)
    {
        $request->validate([
            'curso' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_entrega' => 'required|date',
            'enlace_moodle' => 'required|url',
            'estado' => 'nullable|boolean',
        ]);

        $tarea = TareaMoodle::create([
            'curso' => $request->curso,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
            'enlace_moodle' => $request->enlace_moodle,
            'estado' => $request->estado ?? true,
        ]);

        return response()->json([
            'mensaje' => 'Tarea creada correctamente.',
            'tarea' => $tarea
        ], 201);
    }

    // Mostrar una tarea
    public function show(string $id)
    {
        $tarea = TareaMoodle::find($id);

        if (!$tarea) {
            return response()->json([
                'mensaje' => 'Tarea no encontrada.'
            ], 404);
        }

        return response()->json($tarea);
    }

    // Actualizar tarea
    public function update(Request $request, string $id)
    {
        $tarea = TareaMoodle::find($id);

        if (!$tarea) {
            return response()->json([
                'mensaje' => 'Tarea no encontrada.'
            ], 404);
        }

        $request->validate([
            'curso' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_entrega' => 'required|date',
            'enlace_moodle' => 'required|url',
            'estado' => 'nullable|boolean',
        ]);

        $tarea->update([
            'curso' => $request->curso,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_entrega' => $request->fecha_entrega,
            'enlace_moodle' => $request->enlace_moodle,
            'estado' => $request->estado ?? $tarea->estado,
        ]);

        return response()->json([
            'mensaje' => 'Tarea actualizada correctamente.',
            'tarea' => $tarea
        ]);
    }

    // Eliminar tarea
    public function destroy(string $id)
    {
        $tarea = TareaMoodle::find($id);

        if (!$tarea) {
            return response()->json([
                'mensaje' => 'Tarea no encontrada.'
            ], 404);
        }

        $tarea->delete();

        return response()->json([
            'mensaje' => 'Tarea eliminada correctamente.'
        ]);
    }
}