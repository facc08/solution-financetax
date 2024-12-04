<div wire:ignore.self class="modal fade bd-example-modal-lg" id="createProyeccion" tabindex="-1" data-keyboard="false"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="myLargeModalLabel">Actualizar Datos </h5>
                @else
                    <h5 class="modal-title" id="myLargeModalLabel">Crear Datos</h5>
                @endif

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Descripción</label>
                        <input type="text" wire:model.defer="descripcion"
                            class="form-control @error('descripcion') is-invalid @enderror" placeholder="Descripcion">
                        @error('descripcion')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Codigo SRI</label>
                        <input type="text" wire:model.defer="codigosri"
                            class="form-control @error('codigosri') is-invalid @enderror" placeholder="Codigo SRI">
                        @error('codigosri')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Porcentaje</label>
                        <input type="numb" wire:model.defer="porcentaje"
                            class="form-control @error('porcentaje') is-invalid @enderror" placeholder="0.00">
                        @error('porcentaje')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Fecha Actualización</label>
                        <input type="date" wire:model.defer="fechaactualizacion"
                            class="form-control @error('fechaactualizacion') is-invalid @enderror" placeholder="">
                        @error('fechaactualizacion')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
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
                    <button type="button" class="btn btn-warning" wire:click="Update">Actualizar Proyeccion</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" class="btn btn-primary" @if ($createMode) disabled @endif wire:click="Create">Crear Proyeccion</button>
                @endif

            </div>
        </div>
    </div>
</div>