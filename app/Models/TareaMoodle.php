<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TareaMoodle extends Model
{
    protected $fillable = [
        'curso',
        'titulo',
        'descripcion',
        'fecha_entrega',
        'enlace_moodle',
        'estado',
    ];
}