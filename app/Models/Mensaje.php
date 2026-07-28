<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = [
        'conversacion_id',
        'emisor_id',
        'mensaje',
        'leido',
    ];


    /**
     * Un mensaje pertenece a una conversación.
     */
    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class);
    }


    /**
     * Un mensaje pertenece al usuario que lo envió.
     */
    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }
}