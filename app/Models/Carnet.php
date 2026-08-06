<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carnet extends Model
{
    protected $fillable = [
        'usuario_id',
        'codigo_estudiante',
        'carrera',
        'nivel',
        'jornada',
        'periodo_academico',
        'qr',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}