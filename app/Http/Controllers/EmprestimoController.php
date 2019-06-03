<?php

namespace App\Http\Controllers;

use App\Emprestimo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Response;
use Validator;
use Yajra\DataTables\DataTables;

class EmprestimoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('emprestimo');
    }
    public function emprestimoAll()
    {
        $emprestimos = DB::table('equipamento')
            ->join('emprestimo', 'equipamento.id', '=', 'emprestimo.equipamento_id')
            ->select('emprestimo.id', 'equipamento.serial', 'equipamento.setor', 'equipamento.equipamento', 'emprestimo.destino',
                'emprestimo.nome', 'emprestimo.data_saida', 'emprestimo.data_devolucao', 'equipamento.tombo', 'emprestimo.telefone', 'emprestimo.descricao')
            ->get();
        return Datatables::of($emprestimos)->addColumn('action', function ($emprestimos) {
            return '<a onclick="showEquipamentoEmprstimo(' . $emprestimos->id . ')" class="btn btn-sm btn-primary" id="btnEmpresta"><span class="glyphicon glyphicon-print"></span></a>' . ' ' .
            '<a onclick="showEquipamentoEdit(' . $emprestimos->id . ')" class="btn btn-warning btn-sm "  id="btnEditar"> <span class="glyphicon glyphicon-pencil"></span></a>' . ' ' .
            '<a onclick="showEquipamentoDelete(' . $emprestimos->id . ')" class="btn btn-success btn-sm " id="btnExcluir"> <span class="glyphicon glyphicon-repeat"></span></a>';

        })->make(true);

    }
    public function insertEmprestimo(Request $request)
    {
        $emprestimo = new Emprestimo();
        $rules = $emprestimo->rules();
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(
                'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
            $emprestimo->destino = $request->destino;
            $emprestimo->telefone = $request->telefone;
            $emprestimo->data_saida = $request->data_saida;
            $emprestimo->data_devolucao = $request->data_devolucao;
            $emprestimo->nome = $request->nome;
            $emprestimo->descricao = $request->descricao;
            $emprestimo->equipamento_id = $request->equipamento_id;
            $emprestimo->save();
            return response()->json($emprestimo);
        }
    }
    public function update(Request $request)
    {
        $emprestimo = new Emprestimo();
        $rules = $emprestimo->rulesUpdate();
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(
                'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
            $dataForm = $request->except('_token');
            $emprestimo = Emprestimo::find($request->id);
            $emprestimo->update($dataForm);

            return response()->json($emprestimo);
        }
    }
    public function devolver(Request $request)
    {
        $id = $request->id;
        $emprestimo = Emprestimo::find($id)->delete();
        return response()->json($emprestimo);
    }
    public function segundaViaSaidaEquipamento(Request $request)
    {
        $id = $request->id;
        $equipamentoEmprestado = Emprestimo::find($id);

        return view('recibos.saidaEquipamento', compact('equipamentoEmprestado'));
    }
    public function reciboSaidaEquipamento()
    {
        $equipamentoEmprestado = Emprestimo::orderBy('id', 'desc')->first();
        return view('recibos.saidaEquipamento', compact('equipamentoEmprestado'));
    }
    public function showEquipamentoEmprestimo(Request $request)
    {
        $id = $request->id;
        $emprestimo = Emprestimo::find($id);
        return $emprestimo;
    }
    public function reciboDelucaoEquipamento(Request $request)
    {
        $id    = $request->id;
        $query = Emprestimo::find($id);

        return view('recibos.devolucaoEquipamento', compact('query'));
    }
}
