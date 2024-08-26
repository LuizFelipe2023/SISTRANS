<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cpf','numero_telefone','email','data_nascimento','tipo_carteira','numero_carteira','saldo_carteira','foto_perfil'];

    public function agendamentos()
    {
           return $this->hasMany(Agendamento::class);
    }
}
