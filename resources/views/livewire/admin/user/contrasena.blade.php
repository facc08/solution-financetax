<div>
    <div class="needs-validation">
        <div class="card-header">
            <h4>Cambiar Contraseña</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6 col-12">
                    <label>Contraseña Nueva</label>
                    <input wire:model.defer="password" type="password" class="form-control" @error('password') is-invalid @enderror" value="">
                    @error('password')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-md-6 col-12">
                    <label>Confirmar Contraseña</label>
                    <input wire:model.defer="password_confirmation" type="password" class="form-control" @error('password_confirmation') is-invalid @enderror" value="">
                    @error('password_confirmation')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button  wire:click.prevent="ChangePassword" class="btn btn-primary">Cambiar Contraseña</button>
        </div>
    </div>
</div>
