<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function registrationForm()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('auth.login')->with('success', 'Usuário registrado com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao registrar usuário: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.');
        }
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return redirect()->intended('/agendamentos');
            }

            return redirect()->back()->with('error', 'Credenciais inválidas. Por favor, tente novamente.');
        } catch (Exception $e) {
            Log::error('Erro ao tentar login: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao tentar fazer login. Por favor, tente novamente.');
        }
    }
}
