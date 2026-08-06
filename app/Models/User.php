<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'fotografia',
        'password',
        'rol_id',
        'estado',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }


    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }


    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }


    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    public function carnet()
    {
        return $this->hasOne(Carnet::class, 'usuario_id');
    }
}