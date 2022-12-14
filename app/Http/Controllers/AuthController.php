<?php

namespace App\Http\Controllers;

use App\Poblacion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate_data = $request->validate(
            [
                'name' => 'required|max:255',
                'username' => 'required|unique:users',
                'password' => 'required|confirmed'
            ]
        );


        $validate_data['password'] = Hash::make($request->password);

        // $user = User::create($validate_data);

        $user = new User();
        $user->name = $validate_data['name'];
        $user->username = $validate_data['username'];
        $user->password = $validate_data['password'];
        $user->save();

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'accessToken' => $accessToken
        ]);
    }

    public function login(Request $request)
    {
        $login_data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($login_data)) {
            return response([
                'val' => '1',
                'mensaje' => 'usuario y/o contraseña es invalido',
                'accessToken' => '',
                'id' => 0
            ]);
        }

       // return auth()->user()->username;

        $accessToken = auth()->user()->createToken('authSertrasenToken')->accessToken;
        $poblacion = Poblacion::where('POB_NRO_DUI','=',auth()->user()->username)->first();

        return response([
            'val' => '0',
            'mensaje' => 'ACCESO EXITOSO',
            'accessToken' => $accessToken,
            'id' => $poblacion->ID
        ]);
    }
}
