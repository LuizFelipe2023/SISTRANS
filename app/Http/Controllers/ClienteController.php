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
        $this->validateRequest($request);

        try {
            $cpf = $this->formatCpf($request->input('cpf'));
            $fotoPerfilPath = $this->storeProfilePhoto($request);

            Cliente::create($request->merge([
                'cpf' => $cpf,
                'foto_perfil' => $fotoPerfilPath
            ])->all());

            return redirect()->route('agendamentos.searchCpf')
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
        $this->validateRequest($request, $id);

        try {
            $cpf = $this->formatCpf($request->input('cpf'));

            $cliente = Cliente::findOrFail($id);
            $fotoPerfilPath = $this->updateProfilePhoto($request, $cliente);

            $cliente->update($request->merge([
                'cpf' => $cpf,
                'foto_perfil' => $fotoPerfilPath
            ])->all());

            return redirect()->route('agendamentos.')
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


    private function validateRequest(Request $request, $id = null)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|unique:clientes,cpf,' . $id,
            'numero_telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'data_nascimento' => 'required|date',
            'foto_perfil' => 'nullable|image|max:2048' // Limite de tamanho adicionado
        ]);
    }

    private function formatCpf($cpf)
    {
        return preg_replace('/\D/', '', $cpf);
    }

    private function storeProfilePhoto(Request $request)
    {
        if ($request->hasFile('foto_perfil')) {
            $file = $request->file('foto_perfil');
            return $file->store('imgs', 'public');
        }
        return null;
    }

    private function updateProfilePhoto(Request $request, $cliente)
    {
        $fotoPerfilPath = $cliente->foto_perfil;

        if ($request->hasFile('foto_perfil')) {
            if ($fotoPerfilPath && Storage::exists($fotoPerfilPath)) {
                Storage::delete($fotoPerfilPath);
            }
            $file = $request->file('foto_perfil');
            $fotoPerfilPath = $file->store('imgs', 'public');
        }

        return $fotoPerfilPath;
    }
}
