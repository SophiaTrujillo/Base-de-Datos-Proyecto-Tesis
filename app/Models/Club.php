<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'responsable_id',
        'estado',
    ];


    /**
     * Un club pertenece a un usuario responsable.
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}