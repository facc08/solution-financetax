<div wire:ignore.self class="modal fade" id="createEmpresa" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="createPostLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Empresa <i class="fas fa-building"></i></h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">Añadir Empresa <i class="fas fa-building"></i></h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>RUC</label><span aria-hidden="true" class="text-danger">&nbsp;*</span>
                    <input wire:model.defer="ruc" type="number" class="form-control" id="ruc" onkeyup='validaRuc();'>
                    <span id="msg-ruc" class="text-danger"></span>
                    @error('ruc')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Razón Social</label><span aria-hidden="true" class="text-danger">&nbsp;*</span>
                    <input wire:model.defer="razon_social"  type="text" class="form-control" id="razon_social" onkeyup='validaObligatorio();'>
                    <span id="msg-razon" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Per&iacute;odo Declaraciones</label><span aria-hidden="true" class="text-danger">&nbsp;*</span>
                    <select wire:model="periodo_declaracion_id" class="form-control @error('periodo_declaracion_id') is-invalid @enderror">
                        <option value="" selected hidden>Seleccione un per&iacute;odo</option>
                        @foreach ($periodos as $per)
                            <option value="{{ $per->id }}">{{ $per->descripcion }}</option>
                        @endforeach
                    </select>
                    <span id="msg-periodo" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label>Actividad Empresa</label><span aria-hidden="true" class="text-danger">&nbsp;*</span>
                    <input wire:model.defer="actividad"  type="text" class="form-control" id="actividad" onkeyup='validaObligatorio();'>
                    <span id="msg-actividad" class="text-danger"></span>
                </div>
                <div class="form-group">
                    @if ($flagShop)
                    <label>Clave de Acceso</label>
                    <input wire:model.defer="clave_acceso"  type="text" class="form-control">
                    @endif
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                @if ($editMode)
                    <button type="button" wire:click="updateEmpresa" class="btn btn-warning">Actualizar Empresa</button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="CrearEmpresa" id="btnAñadir" >Añadir Empresa</button>
                @endif
            </div>
        </div>
    </div>
