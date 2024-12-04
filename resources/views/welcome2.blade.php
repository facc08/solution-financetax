<!DOCTYPE html>
<html lang="es">
<!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/carousel.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>INICIO</title>
    <!-- General CSS Files -->

    <link rel="stylesheet" href=" {{ asset('aegis/source/light/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('aegis/source/light/assets/css/style.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('aegis/source/light/assets/img/icono.ico') }}">
    <style type="text/css">
        a {
        color: inherit;
        }

        .menu-icon{
            font-size: 25px;
            padding-top: 10px;
        }

        .menu-text{
            font-size: 0.60rem;
            font-family: "Nunito", "Segoe UI", arial;
        }

        .menu-item,
        .menu-open-button {
        background: #8f33ca;
        border-radius: 100%;
        width: 80px;
        height: 80px;
        margin-left: -40px;
        position: absolute;
        color: #FFFFFF;
        text-align: center;
        line-height: 80px;
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        -webkit-transition: -webkit-transform ease-out 200ms;
        transition: -webkit-transform ease-out 200ms;
        transition: transform ease-out 200ms;
        transition: transform ease-out 200ms, -webkit-transform ease-out 200ms;
        }

        .menu-open {
        display: none;
        }

        .lines {
        width: 25px;
        height: 3px;
        background: white;
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -12.5px;
        margin-top: -1.5px;
        -webkit-transition: -webkit-transform 200ms;
        transition: -webkit-transform 200ms;
        transition: transform 200ms;
        transition: transform 200ms, -webkit-transform 200ms;
        }

        .line-1 {
        -webkit-transform: translate3d(0, -8px, 0);
        transform: translate3d(0, -8px, 0);
        }

        .line-2 {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        }

        .line-3 {
        -webkit-transform: translate3d(0, 8px, 0);
        transform: translate3d(0, 8px, 0);
        }

        .menu-open:checked + .menu-open-button .line-1 {
        -webkit-transform: translate3d(0, 0, 0) rotate(45deg);
        transform: translate3d(0, 0, 0) rotate(45deg);
        }

        .menu-open:checked + .menu-open-button .line-2 {
        -webkit-transform: translate3d(0, 0, 0) scale(0.1, 1);
        transform: translate3d(0, 0, 0) scale(0.1, 1);
        }

        .menu-open:checked + .menu-open-button .line-3 {
        -webkit-transform: translate3d(0, 0, 0) rotate(-45deg);
        transform: translate3d(0, 0, 0) rotate(-45deg);
        }

        .menu {
        margin: auto;
        /*position: absolute;*/
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 80px;
        height: 80px;
        text-align: center;
        box-sizing: border-box;
        font-size: 26px;
        }


        /* .menu-item {
        transition: all 0.1s ease 0s;
        } */

        .menu-item:hover {
        background: #EEEEEE;
        color: #3290B1;
        }

        .menu-item:nth-child(3) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(4) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(5) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(6) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(7) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(8) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-item:nth-child(9) {
        -webkit-transition-duration: 180ms;
        transition-duration: 180ms;
        }

        .menu-open-button {
        z-index: 2;
        -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
        -webkit-transition-duration: 400ms;
        transition-duration: 400ms;
        -webkit-transform: scale(1.1, 1.1) translate3d(0, 0, 0);
        transform: scale(1.1, 1.1) translate3d(0, 0, 0);
        cursor: pointer;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        }

        .menu-open-button:hover {
        -webkit-transform: scale(1.2, 1.2) translate3d(0, 0, 0);
        transform: scale(1.2, 1.2) translate3d(0, 0, 0);
        }

        .menu-open:checked + .menu-open-button {
        -webkit-transition-timing-function: linear;
        transition-timing-function: linear;
        -webkit-transition-duration: 200ms;
        transition-duration: 200ms;
        -webkit-transform: scale(0.8, 0.8) translate3d(0, 0, 0);
        transform: scale(0.8, 0.8) translate3d(0, 0, 0);
        }

        .menu-open:checked ~ .menu-item {
        -webkit-transition-timing-function: cubic-bezier(0.935, 0, 0.34, 1.33);
        transition-timing-function: cubic-bezier(0.935, 0, 0.34, 1.33);
        }

        .menu-open:checked ~ .menu-item:nth-child(3) {
        transition-duration: 180ms;
        -webkit-transition-duration: 180ms;
        -webkit-transform: translate3d(0.08361px, -104.99997px, 0);
        transform: translate3d(0.08361px, -104.99997px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(4) {
        transition-duration: 280ms;
        -webkit-transition-duration: 280ms;
        -webkit-transform: translate3d(90.9466px, -52.47586px, 0);
        transform: translate3d(90.9466px, -52.47586px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(5) {
        transition-duration: 380ms;
        -webkit-transition-duration: 380ms;
        -webkit-transform: translate3d(90.9466px, 52.47586px, 0);
        transform: translate3d(90.9466px, 52.47586px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(6) {
        transition-duration: 480ms;
        -webkit-transition-duration: 480ms;
        -webkit-transform: translate3d(0.08361px, 104.99997px, 0);
        transform: translate3d(0.08361px, 104.99997px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(7) {
        transition-duration: 580ms;
        -webkit-transition-duration: 580ms;
        -webkit-transform: translate3d(-90.86291px, 52.62064px, 0);
        transform: translate3d(-90.86291px, 52.62064px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(8) {
        transition-duration: 680ms;
        -webkit-transition-duration: 680ms;
        -webkit-transform: translate3d(-91.03006px, -52.33095px, 0);
        transform: translate3d(-91.03006px, -52.33095px, 0);
        }

        .menu-open:checked ~ .menu-item:nth-child(9) {
        transition-duration: 780ms;
        -webkit-transition-duration: 780ms;
        -webkit-transform: translate3d(-0.25084px, -104.9997px, 0);
        transform: translate3d(-0.25084px, -104.9997px, 0);
        }

        .blue {
        background-color: #669AE1;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .blue:hover {
        color: #669AE1;
        text-shadow: none;
        }

        .green {
        background-color: #70CC72;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .green:hover {
        color: #70CC72;
        text-shadow: none;
        }

        .red {
        background-color: #FE4365;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .red:hover {
        color: #FE4365;
        text-shadow: none;
        }

        .purple {
        background-color: #C49CDE;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .purple:hover {
        color: #C49CDE;
        text-shadow: none;
        }

        .orange {
        background-color: #FC913A;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .orange:hover {
        color: #FC913A;
        text-shadow: none;
        }

        .lightblue {
        background-color: #62C2E4;
        box-shadow: 3px 3px 0 0 rgba(0, 0, 0, 0.14);
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.12);
        }

        .lightblue:hover {
        color: #62C2E4;
        text-shadow: none;
        }

        .credit {
        margin: 24px 20px 120px 0;
        text-align: right;
        color: #EEEEEE;
        }

        .credit a {
        padding: 8px 0;
        color: #C49CDE;
        text-decoration: none;
        transition: all 0.3s ease 0s;
        }

        .credit a:hover {
        text-decoration: underline;
        }

        #videoInicio {
            object-fit: cover;
            width: 100%;
            height: 100vh;
        }

        @media (max-width: 600px) {
            #videoInicio {
                height: 30vh;
            }

            #span-scroll, #text-scroll{
                display: none;
            }
        }

        .switch-button {
        background: rgba(255, 255, 255, 0.56);
        border-radius: 30px;
        overflow: hidden;
        width: 200px;
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        color: #155FFF;
        position: relative;
        padding-right: 110px;
        position: relative;

        position: absolute;
        top: 20px;
        right: 20px;
        height: 40px;
        }
        .switch-button:before {
        content: "AUDIO ON";
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        pointer-events: none;
        }
        .switch-button-checkbox {
        cursor: pointer;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 2;
        }
        .switch-button-checkbox:checked + .switch-button-label:before {
        transform: translateX(110px);
        transition: transform 300ms linear;
        }
        .switch-button-checkbox + .switch-button-label {
        position: relative;
        padding: 10px 0;
        display: block;
        user-select: none;
        pointer-events: none;
        }
        .switch-button-checkbox + .switch-button-label:before {
        content: "";
        background: #fff;
        height: 100%;
        width: 100%;
        position: absolute;
        left: 0;
        top: 0;
        border-radius: 30px;
        transform: translateX(0);
        transition: transform 300ms;
        }
        .switch-button-checkbox + .switch-button-label .switch-button-label-span {
        position: relative;
        }
        
        .btn-inicio:hover{
            opacity: 75%;
            cursor: pointer;
        }

        .mouse {
        width: 40px;
        height: 80px;
        border: 4px solid white;
        border-radius: 60px;
        position: relative;
        opacity: 85%;
        }
        .mouse::before {
        content: "";
        width: 12px;
        height: 12px;
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: white;
        border-radius: 50%;
        opacity: 2;
        animation: wheel 2s infinite;
        -webkit-animation: wheel 2s infinite;
        }

        @keyframes wheel {
        to {
            opacity: 0;
            top: 60px;
        }
        }
        @-webkit-keyframes wheel {
        to {
            opacity: 0;
            top: 60px;
        }
        }

        #span-scroll{
            position: absolute;
            top: 89%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);
        }

        #text-scroll{
            position: absolute;
            top: 80%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);
            color: #155FFF;
            opacity: 70%;
        }
        
        #row-botones-welcome{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        #row-descargar-app{
            width: fit-content;
            margin: 5px;
        }

        #row-inicio-sesion{
            width: fit-content;
            vertical-align: -webkit-baseline-middle;
            margin: 5px;
        }

        #row-boton-conoce-servicios{
            width: 45%;
            margin: auto;
        }
    </style>
    @laravelPWA
