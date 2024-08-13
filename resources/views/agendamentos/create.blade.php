@extends('layouts.app')

@section('content')
<div class="container-md">
    <div class="card shadow rounded">
        <div class="card-header text-black text-center rounded-top">
            <h4>Formulário de Agendamento</h4>
        </div>
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('agendamentos.store') }}" method="POST">
                @csrf

                <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

                <div class="form-group mb-4">
                    <label for="cliente_nome" class="form-label">Nome do Cliente</label>
                    <input type="text" name="cliente_nome" id="cliente_nome" class="form-control"
                        value="{{ old('cliente_nome', $cliente->nome) }}" required>
                    @error('cliente_nome')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="cliente_cpf" class="form-label">CPF do Cliente</label>
                    <input type="text" name="cliente_cpf" id="cliente_cpf" class="form-control"
                        value="{{ old('cliente_cpf', $cliente->cpf) }}" required>
                    @error('cliente_cpf')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="cliente_cpf" class="form-label">Numero do Cliente</label>
                    <input type="text" name="cliente_numero" id="cliente_numero" class="form-control"
                        value="{{ old('cliente_cpf', $cliente->numero_telefone) }}" required>
                    @error('cliente_cpf')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="dia_agendamento" class="form-label">Data do Agendamento</label>
                    <input type="date" name="dia_agendamento" id="dia_agendamento" class="form-control" required>
                    @error('dia_agendamento')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="hora_agendamento" class="form-label">Hora do Agendamento</label>
                    <select name="hora_agendamento" id="hora_agendamento" class="form-control" required>
                        <option value="" disabled selected>Selecione a Hora</option>
                        @foreach ($horarios as $hora)
                            <option value="{{ $hora }}">{{ $hora }}</option>
                        @endforeach
                    </select>
                    @error('hora_agendamento')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="tipo_carteira" class="form-label">Tipo de Carteira</label>
                    <select name="tipo_carteira" id="tipo_carteira" class="form-control" required>
                        <option value="" disabled selected>Selecione o Tipo de Carteira</option>
                        <option value="estudantil" {{ old('tipo_carteira') == 'estudantil' ? 'selected' : '' }}>Estudantil</option>
                        <option value="cidadao" {{ old('tipo_carteira') == 'cidadao' ? 'selected' : '' }}>Cidadão</option>
                        <option value="pcd" {{ old('tipo_carteira') == 'pcd' ? 'selected' : '' }}>PCD</option>
                        <option value="vale_transporte" {{ old('tipo_carteira') == 'vale_transporte' ? 'selected' : '' }}>Vale Transporte</option>
                    </select>
                    @error('tipo_carteira')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="local" class="form-label">Local</label>
                    <select name="local" id="local" class="form-control" required>
                        <option value="" disabled selected>Selecione o Local</option>
                        <option value="Centro" {{ old('local') == 'Centro' ? 'selected' : '' }}>Centro</option>
                        <option value="Cidade Nova" {{ old('local') == 'Cidade Nova' ? 'selected' : '' }}>Cidade Nova</option>
                    </select>
                    @error('local')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Agendar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
