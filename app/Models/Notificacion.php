<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'mensaje',
        'tipo',
        'leida',
        'fecha',
    ];

    /**
     * Una notificación pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}    