<?php

namespace App\Http\Controllers;

use App\Models\Carnet;
use Illuminate\Http\Request;

class CarnetController extends Controller
{
    // Mostrar todos los carnets
    public function index()
    {
        return Carnet::with([
            'usuario:id,nombres,apellidos,correo,fotografia'
        ])->get();
    }

    // Crear un carnet
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'codigo_estudiante' => 'required|string|unique:carnets,codigo_estudiante',
            'carrera' => 'required|string',
            'nivel' => 'required|string',
            'jornada' => 'required|string',
            'periodo_academico' => 'required|string',
        ]);

        // Verificar que el usuario no tenga ya un carnet
        if (Carnet::where('usuario_id', $request->usuario_id)->exists()) {
            return response()->json([
                'mensaje' => 'Este usuario ya tiene un carnet registrado.'
            ], 409);
        }

        $carnet = Carnet::create([
            'usuario_id' => $request->usuario_id,
            'codigo_estudiante' => $request->codigo_estudiante,
            'carrera' => $request->carrera,
            'nivel' => $request->nivel,
            'jornada' => $request->jornada,
            'periodo_academico' => $request->periodo_academico,
            'qr' => $request->qr,
            'estado' => true,
        ]);

        return response()->json([
            'mensaje' => 'Carnet creado correctamente.',
            'carnet' => $carnet
        ], 201);
    }

    // Mostrar un carnet específico
    public function show($id)
    {
        $carnet = Carnet::with([
            'usuario:id,nombres,apellidos,correo,fotografia'
        ])->findOrFail($id);

        return response()->json($carnet);
    }

    // Actualizar un carnet
    public function update(Request $request, $id)
    {
        $carnet = Carnet::findOrFail($id);

        $request->validate([
            'codigo_estudiante' => 'required|string|unique:carnets,codigo_estudiante,' . $id,
            'carrera' => 'required|string',
            'nivel' => 'required|string',
            'jornada' => 'required|string',
            'periodo_academico' => 'required|string',
        ]);

        $carnet->update([
            'codigo_estudiante' => $request->codigo_estudiante,
            'carrera' => $request->carrera,
            'nivel' => $request->nivel,
            'jornada' => $request->jornada,
            'periodo_academico' => $request->periodo_academico,
            'qr' => $request->qr,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'mensaje' => 'Carnet actualizado correctamente.',
            'carnet' => $carnet
        ]);
    }

    // Eliminar un carnet
    public function destroy($id)
    {
        $carnet = Carnet::findOrFail($id);
        $carnet->delete();

        return response()->json([
            'mensaje' => 'Carnet eliminado correctamente.'
        ]);
    }

    public function miCarnet()
    {
        return Carnet::with('usuario')
            ->where('usuario_id', auth()->id())
            ->first();
    }
}