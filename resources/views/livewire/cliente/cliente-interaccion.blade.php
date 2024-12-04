<div>
    <div>
        <h2> </h2>
        <div class="card">
            <div class="card-body">
                <div class="row table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center " >
                                    Tipo
                                </th>
                                <th class="px-4 py-2 text-center " >
                                    Detalle Mensaje
                                </th>
                                <th class="px-4 py-2 text-center">
                                    Observaci&oacute;n Mensaje
                                </th>
                                <th class="px-4 py-2 text-center ">
                                    Fecha de Env&iacute;o
                                </th>
                                <th class="px-4 py-2 text-center">Descargar Adjunto</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $p)
                                @if($p->tipo == "C")
                                <tr>
                                    <td class="text-center"><span class="badge badge-info">Cliente</span></td>
                                @elseif($p->tipo == "E")
                                <tr style="background-color: #f3f5ff !important">
                                    <td class="text-center"><span class="badge badge-primary">Especialista</span></td>
                                @endif
                                <td class="text-center">{{ $p->detalle }}</td>
                                <td class="text-center">{{ $p->observacion }}</td>
                                <td class="text-center">{{ $p->created_at }}</td>

                                <td class="text-center" >
                                @foreach ($p->docs as $d)
                                    <a target="_blank" href="/documentos_interaccion/{{$d->url_archivo}}" class="btn btn-primary mt-2 mb-2 mr-3 "> {{$d->documento_interaccion}} <i class="fas fa-download"> </i </a>
                                @endforeach
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
