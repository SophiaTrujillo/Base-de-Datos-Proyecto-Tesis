<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];


    /**
     * Un permiso puede pertenecer a muchos roles.
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class);
    }
}
