<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Models\Conversacion;

class MensajeController extends Controller
{
    // Mostrar mensajes de una conversación
    public function index(Request $request)
    {
        $usuario = $request->user();

        $request->validate([
            'conversacion_id' => 'required|exists:conversacions,id',
        ]);

        $conversacion = Conversacion::where('id', $request->conversacion_id)
            ->where(function ($query) use ($usuario) {
                $query->where('usuario1_id', $usuario->id)
                      ->orWhere('usuario2_id', $usuario->id);
            })
            ->first();

        if (!$conversacion) {
            return response()->json([
                'mensaje' => 'No tienes acceso a esta conversación.'
            ], 403);
        }

        $mensajes = Mensaje::with([
            'emisor:id,nombres,apellidos,correo,fotografia'
        ])
        ->where('conversacion_id', $conversacion->id)
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($mensajes);
    }

    // Enviar un mensaje
    public function store(Request $request)
    {
        $usuario = $request->user();

        $request->validate([
            'conversacion_id' => 'required|exists:conversacions,id',
            'mensaje' => 'required|string',
        ]);

        $conversacion = Conversacion::where('id', $request->conversacion_id)
            ->where(function ($query) use ($usuario) {
                $query->where('usuario1_id', $usuario->id)
                      ->orWhere('usuario2_id', $usuario->id);
            })
            ->first();

        if (!$conversacion) {
            return response()->json([
                'mensaje' => 'No tienes acceso a esta conversación.'
            ], 403);
        }

        $mensaje = Mensaje::create([
            'conversacion_id' => $conversacion->id,
            'emisor_id' => $usuario->id,
            'mensaje' => $request->mensaje,
            'leido' => false,
        ]);

        return response()->json([
            'mensaje' => 'Mensaje enviado correctamente.',
            'datos' => $mensaje->load('emisor')
        ], 201);
    }

    // Marcar un mensaje como leído
    public function marcarLeido(Request $request, string $id)
    {
        $usuario = $request->user();

        $mensaje = Mensaje::with('conversacion')->find($id);

        if (!$mensaje) {
            return response()->json([
                'mensaje' => 'Mensaje no encontrado.'
            ], 404);
        }

        $conversacion = $mensaje->conversacion;

        if (
            $conversacion->usuario1_id != $usuario->id &&
            $conversacion->usuario2_id != $usuario->id
        ) {
            return response()->json([
                'mensaje' => 'No tienes acceso a este mensaje.'
            ], 403);
        }

        $mensaje->update([
            'leido' => true
        ]);

        return response()->json([
            'mensaje' => 'Mensaje marcado como leído.',
            'datos' => $mensaje
        ]);
    }
}