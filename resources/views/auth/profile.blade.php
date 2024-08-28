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
                        @if ($user->path)
                            <div class="row mb-3">
                                <label class="form-label col-md-4 font-weight-bold">Foto de Perfil:</label>
                                <div class="col-md-8">
                                    <img src="{{ asset('storage/' . $user->path) }}" alt="Foto de Perfil"
                                        style="max-width: 150px; max-height: 150px;">
                                </div>
                            </div>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#updateProfileModal">
                                Editar Perfil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalLabel">Atualizar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha (opcional)</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control mt-2" placeholder="Confirme a nova senha">
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto de Perfil (opcional)</label>
                            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
