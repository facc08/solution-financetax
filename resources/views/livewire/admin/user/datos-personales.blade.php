<div>

    @include('admin.usuarios.modal.modaldatos-personales')
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditUser" wire:click.prevent="EditDatos()"> <i class="fas fa-edit"></i>&nbsp;Actualizar Datos
            Usuario</button>
    </div>
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                @if (Auth::user()->image)
                                    <img src="{{ url(Auth::user()->image) }}" border="1" alt="avatar" width="50%" height="auto">
                                @endif
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#">{{ Auth::user()->name }}</a>
                                </div>
                                <div class="author-box-job">{{ Auth::user()->roles[0]->name }}</div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-description">
                                    {{-- texto para detalle --}}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>Detalles</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        <b>Fecha Nacimiento</b>
                                    </span>
                                    @foreach ($data as $item)
                                        <span class="float-right text-muted">
                                            {{ $item->fecha_n }}
                                        </span>
                                    @endforeach

                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        <b>Tel&eacute;fono</b>
                                    </span>
                                    @foreach ($data as $item)
                                        <span class="float-right text-muted">
                                            {{ $item->telefono }}
                                        </span>
                                    @endforeach
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        <b>Correo Electr&oacute;nico</b>
                                    </span>
                                    @foreach ($data as $item)
                                        <span class="float-right text-muted">
                                            {{ $item->email }}
                                        </span>
                                    @endforeach
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                    <b>Tipo de Contribuyente</b>
                                    </span>
                                    @foreach ($data as $item)
                                        <span class="float-right text-muted">
                                            @if(!empty($item->tipo_contribuyente->descripcion))
                                                {{ $item->tipo_contribuyente->descripcion }}
                                            @endif
                                        </span>
                                    @endforeach
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
                                        aria-selected="true"><b>Datos Personales</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings"
                                        role="tab" aria-selected="false"><b>Contraseña</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#imagen"
                                        role="tab" aria-selected="false"><b>Foto Perfil</b></a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel"
                                    aria-labelledby="home-tab2">

                                    @foreach ($data as $item)
                                        <form method="post" class="needs-validation">
                                            <div class="card-header">
                                                <h4>Perfil</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-md-8 col-12">
                                                        <label>Cédula</label>
                                                        <br>
                                                        {{ $item->cedula }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>Nombre y Apellido</label>
                                                        <br>
                                                        {{ $item->name }}
                                                    </div>
                                                    <div class="form-group col-md-6 col-12">
                                                        <label>Correo Electrónico</label>
                                                        <br>
                                                        {{ $item->email }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-7 col-12">
                                                        <label>Edad</label>
                                                        <br>
                                                        {{ $item->edad }}
                                                    </div>
                                                    <div class="form-group col-md-5 col-12">
                                                        <label>Genero</label>
                                                        <br>
                                                        {{ $item->genero }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-7 col-12">
                                                        <label>Ciudad</label>
                                                        <br>
                                                        @isset($item->city->nombre)
                                                            {{ $item->city->nombre }}
                                                        @endisset
                                                    </div>
                                                    <div class="form-group col-md-5 col-12">
                                                        <label>Teléfono</label>
                                                        <br>
                                                        {{ $item->telefono }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-7 col-12">
                                                        <label>Domicilio</label>
                                                        <br>
                                                        {{ $item->domicilio }}
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endforeach

                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel"
                                    aria-labelledby="profile-tab2">
                                    @livewire('admin.user.contrasena')
                                </div>
                                <div class="tab-pane fade" id="imagen" role="tabpanel" aria-labelledby="profile-tab3">

                                    @livewire('admin.user.foto-perfile')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
