<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['secretaria_orgao', 'numero_circuito', 'velocidade', 'logradouro', 'numero', 'bairro', 'ponto_referencia', 'cep', 'localidade'];
    public $timestamps = false;
}
