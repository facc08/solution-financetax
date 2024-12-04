<div>
    <div class="row">
        <div class="form-group col-md-0 col-12">
            <label>Subir Foto</label>
            <input type="file" class="form-control" min="0" wire:model.defer="image">
            @error('image') <span class="error">{{ $message }}</span> @enderror
        </div>
        
    </div>  
    
    <div class="card-footer text-center">
        <button class="btn btn-primary" wire:click.prevent="StoreImage">Actualizar</button>
    </div>
</div>
