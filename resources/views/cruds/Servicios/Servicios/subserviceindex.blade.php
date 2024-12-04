@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Administración de Sub Servicios</h1>

<div class="card-body">
        <a type="button" class="btn btn-primary" href="{{route('servicios.subservicio.create')}}" > Crear Subservicio</a>
 </div>

 @livewire('servicios.servicios.subservicio')
 
@endsection