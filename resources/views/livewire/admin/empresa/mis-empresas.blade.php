<div>
    @include('admin.usuarios.modal.modal-empresa')
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEmpresa"> 
            Añadir Empresa <i class="fas fa-building"></i>
        </button>

        @if($tipo !== "none")
        <a type="button" href="/tienda/detalle-subservicios/{{$tipo}}" class="btn btn-success btn-icon">
            Volver a p&aacute;gina de compra&nbsp;<i class="fa fa-reply" aria-hidden="true"></i>
        </a>
        @endif
    </div>

    {{-- <section class="section">
        <div class="row">
            @if ($data->isNotEmpty())
                @foreach ($data as $e)
                    <div class="col-xl-3 col-lg-6">
                        <div class="card">
                            <div class="card-bg">
                                <div class="p-t-20 d-flex justify-content-between">
                                    <div class="col">
                                        <h6 class="mb-0">{{ $e->razon_social }}</h6>
                                        <span class="font-weight-bold mb-0 font-20">{{ $e->ruc }}</span>
                                        <span class="font-weight-bold mb-0 font-20">{{ $e->clave_acceso }}</span>
                                    </div>

                                    <i class="fas fa-building card-icon col-indigo font-30 p-r-30"></i>
                                </div>
                                <canvas id="cardChart1" height="80"></canvas>
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif


        </div>

    </section> --}}


    {{-- <section>
        <div class="row">
            @if ($data->isNotEmpty())
                @foreach ($data as $e)
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4>{{ $e->razon_social }}</h4>
                                <div class="card-header-action">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createEmpresa"
                                        wire:click.prevent="editEmpresa({{ $e->id }})">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger"
                                        wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Empresa?','EliminarEmpresa', {{ $e->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>Write something here</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section> --}}


    <div class="card">
        <div class="card-body">
            <div class="row mb-4 justify-content-between">
                <div class="col-lg-4 form-inline">
                    Por Pagina: &nbsp;
                    <select wire:model="perPage" class="form-control form-control-sm">
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                    </select>
                </div>

                <div class="col-lg-3">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Empresas...">
                </div>
            </div>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center ">
                                RUC
                                <a class="text-primary" wire:click.prevent="sortBy('ruc')" role="button">

                                    @include('includes._sort-icon', ['field' => 'ruc'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center ">
                                Razón Social
                                <a class="text-primary" wire:click.prevent="sortBy('razon_social')" role="button">

                                    @include('includes._sort-icon', ['field' => 'razon_social'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center">Actividad</th>
                            <th class="px-4 py-2 text-center">Per&iacute;odo Declaraciones</th>
                            <th class="px-4 py-2 text-center">Clave Acceso</th>
                            <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->isNotEmpty())
                            @foreach ($data as $e)
                                <tr>
                                    <td class="text-center ">{{ $e->ruc }}</td>
                                    <td class="text-center ">{{ $e->razon_social }}</td>
                                    <td class="text-center ">{{ $e->actividad }}</td>
                                    <td class="text-center ">{{ $e->periodo }}</td>
                                    <td class="text-center ">{{ $e->clave_acceso }}</td>
                                    <td width="10px">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#createEmpresa"
                                            wire:click.prevent="editEmpresa({{ $e->id }})">
                                            Editar
                                        </button>
                                    </td>
                                    <td width="10px">
                                        <button class="btn btn-danger"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Empresa?','EliminarEmpresa', {{ $e->id }})">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">
                                    <p class="text-center">No hay resultado para la busqueda
                                        <strong>{{ $search }}</strong> en la pagina
                                        <strong>{{ $page }}</strong> al mostrar
                                        <strong>{{ $perPage }} </strong> por pagina
                                    </p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    {{ $data->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $data->firstItem() }} a {{ $data->lastItem() }} de
                    {{ $data->total() }} registros
                </div>
            </div>
        </div>
    </div>
</div>
