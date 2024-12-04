<div wire:ignore.self class="modal fade" id="createPost" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createPostLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Post</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Crear Post</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Titulo</label>
                    <input wire:model.defer="titulo" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Resumen</label>
                    <textarea wire:model.defer="resumen" class="form-control" id="" rows="3"></textarea>
                </div>
                <div class="selectgroup selectgroup-pills">
                    <span class="font-weight-bold text-dark" >  Estado:</span>
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
                    <button type="button" wire:click="updatePost" class="btn btn-warning">Actualizar Post</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="createPost" class="btn btn-primary">Crear Post</button>
                @endif
            </div>
        </div>
    </div>
</div>
