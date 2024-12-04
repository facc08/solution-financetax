<div>
   

    <div class="card">
        <div class="card-body">

            <div class="row mb-4 justify-content-between">
                <div class="col-lg-4 form-inline">
                    Por P&aacute;gina: &nbsp;
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
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <select class="form-control form-control-md" aria-label="Servicio" wire:change.prevent="tipoChange()" wire:model="servicio">
                        <option selected>Seleccionar Servicio</option>
                        @if($servicios !== "")
                            @foreach ($servicios as $se)
                                <option value="{{ $se->id }}">{{ $se->nombre }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="row table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th class="px-4 py-2"></th>
                        <th class="px-4 py-2 text-center ">
                            Plan
                           <a class="text-primary" wire:click.prevent="sortBy('plan')" role="button">
         
                               @include('includes._sort-icon', ['field' => 'plan'])
                           </a>
                       </th>
                       <th class="px-4 py-2 text-center ">
                            Tipo
                           <a class="text-primary" wire:click.prevent="sortBy('tipoplan')" role="button">
         
                               @include('includes._sort-icon', ['field' => 'tipoplan'])
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
                     @foreach ($data as $plan)
                     <tr>
                        <td class="text-center" >
                            <button type="button" class="btn btn-primary rounded-circle accordion-toggle-btn accordion-toggle collapsed" 
                                    onclick="mostrarInfo('infoHide{{ $plan->id }}')" id="accordion{{ $plan->id }}" data-toggle="collapse" 
                                    data-parent="#accordion{{ $plan->id }}" href="#collapse{{ $plan->id }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </td>
                        <td class="text-left ">{!! $plan->descripcion !!}</td>
                        <td class="text-left ">{{ $plan->tipoplan }}</td>
                        {{-- <td class="text-center ">{{ $plan->descripcion }}</td> --}}
                        <td class="text-center ">
                           <span style="cursor: pointer;"
                               wire:click.prevent="estadochange('{{ $plan->id }}')"
                               class="badge @if ($plan->estado == 'activo') badge-success
                           @else
                               badge-danger @endif">{{ $plan->estado }}</span>
                       </td>
                       <td width="10px">
                        <button class="btn btn-success" data-toggle="modal" data-target="#createService"
                            wire:click.prevent="editPlan({{ $plan->id }})">
                            Editar
                        </button>
                    </td>
                    <td width="10px">
                        <button class="btn btn-danger"
                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Plan?','eliminarPlan', {{ $plan->id }})">
                            Eliminar
                        </button>
                    </td>
                     </tr>
                     <tr id="infoHide{{ $plan->id }}" style="visibility:collapse">
                        <td></td>
                        <td colspan="4" >
                            <div id="collapse{{ $plan->id }}" class="collapse in p-3">
                                <div class="row">
                                    <div class="col-2"><b>Tipo Plan</b></div>
                                    <div class="col-6">{{ $plan->tipoplan }}</div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-2"><b>Precio</b></div>
                                    <div class="col-6">${{ $plan->costo }}</div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-2"><b>Cantidad Meses</b></div>
                                    <div class="col-6">{{ $plan->cantidad_meses }}</div>
                                </div>
                            </div>
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
