<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AgendamentoController extends Controller
{
    public function searchCpf()
    {
        return view('agendamentos.searchCpf');
    }

    public function verifyCpf(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string|max:14',
        ]);

        $cpf = preg_replace('/\D/', '', $request->input('cpf'));

        try {
            $cliente = Cliente::where('cpf', $cpf)->firstOrFail();

            $agendamentos = Agendamento::with('cliente')
                ->where('cliente_id', $cliente->id)
                ->get();

            if ($agendamentos->isEmpty()) {
                return redirect()->route('agendamentos.searchCpf')
                    ->with('info', 'Nenhum agendamento encontrado para o CPF informado.');
            }

            return view('agendamentos.index', compact('agendamentos'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('agendamentos.searchCpf')
                ->with('error', 'Nenhum cliente encontrado com o CPF informado.');
        } catch (\Exception $e) {
            Log::error('Erro ao buscar agendamentos para o CPF: ' . $e->getMessage());
            return redirect()->route('agendamentos.searchCpf')
                ->with('error', 'Erro ao buscar agendamentos. Tente novamente.');
        }
    }

    public function index()
    {
        try {
            $agendamentos = Agendamento::with('cliente')->get();
            return view('agendamentos.index', compact('agendamentos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar agendamentos: ' . $e->getMessage());
            return redirect()->route('agendamentos.index')
                ->with('error', 'Ocorreu um erro ao carregar os agendamentos. Por favor, tente novamente.');
        }
    }
    public function index2()
    {
        try {
            $agendamentos = Agendamento::all();
            return view('agendamentos.index2', compact('agendamentos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar agendamentos: ' . $e->getMessage());
            return redirect()->route('agendamentos.index2')
                ->with('error', 'Ocorreu um erro ao carregar os agendamentos. Por favor, tente novamente.');
        }
    }


    public function create($clienteId)
    {
        try {
            $horarios = [];
            $start = strtotime('07:00');
            $end = strtotime('16:30');
            $interval = 30 * 60;

            for ($time = $start; $time <= $end; $time += $interval) {
                $horarios[] = date('H:i', $time);
            }

            $cliente = Cliente::findOrFail($clienteId);
            return view('agendamentos.create', [
                'cliente' => $cliente,
                'horarios' => $horarios,
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Cliente não encontrado: ' . $e->getMessage());
            return redirect()->route('clientes.create')
                ->with('info', 'Cliente não encontrado. Por favor, crie um novo cliente para continuar.');
        } catch (\Exception $e) {
            Log::error('Erro ao carregar o cliente: ' . $e->getMessage());
            return redirect()->route('clientes.create')
                ->with('error', 'Erro ao carregar o cliente. Tente novamente.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'cliente_nome' => 'required|string|max:255',
            'cliente_cpf' => 'required|string|max:14',
            'cliente_numero' => 'required|string|max:15',
            'dia_agendamento' => 'required|date',
            'hora_agendamento' => 'required|date_format:H:i',
            'tipo_carteira' => 'required|string|in:estudantil,cidadao,pcd,vale_transporte',
            'local' => 'required|string|in:Centro,Cidade Nova',
        ]);

        try {
            Log::info($validated);
            Agendamento::create($validated);
            return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocorreu um erro ao criar o agendamento.')->withInput();
        }
    }


    public function show($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);
            return view('agendamentos.show', ['agendamento' => $agendamento]);
        } catch (ModelNotFoundException $e) {
            Log::error('Agendamento não encontrado: ' . $e->getMessage());
            return redirect()->route('agendamentos.index')
                ->with('error', 'Agendamento não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            Log::error('Erro ao carregar agendamento: ' . $e->getMessage());
            return redirect()->route('agendamentos.index')
                ->with('error', 'Erro ao carregar os detalhes do agendamento. Por favor, tente novamente.');
        }
    }

    public function edit($id)
    {
        try {
            $agendamento = Agendamento::findOrFail($id);
            return view('agendamentos.edit', [
                'agendamento' => $agendamento,
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Agendamento não encontrado para edição: ' . $e->getMessage());
            return redirect()->route('agendamentos.index')
                ->with('error', 'Agendamento não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            Log::error('Erro ao carregar dados para edição: ' . $e->getMessage());
            return redirect()->route('agendamentos.index')
                ->with('error', 'Erro ao carregar os dados para edição. Por favor, tente novamente.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'dia_agendamento' => 'required|date',
                'hora_agendamento' => 'required|date_format:H:i',
                'tipo_carteira' => 'required|string',
                'local' => 'required|string',
                'cliente_id' => 'required|exists:clientes,id',
                'cliente_nome' => 'required|string',
                'cliente_cpf' => 'required|string',
                'cliente_numero' => 'required|string',
            ]);

            $data = $request->only([
                'dia_agendamento',
                'hora_agendamento',
                'tipo_carteira',
                'local',
                'cliente_id',
                'cliente_nome',
                'cliente_cpf',
                'cliente_numero'
            ]);

            $agendamento = Agendamento::findOrFail($id);
            $agendamento->update($data);

            return redirect()->route('agendamentos.index')
                ->with('success', 'Agendamento atualizado com sucesso.');
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar agendamento: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Há alguns erros no seu formulário. Verifique e tente novamente.');
        } catch (ModelNotFoundException $e) {
            Log::error('Agendamento não encontrado para atualização: ' . $e->getMessage());
            return redirect()->route('agendamentos.index')
                ->with('error', 'Agendamento não encontrado. Verifique o ID e tente novamente.');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar agendamento: ' . $e->getMessage());
            return redirect()->route('agendamentos.index')
                ->with('error', 'Erro ao atualizar o agendamento. Por favor, tente novamente.');
        }
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->delete();

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento excluído com sucesso.');
    }




    public function search()
    {
        return view('agendamentos.search');
    }

    public function findClient(Request $request)
    {
        try {
            $request->validate([
                'cpf' => 'required|string',
            ]);

            $cpf = preg_replace('/\D/', '', $request->input('cpf'));

            Log::info('Buscando cliente com CPF: ' . $cpf);

            $cliente = Cliente::where('cpf', $cpf)->first();

            if ($cliente) {
                $agendamentoExistente = Agendamento::where('cliente_id', $cliente->id)->exists();

                if (!$agendamentoExistente) {
                    Log::info('Cliente encontrado: ' . $cliente->id);
                    return redirect()->route('agendamentos.create', ['clienteId' => $cliente->id])
                        ->with('success', 'Cliente encontrado. Você pode agendar agora.');
                } else {
                    Log::info('Agendamento já existente para o cliente com CPF: ' . $cpf);
                    return redirect()->route('agendamentos.search')
                        ->with('info', 'O cliente já possui um agendamento.');
                }
            } else {
                Log::info('Cliente não encontrado com CPF: ' . $cpf);
                return redirect()->route('clientes.create')
                    ->with('info', 'Cliente não encontrado. Por favor, crie um novo cliente para prosseguir.');
            }
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao buscar cliente: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Há um erro no seu CPF. Verifique e tente novamente.');
        } catch (\Exception $e) {
            Log::error('Erro ao buscar cliente: ' . $e->getMessage());
            return redirect()->route('agendamentos.search')
                ->with('error', 'Ocorreu um erro ao buscar o cliente. Tente novamente.');
        }
    }
}
