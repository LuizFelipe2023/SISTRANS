@extends('layouts.app2')

@section('content')
    <div class="container-fluid pt-5">
        <div class="row g-3 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Login</h4>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <form action="{{ route('auth.processLogin') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-primary">Entrar</button>
                                </div>

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
