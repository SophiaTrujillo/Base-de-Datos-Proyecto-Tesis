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
use App\Http\Controllers\CarnetController;

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
Route::post('/noticias', [NoticiaController::class, 'store']);
Route::get('/noticias/{id}', [NoticiaController::class, 'show']);
Route::put('/noticias/{id}', [NoticiaController::class, 'update']);
Route::delete('/noticias/{id}', [NoticiaController::class, 'destroy']);

// Eventos
Route::get('/eventos', [EventoController::class, 'index']);
Route::post('/eventos', [EventoController::class, 'store']);
Route::get('/eventos/{id}', [EventoController::class, 'show']);
Route::put('/eventos/{id}', [EventoController::class, 'update']);
Route::delete('/eventos/{id}', [EventoController::class, 'destroy']);

// Clubes
Route::get('/clubes', [ClubController::class, 'index']);
Route::post('/clubes', [ClubController::class, 'store']);
Route::get('/clubes/{id}', [ClubController::class, 'show']);
Route::put('/clubes/{id}', [ClubController::class, 'update']);
Route::delete('/clubes/{id}', [ClubController::class, 'destroy']);

// Notificaciones
Route::get('/notificaciones', [NotificacionController::class, 'index']);
Route::post('/notificaciones', [NotificacionController::class, 'store']);
Route::get('/notificaciones/{id}', [NotificacionController::class, 'show']);
Route::put('/notificaciones/{id}', [NotificacionController::class, 'update']);
Route::delete('/notificaciones/{id}', [NotificacionController::class, 'destroy']);

// Tareas Moodle
Route::get('/tareas', [TareaMoodleController::class, 'index']);
Route::post('/tareas', [TareaMoodleController::class, 'store']);
Route::get('/tareas/{id}', [TareaMoodleController::class, 'show']);
Route::put('/tareas/{id}', [TareaMoodleController::class, 'update']);
Route::delete('/tareas/{id}', [TareaMoodleController::class, 'destroy']);

// Carnet
Route::get('/carnets', [CarnetController::class, 'index']);
Route::post('/carnets', [CarnetController::class, 'store']);
Route::get('/carnets/{id}', [CarnetController::class, 'show']);
Route::put('/carnets/{id}', [CarnetController::class, 'update']);
Route::delete('/carnets/{id}', [CarnetController::class, 'destroy']);

// Chat
Route::get('/conversaciones', [ConversacionController::class, 'index']);
Route::post('/conversaciones', [ConversacionController::class, 'store']);
Route::get('/conversaciones/{id}', [ConversacionController::class, 'show']);

Route::get('/mensajes', [MensajeController::class, 'index']);
Route::post('/mensajes', [MensajeController::class, 'store']);
Route::put('/mensajes/{id}/leido', [MensajeController::class, 'marcarLeido']);

});