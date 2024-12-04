@extends('layouts.app')

@section('content')
<h1 class="text-center font-weight-bold">Mis Empresas</h1>

@livewire('admin.empresa.mis-empresas', ['tipoRuta' => $tipoRuta])



@endsection