<div>
  
    <button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="GenerarExcelUsuarioTelefono()">
        <i class="fa fa-file-excel"></i> Generar Reporte
    </button>
    <div class="card">
        <div class="row p-2">
            <div class="col-lg-3 col-sm-12 mt-2">
                <select wire:model="findrole" class="form-control form-control-sm" >
                    <option value="">Roles</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r }}">{{ $r }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Usuario...">
                </div>
            </div>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center">Cedúla</th>
                            <th class="px-4 py-2 text-center ">
                                Nombre y Apellido
                                <a class="text-primary" wire:click.prevent="sortBy('name')" role="button">

                                    @include('includes._sort-icon', ['field' => 'name'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center">Teléfono</th>
                            <th class="px-4 py-2 text-center">Estado</th>
                            <th class="px-4 py-2 text-center">Fecha Registro</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())
                            @foreach ($users as $u)
                                <tr>
                                    <td class="text-center ">{{ $u->cedula }}</td>
                                    <td class="text-center ">{{ $u->name }}</td>
                                    <td class="text-center ">{{ $u->telefono }}</td>
                                    <td class="text-center ">
                                        <span class="float-center  badge badge-success">
                                            {{ $u->estado }}
                                        </span>
                                    </td>
                                    <td class="text-center ">{{ $u->created_at }}</td>
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
                    {{ $users->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $users->firstItem() }} a {{ $users->lastItem() }} de
                    {{ $users->total() }} registros
                </div>
            </div>
        </div>
    </div>


</div>
