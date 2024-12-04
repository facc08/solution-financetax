<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modalInteraccion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myLargeModalLabel">Enviar Mensaje</h5>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Especialista</label>
                        <input disabled type="text" class="form-control  wire:model.defer=" especialista_id" placeholder="{{ $compra->especialista->name }}">

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-8">
                        <label>Detalle</label>
                        <input type="text" wire:model.defer="detalle" class="form-control @error('detalle') is-invalid @enderror" placeholder="Detalle">
                        @error('detalle')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Observaci&oacute;n</label>
                        <textarea class="form-control" wire:model.defer="observacion" class="form-control @error('detalle') is-invalid @enderror" id="" cols="30" rows="5"></textarea>
                        @error('observacion')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Documentos</label>
                        <input type="file" wire:model.defer="documentos" multiple onchange="cargaLoader()" id="bandejaClienteFile">
                        <div class="spinner-border text-info" role="status" id="bandejaEspecialistaLoader" style="display:none">
                            <span class="visually-hidden"></span>
                        </div>
                        <span class="text-info" id="textoLoader" style="display:none">Subiendo archivo...</span>
                        @error('documentos')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                        <br>
                        <br>
                        <div class="alert alert-warning" role="alert" id="alertaSize">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;<b>El tamaño del archivo no debe ser mayor a 8 MB</b>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer br">

                <button type="submit"  @if ($createMode) disabled @endif wire:click="enviarMensaje" id="btnEnviarMensaje" class="btn btn-success">Enviar Mensaje</button>
            </div>
        </div>
    </div>
</div>
<script>
const units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

function cargaLoader(){
    var input = document.getElementById('bandejaClienteFile');
    var file = input.files[0];
    var fileSize = niceBytes(file.size);
    var sizeArray = fileSize.split("@");

    if(sizeArray[0] > 8 && sizeArray[1] == "MB"){
        //document.getElementById( 'alertaSize' ).style.display = 'block';
        document.getElementById('btnEnviarMensaje').disabled = true;
    }else if(file.size < 8000000){
        //document.getElementById( 'alertaSize' ).style.display = 'none';
        document.getElementById('btnEnviarMensaje').disabled = false;
    }

    document.getElementById( 'bandejaEspecialistaLoader' ).style.display = 'inline-block';
    document.getElementById( 'textoLoader' ).style.display = 'inline-block';

    setTimeout(function() {
        document.getElementById( 'bandejaEspecialistaLoader' ).style.display = 'none';
        document.getElementById( 'textoLoader' ).style.display = 'none';
    }, 4000);

}

function niceBytes(x){

    let l = 0, n = parseInt(x, 10) || 0;

    while(n >= 1024 && ++l){
        n = n/1024;
    }

    return(n.toFixed(n < 10 && l > 0 ? 1 : 0) + '@' + units[l]);
}
</script>