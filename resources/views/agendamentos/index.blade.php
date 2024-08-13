@extends('layouts.app')

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

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Tipo de Carteira</th>
                        <th>Local</th>
                        <th>Ações</th>
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
                            <td>

                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $agendamento->id }}">Cancelar</button>


                                <div class="modal fade" id="deleteModal-{{ $agendamento->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $agendamento->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel-{{ $agendamento->id }}">Confirmar Exclusão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja cancelar o agendamento de <strong>{{ $agendamento->cliente_nome }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="{{ route('agendamentos.destroy', $agendamento->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhum agendamento encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
