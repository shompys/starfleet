<?php 
    //$captcha = require_once 'captcha_v1.php'; 
    //require_once 'captcha_v1.php';
    require_once '../app/Conexion.inc.php';
    require_once '../app/RepositorioContrato.inc.php';
    session_start();
    Conexion::abrir_conexion();
    $_typeContract = RepositorioContrato::obtener_todos_nombres_contratos(Conexion::obtener_conexion());
    Conexion::cerrar_conexion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Cardo:400,700|Oswald" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
        }
        .loader-bg {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.95);
        }
        .loader {
            position: fixed;
            z-index: 9999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 70px;
            text-align: center;
        }
        .loader .bounce1 {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }
        .loader .bounce2 {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }
        .loader > div {
            width: 18px;
            height: 18px;
            background-color: #ffc107;
            border-radius: 100%;
            display: inline-block;
            -webkit-animation: loaderAnimation 1.4s infinite ease-in-out both;
            animation: loaderAnimation 1.4s infinite ease-in-out both;
        }
        @keyframes loaderAnimation {
            0%, 80%, 100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }
            40% {
                -webkit-transform: scale(1.0);
                transform: scale(1.0);
            }
        }
    </style>
</head>
<body id="body">
    
    <div class="loader-bg" id="preloader">
        <div class="loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <script type="text/javascript">
        (function(){

            var bodys   = document.getElementById('body');
            var preload = document.getElementById('preloader');
            var loading = 0;
            var id = setInterval(frame, 64);

            function frame(){
                if(loading == 100)
                {
                    clearInterval(id);
                } 
                else
                {
                    loading = loading + 1;
                    if(loading == 90){
                        bodys.style.overflow  = 'auto';
                        preload.style.opacity = '0';
                        preload.style.display = 'none';
                    }
                }
            }

        })();
    </script>
    

    <div class="container-fluid fixed-top bg-dark" style="box-shadow: 0 0 20px 0 rgba(0,0,0,0.2);">
        <div class="container px-0">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a class="navbar-brand" href="https://starfleet.company/profliendro/"><img src="images/logo.svg" alt="Starfleet"></a>
            
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <!--<span class="navbar-toggler-icon"></span>-->
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#nuestros-servicios">Nuestros servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#quienes-somos">¿Quiénes somos?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#precios">Precios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contacto">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://starfleet.company/" class="btn btn-outline-warning mt-2 ml-lg-4 my-lg-0">Ingresar al sistema</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    
    <div class="container-fluid px-0">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="carousel-caption text-left">
                            <h1 class="display-4">Honestidad</h1>
                            <p>Justos y coherentes en todas nuestras acciones.</p>
                            <!--<a class="btn btn-warning" href="#precios">Precios</a>-->
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1 class="display-4">Responsabilidad</h1>
                            <p>Asumiendo el compromiso y cumpliendo los mismos.</p>
                            <!--<a class="btn btn-warning" href="#" role="button">Sign up today</a>-->
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1 class="display-4">Vocación</h1>
                            <p>Predecir y exceder, oportunamente las expectativas de nuestros clientes.</p>
                            <!--<a class="btn btn-warning" href="#" role="button">Sign up today</a>-->
                        </div>
                    </div>
                </div>

                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"><svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg></a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"><svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg></a>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-light mb-5" id="nuestros-servicios">
        <div class="container">
            <div class="row">
                <div class="services-header px-3 pt-md-4 mx-auto text-center">
                    <h1 class="display-4">Nuestros servicios</h1>
                </div>
            </div>
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-4 mb-4 services2">
                    <div class="services2-icon"><svg width="4em" height="4em" viewBox="0 0 16 16" class="bi bi-people-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg></div>
                    <h1>RRHH</h1>
                    <ul class="mt-3 mb-3">
                        <li>Administración del personal de la empresa.</li>
                        <li>Manejo de horarios y asignacion vehicular.</li>
                        <li>Control de vencimiento de registros.</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4 services2">
                    <div class="services2-icon"><svg width="4em" height="4em" viewBox="0 0 16 16" class="bi bi-map-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.598-.49L10.5.99 5.598.01a.5.5 0 0 0-.196 0l-5 1A.5.5 0 0 0 0 1.5v14a.5.5 0 0 0 .598.49l4.902-.98 4.902.98a.502.502 0 0 0 .196 0l5-1A.5.5 0 0 0 16 14.5V.5zM5 14.09V1.11l.5-.1.5.1v12.98l-.402-.08a.498.498 0 0 0-.196 0L5 14.09zm5 .8V1.91l.402.08a.5.5 0 0 0 .196 0L11 1.91v12.98l-.5.1-.5-.1z"/></svg></div>
                    <h1>Logística</h1>
                    <ul class="mt-3 mb-3">
                        <li>Administración de los vehiculos.</li>
                        <li>Control de viajes y mantenimientos preventivos.</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4 services2">
                    <div class="services2-icon"><svg width="4em" height="4em" viewBox="0 0 16 16" class="bi bi-tools" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z"/><path fill-rule="evenodd" d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/></svg></div>
                    <h1>Talleres</h1>
                    <ul class="mt-3 mb-3">
                        <li>Control de reparaciones.</li>
                        <li>Inventario de insumos.</li>
                        <li>Agendas en linea del taller.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5" id="quienes-somos">
        <div class="row">
            <div class="business-header px-3 pt-md-4 mx-auto text-center">
                <h1 class="display-4">¿Quiénes somos?</h1>
                <p class="lead">Somos UdeIT&copy;, una empresa dedicada al desarrollo de software, relativamente joven, con tan solo unos años en el mercado, tiempo suficiente en el que fuimos perfeccionando nuestro producto, posicionando Starfleet&copy; como el principal software de gestión entre las principales empresas de logística del país.</p>
            </div>
        </div>

        <hr class="business-divider">

        <div class="row business">
            <div class="col-md-7 my-auto">
                <h2 class="business-heading">Nuestra Misión <div></div></h2>
                <p class="lead">Ser una empresa innovadora que busca el máximo beneficio de nuestros clientes a través de la calidad de nuestras soluciones, productos y servicios, manteniendo las mejores condiciones de trabajo para nuestros colaboradores y una alta rentabilidad para nuestros clientes.</p>
            </div>
            <div class="col-md-5 my-auto">
                <img class="img-fluid" style="box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.1);" src="images/mision.png" alt="">
            </div>
        </div>

        <hr class="business-divider">

        <div class="row business">
            <div class="col-md-7 order-md-2 my-auto">
                <h2 class="business-heading">Nuestra Visión <div></div></h2>
                <p class="lead">Ser un aliado estratégico para nuestros clientes basados en soluciones y servicios innovadores sobre la base de nuestra responsabilidad, calidad, productividad y compromiso.</p>
            </div>
            <div class="col-md-5 order-md-1 my-auto">
                <img class="img-fluid" style="box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.1);" src="images/vision.png" alt="">
            </div>
        </div>

        <hr class="business-divider">

        <div class="row business">
            <div class="col-md-7 my-auto">
                <h2 class="business-heading">Nuestros Valores <div></div></h2>
                <p class="lead"><span style="font-weight: 500;">Honestidad</span>, justos y coherentes en todas nuestras acciones. <span style="font-weight: 500;">Responsabilidad</span>, asumiendo el compromiso y cumpliendo los mismos. <span style="font-weight: 500;">Vocación</span>, predecir y exceder, oportunamente las expectativas de nuestros clientes.</p>
            </div>
            <div class="col-md-5 my-auto">
                <img class="img-fluid" style="box-shadow: 0px 0px 3px 1px rgba(0,0,0,0.1);" src="images/valores.png" alt="">
            </div>
        </div>
    </div>

    <div class="container-fluid mb-5" style="margin-top: 40px !important;" id="precios">
        <div class="container">
            <div class="row">
                <div class="prices-header px-3 pt-md-4 mx-auto text-center">
                    <h1 class="display-4">Precios</h1>
                </div>
            </div>
            <div class="row d-flex align-items-center justify-content-center">
                <div class="card-deck mb-3 text-center">
                    <div class="col-md-4 d-flex justify-content-center">
                        <div class="card mb-4 prices" style="border-radius: 0px !important;">
                            <div class="card-body px-5 py-4">
                                <div class="display-4" style="font-size: 3rem;">Básico</div>
                                <hr>
                                <ul class="mt-3 mb-3">
                                    <li>5 usuarios incluidos</li>
                                    <li>Soporte vía email</li>
                                    <li>Help center 24/7</li>
                                    <li>Contrato por 12 meses</li>
                                </ul>
                                <h1 class="card-title">$500 <small class="text-muted">/mes</small></h1>
                                <button type="button" class="btn btn-lg btn-block btn-warning text-uppercase mt-4" data-toggle="modal" data-target="#contratar">Contratar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center">
                        <div class="card mb-4 prices" style="border-radius: 0px !important;">
                            <div class="card-body px-5 py-4">
                                <div class="display-4" style="font-size: 3rem;">Pro</div>
                                <hr>
                                <ul class="mt-3 mb-3">
                                    <li>10 usuarios incluidos</li>
                                    <li>Soporte vía email</li>
                                    <li>Help center 24/7</li>
                                    <li>Contrato por 12 meses</li>
                                </ul>
                                <h1 class="card-title">$1500 <small class="text-muted">/mes</small></h1>
                                <button type="button" class="btn btn-lg btn-block btn-warning text-uppercase mt-4" data-toggle="modal" data-target="#contratar">Contratar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center animate" data-animate="animate_animated animate__bounceIn" data-duration="1.0s" data-delay="0.5s" data-offset="70" data-iteration="1">
                        <div class="card mb-4 prices" style="border-radius: 0px !important;">
                            <div class="card-body px-5 py-4">
                                <div class="display-4" style="font-size: 3rem;">Premium</div>
                                <hr>
                                <ul class="mt-3 mb-3">
                                    <li>15 usuarios incluidos</li>
                                    <li>Soporte vía email</li>
                                    <li>Help center 24/7</li>
                                    <li>Contrato por 24 meses</li>
                                </ul>
                                <h1 class="card-title">$2500 <small class="text-muted">/mes</small></h1>
                                <button type="button" class="btn btn-lg btn-block btn-warning text-uppercase mt-4" data-toggle="modal" data-target="#contratar">Contratar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark" style="padding-bottom: 40px !important;" id="contacto">
        <div class="container">
            <div class="row">
                <div class="prices-header px-3 pt-md-4 mx-auto text-center">
                    <h1 class="display-4 text-muted">Contacto</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="mapa">
                        <iframe width="100%" height="470" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3283.668529662471!2d-58.377485085052015!3d-34.61254246547158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccad4506b020d%3A0x5f61c6f9b3c894a1!2sAv.%20Belgrano%20637%2C%20C1092%20AAG%2C%20Buenos%20Aires!5e0!3m2!1ses!2sar!4v1601056291096!5m2!1ses!2sar"></iframe>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <form class="form-new-contact" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="text-muted" style="font-family: 'Oswald';">Nombre y Apellido</label>
                                <input type="text" name="contact-fullname" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="text-muted"  style="font-family: 'Oswald';">Correo electrónico</label>
                                <input type="text" name="contact-email" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="text-muted"  style="font-family: 'Oswald';">Teléfono</label>
                                <input type="text"  name="contact-phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="text-muted"  style="font-family: 'Oswald';">Mensaje</label>
                                <textarea  name="contact-message" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="text-muted"  style="font-family: 'Oswald';">Captcha</label>
                                <input type="text"  name="contact-captcha" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-muted"  style="font-family: 'Oswald';">&nbsp;</label>
                                <img src="" class="captcha" style="width: 100%; height: auto;">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <button type="button" class="btn btn-block btn-light" id="reset">Reset</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-block btn-warning">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="business-card">
                        <div class="business-userpic-wrapper">
                            <div class="business-userpic" style="--userpic: url('../images/jg-avatar.jpg');"></div>
                        </div>
                        <div class="business-info-wrapper">
                            <div class="business-info">
                                <p class="business-name">Jonathan Gómez</p>
                                <p class="business-work text-muted">Desarrollador</p>
                                <p class="business-cel"><svg width="1.6em" height="1.6em" viewBox="0 0 22 22" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg> 1167230056</p>
                                <p class="business-mail"><svg width="1.6em" height="1.6em" viewBox="0 0 20 20" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/></svg> jgomez@udeit.com</p>
                                <p class="business-www"><svg width="1.6em" height="1.6em" viewBox="0 0 20 20" class="bi bi-globe2" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539a8.372 8.372 0 0 1-1.198-.49 7.01 7.01 0 0 1 2.276-1.52 6.7 6.7 0 0 0-.597.932 8.854 8.854 0 0 0-.48 1.079zM3.509 7.5H1.017A6.964 6.964 0 0 1 2.38 3.825c.47.258.995.482 1.565.667A13.4 13.4 0 0 0 3.508 7.5zm1.4-2.741c.808.187 1.681.301 2.591.332V7.5H4.51c.035-.987.176-1.914.399-2.741zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5H7.5v2.409c-.91.03-1.783.145-2.591.332a12.343 12.343 0 0 1-.4-2.741zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696A12.63 12.63 0 0 1 7.5 11.91v3.014c-.67-.204-1.335-.82-1.887-1.855a7.776 7.776 0 0 1-.395-.872zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964a9.083 9.083 0 0 0-1.565.667A6.963 6.963 0 0 1 1.018 8.5h2.49a13.36 13.36 0 0 0 .437 3.008zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909c.81.03 1.577.13 2.282.287-.12.312-.252.604-.395.872-.552 1.035-1.218 1.65-1.887 1.855V11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5h-2.49a13.361 13.361 0 0 0-.437-3.008 9.123 9.123 0 0 0 1.565-.667A6.963 6.963 0 0 1 14.982 7.5zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343c-.705.157-1.473.257-2.282.287V1.077c.67.204 1.335.82 1.887 1.855.143.268.276.56.395.872z"/></svg> udeit.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="business-card">
                        <div class="business-userpic-wrapper">
                            <div class="business-userpic" style="--userpic: url('../images/afb-avatar.jpg');"></div>
                        </div>
                        <div class="business-info-wrapper">
                            <div class="business-info">
                                <p class="business-name">Alan Facundo Biglieri</p>
                                <p class="business-work text-muted">Diseñador</p>
                                <p class="business-cel"><svg width="1.6em" height="1.6em" viewBox="0 0 22 22" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg> 1137680030</p>
                                <p class="business-mail"><svg width="1.6em" height="1.6em" viewBox="0 0 20 20" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/></svg> abiglieri@udeit.com</p>
                                <p class="business-www"><svg width="1.6em" height="1.6em" viewBox="0 0 20 20" class="bi bi-globe2" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539a8.372 8.372 0 0 1-1.198-.49 7.01 7.01 0 0 1 2.276-1.52 6.7 6.7 0 0 0-.597.932 8.854 8.854 0 0 0-.48 1.079zM3.509 7.5H1.017A6.964 6.964 0 0 1 2.38 3.825c.47.258.995.482 1.565.667A13.4 13.4 0 0 0 3.508 7.5zm1.4-2.741c.808.187 1.681.301 2.591.332V7.5H4.51c.035-.987.176-1.914.399-2.741zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5H7.5v2.409c-.91.03-1.783.145-2.591.332a12.343 12.343 0 0 1-.4-2.741zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696A12.63 12.63 0 0 1 7.5 11.91v3.014c-.67-.204-1.335-.82-1.887-1.855a7.776 7.776 0 0 1-.395-.872zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964a9.083 9.083 0 0 0-1.565.667A6.963 6.963 0 0 1 1.018 8.5h2.49a13.36 13.36 0 0 0 .437 3.008zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909c.81.03 1.577.13 2.282.287-.12.312-.252.604-.395.872-.552 1.035-1.218 1.65-1.887 1.855V11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5h-2.49a13.361 13.361 0 0 0-.437-3.008 9.123 9.123 0 0 0 1.565-.667A6.963 6.963 0 0 1 14.982 7.5zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343c-.705.157-1.473.257-2.282.287V1.077c.67.204 1.335.82 1.887 1.855.143.268.276.56.395.872z"/></svg> udeit.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="business-card">
                        <div class="business-userpic-wrapper">
                            <div class="business-userpic" style="--userpic: url('../images/ce-avatar.jpg');"></div>
                        </div>
                        <div class="business-info-wrapper">
                            <div class="business-info">
                                <p class="business-name">Cristian Espíndola</p>
                                <p class="business-work text-muted">Comercial</p>
                                <p class="business-cel"><svg width="1.6em" height="1.6em" viewBox="0 0 22 22" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg> 1158000069</p>
                                <p class="business-mail"><svg width="1.6em" height="1.6em" viewBox="0 0 20 20" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/></svg> cespindola@udeit.com</p>
                                <p class="business-www"><svg width="1.6em" height="1.6em" viewBox="0 0 20 20" class="bi bi-globe2" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539a8.372 8.372 0 0 1-1.198-.49 7.01 7.01 0 0 1 2.276-1.52 6.7 6.7 0 0 0-.597.932 8.854 8.854 0 0 0-.48 1.079zM3.509 7.5H1.017A6.964 6.964 0 0 1 2.38 3.825c.47.258.995.482 1.565.667A13.4 13.4 0 0 0 3.508 7.5zm1.4-2.741c.808.187 1.681.301 2.591.332V7.5H4.51c.035-.987.176-1.914.399-2.741zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5H7.5v2.409c-.91.03-1.783.145-2.591.332a12.343 12.343 0 0 1-.4-2.741zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696A12.63 12.63 0 0 1 7.5 11.91v3.014c-.67-.204-1.335-.82-1.887-1.855a7.776 7.776 0 0 1-.395-.872zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964a9.083 9.083 0 0 0-1.565.667A6.963 6.963 0 0 1 1.018 8.5h2.49a13.36 13.36 0 0 0 .437 3.008zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909c.81.03 1.577.13 2.282.287-.12.312-.252.604-.395.872-.552 1.035-1.218 1.65-1.887 1.855V11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5h-2.49a13.361 13.361 0 0 0-.437-3.008 9.123 9.123 0 0 0 1.565-.667A6.963 6.963 0 0 1 14.982 7.5zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343c-.705.157-1.473.257-2.282.287V1.077c.67.204 1.335.82 1.887 1.855.143.268.276.56.395.872z"/></svg> udeit.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark">
        <div class="container">
            <div class="row" style="min-height: 100px;">
                <div class="col-sm-6 col my-auto copyr">
                    <span class="text-muted">&copy; 2019-2020 Starfleet Company, Inc. un producto de UdeIT.</span>
                </div>
                <div class="col-sm-6 col my-auto redes">
                    <a class="ml-3" href="https://www.facebook.com/117257476778526/"><svg width="35.863mm" height="67.582mm" viewBox="0 0 35.863 67.582" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g transform="translate(119.91 -126.36)"><path d="m-107.43 193.79c-0.84778-0.11858-1.6504-0.32459-1.7836-0.4578-0.1389-0.1389-0.27139-6.3876-0.31065-14.651l-0.0684-14.409-10.319-0.26459v-11.906l10.319-0.26458 0.17367-6.2177c0.14095-5.0462 0.27682-6.6072 0.72111-8.2852 1.7602-6.6477 6.6199-10.464 13.936-10.945 2.4552-0.16128 8.9973 0.31281 10.1 0.73189l0.6139 0.23341-0.144 9.9305-3.7275 0.15409c-4.3472 0.17972-5.7224 0.65417-6.9973 2.4141-1.0883 1.5024-1.3597 3.1941-1.2646 7.8828l0.0832 4.101 5.5486 0.0717c3.0517 0.0394 5.637 0.1601 5.745 0.26815 0.21952 0.21952-1.2543 10.438-1.6388 11.362-0.23877 0.57383-0.36766 0.59106-4.95 0.66146l-4.7048 0.0723-0.0684 14.478c-0.0683 14.46-0.0691 14.478-0.63101 14.779-0.69393 0.37138-8.4765 0.56242-10.632 0.26097z"/></g></svg></a>
                    <a class="ml-3" href="https://www.instagram.com/starfleetcompany?r=nametag"><svg width="60.693mm" height="60.595mm" viewBox="0 0 60.693 60.595" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g transform="translate(92.378 -123.7)"><path d="m-74.801 184.16c-6.4097-0.45088-10.814-2.5016-13.744-6.4-3.3336-4.4347-3.832-7.5267-3.832-23.775 0-16.219 0.5066-19.39 3.7927-23.734 2.3143-3.0592 5.6011-5.0403 9.9305-5.9855 2.3815-0.51988 3.3452-0.55299 16.421-0.56404 14.602-0.0123 15.854 0.0674 19.441 1.2378 4.5115 1.4722 8.361 5.3226 9.898 9.9004 1.1299 3.3653 1.2213 4.8305 1.2102 19.409-0.0099 13.089-0.0425 14.037-0.56403 16.421-1.5432 7.0539-5.9486 11.493-12.901 13-2.1494 0.46588-3.6669 0.52914-14.57 0.60747-6.694 0.0481-13.481-5e-3 -15.081-0.11731zm28.781-5.9124c4.6565-1.1063 7.5354-4.1919 8.4432-9.0494 0.49316-2.6387 0.49316-27.788 0-30.427-0.95022-5.0843-4.122-8.2583-9.1789-9.1854-2.6261-0.48145-27.801-0.48145-30.427 0-5.0569 0.92712-8.2286 4.1011-9.1789 9.1854-0.49316 2.6387-0.49316 27.788 0 30.427 0.46705 2.499 1.3524 4.3473 2.8487 5.947 1.9542 2.0892 3.9598 2.9051 8.7114 3.5437 0.43656 0.0587 6.6873 0.0793 13.891 0.0458 10.971-0.051 13.388-0.13002 14.891-0.48706zm-19.389-9.0636c-4.2619-0.91442-8.4344-4.1486-10.393-8.0556-5.9224-11.816 4.2283-25.057 17.14-22.358 5.8135 1.2152 10.692 6.0932 11.907 11.907 2.3372 11.181-7.4662 20.907-18.654 18.507zm7.6849-6.1161c3.6599-1.7292 5.8088-5.0895 5.8088-9.0832 0-7.3995-7.6114-12.232-14.308-9.0834-2.1606 1.0158-3.8089 2.6643-4.8495 4.85-0.73716 1.5484-0.81877 1.9703-0.81877 4.2333 0 2.1984 0.09287 2.7126 0.7407 4.101 0.84768 1.8168 2.7399 3.8895 4.2864 4.6952 1.9066 0.99332 3.0954 1.2564 5.3037 1.1737 1.7168-0.0643 2.4591-0.23586 3.8365-0.88664zm10.121-22.302c-2.9967-1.8272-1.6712-6.6253 1.8302-6.6253 2.7554 0 4.5512 3.144 3.1286 5.4772-0.99298 1.6285-3.2962 2.1618-4.9588 1.148z"/></g></svg></a>
                </div>
            </div>
        </div>
    </div>

