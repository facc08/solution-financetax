<div>
    @include('admin.roles.modal.modalrolpermisos')

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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Rol...">
                </div>
            </div>


            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="100" class="px-4 py-2 text-center ">
                                ID
                                <a class="text-primary" wire:click.prevent="sortBy('id')" role="button" href="#">                               
                                @include('includes._sort-icon', ['field' => 'id'])
                                </a>
                            </th>
                            <th width="150" class="px-4 py-2 text-center ">
                                Rol
                                <a class="text-primary" wire:click.prevent="sortBy('name')" role="button" href="#">
                                    @include('includes._sort-icon', ['field' => 'name'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center ">Permisos</th>
                            <th class="px-4 py-2 text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($roles->isNotEmpty())
                        @foreach ($roles as $r)
                        <tr>
                            <td width="100" class="p-1 text-center ">{{ $r->id }}</td>
                            <td class="p-1 text-center  ">{{ $r->name }}</td>
                            <td class="p-1  text-dark">
                                @foreach ($r->permissions as $permisio)
                                <div class="badge badge-dark">{{ $permisio->name }}</div>
                                    {{-- <span class="text-capitalize badge badge-secondary mb-1">{{ $permisio->name }}</span> --}}
                                @endforeach
                            </td>
                            <td class="p-1 text-center" width="25">
                                <a class="btn btn-icon btn-warning" data-toggle="modal"
                                    data-target="#modalPermisos"
                                    wire:click.prevent="editPermisos('{{ $r->name }}')">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="10">
                                <p class="text-center">No hay resultado para la busqueda
                                    <strong>{{ $search }}</strong> en la pagina
                                    <strong>{{ $page }}</strong> al mostrar <strong>{{ $perPage }}
                                    </strong> por pagina
                                </p>
                            </td>
                        </tr>
                         @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
