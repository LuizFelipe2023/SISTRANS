@extends('layouts.app')

@section('content')
    <div class="container-md mt-5">
        <div class="card shadow-lg rounded">
            <div class="card-header text-black text-center rounded-top">
                <h4>Formulário de Edição de Usuário</h4>
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

                <form action="{{ route('clientes.update', ['id' => $cliente->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $cliente->nome) }}" required>
                        @error('nome')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf', $cliente->cpf) }}" required>
                        @error('cpf')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="numero_telefone" class="form-label">Número de Telefone</label>
                        <input type="text" name="numero_telefone" id="numero_telefone" class="form-control" value="{{ old('numero_telefone', $cliente->numero_telefone) }}" required>
                        @error('numero_telefone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $cliente->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" value="{{ old('data_nascimento', $cliente->data_nascimento) }}" required>
                        @error('data_nascimento')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                        @if ($cliente->foto_perfil)
                            <div class="mb-2">
                                <img src="{{ asset('storage/imgs/' . $cliente->foto_perfil) }}" alt="Foto de Perfil" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                        @endif
                        <input type="file" name="foto_perfil" id="foto_perfil" class="form-control">
                        @error('foto_perfil')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
