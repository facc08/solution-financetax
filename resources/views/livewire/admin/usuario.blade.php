<div>
    @include('admin.usuarios.modal.modaluser')
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUser"> Crear
            Usuario</button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-body p-0">

                <div class="row p-2">
                    <div class="col-lg-3 col-sm-12 mt-2">
                        <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                            placeholder="Buscar Usuario...">
                    </div>
                    <div class="col-lg-2 col-sm-12 mt-2">
                        <select wire:model="orderBy" class="custom-select " id="grid-state">
                            <option value="name">Nombres</option>
                            <option value="email">Correo</option>

                        </select>

                    </div>
                    <div class="col-lg-2 col-sm-12 mt-2">
                        <select wire:model="orderAsc" class="custom-select " id="grid-state">
                            <option value="1">Ascendente</option>
                            <option value="0">Descenente</option>
                        </select>

                    </div>
                    <div class="col-lg-3 col-sm-12 mt-2">
                        <select wire:model="findrole" class="custom-select " id="grid-state">
                            <option value="">Roles</option>
                            @foreach ($roles as $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-lg-2 col-sm-12 mt-2">
                        <select wire:model="perPage" class="custom-select " id="grid-state">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="">
                                <th class="px-4 py-2 text-center ">ID</th>
                                <th class="px-4 py-2 text-center ">Nombre</th>
                                <th class="px-4 py-2 text-center ">Email</th>
                                <th class="px-4 py-2 text-center ">Rol</th>
                                <th class="px-4 py-2 text-center ">Estado</th>
                                <th class="px-4 py-2 text-center ">Ultimo Acceso</th>
                                <th class="px-4 py-2 text-center " colspan="2">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->isNotEmpty())
                                @foreach ($data as $c)
                                    <tr>
                                        <td class="text-center ">{{ $c->id }}</td>
                                        <td class="text-center ">{{ $c->name }}</td>
                                        <td class="text-center ">{{ $c->email }}</td>
                                        <td class="text-center "> {{ $c->roles[0]->name }}</td>
                                        <td class="text-center ">
                                            <span style="cursor: pointer;"
                                                wire:click.prevent="estadochange('{{ $c->id }}')"
                                                class="badge @if ($c->estado == 'activo') badge-success
                                            @else
                                                badge-danger @endif">{{ $c->estado }}</span>
                                        </td>
                                        <td class="text-center ">
                                            @isset($c->access_at)
                                                {{ Carbon\Carbon::parse($c->access_at)->diffForHumans() }}
                                            @else
                                                Sin Ingreso
                                            @endisset

                                        </td>
                                        <td width="10px">
                                            <button class="btn btn-warning" data-toggle="modal"
                                                data-target="#createUser"
                                                wire:click.prevent="EditUser({{ $c->id }})">
                                                Editar
                                            </button>
                                        </td>
                                        <td width="10px">
                                            <button class="btn btn-danger"
                                                wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Usuario?','EliminarUsuario', {{ $c->id }})">
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
