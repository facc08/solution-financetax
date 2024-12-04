@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Administración del Plan Contable</h1>

    @livewire('mantenimiento.plancontable', ['idEmpresa' => $idEmpresa])

@endsection