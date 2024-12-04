<div wire:ignore.self class="modal fade bd-example-modal-lg" id="createUser" tabindex="-1" data-keyboard="false"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="myLargeModalLabel">Actualizar Datos Usuario</h5>
                @else
                    <h5 class="modal-title" id="myLargeModalLabel">Crear Usuario</h5>
                @endif

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-8">
                        <label>Nombres y Apellidos</label>
                        <input type="text" wire:model.defer="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Nombres y Apellidos">
                        @error('name')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Correo Electrónico</label>
                        <input type="email" wire:model.defer="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electronico">
                        @error('email')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Seleccione un Rol</label>
                        <select wire:model="rol" class="form-control @error('rol') is-invalid @enderror">
                            <option value="" selected disabled="">Elige un Rol</option>
                            @foreach ($roles as $ro)
                                <option value="{{ $ro }}">{{ $ro }}</option>
                            @endforeach
                        </select>
                        @error('rol')
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
                <div class="badge badge-danger">clave por defecto : 12345678</div>
                {{-- <span> clave por defecto : 12345678</span> --}}
            </div>

            <div class="modal-footer br">

                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:click="updateUser">Actualizar Usuario</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" class="btn btn-primary" @if ($createMode) disabled @endif wire:click="createUser">Crear Usuario</button>
                @endif


            </div>
        </div>
    </div>
</div>
