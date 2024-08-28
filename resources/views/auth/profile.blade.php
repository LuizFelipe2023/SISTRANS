@extends('layouts.app2')

@section('content')
<div class="container-fluid pt-5">
    <div class="row g-3 justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-light rounded">
                <div class="card-header text-center">
                    <h4 class="mb-0">Informações do Perfil</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="name" class="form-label col-md-4 font-weight-bold">Nome:</label>
                        <div class="col-md-8">
                            <p class="form-control-plaintext">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="form-label col-md-4 font-weight-bold">E-mail:</label>
                        <div class="col-md-8">
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
