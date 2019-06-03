@extends('adminlte::page')
@section('title', 'Controle de Equipamentos')
@section('content_header')

<h1>Controle de Equipamentos - NTI</h1> 
<div class="total_equipamentos">
  <center><h3>Total de Equipamentos cadastrados no sistema: {{$total_equipamentos}}</h3></center>
</div>
@stop
@section('content')
 <button type="button" class="btn btn-success btn-sm" id="btnInsert">
   <span class="glyphicon glyphicon-plus"></span>  Inseir
 </button><br/>
<div class="box">
   <div class="box-header" >
   </div>
   <div class="box-body">
      <table id="tblEquipamento" class="table table-bordered table-hover " style="width:100%">
         <thead>
            <tr>
               <th width="3">COD</th>
               <th width="10">LOCAL</th>
               <th>SETOR</th>
               <th>USUÁRIO</th>
               <th>HARD/SOFT</th>
               <th>DESCRIÇÃO</th>
               <th>SERIAL</th>
               <th>TOMBO</th>
               <th>FORNECEDOR</th>
               <th>MARCA</th>
               <th>ENDEREÇO/IP</th>
               <th>OBS</th>
               <th class="actions">AÇÔES</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>
<button type="button" class="btn btn-info btn-sm" id="btnAbrirOCS">
   <span class="glyphicon glyphicon-share-alt"></span> Abrir OCS
</button>
<button type="button" class="btn btn-success btn-sm" id="btnAbrirOcomon">
   <span class="glyphicon glyphicon-share-alt"></span> Abrir Ocomon
</button>
<!-- Modal com Formulario para Salvar Equipamentos Equipamentos. -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalInsertUpdate">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h2 class="modal-title">Registro de Equipamentos</h2>
            <div class="modal-body">
               <!-- Mostrar uma messagem error de validaçãode campos -->
               <div class="alert alert-danger " style="display: none; " id="danger">
                  <ul ></ul>
               </div>
               <form class="was-validated needs-validation" method="POST"  id="insertEquipamento" >
                  {!! csrf_field() !!}
                  <div class="form-row ">
                     <div class="form-group col-md-6">
                        <label for="txtCadLocal">Local</label>
                        <input type="text" class="form-control is-invalid" id="txtCadLocal" name="local" placeholder="Local" value="" required>
                        <label for="txtCadSetor">Setor</label>
                        <input type="text" class="form-control is-valid" id="txtCadSetor" name="setor" placeholder="Setor" value="" required>
                        <label for="txtCadUsuario">Usuário</label>
                        <input type="text" class="form-control is-invalid" id="txtCadUsuario" name="usuario" placeholder="Usuário" aria-describedby="inputGroupPrepend3"value=""  required>
                        <label for="softHard">Soft/Hard</label>
                        <input type="text" class="form-control is-invalid" id="softHard" name="equipamento" placeholder="Soft Hard" value=""  required>
                        <label for="txtCadDescricao">Descrição</label>
                        <input type="text" class="form-control is-invalid" id="txtCadDescricao" name="descricao" placeholder="Descrição" value=""  required>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="txtCadSerial">Serial</label>
                        <input type="text" class="form-control is-invalid" id="txtCadSerial" name="serial" placeholder="Serial" value="" required>
                        <label for="txtCadTombo">Tombo</label>
                        <input type="text" class="form-control is-valid" id="txtCadTombo" name="tombo" placeholder="Tombo" value="">
                        <label for="txtCadFornecedor">Fornecedor</label>
                        <input type="text" class="form-control is-valid" id="txtCadFornecedor" name="fornecedor" placeholder="Fornecedor" value="" required>
                        <label for="txtCadMarca">Marca</label>
                        <input type="text" class="form-control is-invalid" id="txtCadMarca" name="marca" placeholder="Marca" aria-describedby="inputGroupPrepend3" value="" required>
                        <label for="txtCadEnderecoIP">Endereço/IP</label>
                        <input type="text" class="form-control is-invalid" id="computador" name="computador" placeholder="Endereço/IP" value="">
                     </div>
                     <div class="form-group col-md-12">
                        <label for="txtCadObs" class="col-form-label">Observações:</label>
                        <textarea class="form-control" id="txtCadObs" name="observacoes" placeholder="Observação" value="" ></textarea>
                     </div>
                     <input type="hidden" name="id" value="" id="id">
                  </div>
                  <div class="form-group col-md-12">
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id='btnFechar'>Fechar</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btnSalvar" data-url="{{route('insert')}}">
                          <span class="glyphicon glyphicon-ok"></span> Salvar
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="btnUpdate" data-url="{{route('update')}}">
                           <span class="glyphicon glyphicon-pencil"></span> Atualizar
                        </button>
                     </div>
                  </div>
            </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
<!-- Modal confirma a exclusão de equipamentos no sistema -->
<div class="modal" tabindex="-1" role="dialog" id="confirmaExclucao" >
   <div class="modal-dialog"  role="document">
      <div class="modal-content ">
         <div class="modal-body">
            <center><h3>Deseja realmente excluir este equipamento?</h3><center>
            <form >
               {!! csrf_field() !!}
               <input type="hidden" name="idExcluir" value="" id="idExcluir">
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-danger" id="btnConfirmarExclusao"  data-url="{{route('delete')}}">
               <span class="glyphicon glyphicon-remove"></span> Confirmar Exclusão 
            </button>
         </div>
      </div>
   </div>
