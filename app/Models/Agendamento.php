<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = ['dia_agendamento', 'hora_agendamento', 'tipo_carteira', 'local', 'cliente_id', 'cliente_nome', 'cliente_cpf', 'cliente_numero'];

    public function cliente()
    {
           return $this->belongsTo(Cliente::class);
    }
}
