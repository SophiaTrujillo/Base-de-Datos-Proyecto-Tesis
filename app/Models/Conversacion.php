<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $fillable = [
        'usuario1_id',
        'usuario2_id',
    ];


    /**
     * Primer usuario de la conversación.
     */
    public function usuario1()
    {
        return $this->belongsTo(User::class, 'usuario1_id');
    }


    /**
     * Segundo usuario de la conversación.
     */
    public function usuario2()
    {
        return $this->belongsTo(User::class, 'usuario2_id');
    }


    /**
     * Una conversación tiene muchos mensajes.
     */
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}