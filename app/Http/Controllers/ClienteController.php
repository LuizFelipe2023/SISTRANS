<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    public function index()
    {
        try {
            $clientes = Cliente::all();
            return view('clientes.index', compact('clientes'));
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Erro ao carregar a lista de clientes. Por favor, tente novamente.');
        }
    }

    public function createCliente()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf',
            'numero_telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:clientes,email',
            'data_nascimento' => 'required|date',
            'tipo_carteira' => 'nullable|string|max:50',
            'numero_carteira' => 'nullable|string|max:50',
            'saldo_carteira' => 'nullable|numeric|min:0',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            if ($request->hasFile('foto_perfil')) {
                $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');
                $validatedData['foto_perfil'] = $path;
            }

            Cliente::create($validatedData);

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente criado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.create')
                ->with('error', 'Erro ao criar o cliente. Por favor, tente novamente.')
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            return view('clientes.show', compact('cliente'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Cliente não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Erro ao carregar os detalhes do cliente. Por favor, tente novamente.');
        }
    }

    public function edit($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            return view('clientes.edit', compact('cliente'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Cliente não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Erro ao carregar o formulário de edição. Por favor, tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf,' . $id,
            'numero_telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:clientes,email,' . $id,
            'data_nascimento' => 'required|date',
            'tipo_carteira' => 'nullable|string|max:50',
            'numero_carteira' => 'nullable|string|max:50',
            'saldo_carteira' => 'nullable|numeric|min:0',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $cliente = Cliente::findOrFail($id);

            if ($request->hasFile('foto_perfil')) {
                if ($cliente->foto_perfil && Storage::exists($cliente->foto_perfil)) {
                    Storage::delete($cliente->foto_perfil);
                }
                $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');
                $validatedData['foto_perfil'] = $path;
            }

            $cliente->update($validatedData);

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente atualizado com sucesso.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Cliente não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.edit', $id)
                ->with('error', 'Erro ao atualizar o cliente. Por favor, tente novamente.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            if ($cliente->foto_perfil && Storage::exists($cliente->foto_perfil)) {
                Storage::delete($cliente->foto_perfil);
            }

            $cliente->delete();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente excluído com sucesso.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Cliente não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Erro ao excluir o cliente. Por favor, tente novamente.');
        }
    }
}
