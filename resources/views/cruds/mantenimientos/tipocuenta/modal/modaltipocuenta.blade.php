<div wire:ignore.self class="modal fade" id="createTipocuenta" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createTipoPlanLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Tipo Servicio</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Tipo Servicio</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="inputEmail3" class=" text-dark font-weight-bold">Tipo Cuenta</label>
                    <input type="text" wire:model.defer="descripcion"
                    class="form-control @error('descripcion') is-invalid @enderror" placeholder="Nuevo Tipo Cuenta">
                    @error('descripcion')
                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class=" text-dark font-weight-bold">Signo</label>
            
                    <input type="text" wire:model.defer="signo"
                    class="form-control @error('signo') is-invalid @enderror" placeholder="Signo">
                    @error('signo')
                    <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
             
                <div class="selectgroup selectgroup-pills">
                    <span class="font-weight-bold text-dark" >Estado:</span>
                      <label class="selectgroup-item">
                        <input type="radio" wire:model="estado" name="estado" value="activo" class="selectgroup-input">
                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-on"></i></span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" wire:model="estado" name="estado" value="inactivo" class="selectgroup-input">
                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-off"></i></span>
                      </label>
                      <span class="badge @if ($estado == 'activo')
                        badge-success @else badge-danger
                      @endif">{{ $estado }}</span>
                    </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                @if ($editMode)
                    <button type="button" wire:click="Update" class="btn btn-warning">Actualizar Tipo Servicio</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="Create" class="btn btn-primary">Crear Tipo Cuenta</button>
                @endif
            </div>
        </div>
    </div>
</div>