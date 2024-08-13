@extends('layouts.app')

@section('content')
<div class="container-md mt-4 py-4">
    <div class="card rounded shadow">
        <div class="card-header text-black">
            <h4>Detalhes do Cliente</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-4">Nome:</dt>
                        <dd class="col-sm-8"><strong>{{ $cliente->nome }}</strong></dd>

                        <dt class="col-sm-4">CPF:</dt>
                        <dd class="col-sm-8">{{ $cliente->cpf }}</dd>

                        <dt class="col-sm-4">Telefone:</dt>
                        <dd class="col-sm-8">{{ $cliente->numero_telefone }}</dd>

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $cliente->email }}</dd>
                    </dl>
                </div>
                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-4">Data de Nascimento:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y') }}</dd>

                        <dt class="col-sm-4">Tipo de Carteira:</dt>
                        <dd class="col-sm-8">{{ $cliente->tipo_carteira ?? '-' }}</dd>

                        <dt class="col-sm-4">Número da Carteira:</dt>
                        <dd class="col-sm-8">{{ $cliente->numero_carteira ?? '-' }}</dd>

                        <dt class="col-sm-4">Saldo da Carteira:</dt>
                        <dd class="col-sm-8">{{ isset($cliente->saldo_carteira) ? 'R$ ' . number_format($cliente->saldo_carteira, 2, ',', '.') : '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="text-end">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
