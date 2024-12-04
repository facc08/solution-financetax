@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Lista de Servicios</h1>

<div class="row">
	@if (!$data->isEmpty())
		@foreach ($data as $p)
		<div class="col-12 col-sm-6 col-md-6 col-lg-4">
			<article class="article article-style-b">
			<div class="article-header">
				<div class="article-image" data-background="">
					@isset($p->documento->archivo)
					<img class="article-image" src="{{$p->documento->archivo}}" alt="">
					@endisset
				</div>
				<div class="article-badge">
				</div>
			</div>
			<div class="article-details" style="height: 220px;">
				<div class="article-title">
					<h2><b><a href="{{route('subservicios.detalle', $p->slug)}}">{{$p->nombre}}</a></b></h2>
				</div>
				<div class="article-cta article-bottom">
					{{--<a class="btn btn-outline-primary" role="button" aria-pressed="true" href="{{route('subservicios', $p->slug)}}">
						Mostrar Subservicios&nbsp;<i class="fas fa-arrow-right"></i>
					</a>--}}
					<a class="btn btn-outline-primary" role="button" aria-pressed="true" href="{{route('subservicios.detalle', $p->slug)}}">
						Obtener Servicio&nbsp;<i class="fa fa-shopping-cart"></i>
					</a>
				</div>
			</div>
			</article>
		</div>
		@endforeach
	@endif
</div>

@endsection