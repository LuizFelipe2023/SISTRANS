@extends('layouts.app2')

@section('content')
<div class="container-md">
    <div class="card shadow rounded">
        <div class="card-header text-black text-center rounded-top">
            <h4>Lista de Agendamentos</h4>
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

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Tipo de Carteira</th>
                            <th>Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($agendamentos as $agendamento)
                            <tr>
                                <td>{{ $agendamento->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($agendamento->dia_agendamento)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($agendamento->hora_agendamento)->format('H:i') }}</td>
                                <td>{{ $agendamento->cliente_nome }} - {{ $agendamento->cliente_cpf }}</td>
                                <td>{{ ucfirst($agendamento->tipo_carteira) }}</td>
                                <td>{{ $agendamento->local }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhum agendamento encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
