<div>
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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Servicio...">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <select class="form-control form-control-md" aria-label="Tipo Servicio" wire:change.prevent="tipoChange()" wire:model="tipoServicio">
                        <option selected>Seleccionar Tipo de Servicio</option>
                        @foreach ($tipoServicios as $tipos)
                            <option value="{{ $tipos->id }}">{{ $tipos->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center ">
                                Tipo Servicio
                                <a class="text-primary" wire:click.prevent="sortBy('tipo')" role="button">

                                    @include('includes._sort-icon', ['field' => 'tipo'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center ">
                                Servicio
                                <a class="text-primary" wire:click.prevent="sortBy('nombre')" role="button">

                                    @include('includes._sort-icon', ['field' => 'nombre'])
                                </a>
                            </th>
                            {{-- <th class="px-4 py-2 text-center ">
                                Descripción
                                <a class="text-primary" wire:click.prevent="sortBy('descripcion')" role="button">

                                    @include('includes._sort-icon', ['field' => 'descripcion'])
                                </a>
                            </th> --}}
                            <th class="px-4 py-2 text-center">Estado</th>
                            <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->isNotEmpty())
                            @foreach ($data as $p)
                                <tr>
                                    <td class="text-center ">{{ $p->tipo }}</td>
                                    <td class="text-center ">{{ $p->nombre }}</td>
                                    {{-- <td class="text-center ">{{ $p->descripcion }}</td> --}}
                                    <td class="text-center ">
                                        <span style="cursor: pointer;"
                                            wire:click.prevent="estadochange('{{ $p->id }}')"
                                            class="badge @if ($p->estado == 'activo') badge-success
                                        @else
                                            badge-danger @endif">{{ $p->estado }}</span>
                                    </td>
                                    <td width="10px">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#createService"
                                            wire:click.prevent="editSer({{ $p->id }})">
                                            Editar
                                        </button>
                                    </td>
                                    <td width="10px">
                                        <button class="btn btn-danger"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Servicio?','eliminarService', {{ $p->id }})">
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
