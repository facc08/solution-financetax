@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Bandeja Entrada - Especialista</h1>

@livewire('tienda.interaccion', ['compra' => $compra], key($compra->id))


@livewire('tienda.especialista-interaccion', ['compra' => $compra])



@endsection
