<div>
   
    @include('admin.usuarios.modal.modaltarjeta-credito')
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTarjeta"> Asociar
            Tarjeta </button>
    </div>
  
   
    <section class="section">
        <div class="row">
            @if ($data->isNotEmpty())
            @foreach ($data as $key=>$e)     
           
            <div class="col-8 col-md-4 col-lg-5">
                <div class="card card-light " >
                    <div class="card-header">
                        <h4>TARJETA CREDITO O DEBITO</h4>
                        <div class="card-header-action">
                            <button class="btn btn-success" data-toggle="modal" data-target="#createTarjeta"
                            wire:click.prevent="editTarjeta({{ $e->id }})">
                            <i class="fas fa-pen"></i>
                             </button>

                            <button class="btn btn-danger"
                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Tarjeta de Credito?','EliminarTarjeta', {{ $e->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body" style="background-color: rgba(255, 255, 255, 0.912)">
                        <form class="credit-card-div">
                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <div class="row ">
                                        <div class="col-md-12">
                                          <h5> {{ $e->n_tarjeta }}</h5> 
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <span class="help-block text-muted small-font" > Mes / Año </span>
                                            <br>
                                            {{ $e->mes_vencimiento }} / {{ $e->ano_vencimiento }} 
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                           
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                            <span class="help-block text-muted small-font"> CCV</span>
                                            <br>
                                            {{ $e->cvv }} 
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3" >
                                            @if ($e->tipo == 'mastercard')
                                            <img style="padding: 8px" src="/aegis/source/light/assets/img/cards/mastercard.png" alt="mastercard">
                                        
                                            @elseif($e->tipo =='visa')
                                            <img style="padding: 8px" src="/aegis/source/light/assets/img/cards/visa.png" alt="visa">

                                            @elseif($e->tipo =='dinersclud')
                                            <img style="padding: 8px" src="/aegis/source/light/assets/img/cards/dinersclub.png" alt="dinersclub">
                                          
                                            @elseif($e->tipo =='discover')
                                            <img style="padding: 8px" src="/aegis/source/light/assets/img/cards/discover.png" alt="discover">

                                            @elseif($e->tipo =='americanexpress')
                                            <img style="padding: 8px" src="/aegis/source/light/assets/img/cards/americanexpress.png" alt="americanexpress">

                                            @endif
                                           
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-12 pad-adjust " style="padding: 10px">
                                            <span class="help-block text-muted small-font"> </span>
                                            {{ $e->propietario }} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
            @endif
        </div>
    </section>
    
</div>
