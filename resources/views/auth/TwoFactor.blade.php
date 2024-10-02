@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Autenticação de Dois Fatores</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('auth.verify_two_factor_code') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="code">Código de Autenticação:</label>
                                <input type="text"
                                       name="code"
                                       class="form-control @error('code') is-invalid @enderror"
                                       id="code"
                                       placeholder="Digite o código recebido"
                                       required>

                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-100">Verificar Código</button>
                            </div>
                        </form>
                        <div class="mt-4 text-center">
                            {{-- <p>Não recebeu o código? <a href="{{ route('auth.resend_two_factor_code') }}">Reenviar Código</a></p> --}}
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('auth.logout') }}" class="btn btn-link">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
