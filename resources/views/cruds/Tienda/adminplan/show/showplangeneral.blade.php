@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Detalle de Compra </h1>
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <img alt="image"
                                    src="{{ Avatar::create($compra->subservicio->nombre)->setFontSize(35)->setChars(2) }}"
                                    class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#">{{ $compra->subservicio->nombre }}</a>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-description">
                                    <p>
                                    </p>
                                </div>
                                <div class="mb-2 mt-3">
                                    <div class="text-small font-weight-bold">{{ $compra->subservicio->nombre }}</div>
                                </div>
                                <div class="w-100 d-sm-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Datos de Compra</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Cliente
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $compra->cliente->name }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Fecha de Compra
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $compra->created_at->diffForHumans() }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Estado
                                    </span>
                                    <span class="float-right  badge badge-danger">
                                        {{ $compra->estado }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Correo Cliente
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $compra->cliente->email }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Tipo Plan
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $compra->tipoplan->nombre }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Costo del Plan
                                    </span>
                                    <span class="float-right ">
                                        <strong>${{ $compra->costo }}</strong>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                        aria-selected="true">Subservicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                        aria-selected="false">Plan</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">
                                    <div class="card-header">
                                        <h4>Detalle Subservicio</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="m-t-30">

                                           
                                            {!!htmlspecialchars_decode($compra->subservicio->descripcion)!!}
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card-header">
                                        <h4>Detalle del Plan</h4>
                                    </div>
                                    <div class="card-body">
                                        
                                    
                                        <p class="m-t-30">
                                            {!!htmlspecialchars_decode($compra->plan->descripcion)!!}
                                          
                                        </p>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
