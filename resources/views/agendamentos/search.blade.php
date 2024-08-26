@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Pesquisa de Cadastro para Agendamentos</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif(session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('agendamentos.findClient') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="cpf" class="form-label">CPF do Cliente:</label>
                                <input type="text" name="cpf" id="cpf" class="form-control form-control-lg" required>
                                @error('cpf')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-md w-100 rounded shadow">Buscar Cliente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
