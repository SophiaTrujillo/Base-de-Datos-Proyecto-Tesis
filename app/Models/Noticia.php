<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'usuario_id',
        'fecha_publicacion',
        'estado',
    ];


    /**
     * Una noticia pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}