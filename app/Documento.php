<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Documento extends Model
{
    protected $table = 'documento';
    public $timestamps = false;
    protected $fillable = ['empresa', 'descricao', 'nome'];

    public function rules()
    {
        return [
            'empresa'   => 'required|max:45',
            'descricao' => 'max:190',
            
        ];
    } 
    public function search(Array $date)
    {
        return $this->where(function($query) use($date){
            if (isset($date['empresa'])) 
                $query->where('empresa', $date['empresa']);
            
        })->get();
    }
    public function getEmpresa()
    {
        return  DB::table('equipamento')
            ->select('fornecedor')
            ->orderBy('fornecedor', 'asc')
            ->groupBy('fornecedor')
            ->get();
    }
}
