<?php
require_once 'app/config.inc.php';
require_once 'app/Conexion.inc.php';
require_once 'app/ControlSesion.inc.php';
require_once 'app/Redireccion.inc.php';
require_once 'app/RepositorioAdministrador.inc.php';
require_once 'app/ControlCookie.inc.php';

if(ControlCookie::cookie_iniciada_sesion()){
    ControlSesion::iniciar_sesion($_COOKIE['id'],$_COOKIE['usuario']);
}
if(ControlSesion::sesion_iniciada()){ // si el usuario ya inicio sesion lo echamos de aqui
    Conexion::abrir_conexion();
    if(RepositorioAdministrador::verificar_rol(Conexion::obtener_conexion(), $_SESSION['nombre_usuario'])){
        Conexion::cerrar_conexion();
        Redireccion::redirigir(RUTA_ADMINISTRADOR);
    }else{
        Conexion::cerrar_conexion();
        Redireccion::redirigir(RUTA_INICIO);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!--<link rel='shortcut icon' type='image/svg' href="logo.svg">-->
    <title>StarFleet v1.0.13.08.2020</title>
    <link rel="stylesheet" href="<?php echo RUTA_CSS?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo RUTA_CSS?>sf-login.css">
    <link rel="stylesheet" href="<?php echo RUTA_CSS?>sf.css">
</head>
<body>
    <div class="loader"><div class="logo"></div></div>
    <!-- Main - Start -->
    <div class="container-fluid p-0">
        <div class="form bg">
            <div class="form-wrapper bg-dark">

                <!-- Form Login - Start -->
                <form class="form-signin">
                    <div class="display-4 starfleet"><div class="logo"></div></div>
                    <hr>
                    <div class="form-label-group">
                        <div class="error-msg text-danger">Verificar los datos ingresados.</div>
                    </div>
                    <input type="hidden" name="requestForm" value="signin">
                    <div class="form-label-group">
                        <input type="text" name="signinEmail" class="form-control" autocomplete="off" placeholder="Usuario">
                    </div>
                    <div class="form-label-group">
                        <input type="password" name="signinPassword" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="checkbox mb-3 text-muted">
                        <label>
                            <input type="checkbox" name="signinRemember" value="true"> Recordarme
                        </label>
                    </div>
                    <button class="btn btn-lg btn-warning btn-block" type="submit" id="signin">Iniciar sesión</button>             
                    <div class="text-center">
                        <button type="button" class="btn btn-link text-muted" style="font-size: 0.8rem;" id="request-link">Olvide mi contraseña</button>
                    </div>
                    <hr class="m-0">
                    <div class="version text-center text-muted mb-0 mt-2" style="font-size: 0.8rem;">v1.0.13.08.2020</div>
                </form>
                <!-- Form Login - End -->
                <!-- Form Request - Start -->
                <form class="form-request">
                    <div class="display-4 starfleet"><div class="logo"></div></div>
                    <hr>
                    <div class="form-label-group">
                        <div class="error-msg text-danger">Verificar los datos ingresados.</div>
                    </div>
                    <input type="hidden" name="requestForm" value="request">
                    <div class="form-label-group">
                        <input type="text" name="requestEmail" class="form-control" placeholder="Email">
                    </div>
                    <!--Test PIN-->
                    <div class="form-label-group">
                        <input type="text" name="requestPin" readonly class="form-control" placeholder="Pin">
                    </div>
                    <!--Test PIN-->
                    <button class="btn btn-lg btn-warning btn-block" type="submit" id="request">Recuperar cuenta</button>             
                    <div class="text-center">
                        <button type="button" class="btn btn-link text-muted" style="font-size: 0.8rem;" id="signin-link">Iniciar sesión</button>
                    </div>
                    <hr class="m-0">
                    <div class="version text-center text-muted mb-0 mt-2" style="font-size: 0.8rem;">v1.0.03.08.2020</div>
                </form>
                <!-- Form Request - End -->
                <!-- Form Change Password - Start -->
                <form class="form-change">
                    <div class="display-4 starfleet"><div class="logo"></div></div>
                    <hr>
                    <div class="form-label-group">
                        <div class="error-msg text-danger">Verificar los datos ingresados.</div>
                    </div>
                    <input type="hidden" name="requestForm" value="change">
                    <div class="form-label-group">
                        <input type="text" name="changeEmail" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-label-group">
                        <input type="text" name="changePassword" class="form-control" placeholder="Nueva contraseña">
                    </div>
                    <div class="form-label-group">
                        <input type="text" name="changePassword2" class="form-control" placeholder="Repetir contraseña">
                    </div>
                    <button class="btn btn-lg btn-warning btn-block" type="submit" id="change">Cambiar contraseña</button>             
                    <hr class="mb-0">
                    <div class="version text-center text-muted mb-0 mt-2" style="font-size: 0.8rem;">v1.0.03.08.2020</div>
                </form>
                <!-- Form Change Password - End -->

            </div>
        </div>
    </div>
    <!-- Main - End -->
    <!-- Include - Start -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="<?php echo RUTA_JS?>bootstrap.bundle.min.js"></script>
    <script src="<?php echo RUTA_JS?>sf.js"></script>
    <script src="<?php echo RUTA_JS?>sf-loader.js"></script>
    <script>
        $(function(){
            $('#request-link').on('click', function(){
                $('.form-signin').fadeOut('slow', function(){
                    $('.form-request').fadeIn('slow');
                });
            });
            $('#signin-link').on('click', function(){
                $('.form-request').fadeOut('slow', function(){
                    $('.form-signin').fadeIn('slow');
                });
            });

            $('form').submit(function(){

                var form = $(this).attr('class');
                var id   = $(this).find('button[type="submit"]').attr('id');
                var btn  = $('#' + id).html();
              
                $.ajax({
                    url : 'scripts/validateForm.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $('.' + form).serialize(),
                    beforeSend: function(){

                        if(id === 'request')
                        {
                            $('#' + id).html('<div class="loading-mini"></div>');
                        }
                        else
                        {
                            $('#' + id).html('Validando datos...');
                            $('.form-wrapper').prepend('<div class="ajax-icon-bg"><div class="loading"></div></div>');
                        }

                    },
                    success:  function(data){
                        //console.log($('.' + form).serialize());
                        if(id === 'signin' && data.status === 1)
                        {
                            location.reload();
                        }
                        else if(id === 'request' && data.status === 1)
                        {
                            $('.' + form).find('input[name="requestEmail"]').attr('readonly', true);
                            $('.' + form).find('input[name="requestPin"]').attr('readonly', false);
                            checkPin(form);
                        }
                        else if(id === 'change' && data.status === 1)
                        {
                            location.reload()
                        }
                        else
                        {
                            $('#' + id).html(btn);
                            $('.ajax-icon-bg').remove();
                            showError();
                        }
                        
                    },
                });
                
                return false;
            });

            function showError()
            {
                $(".error-msg").fadeIn('fast').delay(3000).queue(function(){
                    $(this).fadeOut('slow').dequeue();
                });
                $(".form-wrapper").addClass("error-animation").delay(300).queue(function(){
                    $(this).removeClass("error-animation").dequeue();
                });
            }

            function checkPin(form)
            {
                setTimeout(function(){
                    if($('.' + form).find('input[name="requestPin"]').val() !== '' && $('.' + form).find('input[name="requestPin"]').val().length === 6)
                    {
                        $.ajax({
                            url : 'scripts/validateForm.php',
                            type: 'POST',
                            dataType: 'json',
                            data: $('.' + form).serialize(),
                            beforeSend: function(){

                                $('.' + form).find('input[name="requestPin"]').attr('readonly', true);

                            },
                            success:  function(data){
                                console.log(data);
                                if(data.status === 1)
                                {
                                    $('.' + form).fadeOut('slow', function(){
                                        $('.form-change').find('input[name="changeEmail"]').val($('.' + form).find('input[name="requestEmail"]').val()).attr('readonly', true);
                                        $('.form-change').fadeIn('slow');
                                    });
                                }
                                else
                                {
                                    $('.' + form).find('input[name="requestPin"]').val('');
                                    $('.' + form).find('input[name="requestPin"]').attr('readonly', false);
                                    checkPin(form);
                                }
                                
                            },
                        });
                    }
                    else
                    {
                        checkPin(form);
                    }
                }, 5000);
            }

        });
    </script>
    <!-- Include - End -->
</body>
</html>