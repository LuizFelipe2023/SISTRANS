<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Storage;


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
                return redirect()->intended('/agendamentos2');
            }

            return redirect()->back()->with('error', 'Credenciais inválidas. Por favor, tente novamente.');
        } catch (Exception $e) {
            Log::error('Erro ao tentar login: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao tentar fazer login. Por favor, tente novamente.');
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('auth.login')->with('success', 'Você foi desconectado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao tentar logout: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao tentar fazer logout. Por favor, tente novamente.');
        }
    }

    public function forgotForm()
    {
        return view('auth.forgot');
    }

    public function forgotProcess(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->input('email');
            $user = User::where('email', $email)->first();

            if ($user) {
                $token = Str::random(60);

                DB::table('password_resets')->insert([
                    'email' => $email,
                    'token' => $token,
                    'created_at' => now(),
                ]);

                Mail::to($email)->send(new ResetPasswordMail($token, $email));

                return redirect()->route('auth.token.form', ['email' => $email])
                    ->with('success', 'Um e-mail de redefinição de senha foi enviado. Verifique sua caixa de entrada.');
            } else {
                return redirect()->back()->with('error', 'Nenhuma conta foi encontrada com este e-mail.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao processar solicitação de redefinição de senha: ', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.');
        }
    }

    public function showTokenForm($email)
    {
        return view('auth.token', ['email' => $email]);
    }

    public function tokenProcess(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email'
            ]);

            $token = $request->input('token');
            $email = $request->input('email');

            $passwordReset = DB::table('password_resets')
                ->where('email', $email)
                ->where('token', $token)
                ->first();

            if ($passwordReset) {
                return redirect()->route('auth.reset.form', ['token' => $token, 'email' => $email]);
            } else {
                return redirect()->back()->with('error', 'Token inválido ou expirado.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao validar token de redefinição de senha: ', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.');
        }
    }

    public function showResetForm($token, $email)
    {
        return view('auth.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            $reset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

            if (!$reset) {
                return redirect()->back()->with('error', 'O token de redefinição de senha é inválido ou expirado.');
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Nenhum usuário encontrado com este e-mail.');
            }

            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_resets')->where('email', $request->email)->delete();

            return redirect()->route('auth.login')->with('success', 'Sua senha foi redefinida com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao redefinir a senha: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao redefinir a senha. Por favor, tente novamente.');
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|confirmed|min:6',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = User::findOrFail($id);


            $user->name = $request->input('name');
            $user->email = $request->input('email');


            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }


            if ($request->hasFile('photo')) {
                if ($user->path && Storage::exists($user->path)) {
                    Storage::delete($user->path);
                }

                $photo = $request->file('photo');
                $path = $photo->store('pictures', 'public');
                $user->path = $path;
                $user->filename = $photo->getClientOriginalName();
            }

            $user->save();

            return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o usuário. Por favor, tente novamente.');
        }
    }

    public function showVerifyEmailForm()
    {
        return view('auth.verifyEmailForm');
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::warning('Tentativa de envio de verificação para e-mail não encontrado: ' . $request->email);
            return redirect()->back()->with('error', 'Nenhuma conta foi encontrada com este e-mail.');
        }

        $token = Str::random(60);

        DB::table('email_verifications')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Log::info('Token gerado para verificação de e-mail: ' . $user->email . ' | Token: ' . $token);

        try {
            Mail::to($user->email)->send(new VerificationMail($token, $user->email));
            Log::info('E-mail de verificação enviado com sucesso para: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail de verificação: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao enviar o e-mail de verificação.');
        }

        return redirect()->route('auth.verifyEmailForm')->with('success', 'Um e-mail de verificação foi enviado.');
    }

    public function verifyEmailToken($token)
    {
        $verification = DB::table('email_verifications')
            ->where('token', $token)
            ->first();

        if (!$verification) {
            Log::warning('Tentativa de verificação com token inválido ou expirado: ' . $token);
            return redirect()->route('auth.verifyEmailForm')->with('error', 'Token inválido ou expirado.');
        }

        $user = User::where('email', $verification->email)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->save();

            DB::table('email_verifications')->where('email', $verification->email)->delete();

            Log::info('E-mail verificado com sucesso para: ' . $user->email);

            return redirect()->route('auth.login')->with('success', 'E-mail verificado com sucesso! Faça login.');
        }

        Log::error('Usuário não encontrado para o e-mail: ' . $verification->email);
        return redirect()->route('auth.verifyEmailForm')->with('error', 'Usuário não encontrado.');
    }
}
