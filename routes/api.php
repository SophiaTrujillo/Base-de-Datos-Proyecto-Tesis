<?php

use Illuminate\Support\Facades\Route; 

use App\Http\Controllers\AuthController; 
use App\Http\Controllers\NoticiaController; 
use App\Http\Controllers\EventoController; 
use App\Http\Controllers\ClubController; 
use App\Http\Controllers\NotificacionController; 
use App\Http\Controllers\TareaMoodleController; 
use App\Http\Controllers\ConversacionController; 
use App\Http\Controllers\MensajeController; 

/* 
|-------------------------------------------------------------------------- 
| Login |
-------------------------------------------------------------------------- 
*/ 

Route::post('/login', [AuthController::class, 'login']); 

/* 
|-------------------------------------------------------------------------- 
| Rutas protegidas con Sanctum |
-------------------------------------------------------------------------- 
*/ 

Route::middleware('auth:sanctum')->group(function () { 

// Noticias 
Route::get('/noticias', [NoticiaController::class, 'index']); 

// Eventos 
Route::get('/eventos', [EventoController::class, 'index']); 

// Clubes 
Route::get('/clubes', [ClubController::class, 'index']); 

// Notificaciones 
Route::get('/notificaciones', [NotificacionController::class, 'index']); 

// Tareas Moodle 
Route::get('/tareas', [TareaMoodleController::class, 'index']); 

// Chat 
Route::get('/conversaciones', [ConversacionController::class, 'index']); 
Route::get('/mensajes', [MensajeController::class, 'index']); 

});