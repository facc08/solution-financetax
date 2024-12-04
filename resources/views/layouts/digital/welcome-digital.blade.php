

    @section('css')
        <style>
        
        #menucircular  .wrapper {
                width: 100%;
                height: 100vh;
                position: relative;
            }

            #menucircular   .menu-btn {
                background: #e355fd;
                border-radius: 50%;
                width: 100px;
                height: 100px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                cursor: pointer;
                transition: background .3s;
                z-index: 2;
                box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.3);
            }

            #menucircular    .menu-btn:hover,
            #menucircular     .active {
                background: #e355fd;
            }

            #menucircular    .menu-btn,
            #menucircular     .icons-wrapper {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                transition-delay: .1s;
            }

            #menucircular   .menu-btn span {
                display: block;
                width: 30px;
                height: 3px;
                background: rgb(0, 0, 0);
                margin-bottom: 5px;
                transition: background .3s, transform .3s;
            }

            #menucircular    .menu-btn span:last-child {
                margin-bottom: 0;
            }

            #menucircular   .active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }

            #menucircular   .active span:nth-child(2) {
                opacity: 0;
            }

            #menucircular   .active span:nth-child(3) {
                transform: rotate(-45deg) translate(6px, -5px);
            }

            #menucircular     .icons {
                position: relative;
            }

            #menucircular     .icon {
                position: absolute;
                top: calc(50% - 30px);
                left: calc(50% - 30px);
                background: #272C2C;
                width: 70px;
                height: 70px;
                border-radius: 70%;
                display: flex;
                cursor: pointer;
                transform: translate(0px, 0px);
                z-index: 1;
            }

            #menucircular     .icon:hover {
                background: #000000;
            }

            #menucircular     .icon:hover .fas {
                color: #e355fd;
            }

            #menucircular     .fas {
                margin: 1.2rem;

                color: #e355fd;
                font-size: 40px;
                position: absolute;
            }

            #menucircular      .icon:nth-child(1) {
                transition: background .3s, transform .3s .10s;
            }

            #menucircular     .icon:nth-child(2) {
                transition: background .3s, transform .3s .15s;
            }

            #menucircular     .icon:nth-child(3) {
                transition: background .3s, transform .3s .20s;
            }

            #menucircular      .icon:nth-child(4) {
                transition: background .3s, transform .3s .25s;
            }

            #menucircular    .icon:nth-child(5) {
                transition: background .3s, transform .3s .30s;
            }

            #menucircular      .icon:nth-child(6) {
                transition: background .3s, transform .3s .35s;
            }

            #menucircular     .icon:nth-child(7) {
                transition: background .3s, transform .3s .40s;
            }

            #menucircular      .icon:nth-child(8) {
                transition: background .3s, transform .3s .45s;
            }

            #menucircular      .show:nth-child(1) {
                transform: translate(0px, -150px);
            }

            #menucircular     .show:nth-child(2) {
                transform: translate(110px, -110px);
            }

            #menucircular      .show:nth-child(3) {
                transform: translate(150px, 0px);
            }

            #menucircular      .show:nth-child(4) {
                transform: translate(110px, 110px);
            }

            #menucircular    .show:nth-child(5) {
                transform: translate(0px, 150px);
            }

            #menucircular     .show:nth-child(6) {
                transform: translate(-110px, 110px);
            }

            #menucircular      .show:nth-child(7) {
                transform: translate(-150px, 0px);
            }

            #menucircular     .show:nth-child(8) {
                transform: translate(-110px, -110px);
            }
            

        </style>

        {{-- <style>

            
                #menudos     .menu {
                position: relative;
                background: #cd3e3d;
                width: 3em;
                height: 3em;
                border-radius: 5em;
                margin: auto;
                margin-top: 5em;
                margin-bottom: 5em;
                cursor: pointer;
                border: 1em solid #df1cb8;
                }
                #menudos     .menu:after {
                content: "";
                position: absolute;
                top: 1em;
                left: 1em;
                width: 1em;
                height: 0.2em;
                border-top: 0.6em double #fff;
                border-bottom: 0.2em solid #fff;
                }
                #menudos    .menu ul {
                list-style: none;
                padding: 0;
                }
                #menudos     .menu li {
                width: 5em;
                height: 1.4em;
                padding: 0.2em;
                margin-top: 0.2em;
                text-align: center;
                border-top-right-radius: 0.6em;
                border-bottom-right-radius: 0.6em;
                transition: all 1s;
                background: #fdaead;
                opacity: 0;
                z-index: -1;
                }
                #menudos     .menu:hover li {
                opacity: 1;
                }
                /**
                * Add a pseudo element to cover the space
                * between the links. This is so the menu
                * does not lose :hover focus and disappear
                */
                #menudos    .menu:hover ul::before {
                position: absolute;
                content: "";
                width: 0;
                height: 0;
                display: block;
                left: 50%;
                top: -5.0em;
                /**
                * The pseudo-element is a semi-circle
                * created with CSS. Top, bottom, and right
                * borders are 6.5em (left being 0), and then
                * a border-radius is added to the two corners
                * on the right.
                */
                border-width: 6.5em;
                border-radius: 0 7.5em 7.5em 0;
                border-left: 0;
                border-style: solid;
                /**
                * Have to have a border color for the border
                * to be hoverable. I'm using a very light one
                * so that it looks invisible.
                */
                border-color: rgba(0,0,0,0.01);
                /**
                * Put the psuedo-element behind the links
                * (So they can be clicked on)
                */
                z-index: -1;
                /**
                * Make the cursor default so it looks like
                * nothing is there
                */
                cursor: default;
                }
                #menudos    .menu a {
                color: white;
                text-decoration: none;
                /**
                * This is to vertically center the text on the
                * little tab-like things that the text is on.
                */
                line-height: 1.5em;
                }
                #menudos     .menu a {
                color: white;
                text-decoration: none;
                }
                #menudos    .menu ul {
                transform: rotate(180deg) translateY(-2em);
                transition: 1s all;
                }
                #menudos     .menu:hover ul {
                transform: rotate(0deg) translateY(-1em);
                }
                #menudos     .menu li:hover {
                background: #cd3e3d;
                z-index: 10;
                }

                #menudos    .menu li:nth-of-type(1) {
                transform: rotate(-90deg);
                position: absolute;
                left: -1.2em;
                top: -4.2em;
                }
                #menudos    .menu li:nth-of-type(2) {
                transform: rotate(-45deg);
                position: absolute;
                left: 2em;
                top: -3em;
                }
                #menudos    .menu li:nth-of-type(3) {
                position: absolute;
                left: 3.4em;
                top: 0.3em;
                }
                #menudos   .menu li:nth-of-type(4) {
                transform: rotate(45deg);
                position: absolute;
                left: 2em;
                top: 3.7em;
                }
                #menudos   .menu li:nth-of-type(5) {
                transform: rotate(90deg);
                position: absolute;
                left: -1.2em;
                top: 5em;
                }
                #menudos   .hint {
                text-align: center;
                }


        </style> --}}

    @endsection

    @section('header')
        <div class="row">
            <div class="col-md-12">
                <div class="header-carousal owl-carousel owl-theme">
                    <div class="item">
                        <h4>Nosotros Somos</h4>
                        <h2>Tu Consultoría OnLine</h2>
                        <a href="{{ url('/nosotros-solution') }}" class="btn btn-danger  btn-lg" role="button"
                            aria-pressed="true">Empieza Ahora</a>
                    </div>
                    <div class="item">
                        <h4>Compartir el mismo objetivo es el primer paso para el</h4>
                        <h2>ÉXITO</h2>
                        <a href="{{ url('/nosotros-solution') }}" class="btn btn-danger  btn-lg" role="button"
                            aria-pressed="true">Empieza Ahora</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('content')


        <section class="about-us">
            <h2>ACERCA DE NOSOTROS</h2>
            <div class="about-icon">
                <img src="img/section-icon.jpg" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="video">
                            <iframe width="100%" src="digital/mp4/financetaxvideo.mp4" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text">
                            <h4 style="text-align: justify;">
                                Nuestros servicios de asesoría fiscal,
                                contable y administrativa se prestan a
                                empresas, profesionales y particulares,
                                a medida y de forma personalizada,
                                según los requerimientos de cada cliente.
                            </h4>
                            <br>
                            <h4 style="text-align: justify;">
                                Somos una empresa especialista en asesorías
                                financieras, tributaria, contable y Laboral.
                                Como empresa de consultoría de gestión para
                                compañías, prestamos un servicio altamente
                                profesionalizado, orientado al área
                                económico-financiera, gerencial y de organización.
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <section class="footer-icon">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-carousal owl-carousel owl-theme">
                            <div class="item">
                                <h4 class="text-center"> CONSULTORÍA DE GESTIÓN ONLINE</h4>
                                <p class="text-center" style="text-align: justify;">
                                    Te asesoramos en cualquier área de gestión: Finanzas, Tributación, Presupuesto,
                                    Contabilidad, Organización, RRHH, Operaciones, Estrategia, Plan de Ventas, Mejora de
                                    Procesos y más

                                </p>
                            </div>
                            <div class="item">
                                <h4 class="text-center">¡TÚ ELIGES!</h4>
                                <p class="text-center" style="text-align: justify;">
                                    Planes que se adaptan a tus necesidades desde $50/mes
                                </p>
                            </div>
                            <div class="item">
                                <h4 class="text-center"> CONSULTORES SENIOR EXPERTOS EN CADA AREA</h4>
                                <p class="text-center" style="text-align: justify;">
                                    Nuestros Consultores tienen amplia experiencia como Directivos y Consultores de Empresas
                                </p>
                            </div>
                            <div class="item">
                                <h4 class="text-center">CONTACTO &Aacute;GIL</h4>
                                <p class="text-center" style="text-align: justify;">
                                    A través de email, chat, teléfono o videoconferencia
                                </p>
                            </div>
                            <div class="item">
                                <h4 class="text-center">+ CLIENTES</h4>
                                <p class="text-center" style="text-align: justify;">
                                    Más clientes y empresas avalan nuestra experiencia y metodología ayudando a Pymes,
                                    profesionales y al nuevo emprendedor.
                                </p>
                            </div>
                            <div class="item">
                                <h4 class="text-center">SIN PERMAMENCIA</h4>
                                <p class="text-center" style="text-align: justify;">
                                    nuestros planes siempre buscan la optimización de recursos de nuestros clientes.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="service">
            <h2>Servicios</h2>
            <div class="about-icon">
            
            </div>
        
            <div class="container">
            
                <div id="menucircular">

                    <div class="wrapper">

                        <div class="menu-btn">
                        <div class="btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        </div>
                    
                        <div class="icons-wrapper">
                        <div class="icons" align = "justify">
                            <div class="icon"><a href=""><i class="fas fa-address-card" data-toggle="tooltip" data-placement="top" title="SERVICIOS CONTABLE"></i></a></div>
                            <div class="icon"><a href=""><i class="fas fa-chart-bar" data-toggle="tooltip" data-placement="top" title="FINANZAS"></i></a></div>
                            <div class="icon"><a href=""><i class="fas fa-donate" data-toggle="tooltip" data-placement="top" title="IMPUESTO"></i></a></div>
                            <div class="icon"><a href=""><i class="fas fa-users" data-toggle="tooltip" data-placement="top" title="RRHH"></i></a></div>
                            <div class="icon"><a href=""><i class="fas fa-chart-pie" data-toggle="tooltip" data-placement="top" title="MARKETING"></i></a></div>                     
                            <div class="icon"><a href=""><i class="fas fa-chart-line" data-toggle="tooltip" data-placement="top" title="INDICADORES DE GESTIÓN"></i></a></div>
                            <div class="icon"><a href=""><i class="fas fa-laptop-code" data-toggle="tooltip" data-placement="top" title="SERVICIOS PARA EMPRENDEDORES"></i></a></div>
                            <div class="icon"><a href=""><i class="fas fa-plus" data-toggle="tooltip" data-placement="top" title="Otros Servicios"></i></a></div>

                        </div>
                        </div>
                    
                    </div>

                </div>
        </section>


        {{-- <section class="service">
            <h2>dos</h2>
            <div class="about-icon">
                <img src="img/section-icon.jpg" alt="">
            </div>
            <div class="container">
                <div id="menudos">

                    <div class="container">
                        <nav class="menu">
                            <ul>
                            <li><a href="#products">Products</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#careers">Careers</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                            </ul>
                        </nav>
                    </div><!-- container -->

                </div>
        </section> --}}

        <section class="contact-area">
            <div class="container">
                <br>
                <h4 class="text-center">
                    <i>
                        Con Solution Finance Tax podras solucionar tus dudas de gestión empresarial de forma rápida y ágil via
                        email, chat, teléfono o videoconferencia.
                    </i>
                </h4>
                <br>
                <h4>
                    <i>
                        Asesoramos en cualquier área empresarial: <strong> Financiera, Tributaria, Contable , Comercial,
                            Marketing, RRHH, Atención al Cliente, Procesos y muchas más.</strong>
                    </i>
                </h4>
                <br>
                <h4>
                    <i>
                        La realidad y el día a día de la Pyme son diferentes a la de una gran empresa, es por ello que en
                        <strong> TuConsultoriaOnline</strong> entendemos que tus preocupaciones y recursos son diferentes, pero
                        no por ello hay que renunciar a alcanzar la excelencia en la gestión.
                    </i>
                </h4>
                <br>
                <h2 class="text-center">
                    <strong>¡NO TE PREOCUPES POR LA DISTANCIA! </strong>
                </h2>
                <br>
                <h4>
                    <i>
                        La comunicación vía chat, email, telefónica o videoconferencia con tu asesor nos permite darte un trato
                        cercano y de confianza, como también un servicio más rápido, cómodo y ágil.
                    </i>
                </h4>
                <br>
                <h4>
                    <i>
                        Somos tu <strong>compañero de viaje ideal</strong> , poniendo profesionales a tu alcance que te ayudarán
                        en cualquier consulta de gestión que tengas.
                    </i>
                </h4>


            </div>
        </section>

        <br>


    @endsection

    @section('js')

        <script>
            $(function( ) {
                var $btn = $('.btn'),
                    $menuBtn = $('.menu-btn'),
                    $icon = $(' .icon');

                $menuBtn.on('click', function() {
                    $(this).toggleClass('active');
                    $icon.toggleClass('show');
                    $btn.toggleClass('active');
                });
            });
        </script>

    @endsection 
        
    