<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{
    public function index() {
        $titulo = "Login de usuarios";
        return view("modules.auth.login", compact('titulo'));
    }

    public function logear(Request $request) {
        // validad datos de las credenciales
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // buscar usuario por email
        $user = User::where('email', $request->email)->first();

        // verificar si el usuario existe y la contraseña es correcta
        if(!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Las credenciales no coinciden.'])->onlyInput('email');
        }

        //el usuario esta activo
        if(!$user->activo) {
            return back()->withErrors(['email' => 'El usuario no está activo.'])->onlyInput('email');
        }

        //crear la sesion e usuario
        FacadesAuth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('home');
    }

    public function crearAdmin() {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('root'),
            'activo' => true,
            'rol' => 'admin'
        ]);

        return "Usuario admin creado";
    }

    public function logout(){
        FacadesAuth::logout();
        return to_route('login');
    }
}
