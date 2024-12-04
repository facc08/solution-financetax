@extends('layouts.app')

@section('content')

<h1 class="text-center font-weight-bold">Lista de Sub Servicios</h1>
    <h3 class="text-center font-weight-bold">{{$servicio->nombre}}</h3>
            <div id="accordion">
            @if ($data->isNotEmpty())
            @foreach ($data as $p)
            <div class="card">
                <div class="card-header" id="heading{{$p->id}}">
                    <a href="{{route('subservicios.detalle', $p->slug)}}" data-toggle="collapse" data-target="#collapse{{$p->id}}" aria-controls="collapse{{$p->id}}" aria-expanded="false">
                        <span style="display: -webkit-inline-box;">
                        <i class="fas fa-angle-down rotate-icon" style="font-size: 1.2rem;"></i>&nbsp;&nbsp;<h4 class="mb-0">{{$p->nombre}}</h4>
                        </span>
                    </a>
                </div>

                <div id="collapse{{$p->id}}" class="collapse" aria-labelledby="heading{{$p->id}}" data-parent="#accordion" style="background-color: #efeeff">
                <div class="card-body">
                    <div class="row col col-lg-12">
                        <div class="col col-lg-4">
                            <img class="article-image" src="{{$p->documento->archivo}}" alt="">
                        </div>
                        <div class="col col-lg-8">
                            {!!htmlspecialchars_decode($p->descripcion)!!}
                        </div>
                    </div>
                    <div class="row pull-right">
                        <a class="btn btn-primary btn-lg" href="{{route('subservicios.detalle', $p->slug)}}">
                            <h6 class="mb-0">Adquirir Servicio <i class="fa fa-shopping-cart" aria-hidden="true"></i></h6>
                        </a>
                    </div>
                    <br><br>
                </div>
                </div>
            </div>

            {{--<div class="col col-lg-4">
                <div class="card box-shadow">
                    <img class="article-image" src="{{$p->documento->archivo}}" alt="">
                    <div class="card-body">
                        <h4 class="text-center"><a href="#">{{$p->nombre}}</a></h4>
                        <h1 class="card-title pricing-card-title text-center">$0 <small class="text-muted">/ mes</small></h1>
                        <p>
                            {!!htmlspecialchars_decode($p->descripcion)!!}
                        </p>
                        <a class="btn btn-lg btn-block btn-outline-primary" href="{{route('subservicios.detalle', $p->slug)}}">Adquirir Servicio</a>
                    </div>
                </div>
                </div>--}}
                {{--<tr>
                    <td >
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
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
                                <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="#">{{$p->nombre}}</a></h2>
                                </div>
                                <p>
                                    {!!htmlspecialchars_decode($p->descripcion)!!}
                                </p>
                                <div class="article-cta">
                                    <a href="{{route('subservicios.detalle', $p->slug)}}"> Leer Más <i class="fas fa-chevron-right"></i></a>
                                </div>
                                </div>
                            </article>
                            </div>
                    </td>
                </tr>--}}
            @endforeach
        @endif
        </div>

@endsection