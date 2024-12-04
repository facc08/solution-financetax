@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Proyección Gastos Personales</h1>

<div class="card">
    <div class="card-body">
        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th colspan="2">Empresas Añadidas</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($empresas as $emp)
                <tr>
                    <td>{{$emp->nombreEmpresa}}</td>
                    <td>
                        <a class="btn btn-primary" href="/servicios/proyeccion-gastos-personales/{{$emp->idEmpresa}}" role="button" data-toggle="tooltip" data-placement="top" title="Ver Proyecciones"><i class="far fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection