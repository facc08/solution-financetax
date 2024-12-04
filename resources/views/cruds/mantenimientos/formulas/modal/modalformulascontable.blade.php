<div wire:ignore.self class="modal fade bd-example-modal-lg" id="createFormula" tabindex="-1" data-keyboard="false"
    role="dialog" aria-labelledby="createFormula" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="myLargeModalLabel">Actualizar Datos </h5>
                @else
                    <h5 class="modal-title" id="myLargeModalLabel">Crear Datos</h5>
                @endif

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Nombre</label>
                        @if ($editMode)
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Nombre">
                        @else
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Nombre">
                        @endif

                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Descripci&oacute;n</label>

                        @if ($editMode)
                        <textarea wire:model.defer="descripcion" rows="7" cols="70"
                                 class="form-control @error('descripcion') is-invalid @enderror" placeholder="Descripci&oacute;n">
                        </textarea>
                        @else
                        <textarea wire:model.defer="descripcion" rows="7" cols="70"
                                 class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" placeholder="Descripci&oacute;n">
                        </textarea>
                        @endif

                        @error('descripcion')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">F&oacute;rmula</label>
                        @if ($editMode)
                        <input type="text" wire:model.defer="formula"
                            class="form-control @error('formula') is-invalid @enderror" placeholder="F&oacute;rmula">
                        @else
                        <input type="text" wire:model.defer="formula"
                            class="form-control @error('formula') is-invalid @enderror" id="formula" placeholder="F&oacute;rmula">
                        @endif

                        @error('formula')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Observaci&oacute;n</label>

                        @if ($editMode)
                        <textarea wire:model.defer="observacion" rows="7" cols="70"
                                 class="form-control @error('observacion') is-invalid @enderror" placeholder="Observaci&oacute;n">
                        </textarea>
                        @else
                        <textarea wire:model.defer="observacion" rows="7" cols="70"
                                 class="form-control @error('observacion') is-invalid @enderror" id="observacion" placeholder="Observaci&oacute;n">
                        </textarea>
                        @endif

                        @error('observacion')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer br">

                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:click="Update">Actualizar F&oacute;rmula</button>
                @else
                    @if ($createMode) @endif
                    <button type="button" class="btn btn-primary" @if ($createMode) disabled @endif wire:click="Create">Crear F&oacute;rmula</button>
                @endif

            </div>
        </div>
    </div>
</div>
