<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    protected $table = 'emprestimo';
    public $timestamps = false;

    public function rules()
    {
        return [
            'destino' => 'required|max:40',
            'nome' => 'required|max:40',
            'data_devolucao' => 'required|max:10',
            'descricao' => 'required|max:195',
            'numero' => 'max:150',
            'data_saida' => 'max:10',
            'numero' => 'max:11',
        ];

    }
    public function rulesUpdate()
    {
        return [
            'destino' => 'required|max:40',
            'nome' => 'required|max:40',
            'data_devolucao' => 'required|max:10',
            'descricao' => 'required|max:195',
            'numero' => 'max:150',
            'data_saida' => 'max:10',
            'numero' => 'max:11',
        ];

    }
    protected $fillable = ['destino', 'nome', 'data_devolucao', 'descricao', 'numero', 'data_saida', 'numero', 'marca', 'equipamento_id'];
}
