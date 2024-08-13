@extends('layouts.app')

@section('content')
    <div class="container-md mt-4">
        <div class="table-responsive">
            <table id="clientesTable" class="table table-bordered table-striped table-hover rounded shadow">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Data de Nascimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->cpf }}</td>
                            <td>{{ $cliente->numero_telefone }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($cliente->data_nascimento)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm me-2"
                                    title="Ver Detalhes">
                                    <i class="bi bi-person"></i>
                                </a>

                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm me-2"
                                    title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
