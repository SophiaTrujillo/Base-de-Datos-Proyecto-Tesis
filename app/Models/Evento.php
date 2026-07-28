<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'imagen',
        'usuario_id',
    ];


    /**
     * Un evento pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}