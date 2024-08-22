@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Redefinir Senha</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('auth.reset.password') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="token" class="form-label">Token de Redefinição:</label>
                                <input type="text" name="token" id="token" class="form-control form-control-lg">
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" value="{{ $email }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Nova Senha:</label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Senha:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-md w-100 rounded shadow">Redefinir Senha</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
