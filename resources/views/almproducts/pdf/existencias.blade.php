@extends('layout')

@section('content')
    
    <div class="row">
        <img style="width:150px; height:130px;" src="{{ $cim }}" alt="Rounded Raised" class="img-rounded img-responsive img-raised">
        <h3 class="title text-left">Inventario de {{ $cia->name }}  </h3>
    </div>


    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Lote</th>
                <th>Descripción</th>
                <th>Cantidad/Largo</th>
                <th>Existencia</th>
            </tr>                            
        </thead>
        <tbody>

            @foreach($ps as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->etiqueta_prod }}</td>
                <td>{{ $p->description }}</td>
                <td>{{ $p->cantidad_prod }}</td>
                <td>{{ $p->existencia}}</td>
               
                
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection