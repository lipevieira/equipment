@extends('adminlte::page')

@section('title', 'Links')

@section('content_header')
<h1>DEMANDA DE ACESSOS DE COMUNICAÇÃO DE DADOS (Atual e Futura)</h1>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<a href="{{route('insert.show')}}" class="btn btn-success btn-sm" role="button" aria-pressed="true">
    <span class="glyphicon glyphicon-plus"></span> Inseir Link
</a><br><br>

<div class="box">
    <div class="box-body">
        <div class="modal-header">
            <h2 class="modal-title">Links Cadastrados</h2>
             <table class="table table-bordered table-hover table-sm" id="tblLink">
                <thead>
                    <tr>
                        <th scope="col">COD</th>
                        <th scope="col">SECRETARIA/ÓRGÃO</th>
                        <th scope="col">NUMERO DO CIRCUITO</th>
                        <th scope="col">VELOCIDADE</th>
                        <th scope="col">LOGRADOURO</th>
                        <th scope="col">NÚMERO</th>
                        <th scope="col">BAIRRO</th>
                        <th scope="col">PONTO DE REFERÊNCIA</th>
                        <th scope="col">CEP</th>
                        <th scope="col">LOCALIDADE</th>
                        <th scope="col">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($links as $item)
                    <tr>
                        <th scope="row">{{$item->id}}</th>
                        <td>{{$item->secretaria_orgao}}</td>
                        <td>{{$item->numero_circuito}}</td>
                        <td>{{$item->velocidade}}</td>
                        <td>{{$item->logradouro}}</td>
                        <td>{{$item->numero}}</td>
                        <td>{{$item->bairro}}</td>
                        <td>{{$item->ponto_referencia}}</td>
                        <td>{{$item->cep}}</td>
                        <td>{{$item->localidade}}</td>
                        <td class="actions_tables">
                            <a href="{{route('link.show',$item->id)}}" class="btn btn-warning btn-sm" role="button"
                                aria-pressed="true">
                                <span class="glyphicon glyphicon-pencil"></span> Editar
                            </a>
                            <button class="btn btn-danger btn-sm" id="btnDelete" id_link="{{$item->id}}"
                                data-url="{{route('link.show.delete')}}">
                                <span class="glyphicon glyphicon-trash"></span> Excluir
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
     <!-- Modal confirma a exclusão de cliente no sistema -->
    <div class="modal" tabindex="-1" role="dialog" id="confirmaExclucao">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-body">
                    <center>
                        <h4>Deseja realmente excluir este Link?</h4>
                        <center>
                            <form method="POST" action="{{route('link.delete')}}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="id_excluir" id="id_excluir" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger btn-sm">
                        Confirmar Exclusão
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
    @stop

    @section('css')
   
    @stop

    @section('js')
        <script src="{{asset('js/libs/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{asset('js/libs/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('js/libs/jszip.min.js')}}"></script>
        <script src="{{asset('js/libs/pdfmake.min.js')}}"></script>
        <script src="{{ asset('js/libs/vfs_fonts.js') }}"></script>
        <script src="{{ asset('js/libs/buttons.html5.min.js') }}"></script>
        <script src="{{asset('assets/link/jquery.mask.min.js')}}"></script>
        <script src="{{asset('assets/link/script.js')}}"></script>
    @stop