<!-- Modals - Start -->

<div class="modal fade" id="contratar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 0px !important;">

            <div class="modal-header">
                <h5 class="modal-title" >Contratar un Plan</h5>
                <button type="button" class="close" data-dismiss="modal" style="outline: none !important;"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">

                <!-- Form Contratar Plan - Start -->
                <form class="form-new-contract" autocomplete="off">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Razón Social</label>
                            <input type="text" name="contract-razon" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>CUIT</label>
                            <input type="text" name="contract-cuit" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>Calle</label>
                            <input type="text" name="contract-street" class="form-control">
                        </div>
                        <div class="form-group col">
                            <label>Número</label>
                            <input type="text" name="contract-number" class="form-control">
                        </div>
                        <div class="form-group col">
                            <label>Piso</label>
                            <input type="text" name="contract-floor" class="form-control">
                        </div>
                        <div class="form-group col">
                            <label>Dpto</label>
                            <input type="text" name="contract-department" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Código Postal</label>
                            <input type="text" name="contract-cp" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Ciudad</label>
                            <input type="text" name="contract-city" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>País</label>
                            <input type="text" name="contract-country" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Teléfono</label>
                            <input type="text" name="contract-phone" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="text" name="contract-email" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Seleccionar el Tipo de Contrato</label>
                            <select class="form-control" name="contract-type">
                                <?php
                                    if(count($_typeContract) >= 1){
                                        foreach($_typeContract as $v){
                                            echo '<option value=', $v['id_contrato'] ,'>', $v['con_descripcion'], '</option>';
                                        }
                                    }else{
                                        ?><option value="">Nulo</option><?php 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Captcha</label>
                            <input type="text"  name="contract-captcha" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>&nbsp;</label>
                            <img src="" class="captcha" style="border: 1px solid #ced4da; width: 100%; max-height: 38px; height: auto;">
                        </div>
                    </div>
                    <div class="last-form-row form-row">
                        <div class="form-group col-md-8">
                            <div class="form-msg"></div>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn btn-block btn-dark" data-dismiss="modal">Cerrar</button>
                        </div>
                        <div class="form-group col-md-2 mb-0">
                            <button type="submit" class="btn btn-block btn-warning">Enviar</button>
                        </div>
                    </div>
                </form>
                <!-- Form Contratar Plan - End -->

            </div>
            <!--
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning">Enviar</button>
            </div>
            -->
        </div>
    </div>
</div>

<!-- Modals - End -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>
    <script>

        $('form').submit(function(){

            var form = $(this).attr('class');

            $.ajax({
                url : '../scripts/validateForm.php',//'ajax.php', // PHP con las funciones ajax
                type: 'POST',
                dataType: 'json',
                data: 'usersForm=' + form + '&' + $('.' + form).serialize(), // Datos del formulario
                beforeSend: function(){},
                success:  function(data){
                    
                    if(data.status == 0)
                    {

                        setTimeout(function(){

                            $('.form-msg').removeClass('alert-success').addClass('alert-danger').html('Verificar los campos marcados.');

                            $.map(data, function(v, k){

                                if(v == 0)
                                {
                                    $('[name="' + k + '"]').addClass('form-error');
                                }
                                else
                                {
                                    $('[name="' + k + '"]').removeClass('form-error');
                                }

                            });

                        }, 1000);

                        setTimeout(function(){
                            $('.form-msg').removeClass('alert-danger').html('');
                        }, 5000);

                    }
                    else
                    {
                        setTimeout(function(){
                            $('.form-msg').removeClass('alert-danger').addClass('alert-success').html('Datos registrados exitosamente.');
                        }, 1000);

                        setTimeout(function(){
                            $('.form-msg').removeClass('alert-success').html('');
                            $('.reset').click();
                        }, 5000);
                    }

                }
            });

            return false;
        });

        $('#reset').on('click', function(){

            var form = $($(this)[0].form).attr('class');

            $('.' + form).find('input').each(function(){
                $(this).val('');
            });

            $('.' + form).find('textarea').each(function(){
                $(this).val('');
            });

        });

        getCaptcha();
        setInterval(function(){
            getCaptcha();
        }, 15 * 1000);

        function getCaptcha()
        {
            $.get('captcha_v1.php', function(d) {
                $('.captcha').attr('src', d);
            });
        }
    </script>

</body>
</html>