</div>
<script>

        var validaRuc = function() {
            if(document.getElementById('ruc').value.length >= 13){
                let validaRuc = validarDocumento();
                if(validaRuc !== "OK"){
                    document.getElementById('ruc').style.borderColor = 'red';
                    document.getElementById('msg-ruc').textContent = validaRuc;
                }else if(validaRuc == "OK"){
                    //document.getElementById('btnAñadir').disabled = false;
                    document.getElementById('ruc').style.borderColor = '#e4e6fc';
                    document.getElementById('msg-ruc').textContent = "";
                }
            } else {
                document.getElementById('ruc').style.borderColor = 'red';
                document.getElementById('msg-ruc').textContent = "El ruc debe tener 13 dígitos.";
            }
        }

        var validaObligatorio = function() {
            if(document.getElementById('actividad').value !== "" && document.getElementById('razon_social').value !== ""){
                document.getElementById('btnAñadir').disabled = false;
            }
        }

        validarDocumento  = function() {
            numero = document.getElementById('ruc').value;

            var suma = 0;
            var residuo = 0;
            var pri = false;
            var pub = false;
            var nat = false;
            var numeroProvincias = 22;
            var modulo = 11;

            /* Verifico que el campo no contenga letras */
            var ok=1;
            for (i=0; i<numero.length && ok==1 ; i++){
                var n = parseInt(numero.charAt(i));
                if (isNaN(n)) ok=0;
            }
            if (ok==0){
                //alert("No puede ingresar caracteres en el número");
                return "No puede ingresar caracteres en el número";
            }

            if (numero.length < 10 ){
                //alert('El número ingresado no es válido');
                return 'El número ingresado no es válido';
            }

            /* Los primeros dos digitos corresponden al codigo de la provincia */
            provincia = numero.substr(0,2);
            if (provincia < 1 || provincia > numeroProvincias){
                //alert('El código de la provincia (dos primeros dígitos) es inválido');
            return 'El código de la provincia (dos primeros dígitos) es inválido';
            }

            /* Aqui almacenamos los digitos de la cedula en variables. */
            d1  = numero.substr(0,1);
            d2  = numero.substr(1,1);
            d3  = numero.substr(2,1);
            d4  = numero.substr(3,1);
            d5  = numero.substr(4,1);
            d6  = numero.substr(5,1);
            d7  = numero.substr(6,1);
            d8  = numero.substr(7,1);
            d9  = numero.substr(8,1);
            d10 = numero.substr(9,1);

            /* El tercer digito es: */
            /* 9 para sociedades privadas y extranjeros   */
            /* 6 para sociedades publicas */
            /* menor que 6 (0,1,2,3,4,5) para personas naturales */

            if (d3==7 || d3==8){
                //alert('El tercer dígito ingresado es inválido');
                return 'El tercer dígito ingresado es inválido';
            }

            /* Solo para personas naturales (modulo 10) */
            if (d3 < 6){
                nat = true;
                p1 = d1 * 2;  if (p1 >= 10) p1 -= 9;
                p2 = d2 * 1;  if (p2 >= 10) p2 -= 9;
                p3 = d3 * 2;  if (p3 >= 10) p3 -= 9;
                p4 = d4 * 1;  if (p4 >= 10) p4 -= 9;
                p5 = d5 * 2;  if (p5 >= 10) p5 -= 9;
                p6 = d6 * 1;  if (p6 >= 10) p6 -= 9;
                p7 = d7 * 2;  if (p7 >= 10) p7 -= 9;
                p8 = d8 * 1;  if (p8 >= 10) p8 -= 9;
                p9 = d9 * 2;  if (p9 >= 10) p9 -= 9;
                modulo = 10;
            }

            /* Solo para sociedades publicas (modulo 11) */
            /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
            else if(d3 == 6){
                pub = true;
                p1 = d1 * 3;
                p2 = d2 * 2;
                p3 = d3 * 7;
                p4 = d4 * 6;
                p5 = d5 * 5;
                p6 = d6 * 4;
                p7 = d7 * 3;
                p8 = d8 * 2;
                p9 = 0;
            }

            /* Solo para entidades privadas (modulo 11) */
            else if(d3 == 9) {
                pri = true;
                p1 = d1 * 4;
                p2 = d2 * 3;
                p3 = d3 * 2;
                p4 = d4 * 7;
                p5 = d5 * 6;
                p6 = d6 * 5;
                p7 = d7 * 4;
                p8 = d8 * 3;
                p9 = d9 * 2;
            }

            suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
            residuo = suma % modulo;

            /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
            digitoVerificador = residuo==0 ? 0: modulo - residuo;

            /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
            if (pub==true){
                if (digitoVerificador != d9){
                    //alert('El ruc de la empresa del sector público es incorrecto.');
                    return 'El ruc de la empresa del sector público es incorrecto.';
                }
                /* El ruc de las empresas del sector publico terminan con 0001*/
                if ( numero.substr(9,4) != '0001' ){
                    //alert('El ruc de la empresa del sector público debe terminar con 0001');
                    return 'El ruc de la empresa del sector público debe terminar con 0001';
                }
            }
            else if(pri == true){
                if (digitoVerificador != d10){
                    //alert('El ruc de la empresa del sector privado es incorrecto.');
                    return 'El ruc de la empresa del sector privado es incorrecto.';
                }
                if ( numero.substr(10,3) != '001' ){
                    //alert('El ruc de la empresa del sector privado debe terminar con 001');
                    return 'El ruc de la empresa del sector privado debe terminar con 001';
                }
            }

            else if(nat == true){
                if (digitoVerificador != d10){
                    //alert('El número de cédula de la persona natural es incorrecto.');
                    return 'El número de cédula de la persona natural es incorrecto.';
                }
                if (numero.length >10 && numero.substr(10,3) != '001' ){
                    //alert('El ruc de la persona natural debe terminar con 001');
                    return 'El ruc de la persona natural debe terminar con 001';
                }
            }
            return 'OK';
            }
    </script>