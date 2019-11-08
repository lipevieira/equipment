@extends('adminlte::page')
@section('title', 'Controle de Equipamentos')
@section('content_header')

<h1>Controle de Equipamentos - NTI</h1> 
@stop
@section('content')
{{-- Tabelas de Usuarios do Sistema Controle de Equipamentos --}}
<div class="box">
    <div class="box-header">
        <h4>Gerenciamento de Usuários</h4>
    </div>
    <div class="box-body">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        {{-- Caso acontessa algum error ao enviar arquivo para o servidor mostrar está MSG --}}
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CÓDICO</th>
                    <th scope="col">NOME</th>
                    <th scope="col">E-MAIL</th>
                    <th scope="col">AÇÕES</th>
                </tr>
            </thead>
           <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a href="{{route('resert.user', $user->id)}}" class="btn btn-warning btn-sm" role="button">
                            <span class="glyphicon glyphicon-pencil"></span> Resetar Senha
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" id_user="{{$user->id}}"
                            id="btn_delete_user">
                            <span class="glyphicon glyphicon-trash"></span> Deletar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody> 
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalconfirmationDeleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div style="text-align: center">
                    <h3>Deseja realmente Excluir esse Usuário?</h3>
                </div>
                <form action="{{route('delete.user')}}" method="POST">
                    @csrf
                    <input type="hidden" value="" name="id_user" id="id_user">

            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger btn-sm">Confimar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop
@section('css')
<!-- <link rel="stylesheet" href="{{env('APP_URL')}}assets/equipamento/css/equipamento.css"> -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
@stop
@section('js')
<script>
    $('table tr td #btn_delete_user').on('click', function(){
         let id = $(this).attr("id_user");
         $('#id_user').val(id);

         $('#modalconfirmationDeleteUser').modal('show');
    });
</script>

@stop
