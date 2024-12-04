@extends('layouts.app')

@section('content')

<style>
.card-box {
    position: relative;
    color: #fff;
    padding: 20px 10px 40px;
    margin: 20px 0px;
}
.card-box:hover {
    text-decoration: none;
    color: #f1f1f1;
}
.card-box:hover .icon i {
    font-size: 100px;
    transition: 1s;
    -webkit-transition: 1s;
}
.card-box .inner {
    padding: 5px 10px 0 10px;
}
.card-box h3 {
    font-size: 35px;
    font-weight: bold;
    margin: 0 0 8px 0;
    white-space: nowrap;
    padding: 0;
    text-align: left;
}
.card-box p {
    font-size: 22px;
}
.card-box .icon {
    position: absolute;
    top: auto;
    bottom: 5px;
    right: 5px;
    z-index: 0;
    font-size: 72px;
    color: rgba(0, 0, 0, 0.15);
}
.card-box .card-box-footer {
    position: absolute;
    left: 0px;
    bottom: 0px;
    text-align: center;
    padding: 3px 0;
    color: rgba(255, 255, 255, 0.8);
    background: rgba(0, 0, 0, 0.1);
    width: 100%;
    text-decoration: none;
}
.card-box:hover .card-box-footer {
    background: rgba(0, 0, 0, 0.3);
}
.bg-primary {
    background-color: #a623e7 !important;
}
.bg-red {
    background-color: #ee1c36 !important;
}
.bg-orange {
    background-color: #f39c12 !important;
}

</style>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="jumbotron text-center" id="jumbotron-home">
                <br>
                <h3>{{ __('Bienvenido') }} {{$usuario->name}}</h3>
                <p>&Uacute;ltima sesi&oacute;n:&nbsp;{{date_format(date_create($usuario->access_at),"d/m/Y H:i")}}</p>

                <div class="row">
                    <div class="col-lg-2 col-sm-6">
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card-box bg-primary">
                            <div class="inner">
                                <h3> {{$panel1}} </h3>
                                <p> {{$panel1Text}} </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cubes" aria-hidden="true"></i>
                            </div>
                            <a href="{{$panel1Url}}" class="card-box-footer">Ver m&aacute;s <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card-box bg-red">
                            <div class="inner">
                                <h3> {{$panel2}} </h3>
                                <p> {{$panel2Text}} </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-briefcase" aria-hidden="true"></i>
                            </div>
                            <a href="{{$panel2Url}}"" class="card-box-footer">Ver m&aacute;s <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                    </div>
                </div>
                <br>
                @if($clienteFlag)
                <table class="table table-striped table-dark">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white"><i class="fas fa-briefcase"></i>&nbsp;Servicio Contratado</th>
                            <th class="text-white"><i class="fas fa-clipboard-list"></i>&nbsp;Plan</th>
                            <th class="text-white"><i class="far fa-calendar-alt"></i>&nbsp;Fecha Caducidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contratados as $co)
                        <tr>
                            <td>{{$co->servicio}}</td>
                            <td>{{$co->tipoplan}}</td>
                            @if($co->diasRestantes > 30)
                                <td>{{$co->fecha_caducidad}}&nbsp;&nbsp;<span class="badge badge-success">{{$co->diasRestantes}} D&iacute;a(s) restantes</span></td>
                            @elseif($co->diasRestantes > 15 && $co->diasRestantes < 30)
                                <td>{{$co->fecha_caducidad}}&nbsp;&nbsp;<span class="badge badge-warning text-dark">{{$co->diasRestantes}} D&iacute;a(s) restantes</span></td>
                            @elseif($co->diasRestantes < 15 && $co->diasRestantes > 0)
                                <td>{{$co->fecha_caducidad}}&nbsp;&nbsp;<span class="badge badge-danger">{{$co->diasRestantes}} D&iacute;a(s) restantes</span></td>
                            @elseif($co->diasRestantes == 0 || $co->diasRestantes < 0)
                                <td>{{$co->fecha_caducidad}}&nbsp;&nbsp;<span class="badge badge-dark text-white">0 D&iacute;a(s) restantes - Caducado</span></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>
            {{--<div class="card">
                <div class="card-header"><b></b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                </div>
            --}}

            

        </div>
    </div>
@endsection
