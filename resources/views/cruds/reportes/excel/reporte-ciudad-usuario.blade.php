<div class="container">
    <h3 style="text-align: center"><strong>REPORTE POR EDADES USUARIOS</strong></h3>
    <table class="table table-striped">
        <tr>
            <th style="vertical-align: middle; background-color: #4cbbd4" scope="col" width="30">CEDULA</th>
            <th style="vertical-align: middle; background-color: #4cbbd4" scope="col" width="25">NOMBRE Y APELLIDO</th>
            <th style="vertical-align: middle; background-color: #4cbbd4" scope="col" width="15">CIUDAD</th>
            <th style="vertical-align: middle; background-color: #4cbbd4" scope="col" width="25">ESTADO</th>
            <th style="vertical-align: middle; background-color: #4cbbd4" scope="col" width="25">FECHA CREACION</th>
        </tr>
        <tbody>
            @foreach ($users as $s)
              <tr>
                    <td>{{ $s['cedula'] }} </td>
                    <td>{{ $s['name'] }}</td>
                    <td>{{ $s['ciudad'] }}</td>
                    
                    <td class="text-center">
                        {{ $s['estado'] }}
                    </td>
                    <td>{{ $s['created_at'] }}</td>
            @endforeach
            <tr>
        </tbody>

    </table>
</div>