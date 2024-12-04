@extends('layouts.app')

@section('content')
    <h1 class="text-center font-weight-bold">Ratios</h1>

    <div class="card">
        <div class="card-body">

        <div class="row table-responsive">
              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th class="px-4 py-2 text-center ">
                              Especialista
                          </th>
                          <th class="px-4 py-2 text-center ">
                              SubServicio
                          </th>
                          <th class="px-4 py-2 text-center ">
                              Tipo Plan
                          </th>
                          <th class="px-4 py-2 text-center">Costo</th>
                          <th class="px-4 py-2 text-center">Estado</th>
                          <th class="px-4 py-2 text-center" colspan="3">Acción</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if ($data->isNotEmpty())
                            @foreach ($dataEmpresas as $info => $empresa)
                            <tr>
                                <td class="text-center " colspan="8" style="background: aliceblue;"><b>{{ strtoupper($info) }}</b></td>
                            </tr>
                            @foreach ($empresa as $compra)
                                <tr>
                                  <td class="text-center ">{{ $compra->especialista }}</td>
                                  <td class="text-center ">{{ $compra->sub }}</td>
                                  <td class="text-center ">{{ $compra->tipoplan }}</td>
                                  <td class="text-center ">${{ $compra->costo }}</td>

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

                                    <td width="10px">
                                      <a class="btn btn-icon icon-left btn-primary" href="/reportes/ratios/principal/{{$compra->shop_id}}">
                                          <i class="fas fa-eye"></i>&nbsp;Ver
                                      </a>
                                    </td>

                                  </tr>
                            @endforeach
                            
                            @endforeach
                      @else
                          <tr>
                              <td colspan="10">
                                  <p class="text-center">No hay resultado para la busqueda
                                  </p>
                              </td>
                          </tr>
                      @endif
                  </tbody>
              </table>
          </div>

        </div>
    </div>
@endsection