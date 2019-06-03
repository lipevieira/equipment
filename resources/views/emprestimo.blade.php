@extends('adminlte::page')

@section('title', 'Equipamento Emprestrados')

@section('content_header')
    <h1>Equipamento Emprestrados</h1>
@stop

@section('content')
<div class="box">
   <div class="box-body">
      <table id="tblEmprestimo" class="table table-bordered table-hover" style="width:100%">
         <thead>
            <tr>
               <th class="cod">#</th>
               <th>SERIAL</th>
               <th>SAIDA</th>
               <th>EQUIPAMENTO</th>
               <th>DESTINO</th>
               <th>NOME</th>
               <th>DATA-SAIDA</th>
               <th>DATA-DEVOLUÇÃO</th>
               <th>TOMBO</th>
               <th>TELEFONE</th>
               <th>DESCRICÃO</th>               
               <th class="actions">AÇÕES</th>
            </tr>
         </thead>
         <tbody>
           
         </tbody>
      </table>
   </div>
</div>

{{-- Modal para editar equipamento emprestados--}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalEmprestimo">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title">Editar equipamentos emprestados</h3>
         </div>
         <div class="modal-body">
             <!-- Mostrar uma messagem error de validaçãode campos -->
               <div class="alert alert-danger " style="display: none; " id="dangerEmprestimo">
                  <ul ></ul>
               </div>
           <form id="CadEmprestimo" method="POST">
                  {!! csrf_field() !!}
               <input type="hidden" class="form-control is-invalid" id="id" name="id" value="">   
               <div class="form-group col-md-6">
                  <label for="txtCadLocal">Destino:</label>
                  <input type="text" class="form-control is-invalid" id="destino" name="destino" placeholder="Destino" value="" >
                  <label for="txtCadSetor">Telefone:</label>
                  <input type="text" class="form-control is-valid" id="telefone" name="telefone" placeholder="Telefone" value="" >
               </div>
               <div class="form-group col-md-6">
                  <label for="data_saida">Data de Saida:</label>             
                   <input type="date" class="form-control is-invalid" id="data_saida" name="data_saida" placeholder="Data de Saida" aria-describedby="inputGroupPrepend3"value="">

                  <label for="txtCadUsuario">Data de Devolução:</label>
                  <input type="date" class="form-control is-invalid" id="data_devolucao" name="data_devolucao" placeholder="Data de Devolução" aria-describedby="inputGroupPrepend3"value="">
               </div>
               <div class="form-group col-md-12">
                  <label for="txtCadSetor">Nome:</label>
                  <input type="text" class="form-control is-valid" id="nome" name="nome" placeholder="Nome" value="" >
               </div>
               <div class="form-group col-md-12">
                  <label for="message-text" class="col-form-label">Descrição/Observação:</label>
                  <textarea class="form-control" id="descricao" name="descricao"></textarea>
               </div>
               <div class="modal-footer ">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                     <span class="glyphicon glyphicon-remove"></span> Fechar
                  </button>
                  <button type="button" class="btn btn-success btn-sm" id="btnAtualizar"  data-url="{{route('updateEmprestimo')}}">
                     <span class="glyphicon glyphicon-pencil"></span> Atualizar
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>

<!-- Modal confirma a exclusão de equipamentos no sistema -->
<div class="modal" tabindex="-1" role="dialog" id="confirmaDevolucao" >
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <center><h3>Deseja realmente devolver este equipamento?</h3></center>
         <form method="POST"> 
               {!! csrf_field() !!}
               <input type="hidden" name="id_equipamento" value="" id="id_equipamento">
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
               <button type="button" class="btn btn-danger" id="btnConfirmarDevolver">
                 <span class="glyphicon glyphicon-remove"></span> Confirmar Devolução
               </button>
            </div>
         </form>
      </div>
   </div>
</div>
    
@stop

@section('css')
   <link rel="stylesheet" href="{{env('APP_URL')}}assets/emprestimo/css/emprestimo.css">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
@stop

@section('js')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
    <script type="text/javascript" language="javascript" src="{{env('APP_URL')}}/assets/emprestimo/js/emprestimo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> 
   <script>
      /* 
       *Gerar segunda via dos equipamentos emprestados
       *retorna uma pagina com o recibo do equipamento.
       */
      function showEquipamentoEmprstimo(id){
          window.open('{{env('APP_URL')}}/emprestimo/segundaVia/'+id, '_blank');
      }
      /*
       *Carregando o modal para fazer a edção.
       *retunr: Equipamento para editar 
       */
      function showEquipamentoEdit(id){
      $.ajaxSetup({
         headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
   
      $.ajax({
            type: "POST",
            url: "{{route('showEquipamentoEmprestimo')}}",
            data: {id:id},
            success: function (data) {
               $('#id').val(data.id);
               $('#serial').val(data.serial);
               $('#saida').val(data.saida);
               $('#tombo').val(data.tombo);
               $('#equipamento').val(data.equipamento);
               $('#destino').val(data.destino);
               $('#telefone').val(data.telefone);
               $('#data_saida').val(data.data_saida);
               $('#data_devolucao').val(data.data_devolucao);
               $('#nome').val(data.nome);
               $('#descricao').val(data.descricao);

               $('#modalEmprestimo').modal('show');
            },
         error: function () {
               alert("Ocorreu um erro ao carregar o equipamento para editar.");
            }
         });
   }
   function showEquipamentoDelete(id) {
       $.ajaxSetup({
         headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });

      $.ajax({
         type: "POST",
         url: "{{route('showEquipamentoEmprestimo')}}",
         data: {id:id},
         success: function (data) {
            $('#id_equipamento').val(data.id);

            $('#confirmaDevolucao').modal('show');
         },
         error: function () {
            alert("Ocorreu um erro ao devolver o equipamento.");
         }
      });
   }
   </script>
@stop


