<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/recibos/recibo.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>Saida de equipamento</title>
</head>
<body>
<div class="container">
{{-- @foreach ($query as $equipamentoEmprestado)
    
@endforeach --}}
        <h5 class="topo">SEMUR / NTI</h5>
        <h5 class="topo">SAIDA DE EQUIPAMENTO / MATÉRIAL</h5><br/>
        
        <h5 class="data_saida">DATA DE SAIDA: {{date (  'd-m-Y' , strtotime($equipamentoEmprestado->data_saida))}}</h5> <h5 class="data_devolucao">DATA DE DEVOLUÇÃO:{{date (  'd-m-Y' , strtotime($equipamentoEmprestado->data_devolucao))}}</h5><br/>
        <h5 class="especificacao">ESPECIFICAÇÃO/DESCRICAÇÃO: {{$equipamentoEmprestado->descricao}}</h5>
        
        
        <h5 class="saida">SAIDA: {{$equipamentoEmprestado->setor}}</h5>
        <h5>RETIRADO POR: {{$equipamentoEmprestado->nome}}</h5>   <h5 class="contato">CONTATO: {{$equipamentoEmprestado->telefone}}</h5>
        
        <h5>DESTINO: {{$equipamentoEmprestado->destino}}</h5> 
        <p class="footer">Fico ciente do seu uso, bem como da devolução do(s) mesmo(s) após o término do trabalho ou serviço</p>
        <hr/>
        <br/><br/><br/><br/><br/>
        
        <h5 class="topo">SEMUR / NTI</h5>
        <h5 class="topo">SAIDA DE EQUIPAMENTO / MATÉRIAL</h5><br/>
        
        <h5 class="data_saida">DATA DE SAIDA: {{date (  'd-m-Y' , strtotime($equipamentoEmprestado->data_saida))}}</h5> <h5 class="data_devolucao">DATA DE DEVOLUÇÃO:{{date (  'd-m-Y' , strtotime($equipamentoEmprestado->data_devolucao))}}</h5><br/>
        <h5 class="especificacao">ESPECIFICAÇÃO/DESCRICAÇÃO: {{$equipamentoEmprestado->descricao}}</h5>
        
        
        <h5 class="saida">SAIDA: {{$equipamentoEmprestado->setor}}</h5>
        <h5>RETIRADO POR: {{$equipamentoEmprestado->nome}}</h5>   <h5 class="contato">CONTATO: {{$equipamentoEmprestado->telefone}}</h5>
        
        <h5>DESTINO: {{$equipamentoEmprestado->destino}}</h5> 
        <p class="footer">Fico ciente do seu uso, bem como da devolução do(s) mesmo(s) após o término do trabalho ou serviço</p>
        <hr/>
</div>
  
<script src="{{env('APP_URL')}}vendor/adminlte/vendor/jquery/dist/jquery.min.js"></script>  
<script type="text/javascript"language="javascript" src="{{env('APP_URL')}}assets/recibos/recibo.js"></script>
</body>
</html>