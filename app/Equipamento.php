<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Equipamento extends Model
{
    protected $table = 'equipamento';
    public $timestamps = false;

    public function rules()
    {
        return [
            'local' => 'required|max:40',
            'setor' => 'required|max:40',
            'usuario' => 'required|min:3|max:40',
            'equipamento' => 'required|max:40',
            'descricao' => 'required|max:40',
            'serial' => 'required|unique:equipamento|max:40',
            'fornecedor' => 'required|max:40',
            'marca' => 'required|max:40',
            'observacoes' => 'max:150',
        ];

    }

    public function rulesUpdate()
    // TO-DE FAZER: Tratamento para mostrar meg de error ao tentar inseiri um serial que  já existe
    {
        return [
            'local' => 'required|max:40',
            'setor' => 'required|max:40',
            'usuario' => 'required|min:3|max:40',
            'equipamento' => 'required|max:40',
            'descricao' => 'required|max:40',
            'serial' => 'required|max:40',
            'fornecedor' => 'required|max:40',
            'marca' => 'required|max:40',
            'observacoes' => 'max:190',
        ];
    }
    public function getContagemEquipamento()
    {
        return  DB::table('equipamento')
            ->select('equipamento',DB::raw('count(*) as total'))
            ->groupBy('equipamento')
            ->get();
    }

    protected $fillable = ['local', 'setor', 'usuario', 'equipamento', 'descricao', 'serial', 'fornecedor', 'marca', 'observacoes'];
}
