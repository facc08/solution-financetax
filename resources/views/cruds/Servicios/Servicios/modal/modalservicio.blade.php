<div wire:ignore.self class="modal fade bd-example-modal-lg" id="createService" tabindex="-1" data-keyboard="false"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                <h5 class="modal-title" id="myLargeModalLabel">Actualizar Datos del Servicio</h5>
                @else
                <h5 class="modal-title" id="myLargeModalLabel">Añadir Nuevo Servicio</h5>
                @endif
               
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Servicio</label>
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Servicio">
                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Descripción</label>
                        <textarea  wire:model.defer="descripcion" class="form-control @error('descripcion') is-invalid @enderror" ></textarea>
                        @error('descripcion')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
               <div class="row">
                <div class="form-group col-md-12">
                    <label >Imagen</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="file"  wire:model.defer="image" class="form-control" min="0">
                        @error('image') <span class="error">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="image">Cargando...</div>
                    </div>
                  </div>

               </div>

                <div class="row">
                    <div class="form-group col-md-8">
                    <div class="selectgroup selectgroup-pills">
                        <span class="font-weight-bold text-dark"> Estado:</span>
                        <label class="selectgroup-item">
                            <input type="radio" wire:model="estado" name="estado" value="activo"
                                class="selectgroup-input">
                            <span class="selectgroup-button selectgroup-button-icon"><i
                                    class="fas fa-toggle-on"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" wire:model="estado" name="estado" value="inactivo"
                                class="selectgroup-input">
                            <span class="selectgroup-button selectgroup-button-icon"><i
                                    class="fas fa-toggle-off"></i></span>
                        </label>
                        <span class="badge @if ($estado=='activo' ) badge-success @else badge-danger @endif">{{ $estado }}</span>
                    </div>
                </div>

            </div>
            </div>

            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" wire:click="updateService" class="btn btn-warning">Actualizar Servicio</button>
                @else
                
                    <button type="button"  wire:click="createService" class="btn btn-primary">Crear Servicio</button>
                @endif
            </div>
        </div>
    </div>
</div>