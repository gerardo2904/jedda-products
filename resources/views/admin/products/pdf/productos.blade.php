@extends('layout')

@section('content')
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Sub Categoría</th>
                <th>Activo</th>
                
            </tr>                            
        </thead>
        <tbody>

            @foreach($ps as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->description }}</td>
                <td>{{ $p->categoria }}</td>
                <td>{{ $p->subcategoria }}</td>
                <td>{{ $p->activo ? 'Sí' : 'No' }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection