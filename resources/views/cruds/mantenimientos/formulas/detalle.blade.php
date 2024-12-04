@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Lista de F&oacute;rmulas</h1>

    @livewire('mantenimiento.formulas-contable', ['shop_id' => $shop_id])

@endsection