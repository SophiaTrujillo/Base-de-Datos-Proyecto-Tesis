<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);


        $usuario = User::with('rol')->where('correo', $request->correo)->first();


        if (!$usuario || !Hash::check($request->password, $usuario->password)) {

            return response()->json([
                'mensaje' => 'Credenciales incorrectas'
            ], 401);

        }


        $token = $usuario->createToken('app-instituto')->plainTextToken;


        return response()->json([
            'mensaje' => 'Login correcto',
            'usuario' => $usuario,
            'token' => $token
        ]);
    }
}