</div>
{{-- Modal para cadastramento de emprestimo de equipamento --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalEmprestimo">
 <div class="modal-dialog modal-lg">
   <div class="modal-content">
      <div class="modal-header">
         <h3 class="modal-title">Emprestimo de Equipamentos</h3>
      </div>
      <div class="modal-body">
            <!-- Mostrar uma messagem error de validaçãode campos -->
            <div class="alert alert-danger " style="display: none; " id="dangerEmprestimo">
               <ul ></ul>
            </div>
         <form id="CadEmprestimo" method="POST">
               {!! csrf_field() !!}
            <div class="form-group col-md-6">
               <label>Codico:</label>
               <input type="text" class="form-control is-invalid" id="id_equipamento" name="equipamento_id" value="" readonly>
               <label>Serial:</label>
               <input type="text" class="form-control is-valid" id="serial" name="serial" value=""readonly>
            </div>
            <div class="form-group col-md-6">
               <label>Saida:</label>
               <input type="text" class="form-control is-valid" id="saida" name="saida" value=""readonly>
               <label>Tombo</label>
               <input type="text" class="form-control is-invalid" id="tombo" name="tombo"aria-describedby="inputGroupPrepend3"value=""readonly>
            </div>
            <div class="form-group col-md-12">
               <label>Equipamento:</label>
               <input type="text" class="form-control is-valid" id="equipamento" name="equipamento" value=""readonly>
            </div>

            <div class="form-group col-md-6">
               <label for="txtCadLocal">Destino:</label>
               <input type="text" class="form-control is-invalid" id="destino" name="destino" placeholder="Destino" value="" required>
               <label for="txtCadSetor">Telefone:</label>
               <input type="number" class="form-control is-valid" id="telefone" name="telefone" placeholder="Telefone" value="" required min="4">
            </div>
            <div class="form-group col-md-6">
               <label for="data_saida">Data de Saida:</label>
                  <input type="date" class="form-control is-invalid datepicker" id="data_saida" name="data_saida" placeholder="Data de Saida"  aria-describedby="inputGroupPrepend3"value=""required>
               <label for="txtCadUsuario">Data de Devolução:</label>
               <input type="date" class="form-control is-invalid" id="data_devolucao" name="data_devolucao" placeholder="Data de Devolução" aria-describedby="inputGroupPrepend3"value=""required>
            </div>
            <div class="form-group col-md-12">
               <label for="txtCadSetor">Nome:</label>
               <input type="text" class="form-control is-valid" id="nome" name="nome" placeholder="Nome" value="" required>
            </div>
            <div class="form-group col-md-12">
               <label for="message-text" class="col-form-label">Descrição/Observação:</label>
               <textarea class="form-control" id="message-text" name="descricao"></textarea>
            </div>
            <div class="modal-footer ">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                  <span class="glyphicon glyphicon-remove"></span> Fechar
               </button>
               <button type="button" class="btn btn-primary btn-sm" id="btnConfirmaEmprestimo"  data-url="{{route('addEmprestimo')}}">
                  <span class="glyphicon glyphicon-ok"></span> Confirmar Emprestimo
               </button>
            </div>
         </form>
      </div>
   </div>
</div>
</div>
</div>

@stop
@section('css')
<link rel="stylesheet" href="{{env('APP_URL')}}assets/equipamento/css/equipamento.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
@stop
@section('js')
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script  type="text/javascript"language="javascript" src="{{env('APP_URL')}}assets/equipamento/js/equipamento.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> 

<script>
   /*Codicos JS para fazer o carregamento de dados
   *do equipamento nos formularios para Edtar, Empresta e excluir 
   *equipamentos.  
   */
function showEquipamentoEdit(id){
 $.ajaxSetup({
      headers:
         { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
   });
   
   $.ajax({
      type: "POST",
      url: "{{route('showEquipamento')}}",
      data: {id:id},
      success: function (data) {
        $('#id').val(data.id);
        $('#txtCadLocal').val(data.local);
        $('#txtCadSetor').val(data.setor);
        $('#txtCadUsuario').val(data.usuario);
        $('#softHard').val(data.equipamento);
        $('#txtCadDescricao').val(data.descricao);
        $('#txtCadSerial').val(data.serial);
        $('#txtCadTombo').val(data.tombo);
        $('#txtCadFornecedor').val(data.fornecedor);
        $('#txtCadMarca').val(data.marca);
        $('#computador').val(data.computador);
        $('#txtCadObs').val(data.observacoes);

        $('#btnSalvar').hide(); // Esconde o botão de salvar para mostar p botão de alterar.
        $('#btnUpdate').show(); // Mostrar o botão de atualizar 
        $('.modal-title').text('Edita Equipamentos');
        $('#modalInsertUpdate').modal('show');
      },
   error: function () {
         alert("Ocorreu um erro ao carregar o equipamento.");
      }
   });
}

function showEquipamentoEmprstimo(id) {
    $.ajaxSetup({
      headers:
         { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
   });
   $.ajax({
      type: "POST",
      url: "{{route('showEquipamento')}}",
      data: {id:id},
      success: function (data) {
        $('#id_equipamento').val(data.id);
        $('#serial').val(data.serial);
        $('#saida').val(data.setor);
        $('#tombo').val(data.tombo);
        $('#equipamento').val(data.equipamento);
        $('#modalEmprestimo').modal('show');
      },
   error: function () {
         alert("Ocorreu um erro ao carregar o equipamento.");
      }
   });
}
function showEquipamentoDelete(id){
    $.ajaxSetup({
      headers:
         { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
   });
    $.ajax({
      type: "POST",
      url: "{{route('showEquipamento')}}",
      data: {id:id},
      success: function (data) {
        $('#idExcluir').val(data.id);  
        $('#confirmaExclucao').modal('show');     
      },
   error: function () {
         alert("Ocorreu um erro ao carregar o equipamento.");
      }
   });
}
</script>

@stop
