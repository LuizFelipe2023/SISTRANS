@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg border-light rounded">
                    <div class="card-header text-center">
                        <h4>Verificação de Token</h4>
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

                        <form action="{{ route('auth.token.process') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="token" class="form-label">Token</label>
                                <input type="text" name="token" class="form-control @error('token') is-invalid @enderror" id="token" placeholder="Insira o token" required>
                                @error('token')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <input type="hidden" name="email" value="{{ $email }}">

                            <button type="submit" class="btn btn-primary w-100">Verificar Token</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
