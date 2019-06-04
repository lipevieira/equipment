<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';
    public $timestamps = false;
    protected $fillable = ['empresa', 'descricao', 'nome'];

    public function rules()
    {
        return [
            'empresa'   => 'required|max:45',
            'descricao' => 'min:3|max:150',
            'nome'   => 'required|max:150',
        ];
    } 
    public function search(Array $date)
    {
        return $this->where(function($query) use($date){
            if (isset($date['empresa'])) 
                $query->where('empresa', $date['empresa']);
            
        })->get();

    }
}
