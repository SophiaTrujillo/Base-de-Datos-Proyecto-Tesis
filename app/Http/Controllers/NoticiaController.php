<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;

class NoticiaController extends Controller
{
    /**
     * Mostrar todas las noticias.
     */
    public function index()
    {
        $noticias = Noticia::with([
            'usuario:id,nombres,apellidos,correo,fotografia'
        ])->get();

        return response()->json($noticias);
    }

    /**
     * Crear una noticia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
            'fecha_publicacion' => 'required|date',
            'estado' => 'nullable|boolean',
        ]);

        $noticia = Noticia::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'usuario_id' => $request->usuario_id,
            'fecha_publicacion' => $request->fecha_publicacion,
            'estado' => $request->estado ?? true,
        ]);

        return response()->json([
            'mensaje' => 'Noticia creada correctamente.',
            'noticia' => $noticia->load('usuario')
        ], 201);
    }

    /**
     * Mostrar una noticia específica.
     */
    public function show(string $id)
    {
        $noticia = Noticia::with([
            'usuario:id,nombres,apellidos,correo,fotografia'
        ])->find($id);

        if (!$noticia) {
            return response()->json([
                'mensaje' => 'Noticia no encontrada.'
            ], 404);
        }

        return response()->json($noticia);
    }

    /**
     * Actualizar una noticia.
     */
    public function update(Request $request, string $id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json([
                'mensaje' => 'Noticia no encontrada.'
            ], 404);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|string',
            'fecha_publicacion' => 'required|date',
            'estado' => 'nullable|boolean',
        ]);

        $noticia->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'fecha_publicacion' => $request->fecha_publicacion,
            'estado' => $request->estado ?? $noticia->estado,
        ]);

        return response()->json([
            'mensaje' => 'Noticia actualizada correctamente.',
            'noticia' => $noticia->load('usuario')
        ]);
    }

    /**
     * Eliminar una noticia.
     */
    public function destroy(string $id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json([
                'mensaje' => 'Noticia no encontrada.'
            ], 404);
        }

        $noticia->delete();

        return response()->json([
            'mensaje' => 'Noticia eliminada correctamente.'
        ]);
    }
}