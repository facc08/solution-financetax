@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Planes</h1>

<div class="card-body">
    <a type="button" class="btn btn-primary" href="{{route('servicios.planes.create')}}" > Crear Plan</a>
</div>

@livewire('servicios.planes.planes')
@endsection