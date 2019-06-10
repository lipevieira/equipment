@extends('layouts.app')

@section('title', 'Contagem de equipamentos')
    
@section('content')
    <h1>Contagem de equipamentos por categoria</h1>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Equipamento</th>
                <th scope="col">Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipamento as $item)
                <tr>
                    <td>{{$item->equipamento }}</td>
                    <td>{{$item->total}}</td>
                </tr>
            @endforeach
        </tbody>
    </table> 
<h4>Total de Equipamentos é: {{$total}}</h4>
@endsection

