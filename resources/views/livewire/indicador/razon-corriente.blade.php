<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-0 col-12">
                    <label>Seleccionar Documento &nbsp;</label>
                    <input type="file" class="form-control" min="0" wire:model.defer="documento">
                    @error('documento') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class=" text-center">
                <button type="button" class="btn btn-outline-dark" wire:click.prevent="ImportarRazonCorriente()">Importar
                    Documento</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div wire:ignore.self class="padding-20">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a wire:ignore class="nav-link active" id="personales-tab2" data-toggle="tab" href="#personales"
                        role="tab" aria-selected="true">Datos</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore class="nav-link" id="contrasena-tab2" data-toggle="tab" href="#contrasena"
                        role="tab" aria-selected="false"> Cuadros Estadisticos</a>
                </li>
            </ul>
            <div wire:ignore.self class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade show active" id="personales" role="tabpanel" aria-labelledby="personales-tab2"
                    wire:ignore.self>
                    {{-- inicio --}}

                    <div class="card-body">

                        {{-- <div class="row mb-4 justify-content-between">
                            <div class="col-lg-4 form-inline">
                                Por Pagina: &nbsp;
                                <select wire:model="perPage" class="form-control form-control-sm">
                                    <option>10</option>
                                    <option>15</option>
                                    <option>25</option>
                                </select>
                            </div>
            
                            <div class="col-lg-3">
                                <input wire:model="search" class="form-control" type="text" placeholder="Buscar Impuesto...">
                            </div>
                        </div> --}}
            
                        <div class="row table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-center ">
                                           Activo Corriente
                                          
                                        </th>
                                        <th class="px-4 py-2 text-center ">
                                            Pasivo Corriente
                                         </th>
                                         
                                        
                                        <th class="px-4 py-2 text-center ">
                                           Resultado
                                        </th>
                                        <th class="px-4 py-2 text-center" colspan="2">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($datos->isNotEmpty())
                                        @foreach ($datos as $p)
                                            <tr>
                                                <td class="text-center "> ${{ $p->activo_corriente }}</td>
                                                <td class="text-center "> ${{ $p->pasivo_corriente  }}</td>
                                                <td class="text-center "> {{ $p->resultado   }}</td>    
                                                <td width="10px">
                                                    <button class="btn btn-success" data-toggle="modal"
                                                        data-target="#createImpuesto"
                                                        wire:click.prevent="CalcularResultado({{ $p->id }})">
                                                        Calcular 
                                                    </button>
                                                </td>
                                                <td width="10px">
                                                    <button class="btn btn-danger"
                                                        wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Cuenta?','EliminarRazon', {{ $p->id }})">
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
                                {{ $datos->links() }}
                            </div>
                            <div class="col text-right text-muted">
                                Mostrar {{ $datos->firstItem() }} a {{ $datos->lastItem() }} de
                                {{ $datos->total() }} registros
                            </div>
                        </div>
            
            
                    </div>



                    {{-- fin --}}
                </div>
                <div class="tab-pane fade" id="contrasena" role="tabpanel" aria-labelledby="contrasena-tab2"
                    wire:ignore.self>
                   {{-- inicio --}}

                   <div class="card">
                    <div class="card-header">
                        <h4>Periodos Registrados</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="d-block">Seleccionar un Periodo</label>
                            @if (!empty($data))
                                @foreach ($data as $item)
                                    <div class="form-check form-check-inline">
                                        <li>
                                            <input type="checkbox" value="{{ $item->periodo }}" wire:model="year" />
                                            <span> {{ $item->periodo }} </span>
                                        </li>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Columna Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div style="height: 20rem;">
                                        @if (!empty($columnChartModel))
                                            <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}"
                                                :column-chart-model="$columnChartModel" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Pastel Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div style="height: 20rem;">
                                        @if (!empty($pieChartModel))
                                            <livewire:livewire-pie-chart key="{{ $pieChartModel->reactiveKey() }}"
                                                :pie-chart-model="$pieChartModel" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                   {{-- fin --}}

                </div>
            </div>

        </div>



    </div>
