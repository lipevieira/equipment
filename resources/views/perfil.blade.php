@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Editar Perfil</h1>
@stop

@section('content')
<h4>Bem-Vindo: {{auth()->user()->name}}</h4>
@if(session('success'))
    <div class="alert alert-success ">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger ">
        {{session('error')}}
    </div>
@endif
<div class="box">
    <div class="box-header">
        <div class="box-body">
        <form method="POST" action="{{route('update-user')}}">
            {!! csrf_field()!!}
                <div class="form-group">
                    <label for="email">Endereço de email</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" value="{{auth()->user()->email}}">
                </div>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control"name="name" aria-describedby="emailHelp" value="{{auth()->user()->name}}">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-success btn-sm">Atualizar</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
@stop