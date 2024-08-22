@extends('layouts.app2')

@section('content')
    <div class="container-fluid pt-5">
        <div class="row g-3 justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-header text-center">
                         <h4 class="mb-0">Registro</h4>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <form action="{{ route('auth.processRegister') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" name="password" id="password" class="form-control" required minlength="6">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>

                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