</head>
<body>
    <header>
        <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active video-container">
                    <video class="embed-responsive-item " height="" id="videoInicio" loop="" autoplay muted>
                        <source src="digital/mp4/video.mp4" type="video/mp4">
                        Su navegador no soporta este elemento.
                    </video>
                    <div class="switch-button">
                        <input class="switch-button-checkbox" type="checkbox" id="input-audio-video"></input>
                        <label class="switch-button-label" for=""><span class="switch-button-label-span">AUDIO OFF</span></label>
                    </div>
                    <span id="span-scroll"><div class="mouse"></div></span>
                    <span class="badge badge-pill badge-light" id="text-scroll"><b>Deslizar hacia abajo</b></span>
                    {{--<div class="carousel-caption d-none d-md-block">
                        <h5>SOLUTIONFINANCETAX</h5>
                        <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                        aria-pressed="true">EMPIEZA AHORA</a>
                    </div>
                    --}}
                </div>
            </div>
        </div>
    </header>

    <section class="my-5">
        <div class="container-sm">
            <br>
            <br>
            <br>
            <nav class="menu">
                <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open" />
                <label class="menu-open-button" for="menu-open">
                    <span class="lines line-1"></span>
                    <span class="lines line-2"></span>
                    <span class="lines line-3"></span>
                </label>

                <a href="/page#services" class="menu-item" style="background-color: #c22a5e;"><i class="fas fa-chart-bar menu-icon" aria-hidden="true"><br><span class="menu-text"><b>CONTABILIDAD</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #c22a5e;"><i class="far fa-money-bill-alt menu-icon"><br><span class="menu-text"><b>FINANCIERO</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #c22a5e;"><i class="fas fa-users menu-icon"><br><span class="menu-text"><b>RRHH</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #c22a5e;"><i class="fas fa-address-card menu-icon"><br><span class="menu-text"><b>TRIBUTACI&Oacute;N</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #c22a5e;"><i class="fas fa-bullhorn menu-icon"><br><span class="menu-text"><b>MARKETING</b></span></i></a>
                <a href="/page#services" class="menu-item" style="background-color: #c22a5e;"><i class="fas fa-gavel menu-icon"><br><span class="menu-text"><b>LEGAL</b></span></i></a>
            </nav>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
             <div id="row-botones-welcome">
                <div id="row-descargar-app">
                    <a class="btn btn-inicio" role="button" aria-pressed="true" style="background: #c22a5e; color: white"
                        id="descargar-aplicacion-modal" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-cloud-download-alt" style="font-size: 18px"></i>&nbsp;&nbsp;Descargar aplicaci&oacute;n
                    </a>
                </div>
                <div id="row-inicio-sesion">
                    <a class="btn btn- btn-info" role="button" aria-pressed="true" style="color: white" href="/login">
                        <i class="fas fa-user-circle" style="font-size: 18px"></i>&nbsp;&nbsp;Iniciar Sesi&oacute;n
                    </a>
                </div>
                <br><br>
            </div>
            <br>
            <div id="row-boton-conoce-servicios">
                <!-- Button trigger modal -->
                <a href="{{ url('/page') }}" class="btn btn-lg btn-block btn-inicio" role="button"
                aria-pressed="true" style="background: #8130b4; color: white">CONOCE NUESTROS SERVICIOS <u>AQU&Iacute;</u></a>
            </div>
        </div>
    </section>

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Instalar Aplicaci&oacute;n</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal-body-content-install" style="display: none">
        <div class="modal-body">
            ¿ Desea instalar la web app?
            <br><br><br>
            <button class="btn" type="button" style="background: #8130b4; color: white; width: 100%; font-size: 13px" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-exclamation-circle menu-icon" aria-hidden="true"></i>&nbsp;Si presenta inconvenientes al instalar la web app, <b>revisar nuestra guía de instalación haciendo <u>click aquí</u></b>
            </button>
        </div>
        <div class="collapse" id="collapseExample"> 
            <div class="modal-body">
                <div class="alert alert-dark" role="alert">
                    <div class="alert alert-info" role="alert">
                        <i class="fa fa-info-circle menu-icon" aria-hidden="true"></i>&nbsp;
                        Se recomienda usar el navegador <b>Google Chrome</b> para instalar y usar la web app&nbsp;<img src="digital/images/Google-Chrome-icon.png" height="45" alt="Safari">
                    </div>
                    <p><b>Para instalar la web app, tener en cuenta los siguientes puntos:</b><p>
                    <ul>
                        <li>Comprueba tu conexión a internet</li>
                        <li>Navegadores permitidos</li>
                        <img height="30" src="digital/images/Google-Chrome-icon.png" alt="GoogleChrome">
                        <img height="30" src="digital/images/Edge-icon.png" alt="MicrosoftEdge">
                        <img height="30" src="digital/images/Firefox-icon.png" alt="Firefox">
                        <img height="30" src="digital/images/Opera-icon.png" alt="Opera">
                        <li>Actualizar el navegador a su versión mas reciente</li>
                        <li>Comprobar que su navegador no se encuentre en modo incógnito o secreto</li>
                        <li>Revisar permisos de su navegador (Notificaciones push)</li>
                        <li>Esperar a la instalación, sólo debería tardar un momento</li>
                        <li>Revisar si no ha sido previamente instalada</li>
                    </ul>
                    <p><b>Para instalar la web app de forma manual desde su navegador, siga estos pasos:</b><p>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pill-chrome-tab" data-toggle="pill" data-target="#pill-chrome" type="button" role="tab"
                            aria-controls="pill-chrome" aria-selected="true">
                                <img height="30" src="digital/images/Google-Chrome-icon.png" alt="GoogleChrome">&nbsp;Google Chrome
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pill-edge-tab" data-toggle="pill" data-target="#pill-edge" type="button" role="tab"
                            aria-controls="pill-edge" aria-selected="false">
                                <img height="30" src="digital/images/Edge-icon.png" alt="MicrosoftEdge">&nbsp;Microsoft Edge
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pill-firefox-tab" data-toggle="pill" data-target="#pill-firefox" type="button" role="tab"
                            aria-controls="pill-firefox" aria-selected="false">
                                <img height="30" src="digital/images/Firefox-icon.png" alt="Firefox">&nbsp;Mozilla Firefox
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pill-opera-tab" data-toggle="pill" data-target="#pill-opera" type="button" role="tab"
                            aria-controls="pill-opera" aria-selected="false">
                                <img height="30" src="digital/images/Opera-icon.png" alt="Opera">&nbsp;Opera
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pill-chrome" role="tabpanel" aria-labelledby="pill-chrome-tab">
                            <ol>
                                <li>Normalmente, Chrome mostrará un mensaje de instalación en la barra de direcciones o un icono en la barra de herramientas.</li>
                                <img src="digital/images/Google-Chrome-install-pwa.PNG" alt="ChromeInstall">
                                <li>Haz clic en el icono de instalación.</li>
                                <li>Si se le solicita, confirme la instalación haciendo clic en "Instalar" o "Añadir".</li>
                                <li>Seleccione dónde desea instalar la Web App, como el escritorio o el menú de aplicaciones.</li>
                                <li>Una vez instalado, puedes encontrar y utilizar el web app en su dispositivo.</li>
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="pill-edge" role="tabpanel" aria-labelledby="pill-edge-tab">
                            <ol>
                                <li>Edge mostrará normalmente un mensaje de instalación en la barra de direcciones o un icoalno en la barra de herramientas.</li>
                                <img src="digital/images/Edge-install-pwa.PNG" alt="EdgeInstall">
                                <li>Haz clic en el icono de instalación.</li>
                                <li>Si se le solicita, confirme la instalación haciendo clic en "Instalar".</li>
                                <li>Seleccione dónde desea instalar la Web App, como el escritorio o el menú de aplicaciones.</li>
                                <li>Una vez instalado, puedes encontrar y utilizar el web app en su dispositivo.</li>
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="pill-firefox" role="tabpanel" aria-labelledby="pill-firefox-tab">
                            <ol>
                                <li>Firefox suele mostrar un aviso de instalación en la barra de direcciones u ofrecer un icono en la barra de herramientas.</li>
                                <img src="digital/images/Firefox-install-pwa.PNG" alt="FirefoxInstall">
                                <li>Haz clic en el icono de instalación.</li>
                                <li>Si se le solicita, confirme la instalación haciendo clic en "Instalar".</li>
                                <li>Seleccione dónde desea instalar la Web App, como el escritorio o el menú de aplicaciones.</li>
                                <li>Una vez instalado, puedes encontrar y utilizar el web app en su dispositivo.</li>
                            </ol>
                        </div>
                        <div class="tab-pane fade" id="pill-opera" role="tabpanel" aria-labelledby="pill-opera-tab">
                            <ol>
                                <li>Opera mostrará normalmente un aviso de instalación en la barra de direcciones o un icono en la barra de herramientas.</li>
                                <img src="digital/images/Opera-install-pwa.PNG" alt="OperaInstall">
                                <li>Haz clic en el icono de instalación.</li>
                                <li>Si se le solicita, confirme la instalación haciendo clic en "Instalar".</li>
                                <li>Seleccione dónde desea instalar la Web App, como el escritorio o el menú de aplicaciones.</li>
                                <li>Una vez instalado, puedes encontrar y utilizar el web app en su dispositivo.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            <button type="button" class="btn btn-primary"  id="descargarPwa">Instalar</button>
        </div>
      </div>
      <div id="modal-body-content-ios" style="display: none">
        <div class="modal-body">
            <div class="alert alert-dark" role="alert">
                <div class="alert alert-info" role="alert">
                    <i class="fa fa-info-circle menu-icon" aria-hidden="true"></i>&nbsp;
                    Se recomienda usar el navegador <b>Safari</b> para instalar y usar la web app&nbsp;<img src="digital/images/Safari-icon.png" height="45" alt="Safari">
                </div>
                <p>Para instalar la aplicación web desde Safari, toca el botón <b>Compartir</b> y selecciona <b>"Añadir a pantalla de inicio"</b>.</p>
                <p>To install the web app, tap the <b>Share</b> button and select <b>"Add to Home Screen"</b>.</p>
                <div class="row" style="margin-left: 25%">
                    <img src="digital/images/Safari-install-pwa-1.PNG" alt="SafariInstall-1">
                </div>
                <div class="row" style="margin-left: 25%">
                    <img src="digital/images/Safari-install-pwa-2.PNG" alt="SafariInstall-2">
                </div>
                <div class="row" style="margin-left: 25%">
                    <img src="digital/images/Safari-install-pwa-3.PNG" alt="SafariInstall-3">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        </div>
      </div>
    </div>
  </div>
