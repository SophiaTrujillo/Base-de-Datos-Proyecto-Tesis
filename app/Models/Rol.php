<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Un rol puede tener muchos usuarios.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Un rol puede tener muchos permisos.
     */
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class);
    }
}