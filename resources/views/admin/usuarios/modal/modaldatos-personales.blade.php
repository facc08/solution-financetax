<div wire:ignore.self class="modal fade bd-example-modal-lg" id="EditUser" tabindex="-1" data-keyboard="false"
    role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="myLargeModalLabel">Actualizar Datos Usuario</h5>
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
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Cédula</label>
                        <input type="number" wire:model.defer="cedula"
                            class="form-control @error('cedula') is-invalid @enderror" id="cedula" onkeyup='validaCedula();'>
                        <span id="msg-ruc" class="text-danger"></span>
                        @error('cedula')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Correo Electrónico</label>
                        <input type="email" wire:model.defer="email"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Seleccione una Ciudad</label>
                        <select wire:model="city_id" class="form-control @error('city_id') is-invalid @enderror">
                            <option value="" selected hidden>Seleccione una Ciudad</option>
                            @foreach ($ciudades as $ro)
                                <option value="{{ $ro->id }}">{{ $ro->nombre }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Genero</label>
                        <select wire:model="genero" class="form-control @error('genero') is-invalid @enderror">
                            <option value="" selected disabled="">Seleccione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                        @error('genero')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Edad</label>
                        <input type="number" wire:model.defer="edad"
                            class="form-control @error('edad') is-invalid @enderror">
                        @error('edad')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Teléfono</label>
                        <input type="text" wire:model.defer="telefono"
                        class="form-control @error('telefono') is-invalid @enderror">
                    @error('telefono')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class=" text-dark font-weight-bold">Domicilio</label>
                        <textarea wire:model.defer="domicilio"
                            class="form-control @error('domicilio') is-invalid @enderror"></textarea>
                        @error('domicilio')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Fecha Nacimiento</label>
                        <input type="date" wire:model.defer="fecha_n"
                            class="form-control @error('fecha_n') is-invalid @enderror">
                        @error('fecha_n')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputTipoContribuyente" class=" text-dark font-weight-bold">Tipo de Contribuyente</label>
                        <select wire:model="tipo_contribuyente_id" class="form-control @error('tipo_contribuyente_id') is-invalid @enderror">
                            <option value="" selected hidden>Seleccione un Tipo</option>
                            @foreach ($tipos_contribuyente as $tc)
                                <option value="{{ $tc->id }}">{{ $tc->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('tipo_contribuyente_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:click="UpdateDatos" id="btnAñadir">Actualizar Usuario</button>
                    @endif
            </div>
        </div>|
    </div>
</div>
<script>

        var validaCedula = function() {
            //if(document.getElementById('cedula').value.length >= 10){
                let validaCedula = validarDocumento();
                if(validaCedula !== "OK"){
                    document.getElementById('cedula').style.borderColor = 'red';
                    document.getElementById('msg-ruc').textContent = validaCedula;
                    document.getElementById('btnAñadir').disabled = true;
                }else if(validaCedula == "OK"){
                    document.getElementById('btnAñadir').disabled = false;
                    document.getElementById('cedula').style.borderColor = 'green';
                    document.getElementById('msg-ruc').textContent = "";
                }
            /*} else {
                document.getElementById('cedula').style.borderColor = 'red';
                document.getElementById('msg-ruc').textContent = "La cédula debe tener 10 dígitos.";
            }*/
        }

        validarDocumento  = function() {
            ci = document.getElementById('cedula').value;

            var isNumeric = true;
            var total = 0, 
                individual;	

            for (var position = 0 ; position < 10 ; position++) {
                // Obtiene cada posición del número de cédula
                // Se convierte a string en caso de que 'ci' sea un valor numérico
                individual = ci.toString().substring(position, position + 1)

                if(isNaN(individual)) {
                    console.log(ci, position,individual, isNaN(individual))
                    isNumeric=false;
                    break;
                } else {
                    // Si la posición es menor a 9
                    if(position < 9) {
                        // Si la posición es par, osea 0, 2, 4, 6, 8.
                        if(position % 2 == 0) {
                            // Si el número individual de la cédula es mayor a 5
                            if(parseInt(individual)*2 > 9) {
                                // Se duplica el valor, se obtiene la parte decimal y se aumenta uno 
                                // y se lo suma al total
                                total += 1 + ((parseInt(individual)*2)%10);
                            } else {
                                // Si el número individual de la cédula es menor que 5 solo se lo duplica
                                // y se lo suma al total
                                total += parseInt(individual)*2;
                            }
                        // Si la posición es impar (1, 3, 5, 7)
                        }else {
                            // Se suma el número individual de la cédula al total
                            total += parseInt(individual);		    		
                        }
                    } 
                }
            }

            if((total % 10) != 0) {
                total =  (total - (total%10) + 10) - total;		
            } else {
                total = 0 ; 	
            }


            if(isNumeric) {	
                // El total debe ser igual al último número de la cédula
                console.log(ci, total, individual);
                console.log(ci, typeof ci, ci.length)
                // La cédula debe contener al menos 10 dígitos
                if(ci.toString().length != 10) { 
                    return("La c\u00E9dula debe ser de: 10 d\u00EDgitos.");
                    //return false; 
                }

                // El número de cédula no debe ser cero
                if (parseInt(ci, 10) == 0) { 
                    return("La c\u00E9dula ingresada no puede ser cero.");
                    //return false;
                }

                // El total debe ser igual al último número de la cédula
                if(total != parseInt(individual)) { 
                    return("La c\u00E9dula ingresada no es v\u00E1lida.");
                    //return false;
                } 

                console.log('cédula válida', ci);
                return "OK";
            }

            // Si no es un número  
            return("El dato solo puede contener numeros.");
            //return false;
        }
    </script>