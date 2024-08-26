@extends('layouts.app')

@section('content')
    <div class="container-md">
        <div class="card shadow rounded">
            <div class="card-header  text-black text-center rounded-top">
                <h4>Formulário de Cadastro de Usuário</h4>
            </div>
            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data" >
                    @csrf

                    <div class="form-group mb-4">
                        <label for="nome" class="form-label">Nome</label>
                        <div class="input-group">
                            <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
                        </div>
                        @error('nome')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="cpf" class="form-label">CPF</label>
                        <div class="input-group">
                            <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf') }}" required>
                        </div>
                        @error('cpf')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="numero_telefone" class="form-label">Número de Telefone</label>
                        <div class="input-group">
                            <input type="text" name="numero_telefone" id="numero_telefone" class="form-control"
                                value="{{ old('numero_telefone') }}" required>
                        </div>
                        @error('numero_telefone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <div class="input-group">
                            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control"
                                value="{{ old('data_nascimento') }}" required>
                        </div>
                        @error('data_nascimento')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                        <div class="input-group">
                            <input type="file" name="foto_perfil" id="foto_perfil" class="form-control">
                        </div>
                        @error('foto_perfil')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Criar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
