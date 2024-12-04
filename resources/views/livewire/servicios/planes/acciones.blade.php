<div>
    @include('cruds.Servicios.TipoPlanes.modal.modalaccionplan')
    <div>
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAccionPlan">Añadir Acci&oacute;n / Plan</button>
    </div>
    <br>
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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Sub Accion...">
                </div>
            </div>
            <div class="row table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th class="px-4 py-2 text-center ">
                          Plan
                           <a class="text-primary" wire:click.prevent="sortBy('plan')" role="button">
                               @include('includes._sort-icon', ['field' => 'plan'])
                           </a>
                        </th>
                        <th class="px-4 py-2 text-center ">
                             Nombre Acci&oacute;n
                             <a class="text-primary" wire:click.prevent="sortBy('accion')" role="button">
                                 @include('includes._sort-icon', ['field' => 'accion'])
                             </a>
                         </th>
                         <th class="px-4 py-2 text-center ">
                             Ruta Acci&oacute;n
                             <a class="text-primary" wire:click.prevent="sortBy('ruta')" role="button">
                                 @include('includes._sort-icon', ['field' => 'ruta'])
                             </a>
                         </th>
                         <th class="px-4 py-2 text-center" colspan="2">Acci&oacute;n</th>
                     </tr>
                 </thead>
                  <tbody>
                     @if($data->isNotEmpty())
                     @foreach($data as $accion)
                     <tr>
                        <td class="text-left ">{!!htmlspecialchars_decode($accion->plan)!!}</td>
                        <td class="text-center ">{{ $accion->accion }}</td>
                        <td class="text-center ">{{ $accion->ruta }}</td>
                        <td width="10px">
                            <button class="btn btn-success" data-toggle="modal" data-target="#createAccionPlan"
                                wire:click.prevent="editAccionPlan({{ $accion->id }})">
                                Editar
                            </button>
                        </td>
                        <td width="10px">
                            <button class="btn btn-danger"
                                wire:click.prevent="$emit('eliminarRegistro','¿ Deseas eliminar esta acción asignada al plan ?','EliminarAccionPlan', {{ $accion->id }})">
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