<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    public function index()
    {
        try {
            $clientes = Cliente::all();
            return view('clientes.index', ['clientes' => $clientes]);
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
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|unique:clientes',
                'numero_telefone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'data_nascimento' => 'required|date',
            ]);

            $cpf = preg_replace('/\D/', '', $request->input('cpf'));

            Cliente::create($request->merge(['cpf' => $cpf])->all());

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente criado com sucesso.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um problema ao criar o cliente. Verifique os dados e tente novamente.')
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.')
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            return view('clientes.show', ['cliente' => $cliente]);
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
            return view('clientes.edit', ['cliente' => $cliente]);
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
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|unique:clientes,cpf,' . $id,
                'numero_telefone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'data_nascimento' => 'required|date',
            ]);


            $cpf = preg_replace('/\D/', '', $request->input('cpf'));

            $cliente = Cliente::findOrFail($id);
            $cliente->update($request->merge(['cpf' => $cpf])->all());

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente atualizado com sucesso.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um problema ao atualizar o cliente. Verifique os dados e tente novamente.')
                ->withInput();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Cliente não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
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
