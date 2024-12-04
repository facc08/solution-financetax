<div wire:ignore.self class="modal fade" id="createAccionPlan" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createTipoPlanLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Acci&oacute;n&nbsp;/&nbsp;Plan</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Acci&oacute;n&nbsp;/&nbsp;Plan</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class=" text-dark font-weight-bold">Seleccione una Acci&oacute;n</label>
                    <select wire:model="accion_id" class="form-control @error('accion_id') is-invalid @enderror">
                        <option value="" selected>Elegir Acci&oacute;n</option>
                        @foreach ($acciones as $ac)
                            <option value="{{ $ac->id }}">{{ $ac->descripcion }}</option>
                        @endforeach
                    </select>
                    @error('accion_id')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class=" text-dark font-weight-bold">Seleccione un Plan</label>
                    <select wire:model="plan_id" class="form-control @error('plan_id') is-invalid @enderror">
                        <option value="" selected>Elegir Plan</option>
                        @foreach ($planes as $pl)
                            <option value="{{ $pl->id }}">{{ $pl->descripcion }}</option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                @if ($editMode)
                    <button type="button" wire:click="updateAccionPlan" class="btn btn-warning">Actualizar Acci&oacute;n&nbsp;/&nbsp;Plan</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createAccionPlan" class="btn btn-primary">Crear Acci&oacute;n&nbsp;/&nbsp;Plan</button>
                @endif
            </div>
        </div>
    </div>
</div>