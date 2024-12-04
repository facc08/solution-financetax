@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Bandeja Entrada</h1>


@livewire('cliente.interaccion', ['compra' => $compra], key($compra->id))

@livewire('cliente.cliente-interaccion', ['compra' => $compra], key($compra->id))
@endsection
