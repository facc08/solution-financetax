<div wire:ignore.self class="modal fade" id="modalPermisos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPermisosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          @if ($editMode)
          <h5 class="modal-title " id="exampleModalCenterTitle">Actualizar Permisos</h5>
          @else
          <h5 class="modal-title " id="exampleModalCenterTitle">Asignar Permisos</h5>
          @endif
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
            <div class="form-inline">
                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Rol Seleccionado</label>
                <select class="form-control" id="" wire:model="role" wire:change="obtenerPermisos()">
                    @foreach ($allRoles as $unique)
                    <option value="{{ $unique }}">{{ $unique }}</option>
                    @endforeach
                </select>
            </div>
          <div class="row">
              <div class="col-lg-6">
                  <h4 class="text-center">Asignados</h4>
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th class="px-4 py-2 ">Permiso</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($permisos as $per)
                          <tr>
                              <td>{{ $per }}</td>
                              <td width="25" class="text-left"><button wire:click.prevent="quitarPermiso('{{ $per }}')" class="btn btn-danger">Quitar</button></td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              <div class="col-lg-6">
                  <h4 class="text-center ">Disponibles</h4>
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>Permiso</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($libres as $libre)
                          <tr>
                              <td>{{ $libre->name }}</td>
                              <td width="25" class="text-left"><button wire:click.prevent="asignarPermiso('{{ $libre->name }}')" class="btn btn-success">Asignar</button></td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
        <div class="modal-footer br">
  
        </div>
      </div>
    </div>
</div>