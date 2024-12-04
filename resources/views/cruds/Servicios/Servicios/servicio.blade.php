@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Servicio</h1>

<div class="card-body">
    <a type="button" class="btn btn-primary" href="{{route('servicios.servicio.create')}}" > Crear Servicio</a>
</div>

@livewire('servicios.servicios.servicio')
@endsection