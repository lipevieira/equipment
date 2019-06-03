@extends('adminlte::page')

@section('title', 'Documento')

@section('content_header')
    <h1>Documentos da Empresa</h1>
@stop

@section('content')
<div class="box">
   <div class="box-header" >
   </div>
   <div class="box-body">
       <div class="body-table" width="700px">
            <button type="button" class="btn btn-success btn-sm" id="btnInsert">
                <span class="glyphicon glyphicon-plus"></span>  Inseir Documento
            </button><br/><br/>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif      
        <table id="tblEquipamento" class="table table-bordered table-hover ">
              <thead>
                 <tr>
                    <th width="15px">ID</th>
                    <th width="600px">DESCRIÇÃO</th>
                    <th >EMPRESA</th>
                    <th class="actions">AÇÔES</th>
                 </tr>
              </thead>
              @foreach ($documentos as $item)
                <tbody>
                    <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->descricao}}</td>
                        <td>{{$item->empresa}}</td>
                        <td>
                        <a href="{{url('storage/arquivos/'.$item->nome)}}" class="btn btn-info btn-sm"  role="button" target="_b﻿lan﻿k">
                                <span class="glyphicon glyphicon-folder-open"></span> Documento
                        </a>
                        </td>
                    </tr>
                </tbody>
              @endforeach
           </table>
       </div>
   </div>
</div>
{{-- Modal para inserir ou atulizar documentos --}}
<div class="modal fade" id="modalInsertDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Documentos</h5>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('insertDocumento')}}" enctype="multipart/form-data">
            {!! csrf_field() !!}
           <div class="form-group">
            <label for="inputState">Empresa</label>
                <select id="empresa" name="empresa" class="form-control" required>
                    @foreach ($empresa as $item)
                        <option value="" selected disabled></option>
                        <option value="{{$item->fornecedor}}">{{$item->fornecedor}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Documento:</label>
                <input type="file" class="form-control" id="documento" name="documento" required>
            </div>

            <div class="form-group">
                <label for="message-text" class="col-form-label">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span> Fechar
                </button>
                <button type="submit" class="btn btn-primary btn-sm" id="btnSalvar">
                    <span class="glyphicon glyphicon-ok"></span> Salvar
                </button>
                <button type="button" class="btn btn-success btn-sm" id="btnUpdate">
                    <span class="glyphicon glyphicon-pencil"></span> Atualizar
                </button>
            </div>
        </form>
    </div>
  </div>
</div>

@stop

@section('css')
   <link rel="stylesheet" href="{{env('APP_URL')}}assets/documento/css/documento.css">
@stop

@section('js')
    <script  type="text/javascript"language="javascript" src="{{env('APP_URL')}}assets/documento/js/documento.js"></script>

@stop