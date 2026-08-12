<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversacion;

class ConversacionController extends Controller
{
    // Mostrar las conversaciones del usuario autenticado
    public function index(Request $request)
    {
        $usuario = $request->user();

        $conversaciones = Conversacion::with([
            'usuario1:id,nombres,apellidos,correo,fotografia',
            'usuario2:id,nombres,apellidos,correo,fotografia',
            'mensajes'
        ])
        ->where('usuario1_id', $usuario->id)
        ->orWhere('usuario2_id', $usuario->id)
        ->get();

        return response()->json($conversaciones);
    }

    // Crear una conversación
    public function store(Request $request)
    {
        $usuario = $request->user();

        $request->validate([
            'usuario2_id' => 'required|exists:users,id',
        ]);

        // No permitir conversación consigo mismo
        if ($usuario->id == $request->usuario2_id) {
            return response()->json([
                'mensaje' => 'No puedes crear una conversación contigo mismo.'
            ], 422);
        }

        // Comprobar si ya existe
        $conversacion = Conversacion::where(function ($query) use ($usuario, $request) {
            $query->where('usuario1_id', $usuario->id)
                  ->where('usuario2_id', $request->usuario2_id);
        })
        ->orWhere(function ($query) use ($usuario, $request) {
            $query->where('usuario1_id', $request->usuario2_id)
                  ->where('usuario2_id', $usuario->id);
        })
        ->first();

        if ($conversacion) {
            return response()->json([
                'mensaje' => 'La conversación ya existe.',
                'conversacion' => $conversacion->load([
                    'usuario1',
                    'usuario2'
                ])
            ]);
        }

        $conversacion = Conversacion::create([
            'usuario1_id' => $usuario->id,
            'usuario2_id' => $request->usuario2_id,
        ]);

        return response()->json([
            'mensaje' => 'Conversación creada correctamente.',
            'conversacion' => $conversacion->load([
                'usuario1',
                'usuario2'
            ])
        ], 201);
    }

    // Mostrar una conversación
    public function show(Request $request, string $id)
    {
        $usuario = $request->user();

        $conversacion = Conversacion::with([
            'usuario1',
            'usuario2',
            'mensajes.emisor'
        ])
        ->where('id', $id)
        ->where(function ($query) use ($usuario) {
            $query->where('usuario1_id', $usuario->id)
                  ->orWhere('usuario2_id', $usuario->id);
        })
        ->first();

        if (!$conversacion) {
            return response()->json([
                'mensaje' => 'Conversación no encontrada.'
            ], 404);
        }

        return response()->json($conversacion);
    }
}