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

Route::get('/', function () {
    return view('welcome');
});




Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/create', [ClienteController::class, 'createCliente'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');
Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
Route::get('/clientes/search', [ClienteController::class, 'searchClient'])->name('clientes.search');
Route::post('/clientes/findOrCreate', [ClienteController::class, 'findOrCreateClient'])->name('clientes.findOrCreate');

Route::get('/agendamentos',[AgendamentoController::class,'index'])->name('agendamentos.index');
Route::get('agendamentos/search', [AgendamentoController::class, 'search'])->name('agendamentos.search');
Route::post('agendamentos/findClient', [AgendamentoController::class, 'findClient'])->name('agendamentos.findClient');
Route::get('/agendamentos/create/{clienteId}', [AgendamentoController::class, 'create'])->name('agendamentos.create');
Route::post('/agendamentos/store',[AgendamentoController::class,'store'])->name('agendamentos.store');
Route::delete('/agendamentos/{id}', [AgendamentoController::class, 'destroy'])->name('agendamentos.destroy');
Route::get('/agendamentos/buscar-cpf', [AgendamentoController::class, 'searchCpf'])->name('agendamentos.searchCpf');
Route::post('/agendamentos/verificar-cpf', [AgendamentoController::class, 'verifyCpf'])->name('agendamentos.verifyCpf');


Route::get('/register',[AuthController::class,'registerForm'])->name('auth.register');
Route::post('/register/process',[AuthController::class,'processRegister'])->name('auth.processRegister');
Route::get('/login',[AuthController::class,'loginForm'])->name('auth.login');
Route::post('/login/process',[AuthController::class,'processLogin'])->name('auth.processLogin');


