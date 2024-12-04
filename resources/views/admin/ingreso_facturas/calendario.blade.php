@extends('layouts.app')
@section('content')

<style>
    .fc-event{background-color: white !important;}
    .evento-ingresos .fc-event-main .fc-event-main-frame .fc-event-title-container .fc-event-title{color: blue !important; font-weight: 700 !important;}
    .evento-egresos .fc-event-main .fc-event-main-frame .fc-event-title-container .fc-event-title{color: red !important; font-weight: 700 !important;}
    .evento-saldos .fc-event-main .fc-event-main-frame .fc-event-title-container .fc-event-title{color: black !important; font-weight: 700 !important;}
    .evento-ingresos .fc-list-event-title a{color: blue !important; font-weight: 700 !important;}
    .evento-egresos .fc-list-event-title a{color: red !important; font-weight: 700 !important;}
    .evento-saldos .fc-list-event-title a{color: black !important; font-weight: 700 !important;}
    /*.fc-v-event .fc-event-main {color: black !important;}*/
    .info-box {
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    border-radius: 0.25rem;
    background-color: #fff;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: 0.5rem;
    position: relative;
    width: 100%;
}

.info-box .info-box-icon {
    border-radius: 0.25rem;
    -ms-flex-align: center;
    align-items: center;
    display: -ms-flexbox;
    display: flex;
    font-size: 1.875rem;
    -ms-flex-pack: center;
    justify-content: center;
    text-align: center;
    width: 70px;
}

.fa-bookmark:before {
    content: "\f02e";
}

.info-box .info-box-content {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    line-height: 1.8;
    -ms-flex: 1;
    flex: 1;
    padding: 0 10px;
    overflow: hidden;
}

