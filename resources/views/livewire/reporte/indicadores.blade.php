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
                  <input wire:model="search" class="form-control" type="text" placeholder="Buscar Subservicio...">
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
                          <th class="px-4 py-2 text-center ">
                              Servicio
                              <a class="text-primary" wire:click.prevent="sortBy('sub')" role="button">

                                  @include('includes._sort-icon', ['field' => 'sub'])
                              </a>
                          </th>
                          <th class="px-4 py-2 text-center ">
                              Tipo Plan
                              <a class="text-primary" wire:click.prevent="sortBy('tipoplan')" role="button">

                                  @include('includes._sort-icon', ['field' => 'tipoplan'])
                              </a>
                          </th>
                          <th class="px-4 py-2 text-center">Precio</th>
                          <th class="px-4 py-2 text-center ">
                              Especialista
                              <a class="text-primary" wire:click.prevent="sortBy('especialista_id')" role="button">

                                  @include('includes._sort-icon', ['field' => 'especialista'])
                              </a>
                          </th>
                          <th class="px-4 py-2 text-center ">
                              Fecha de contrataci&oacute;n
                              <a class="text-primary" wire:click.prevent="sortBy('created_at')" role="button">

                                  @include('includes._sort-icon', ['field' => 'created_at'])
                              </a>
                          </th>
                          <th class="px-4 py-2 text-center">Estado</th>
                          <th class="px-4 py-2 text-center" colspan="3">Acción</th>
                      </tr>
                  </thead>
                  <tbody>
                        @if ($data->isNotEmpty())
                            @foreach ($dataEmpresas as $info => $empresa)
                            <tr>
                                <td class="text-center " colspan="9" style="background: aliceblue;"><b>{{ strtoupper($info) }}</b></td>
                            </tr>
                                @foreach ($empresa as $compra)
                                    <tr>
                                        <td class="text-center ">{{ $compra->sub }}</td>
                                        <td class="text-center ">{{ $compra->tipoplan }}</td>
                                        <td class="text-center ">${{ $compra->costo }}</td>
                                        <td class="text-center ">{{ $compra->especialista }}</td>
                                        <td class="text-center ">{{ date('d/m/y H:i', strtotime($compra->created_at)) }}</td>

                                        @switch($compra->estado)
                                            @case("pendiente")badge  badge-succes
                                                <td class="text-center "><span class="badge badge-primary">{{ ucfirst($compra->estado) }}</span></td>
                                            @break

                                            @case("aprobada")
                                                <td class="text-center "><span class="badge badge-success">{{ ucfirst($compra->estado) }}</span></td>
                                            @break

                                            @case("en proceso")
                                                <td class="text-center "><span class="badge badge-warning">{{ ucfirst($compra->estado) }}</span></td>
                                            @break
                                        @endswitch

                                        <td width="50px">
                                            <div class="dropdown">
                                            @if($compra->diasRestantes == 0 || $compra->diasRestantes < 0)
                                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="tooltip" data-placement="top" title="Fecha caducidad: {{$compra->fecha_caducidad}}">
                                                    Servicios&nbsp;|&nbsp;<i class="fas fa-hourglass-end"></i>&nbsp;Plan Caducado
                                                </button>
                                            @else
                                                <a class="btn btn-icon icon-left btn-primary" href="/reportes/indicadores/principal/{{$compra->shop_id}}">
                                                    <i class="fas fa-eye"></i>&nbsp;Ver
                                                </a>
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

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
