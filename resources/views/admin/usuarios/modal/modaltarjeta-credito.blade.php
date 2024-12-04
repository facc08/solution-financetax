<style>
    .credit-card-div span {
        padding-top: 10px;
    }

    .credit-card-div img {
        padding-top: 20px;
    }

    .credit-card-div .small-font {
        font-size: 9px;
    }

    .credit-card-div .pad-adjust {
        padding-top: 10px;
    }

</style>

<div wire:ignore.self class="modal fade" id="createTarjeta" tabindex="-1" role="dialog"
    aria-labelledby="createTarjetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalCenterTitle">EDITAR TARJETA </h5>
                @else
                    <h5 class="modal-title" id="exampleModalCenterTitle">ASOCIAR TARJETA </h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="credit-card-div">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div class="row ">
                                <div class="col-md-12">
                                    <input wire:model.defer="n_tarjeta" type="text" class="form-control purchase-code" 
                                        @error('n_tarjeta') is-invalid @enderror"  placeholder="ASDF-GHIJ-KLMN-OPQR" />
                                    @error('n_tarjeta')
                                        <p class="error-message text-danger font-small-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font"> Mes Expiración</span>
                                    <input type="number" wire:model.defer="mes_vencimiento" min="01" max="12"
                                        class="form-control" @error('mes_vencimiento') is-invalid @enderror"
                                        placeholder="MM" />
                                    @error('mes_vencimiento')
                                        <p class="error-message text-danger font-small-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font"> Año Expiración</span>
                                    <input type="number" wire:model.defer="ano_vencimiento" class="form-control"
                                        @error('ano_vencimiento') is-invalid @enderror" placeholder="YY" />
                                    @error('ano_vencimiento')
                                        <p class="error-message text-danger font-small-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font"> CCV</span>
                                    <input type="text" class="form-control" wire:model.defer="cvv" @error('cvv')
                                        is-invalid @enderror" placeholder="CCV" />
                                    @error('cvv')
                                        <p class="error-message text-danger font-small-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    {{-- <img src="/aegis/source/light/assets/img/cards/chip.png" alt="visa"> --}}
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 pad-adjust">
                                    <span class="help-block text-muted small-font"> Obligatorio*</span>
                                    <input type="text" wire:model.defer="propietario" class="form-control"
                                        @error('propietario') is-invalid @enderror"
                                        placeholder="Nombre del Propietario" />
                                    @error('propietario')
                                        <p class="error-message text-danger font-small-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 pad-adjust">
                                    <span class="help-block text-muted small-font"> Tipo de Tarjeta</span>
                                    <select wire:model="tipo" class="form-control">
                                        <option value="">Seleccione </option>
                                        <option value="visa">Visa</option>
                                        <option value="mastercard">Mastercard</option>
                                        <option value="americanexpress">American Express</option>
                                        <option value="discover">Discover</option>
                                        <option value="dinersclud">Diners Clud</option>
                                     </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                @if ($editMode)
                    <button type="button" wire:click="updateTarjeta" class="btn btn-warning">Actualizar Tarjeta</button>
                @else
                    @if ($createMode) disabled @endif
                    <button type="button" @if ($createMode) disabled @endif wire:click="CrearTarjeta" class="btn btn-primary">Asociar Tarjeta</button>
                @endif
            </div>
        </div>
    </div>

</div>

