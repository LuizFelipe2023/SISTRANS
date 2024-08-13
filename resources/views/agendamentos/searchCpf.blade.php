@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0 text-center">Buscar Agendamentos por CPF</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif

                        <form action="{{ route('agendamentos.verifyCpf') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="cpf">CPF:</label>
                                <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror" id="cpf" placeholder="Digite o CPF" required>

                                @error('cpf')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success w-100">Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