</div>

    {{-- <section>
        <div class="card">
            <div class="card-body">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <video class="embed-responsive-item w-100 " height="" autoplay loop>
                                <source src="digital/mp4/video.mp4" type="video/mp4">
                            </video>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>SOLUTIONFINANCETAX</h5>
                                <a href="{{ url('/page') }}" class="btn btn-dark btn-lg btn-block" role="button"
                                aria-pressed="true">CONOCE NUESTROS SERVICIOS <u>AQU&iacute;</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- General JS Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script>

        document.getElementById("input-audio-video")
        .addEventListener("click", function(event) {
            var vid = document.getElementById("videoInicio");
            if(vid.muted){
                vid.muted = false;
            }else{
                vid.muted = true;
            }
        });

        /*let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            // Update UI notify the user they can install the PWA
            //showInstallPromotion();
        });*/
        // Inicializa deferredPrompt para su uso más tarde.
        
        /*var deferredPrompt;

window.addEventListener('beforeinstallprompt', function(e) {
  console.log('beforeinstallprompt Event fired');
  e.preventDefault();

  // Stash the event so it can be triggered later.
  deferredPrompt = e;

  return false;
});

document.getElementById("descargarPwa").addEventListener('click', function() {
  if(deferredPrompt !== undefined) {
    // The user has had a postive interaction with our app and Chrome
    // has tried to prompt previously, so let's show the prompt.
    deferredPrompt.prompt();

    // Follow what the user has done with the prompt.
    deferredPrompt.userChoice.then(function(choiceResult) {

      if(choiceResult.outcome == 'dismissed') {
      }
      else {

      }

      // We no longer need the prompt.  Clear it up.
      deferredPrompt = null;
    });
  }
});*/
//descargarPwa
/*
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
  // Prevent the mini-infobar from appearing on mobile
  e.preventDefault();
  // Stash the event so it can be triggered later.
  console.log(e);
  deferredPrompt = e;
  // Update UI notify the user they can install the PWA
  //showInstallPromotion();
});

const buttonInstall = document.getElementById("descargarPwa");
buttonInstall.addEventListener('click', async () => {
    console.log("click");
    console.log(deferredPrompt);
    if (deferredPrompt !== null) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        if (outcome === 'accepted') {
            deferredPrompt = null;
        }
    }
});
*/

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault(); // Prevent automatic prompting
    const installButton = document.getElementById('descargarPwa');
    installButton.disabled = false;
    installButton.addEventListener('click', () => {
        event.prompt(); // Show install prompt
        event.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('Web app Instalado');
            } else {
                console.log('Web app Instalación cancelada');
            }
        });
    });
});


function showInstallBanner() {
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

    if (isIOS && isSafari) {
    const webAppBanner = document.createElement('meta');
    webAppBanner.name = 'apple-mobile-web-app-capable';
    webAppBanner.content = 'yes';
    document.head.appendChild(webAppBanner);
    document.getElementById("modal-body-content-ios").style.display = "block";
    //alert('Para instalar la aplicación web, toca el botón Compartir y selecciona "Añadir a pantalla de inicio".\n\n\nTo install the web app, tap the Share button and select "Add to Home Screen".');
    }else{
    document.getElementById("modal-body-content-install").style.display = "block";
    }
}

// Attach the function to a button click event
const installButton = document.getElementById('descargar-aplicacion-modal');
installButton.addEventListener('click', showInstallBanner);



    document.getElementById("menu-open").click();
    </script>
</body>


</html>
