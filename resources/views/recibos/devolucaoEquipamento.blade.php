</html><!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}assets/recibos/recibo.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>Devolução de equipamento</title>
</head>
<body>
<div class="container">

        <h5 class="topo">SEMUR / NTI</h5>
        <h5 class="topo">DEVOLUÇÃO DE EQUIPAMENTO / MATÉRIAL</h5><br/>
        
        <h5 class="data_saida">DATA DE SAIDA: {{date (  'd-m-Y' , strtotime($query->data_saida))}}</h5> <h5 class="data_devolucao">DATA DE DEVOLUÇÃO:{{date (  'd-m-Y' , strtotime($query->data_devolucao))}}</h5><br/>
        <h5 class="especificacao">ESPECIFICAÇÃO/DESCRICAÇÃO: {{$query->descricao}}</h5>
        
        <p class="footer">Recebido por: {{auth()->user()->name}}</p>
        <hr/>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>         
        <h5 class="topo">SEMUR / NTI</h5>
        <h5 class="topo">DEVOLUÇÃO DE EQUIPAMENTO / MATÉRIAL</h5><br/>
        
        <h5 class="data_saida">DATA DE SAIDA: {{date (  'd-m-Y' , strtotime($query->data_saida))}}</h5> <h5 class="data_devolucao">DATA DE DEVOLUÇÃO:{{date (  'd-m-Y' , strtotime($query->data_devolucao))}}</h5><br/>
        <h5 class="especificacao">ESPECIFICAÇÃO/DESCRICAÇÃO: {{$query->descricao}}</h5>
        
        <p class="footer">Recebido por: {{auth()->user()->name}}</p>
        <hr/>
</div>
  
<script src="{{env('APP_URL')}}vendor/adminlte/vendor/jquery/dist/jquery.min.js"></script>  
<script type="text/javascript"language="javascript" src="{{env('APP_URL')}}assets/recibos/recibo.js"></script>
</body>
</html>