.info-box .info-box-text, .info-box .progress-description {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.info-box .info-box-number {
    display: block;
    font-weight: 700;
    font-size: 20px;
}

.info-box .progress {
    background-color: rgba(0,0,0,.125);
    height: 2px;
    margin: 5px 0;
}

.info-box .progress .progress-bar {
    background-color: #fff;
}

.col-lg-3 .info-box .progress-description, .col-md-3 .info-box .progress-description, .col-xl-3 .info-box .progress-description {
    font-size: 1rem;
    display: block;
}

</style>
<div id="app">
    <h2 class="text-center font-weight-bold">Visualizaci&oacute;n de Transacciones</h2>
    <h4 class="text-center">{{$empresa}}</h4>
    <br>

    <div class="card">
    <div class="card-body">
        <div class="row text-center" id="rowSumas">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box bg-blue text-white">
                    <span class="info-box-icon"><i class="fas fa-sort-amount-up" style="font-size: 45px !important"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><h5>INGRESOS:</h5></span>
                        <b><span class="info-box-number" id="mes-ingresos"></span></b>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box bg-danger text-white">
                    <span class="info-box-icon"><i class="fas fa-sort-amount-down" style="font-size: 45px !important"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><h5>EGRESOS:</h5></span>
                        <b><span class="info-box-number" id="mes-egresos"></span></b>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box bg-dark text-white">
                    <span class="info-box-icon"><i class="fas fa-hand-holding-usd" style="font-size: 45px !important"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><h5>SALDO:</h5></span>
                        <b><span class="info-box-number" id="mes-saldo"></span></b>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id='calendar'></div>
    </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales-all.min.js"></script>
<script>
        var jsonSumaMeses = {!! json_encode($arraySumaMes) !!};
        var arraySumaMeses = JSON.parse(JSON.stringify(jsonSumaMeses))
        var jsonSumasDaily = {!! json_encode($arraySumasDaily) !!};
        const date = new Date();
        const mesDate = date.getMonth() + 1;

        if(mesDate.toString().length < 2)
            var mesActual = "0"+mesDate.toString();
        else
            var mesActual = mesDate.toString();

        document.getElementById('mes-ingresos').innerHTML = "$ "+(arraySumaMeses[mesActual]["ingreso"]).toFixed(2);
        document.getElementById('mes-egresos').innerHTML = "$ "+(arraySumaMeses[mesActual]["egreso"]).toFixed(2);
        document.getElementById('mes-saldo').innerHTML = "$ "+(arraySumaMeses[mesActual]["saldo"]).toFixed(2);

        var transacciones = {!! json_encode($arrayDataCalendario) !!};
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        const { sliceEvents, createPlugin, Calendar } = FullCalendar
        const CustomViewConfig = {

            classNames: [ 'custom-view' ],
            locale: 'es',
            titleFormat: { year: 'numeric', month: 'long'},

            content: function(props) {
                let segs = sliceEvents(props, true); // allDay=true
                var date = calendar.getDate().toISOString();
                var mesSeleccionado = date.substring(5, 7);

                props.dateProfile.currentRangeUnit = "month"
                props.dateProfile.dateIncrement.months = 1
                props.dateProfile.dateIncrement.days = 0

                let html = '<table class="table table-striped">' +
                            '<tbody>'

                for (const key in jsonSumasDaily[mesSeleccionado]) {
                    html +='<tr>'+
                                '<td class="text-center"><b>'+key+'</b></td>'+
                                '<td class="text-info text-center"><b>INGRESOS</b></td>'+
                                '<td><b>$'+jsonSumasDaily[mesSeleccionado][key]["ingreso"].toFixed(2)+'</b></td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td class="text-center"><b>'+key+'</b></td>'+
                                '<td class="text-danger text-center"><b>EGRESOS</b></td>'+
                                '<td><b>$'+jsonSumasDaily[mesSeleccionado][key]["egreso"].toFixed(2)+'</b></td>'+
                            '</tr>'
                }

                html += '</tbody>'+
                        '</table>'

            return { html: html }
            }

        }

        const CustomViewPlugin = createPlugin({
            views: {
                DetalleMes: CustomViewConfig
            }
        })

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            //initialDate: '2022-04-07',
            displayEventTime: false,
            plugins: [ CustomViewPlugin ],
            buttonText: {
                    listMonth: 'Resumen Diario',
                    DetalleMes: 'Detalle Mensual'
            },
            //initialView: 'custom',
            /*customButtons: {
            myCustomButton: {
                text: 'Lista dias',
                    click: function() {
                        //$("#calendar").fullCalendar( 'removeEvents' [, idOrFilter ] )
                        console.log("CUSTOM BUTTon");
                        var source = [{
                                        title: 'All Day Event',
                                        start: '2022-04-01'
                                    },
                                    {
                                        title: 'Long Event',
                                        start: '2022-04-07',
                                        end: '2022-04-10'
                                    },
                                    {
                                        groupId: '999',
                                        title: 'Repeating Event',
                                        start: '2022-04-09T16:00:00'
                                    },
                                    {
                                        groupId: '999',
                                        title: 'Repeating Event',
                                        start: '2022-04-16T16:00:00'
                                    }];
                        $("#calendar").fullCalendar( 'addEventSource', source )
                    }
                }
            },*/
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth,DetalleMes'
            },
            events:
                    transacciones,

            /*[{
                title: 'All Day Event',
                start: '2022-04-01'
            },
            {
                title: 'Long Event',
                start: '2022-04-07',
                end: '2022-04-10'
            },
            {
                groupId: '999',
                title: 'Repeating Event',
                start: '2022-04-09T16:00:00'
            },
            {
                groupId: '999',
                title: 'Repeating Event',
                start: '2022-04-16T16:00:00'
            },
            {
                title: 'Conference',
                start: '2022-04-11',
                end: '2022-04-13'
            },
            {
                title: 'Meeting',
                start: '2022-04-12T10:30:00',
                end: '2022-04-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2022-04-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2022-04-12T14:30:00'
            },
            {
                title: 'Birthday Party',
                start: '2022-04-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2022-04-28'
            }]*/
            
        });

        calendar.render();
            document.querySelector(".fc-prev-button").addEventListener("click", function(event) {
                document.getElementById('mes-ingresos').innerHTML = "";
                document.getElementById('mes-egresos').innerHTML = "";
                document.getElementById('mes-saldo').innerHTML = "";
                var date = calendar.getDate().toISOString();
                var mesSeleccionado = date.substring(5, 7);

                document.getElementById('mes-ingresos').innerHTML = "$ "+(arraySumaMeses[mesSeleccionado]["ingreso"]).toFixed(2);
                document.getElementById('mes-egresos').innerHTML = "$ "+(arraySumaMeses[mesSeleccionado]["egreso"]).toFixed(2);
                document.getElementById('mes-saldo').innerHTML = "$ "+(arraySumaMeses[mesSeleccionado]["saldo"]).toFixed(2);
            });

            document.querySelector(".fc-next-button").addEventListener("click", function(event) {
                document.getElementById('mes-ingresos').innerHTML = "";
                document.getElementById('mes-egresos').innerHTML = "";
                document.getElementById('mes-saldo').innerHTML = "";
                var date = calendar.getDate().toISOString();
                var mesSeleccionado = date.substring(5, 7);

                document.getElementById('mes-ingresos').innerHTML = "$ "+(arraySumaMeses[mesSeleccionado]["ingreso"]).toFixed(2);
                document.getElementById('mes-egresos').innerHTML = "$ "+(arraySumaMeses[mesSeleccionado]["egreso"]).toFixed(2);
                document.getElementById('mes-saldo').innerHTML = "$ "+(arraySumaMeses[mesSeleccionado]["saldo"]).toFixed(2);
            });

            document.querySelector(".fc-dayGridMonth-button").addEventListener("click", function(event) { document.getElementById('rowSumas').style.visibility = 'visible';});
            document.querySelector(".fc-timeGridWeek-button").addEventListener("click", function(event) { document.getElementById('rowSumas').style.visibility = 'hidden';});
            document.querySelector(".fc-listMonth-button").addEventListener("click", function(event) { document.getElementById('rowSumas').style.visibility = 'visible';});
        });
</script>
@endsection
