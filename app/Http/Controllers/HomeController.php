<?php

namespace App\Http\Controllers;

use App\Equipamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Response;
use Validator;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $total_equipamentos = Equipamento::all()->count();
        return view('home', compact('total_equipamentos'));
    }
    public function equipamentoAll()
    {
        $equipamento = Equipamento::all();
        // return DataTables::of($equipamento)->make(true);
        return Datatables::of($equipamento)
            ->addColumn('action', function ($equipamento) {
                return '<a onclick="showEquipamentoEmprstimo(' . $equipamento->id . ')" class="btn btn-sm btn-primary" id="btnEmpresta"> <span class="glyphicon glyphicon-transfer"></span></a>' . ' ' .
                    '<a onclick="showEquipamentoEdit(' . $equipamento->id . ')" class="btn btn-warning btn-sm "  id="btnEditar"> <span class="glyphicon glyphicon-pencil"></span></a>' . ' ' .
                    '<a onclick="showEquipamentoDelete(' . $equipamento->id . ')" class="btn btn-danger btn-sm " id="btnExcluir"> <span class="glyphicon glyphicon-trash"></span></a>';
            })->make(true);
    }
    public function insert(Request $request)
    {
        $equipamento = new Equipamento();
        $rules = $equipamento->rules();
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(
                'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
            $dataForm = $request->except('_token');
             unset($dataForm['id']);
            $equipamento->insert($dataForm);
            return response()->json($equipamento);
        }
    }
    public function update(Request $request)
    {
        $equipamento = new Equipamento();
        $dataForm = $request->except('_token');
        $rules = $equipamento->rulesUpdate();

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(array(
                'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
            $equipamento = Equipamento::find($request->id);
            $equipamento->update($dataForm);
            return response()->json($equipamento);
        }
    }

    public function delete(Request $request)
    {
        Equipamento::find($request->id)->delete();
        return response()->json();
    }
    public function showEquipamento(Request $request)
    {
        $id = $request->id;
        $equipamento = Equipamento::find($id);

        return $equipamento;
    }
    public function contagemEquipamento()
    {
        $equipamento =  new Equipamento();
        $equipamento = $equipamento->getContagemEquipamento();

        $total = Equipamento::all()->count();
        // return view('contagemEquipamento.contagemEquipamento', compact('equipamento', 'total'));
        $pdf = PDF::loadView( 'contagemEquipamento.contagemEquipamento', compact('equipamento', 'total'));
        return $pdf->download('relatório.pdf');
    }
   
}
