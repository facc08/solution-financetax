<div>
    @include('cruds.mantenimientos.formulas.modal.modalformulascontable')
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createFormula"> Crear F&oacute;rmula</button>
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
            </div>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center ">
                                Nombre
                            </th>
                            <th class="px-4 py-2 text-center ">
                                Descripci&oacute;n
                            </th>
                            <th class="px-4 py-2 text-center">F&oacute;rmula</th>
                            <th class="px-4 py-2 text-center">Observaci&oacute;n</th>
                            <th class="px-4 py-2 text-center ">
                                Estado
                            </th>
                            <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($data as $fo)
                                    <td class="text-left"> {{ $fo->nombre }}</td>
                                    <td class="text-left"> {{ $fo->descripcion }}</td>
                                    <td class="text-left"> {{ $fo->formula  }}</td>
                                    <td class="text-left"> {{ $fo->observacion  }}</td>
                                    <td width="10px">
                                        <button class="btn btn-success" data-toggle="modal"
                                            data-target="#createFormula"
                                            wire:click.prevent="Edit({{ $fo->id }})">
                                            Editar
                                        </button>
                                    </td>
                                    <td width="10px">
                                        <button class="btn btn-danger"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Formula?','eliminarFormula', {{ $fo->id }})">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>