<?php

use App\Http\Controllers\AgendamentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/clientes', [ClienteController::class, 'index'])
    ->name('clientes.index')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/clientes/create', [ClienteController::class, 'createCliente'])
    ->name('clientes.create')
    ->middleware(['auth', 'verified', '2fa']);

Route::post('/clientes', [ClienteController::class, 'store'])
    ->name('clientes.store')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/clientes/{id}', [ClienteController::class, 'show'])
    ->name('clientes.show')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])
    ->name('clientes.edit')
    ->middleware(['auth', 'verified', '2fa']);

Route::put('/clientes/{id}', [ClienteController::class, 'update'])
    ->name('clientes.update')
    ->middleware(['auth', 'verified', '2fa']);

Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])
    ->name('clientes.destroy')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/clientes/search', [ClienteController::class, 'searchClient'])
    ->name('clientes.search')
    ->middleware(['auth', 'verified', '2fa']);

Route::post('/clientes/findOrCreate', [ClienteController::class, 'findOrCreateClient'])
    ->name('clientes.findOrCreate')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/agendamentos', [AgendamentoController::class, 'index'])
    ->name('agendamentos.index')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/agendamentos2', [AgendamentoController::class, 'index2'])
    ->name('agendamentos.index2')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('agendamentos/search', [AgendamentoController::class, 'search'])
    ->name('agendamentos.search')
    ->middleware(['auth', 'verified', '2fa']);

Route::post('agendamentos/findClient', [AgendamentoController::class, 'findClient'])
    ->name('agendamentos.findClient')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/agendamentos/create/{clienteId}', [AgendamentoController::class, 'create'])
    ->name('agendamentos.create')
    ->middleware(['auth', 'verified', '2fa']);

Route::post('/agendamentos/store', [AgendamentoController::class, 'store'])
    ->name('agendamentos.store')
    ->middleware(['auth', 'verified', '2fa']);

Route::delete('/agendamentos/{id}', [AgendamentoController::class, 'destroy'])
    ->name('agendamentos.destroy')
    ->middleware(['auth', 'verified', '2fa']);

Route::get('/', [AgendamentoController::class, 'searchCpf'])
    ->name('agendamentos.searchCpf');

Route::post('/agendamentos/verificar-cpf', [AgendamentoController::class, 'verifyCpf'])
    ->name('agendamentos.verifyCpf');



Route::get('/register', [AuthController::class, 'registrationForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('auth.processRegister');
Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('auth.processLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/forgot', [AuthController::class, 'forgotForm'])->name('auth.forgot');
Route::post('/forgot', [AuthController::class, 'forgotProcess'])->name('auth.forgotProcess');
Route::get('/token/{email}', [AuthController::class, 'showTokenForm'])->name('auth.token.form');
Route::post('/token', [AuthController::class, 'tokenProcess'])->name('auth.token.process');
Route::get('/password/reset/{token}/{email}', [AuthController::class, 'showResetForm'])->name('auth.reset.form');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('auth.reset.password');
Route::get('/profile',[AuthController::class,'profile'])->name('auth.profile')->middleware('auth');
Route::put('/users/{id}/update',[AuthController::class,'updateUser'])->name('auth.updateUser');

Route::get('/email/verify', [AuthController::class, 'showVerifyEmailForm'])->name('auth.verifyEmailForm');
Route::post('/email/verify', [AuthController::class, 'sendVerificationEmail'])->name('auth.sendVerificationEmail');
Route::get('/email/verify/{token}', [AuthController::class, 'verifyEmailToken'])->name('auth.verifyEmailToken');

Route::get('/two-factor-auth', [AuthController::class, 'showTwoFactorForm'])
    ->name('auth.two_factor_form')
    ->middleware('auth');


Route::post('/two-factor-auth/verify', [AuthController::class, 'verifyTwoFactorCode'])
    ->name('auth.verify_two_factor_code')
    ->middleware('auth');


