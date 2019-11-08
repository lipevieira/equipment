@extends('adminlte::page')

@section('title', 'Editar Link')

@section('content_header')
<h1>Editar Link</h1>
@stop

@section('content')
<div class="box">
    <div class="box-body">
        <div class="modal-header">
            <h2 class="modal-title">Formulário</h2>
        </div>

        @if(isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
            @endforeach
        </div>
        @endif
        {{-- Formulario --}}
        <form action="{{route('link.update',$link->id)}}" method="POST">
            {!! csrf_field() !!}
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom03">SECRETARIA/ÓRGÃO</label>
                <input type="text" class="form-control" id="secretaria_orgao" value="{{$link->secretaria_orgao}}"
                        name="secretaria_orgao">

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom04">NUMERO DO CIRCUITO</label>
                <input type="text" class="form-control" id="numero_circuito" value="{{$link->numero_circuito}}"
                        name="numero_circuito">

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom05">VELOCIDADE</label>
                    <input type="text" class="form-control" id="velocidade" value="{{$link->velocidade}}" name="velocidade">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom03">CEP</label>
                    <input type="text" class="form-control" id="cep" value="{{$link->cep}}" name="cep">

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom04">LOGRADOURO</label>
                <input type="text" class="form-control" id="logradouro" value="{{$link->logradouro}}" name="logradouro">

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom05">PONTO DE REFERÊNCIA</label>
                    <input type="text" class="form-control" id="ponto_referencia" value="{{$link->ponto_referencia}}"
                        name="ponto_referencia">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom03">BAIRRO</label>
                <input type="text" class="form-control" id="bairro" value="{{$link->bairro}}" name="bairro">

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom04">LOCALIDADE</label>
                    <input type="text" class="form-control" id="localidade" value="{{$link->localidade}}" name="localidade">

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom05">NÚMERO</label>
                    <input type="text" class="form-control" id="numero" value="{{$link->numero}}" name="numero">
                </div>
            </div>

            <div class="form-controll col-md-12 mb-3" style="margin-top: 50px;">
                <button class="btn btn-success" type="submit">
                    <span class="glyphicon glyphicon-ok"></span> Atualizar Informações
                </button>
            </div>
        </form>



    </div>
</div>
@stop

@section('css')
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script src="{{asset('assets/link/script.js')}}"></script>
<script src="{{asset('assets/link/jquery.mask.min.js')}}"></script>
@stop