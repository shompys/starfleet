<?php
require_once 'app/Conexion.inc.php';
require_once 'app/ControlSesion.inc.php';
require_once 'app/config.inc.php';
require_once 'app/Redireccion.inc.php';
require_once 'app/RepositorioEmpresa.inc.php';
require_once 'app/RepositorioAdministrador.inc.php';
require_once 'app/RepositorioContrato.inc.php';
require_once 'app/ControlCookie.inc.php';

/*if(ControlCookie::cookie_iniciada()){
    ControlSesion::iniciar_sesion($_COOKIE['id'],$_COOKIE['usuario']);
}*/
if(!ControlSesion::sesion_iniciada()){// si sesion existe saltamos el if este!!
    if(!ControlCookie::cookie_iniciada_sesion()){//sesion no existia ahora miramos si existen cookie con sesion, si existe salta este if
        Redireccion::redirigir(RUTA_LOGIN);
    }
    ControlSesion::iniciar_sesion($_COOKIE['id'],$_COOKIE['usuario']);// y aca le metemos las cookies e iniciamos la session
}
//-------------------------------verificar rol administrador true or false
Conexion::abrir_conexion();
if(!RepositorioAdministrador::verificar_rol(Conexion::obtener_conexion(), $_SESSION['nombre_usuario'])){
    Conexion::cerrar_conexion();
    Redireccion::redirigir(RUTA_INICIO);
}

$_typeContract = RepositorioContrato::obtener_todos_nombres_contratos(Conexion::obtener_conexion());
$_typeEmpresas = RepositorioEmpresa::obtener_nombres_empresas(Conexion::obtener_conexion());
$_empresaCombo = RepositorioEmpresa::empresa_id_razon(Conexion::obtener_conexion());

$link = mysqli_connect(NOMBRE_SERVIDOR, NOMBRE_USUARIO, PASSWORD, NOMBRE_BD);

$query = "SELECT u.id_usuario AS 'UID', u.us_nombre AS 'NOMBRE', u.us_apellido AS 'APELLIDO', u.us_usuario AS 'USUARIO', u.us_dni AS 'DNI', u.us_email AS 'EMAIL'
        FROM usuarios u 
        INNER JOIN empresas e ON u.empresa_id = e.id_empresa";

        $result = mysqli_query($link, $query);
 
        while($row = $result->fetch_assoc()){
            $_usuarios[] = $row;
        }
    
    $query = "SELECT id_contrato AS 'CID', con_precio AS 'PRECIO', con_maxusuarios AS 'MAX USUARIOS', con_duracionmeses AS 'MESES'
    FROM contratos
    ";
    
    $result = mysqli_query($link, $query);

    while($row = $result->fetch_assoc()){

        $_contratos[] = $row;
    }
    
    $query = "SELECT e.id_empresa AS 'EID', e.em_razonsocial AS 'RAZON SOCIAL', e.em_email AS 'EMAIL' 
    FROM empresas e 
    INNER JOIN contratos c ON e.contrato_id = c.id_contrato";
    
    $result = mysqli_query($link, $query);

    while($row = $result->fetch_assoc()){
        
        $_empresas[] = $row;
    }
   
Conexion::cerrar_conexion();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>StarFleet v1.0.05.11.2020</title>
    <link rel="icon" type="image/png" href="/img/favicon.ico">
    <link rel="stylesheet" href="<?php echo RUTA_CSS?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo RUTA_CSS?>sf.css">
</head>
<body>
    <div class="loader"><div class="logo"></div></div>
    <!-- Navbar - Start -->
    <nav class="navbar d-md-none bg-dark">
        <a class="navbar-brand mx-0 display-4" href="#"><div class="logo" style="width:180px; height: 40px!important;"></div></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </button>
    </nav>
    <!-- Navbar - Start -->
    <!-- Main - Start -->
    <div class="container-fluid  px-0 py-0 mx-0 my-0">
        <div class="row px-0 py-0 mx-0 my-0">
            <div class="collapse d-md-block col-md-3 bg-dark" id="sidebar">
                <!-- Sidebar - Start -->
                <div class="profile-sidebar">
                    <div class="display-4 starfleet d-none d-md-block"><div class="logo"></div></div>
                    <hr>
                    <div class="profile-userpic" style="--userpic: url('../img/WIN_20200721_19_07_47_Pro.jpg');"></div>
                    <div class="profile-userinfo">
                        <div class="display-4 text-muted"><b>Alan Facundo Biglieri</b></div>
                        <div class="display-4 text-muted"><b>Administrador</b></div>
                    </div>
                    <hr>
                    <div class="profile-useractions d-flex justify-content-between align-items-center">
                        <div id="mensajes">
                            <span class="icon">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                                </svg>
                            </span>
                            <div class="badge badge-danger badge-pill notification">12</div>
                        </div>
                        <div id="configuracion">
                            <span class="icon">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-gear" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                                <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                                </svg>
                            </span>
                        </div>
                        <div>
                            <!--<a href="scripts/logout.php">-->
                            <a href="logout">
                                <span class="icon">
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-power" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.578 4.437a5 5 0 1 0 4.922.044l.5-.866a6 6 0 1 1-5.908-.053l.486.875z"/>
                                    <path fill-rule="evenodd" d="M7.5 8V1h1v7h-1z"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="profile-usermenu">
                        <ul class="nav flex-column">
                        <li class="nav-item">
                                <div class="nav-link text-muted" id="reportes">
                                    <span class="icon">
                                        <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-card-checklist" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path fill-rule="evenodd" d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </span>
                                    <span>Reportes</span>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-link text-muted" id="usuarios">
                                    <span class="icon">
                                        <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                        </svg>
                                    </span>
                                    <span>Usuarios</span>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-link text-muted" id="contratos">
                                    <span class="icon">
                                        <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmarks" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1H4z"/>
                                        <path fill-rule="evenodd" d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1z"/>
                                        </svg>
                                    </span>
                                    <span>Contratos</span>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-link text-muted" id="empresas">
                                    <span class="icon">
                                        <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                            <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                          </svg>
                                    </span>
                                    <span>Empresas</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="profile-userversion text-muted">v1.0.05.11.2020</div>
                </div>
                <!-- Sidebar - End -->
            </div>
            <div class="col-md-9 d-md-block p-0 bg">
                <!-- Panel - Start -->
                <div class="main-panel">

                    <!-- Mensajes - Start -->
                    <div class="modal-panel-bg" id="panel-mensajes">
                        <div class="modal-panel">
                            
                            <div class="row px-3 py-2">
                                <div class="col-12">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="display-4 mt-1">Mensajes</h5>
                                        <button type="button" class="btn btn-warning btn-sm m-0" id="panel-mensajes-close">Cerrar</button>
                                    </div>
                                    <hr class="mx-0 my-1">

                                    <div class="form-height col-12 mt-3 text-dark">

                                        <div class="alert alert-danger" role="alert" style="border-radius: 0px;">
                                            Sistema de mensajería en desarrollo.
                                        </div>

                                        <table class="table table-sm">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Nombre y Apellido</th>
                                                    <th scope="col">Correo electrónico</th>
                                                    <th scope="col">Teléfono</th>
                                                    <th scope="col">Mensaje</th>
                                                    <th scope="col">Leído</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td>a</td>
                                                    <td>b</td>
                                                    <td>c</td>
                                                    <td>d</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Mensajes - End -->

                    <!-- Configuración - Start -->
                    <div class="modal-panel-bg" id="panel-configuracion">
                        <div class="modal-panel">
                            
                            <div class="row px-3 py-2">
                                <div class="col-12">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="display-4 mt-1">Configuración de Cuenta</h5>
                                        <button type="button" class="btn btn-warning btn-sm m-0" id="panel-configuracion-close">Cerrar</button>
                                    </div>
                                   
                                    <hr class="mx-0 my-1">

                                    <!-- Form Configuración de Cuenta - Start -->
                                    <div class="form-height col-12 mt-3 text-dark">
                                        <div class="alert alert-danger" role="alert" style="border-radius: 0px;">
                                            Sistema de configuración de cuenta en desarrollo.
                                        </div>
                                        <form class="form-config-user" autocomplete="off">
                                            <input type="hidden" name="usersForm" value="form-config-user">
                                            <div class="form-row">
                                                
                                                <div class="form-group col-md-6">

                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                            <label for="imageUpload">
                                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-camera" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M15 12V6a1 1 0 0 0-1-1h-1.172a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 9.173 3H6.828a1 1 0 0 0-.707.293l-.828.828A3 3 0 0 1 3.172 5H2a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                                                    <path fill-rule="evenodd" d="M8 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                                    <path d="M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                                                  </svg>
                                                            </label>
                                                        </div>
                                                        <div class="avatar-preview">
                                                            <div id="imagePreview" style="background-image: url(images/bg2.jpg);"></div>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="form-group col-md-6">

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Usuario</label>
                                                            <input type="text" name="nu-username" class="form-control">
                                                        </div>

                                                    </div>

                                                    <div class="form-row">

                                                        <div class="form-group col-md-12">
                                                            <label>Email</label>
                                                            <input type="text" name="nu-email" class="form-control">
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="last-form-row form-row">
                                                <div class="form-group col-md-8">
                                                    <div class="form-msg"></div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <button type="button" class="btn btn-block btn-dark">Reset</button>
                                                </div>
                                                <div class="form-group col-md-2 mb-0">
                                                    <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Form Configuración de Cuenta - End -->

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Configuración - End -->

                    <!-- Reportes - Start -->
                    <div class="modal-panel-bg" id="panel-reportes">
                        <div class="modal-panel">
                            
                            <div class="row px-3 py-2">
                                <div class="col-12">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="display-4">Reportes</h5>
                                        <ul class="nav nav-tabs d-none d-lg-flex">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#usuarios-reporte">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                                    </svg>   
                                                    Usuarios
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#contratos-reporte">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmarks" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1z"/>
                                                    </svg>
                                                    Contratos
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#empresas-reporte">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                                    <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                                    </svg>
                                                    Empresas
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="nav-item dropdown d-sm-flex d-md-flex d-lg-none d-xl-none">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" data-toggle="tab" href="#usuarios-reporte">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                                    </svg>
                                                    Usuarios
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#contratos-reporte">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmarks" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1z"/>
                                                    </svg>
                                                    Contratos
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#empresas-reporte">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                                    <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                                    </svg>
                                                    Empresas
                                                </a>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning btn-sm m-0" id="panel-reportes-close">Cerrar</button>
                                    </div>
                                   
                                    <hr class="mx-0 my-1">
                                    <div id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade active show" id="usuarios-reporte">

                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-rep-user" autocomplete="off">
                                                    <input type="hidden" name="usersForm" value="form-rep-user">
                                                    <input type="hidden" name="reptype" value="Reporte de Usuarios">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-3">
                                                            <label>Usuario Activo</label>
                                                            <select class="form-control" name="rep-user-active">
                                                                <option value="todos">Todos</option>
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>Empresa</label>
                                                            <select class="form-control" name="rep-user-business">
                                                            <option value="todas">Todas</option>   
                                                            <?php
                                                            
                                                            if(count($_typeEmpresas) >= 1){                                   
                                                                foreach($_typeEmpresas as $v){
                                                                    echo '<option>', $v['em_razonsocial'], '</option>';
                                                                }
                                                            }else{                                    
                                                            ?><option value="">Nulo</option><?php 
                                                            }                                    
                                                            ?>
                                                            
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>&nbsp;</label>
                                                            <button type="button" class="btn btn-block btn-success csv">Descargar CSV</button>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>&nbsp;</label>
                                                            <button type="button" class="btn btn-block btn-danger pdf">Descargar PDF</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                            
                                                <table class="table table-sm table-users">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                        <tr>
                                                            <th scope="col">Uid</th>
                                                            <th scope="col">Nombre</th>
                                                            <th scope="col">Apellido</th>
                                                            <th scope="col">Usuario</th>
                                                            <th scope="col">DNI</th>
                                                            <th scope="col">Correo electrónico</th>
                                                        </tr>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach($_usuarios as $v){

                                                            echo  '<tr>' . '<td>' . $v['UID'] . '</td>' . '<td>' . $v['NOMBRE'] . '</td>' . '<td>' . $v['APELLIDO'] . '</td>' . '<td>' . $v['USUARIO'] . '</td>' . '<td>' . $v['DNI'] . '</td>' . '<td>' . $v['EMAIL'] . '</td>' . '</tr>';
                                                            
                                                        } 
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="contratos-reporte">

                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-rep-contract" autocomplete="off">
                                                    <input type="hidden" name="usersForm" value="form-rep-contract">
                                                    <input type="hidden" name="reptype" value="Reporte de Contratos">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Tipo de Contrato</label>
                                                            
                                                            <select class="form-control" name="rep-contract-type">
                                                            <option value="todos">Todos</option>
                                                            <?php
                                                            if(count($_typeEmpresas) >= 1)
                                                            {                                   
                                                                foreach($_typeContract as $v)
                                                                {
                                                                    echo '<option>' . $v['con_descripcion'] . '</option>';
                                                                }
                                                            }
                                                            else
                                                            {                                    
                                                            ?>
                                                            <option value="">Nulo</option>
                                                            <?php 
                                                            }                                    
                                                            ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>&nbsp;</label>
                                                            <button type="button" class="btn btn-block btn-success csv">Descargar CSV</button>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>&nbsp;</label>
                                                            <button type="button" class="btn btn-block btn-danger pdf">Descargar PDF</button>
                                                        </div>
                                                    </div>
                                                </form>
    
                                                <table class="table table-sm table-contracts">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">CId</th>
                                                            <th scope="col">Precio</th>
                                                            <th scope="col">Max Usuarios</th>
                                                            <th scope="col">Meses</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($_contratos as $v){
                                                                echo '<tr>' . '<td>' . $v['CID'] . '</td>' . '<td>' . $v['PRECIO'] . '</td>' . '<td>' . $v['MAX USUARIOS'] . '</td>' . '<td>' . $v['MESES'] . '</td>' . '</tr>';
                                                            }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="empresas-reporte">

                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-rep-business" autocomplete="off">
                                                    <input type="hidden" name="usersForm" value="form-rep-business">
                                                    <input type="hidden" name="reptype" value="Reporte de Empresas">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-3">
                                                            <label>Empresa Activa</label>
                                                            <select class="form-control" name="rep-business-active">
                                                                <option value="todas">Todas</option>
                                                                <option value="1">Activa</option>
                                                                <option value="0">Inactiva</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>Tipo de Contrato</label>
                                                            <select class="form-control" name="rep-business-contract">
                                                                <option value="todos">Todos</option>
                                                                <?php
                                                                if(count($_typeContract) >= 1){        
                                                                    foreach($_typeContract as $v){
                                                                        echo '<option value="' . $v['id_contrato'] . '">' . $v['con_descripcion'] . '</option>';
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                ?>
                                                                <option value="">Nulo</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>&nbsp;</label>
                                                            <button type="button" class="btn btn-block btn-success csv">Descargar CSV</button>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>&nbsp;</label>
                                                            <button type="button" class="btn btn-block btn-danger pdf">Descargar PDF</button>
                                                        </div>
                                                    </div>
                                                </form>
    
                                                <table class="table table-sm table-business">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">EId</th>
                                                            <th scope="col">Razon Social</th>
                                                            <th scope="col">Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        foreach($_empresas as $v){
                                                        echo '<tr>' . '<td>' . $v['EID'] . '</td>' . '<td>' . $v['RAZON SOCIAL'] . '</td>'  . '<td>' . $v['EMAIL'] . '</td>' .  '</tr>';
                                                        }

                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Reportes - End -->

                    <!-- Usuarios - Start -->
                    <div class="modal-panel-bg" id="panel-usuarios">
                        
                        <div class="modal-panel">
                            <!--<div class="loading"></div>-->
                            <div class="row py-2 m-0">
                                <div class="col-12">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <h5 class="display-4 mb-0">Usuarios</h5>
                                        <ul class="nav nav-tabs d-none d-lg-flex">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#alta-usuario"><svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-person-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/><path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/></svg>    
                                                    Alta
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#baja-usuario"><svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-person-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm2 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/></svg>
                                                    Baja
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#modificacion-usuario">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z"/>
                                                    <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z"/>
                                                    </svg>
                                                    Modificación
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#consulta-usuario">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm6.854.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                    Consulta
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="nav-item dropdown d-sm-flex d-md-flex d-lg-none d-xl-none">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" data-toggle="tab" href="#alta-usuario">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-person-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                                    </svg>    
                                                    Alta
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#baja-usuario">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-person-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm2 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                    Baja
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#modificacion-usuario">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z"/>
                                                    <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z"/>
                                                    </svg>
                                                    Modificación
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#consulta-usuario">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-person-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm6.854.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                    Consulta
                                                </a>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning btn-sm m-0" id="panel-usuarios-close">Cerrar</button>

                                    </div>
                                   
                                    <hr class="mx-0 my-1">

                                    <div id="myTabContent" class="tab-content">
                                        
                                        <div class="tab-pane fade active show" id="alta-usuario">
                                            <!-- Form Alta Usuarios - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-new-user" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Usuario</label>
                                                            <input type="text" name="nu-username" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="nu-email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Contraseña</label>
                                                            <input type="password" name="nu-password" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Repetir contraseña</label>
                                                            <input type="password" name="nu-password2" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Nombre(s)</label>
                                                            <input type="text" name="nu-name" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Apellido(s)</label>
                                                            <input type="text" name="nu-lastname" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Sexo</label>
                                                            <select class="form-control" name="nu-sex">
                                                                <option value="M">Masculino</option>
                                                                <option value="F">Femenino</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>DNI</label>
                                                            <input type="text" name="nu-dni" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Fecha de nacimiento</label>
                                                            <input type="text" name="nu-birth" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="nu-street" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="nu-number" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="nu-floor" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="nu-department" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="nu-city" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>País</label>
                                                            <input type="text" name="nu-country" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Empresa</label>
                                                            <!--<input type="text" name="nu-companyid" class="form-control">-->
                                                            <select class="form-control" name="nu-companyid">
                                                                <option>Seleccionar</option>   
                                                                <?php
                                                                if(count($_empresaCombo) >= 1)
                                                                {                                   
                                                                    foreach($_empresaCombo as $v)
                                                                    {
                                                                        echo '<option value="' . $v['id_empresa'] . '" data-company="' . $v['em_razonsocial'] . '">' . $v['id_empresa'] . '</option>';
                                                                        //echo '<option value="' . $v['em_razonsocial'] . '">' . $v['id_empresa'] . '</option>';
                                                                    }
                                                                }                                   
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Empresa</label>
                                                            <input type="text" name="nu-company" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Usuario Activo</label>
                                                            <select class="form-control" name="nu-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Permisos</label>
                                                            <div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="nu-perm-1" value="1">
                                                                    <label class="form-check-label" >Opción 1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="nu-perm-2" value="1">
                                                                    <label class="form-check-label" >Opción 2</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="nu-perm-3" value="1">
                                                                    <label class="form-check-label" >Opción 3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="nu-perm-4" value="1">
                                                                    <label class="form-check-label" >Opción 4</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="nu-perm-5" value="1">
                                                                    <label class="form-check-label" >Opción 5</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="nu-perm-6" value="1">
                                                                    <label class="form-check-label" >Opción 6</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Alta Usuarios - End -->
                                        </div>

                                        <div class="tab-pane fade" id="baja-usuario">
                                            <!-- Form Baja Usuarios - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-del-user" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar DNI</label>
                                                            <input type="text" name="dni-check" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Usuario</label>
                                                            <input type="text" name="du-username" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="du-email" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Contraseña</label>
                                                            <input type="password" name="du-password" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Repetir contraseña</label>
                                                            <input type="password" name="du-password2" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Nombre(s)</label>
                                                            <input type="text" name="du-name" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Apellido(s)</label>
                                                            <input type="text" name="du-lastname" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Sexo</label>
                                                            <select class="form-control" name="du-sex" disabled>
                                                                <option value="1">Masculino</option>
                                                                <option value="0">Femenino</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>DNI</label>
                                                            <input type="text" name="du-dni" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Fecha de nacimiento</label>
                                                            <input type="text" name="du-birth" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="du-street" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="du-number" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="du-floor" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="du-department" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="du-city" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>País</label>
                                                            <input type="text" name="du-country" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Empresa</label>
                                                            <input type="text" name="du-companyid" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Empresa</label>
                                                            <input type="text" name="du-company" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Usuario Activo</label>
                                                            <select class="form-control" name="du-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Permisos</label>
                                                            <div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="du-perm-1" disabled>
                                                                    <label class="form-check-label" >Opción 1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="du-perm-2" disabled>
                                                                    <label class="form-check-label" >Opción 2</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="du-perm-3" disabled>
                                                                    <label class="form-check-label" >Opción 3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="du-perm-4" disabled>
                                                                    <label class="form-check-label" >Opción 4</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="du-perm-5" disabled>
                                                                    <label class="form-check-label" >Opción 5</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="du-perm-6" disabled>
                                                                    <label class="form-check-label" >Opción 6</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Baja Usuarios - End -->
                                        </div>

                                        <div class="tab-pane fade" id="modificacion-usuario">
                                            <!-- Form Modificación Usuarios - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-mod-user" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar DNI</label>
                                                            <input type="text" name="dni-check" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Usuario</label>
                                                            <input type="text" name="mu-username" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="mu-email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Contraseña</label>
                                                            <input type="password" name="mu-password" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Repetir contraseña</label>
                                                            <input type="password" name="mu-password2" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Nombre(s)</label>
                                                            <input type="text" name="mu-name" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Apellido(s)</label>
                                                            <input type="text" name="mu-lastname" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Sexo</label>
                                                            <select class="form-control" name="mu-sex">
                                                                <option value="1">Masculino</option>
                                                                <option value="0">Femenino</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>DNI</label>
                                                            <input type="text" name="mu-dni" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Fecha de nacimiento</label>
                                                            <input type="text" name="mu-birth" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="mu-street" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="mu-number" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="mu-floor" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="mu-department" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="mu-city" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>País</label>
                                                            <input type="text" name="mu-country" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Empresa</label>
                                                            <!--<input type="text" name="mu-companyid" class="form-control">-->
                                                            <select class="form-control" name="mu-companyid">
                                                                <option>Seleccionar</option>   
                                                                <?php
                                                                if(count($_empresaCombo) >= 1)
                                                                {                                   
                                                                    foreach($_empresaCombo as $v)
                                                                    {
                                                                        echo '<option value="' . $v['id_empresa'] . '" data-company="' . $v['em_razonsocial'] . '">' . $v['id_empresa'] . '</option>';
                                                                    }
                                                                }                                   
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Empresa</label>
                                                            <input type="text" name="mu-company" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Usuario Activo</label>
                                                            <select class="form-control" name="mu-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Permisos</label>
                                                            <div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="mu-perm-1" value="1">
                                                                    <label class="form-check-label" >Opción 1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="mu-perm-2" value="1">
                                                                    <label class="form-check-label" >Opción 2</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="mu-perm-3" value="1">
                                                                    <label class="form-check-label" >Opción 3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="mu-perm-4" value="1">
                                                                    <label class="form-check-label" >Opción 4</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="mu-perm-5" value="1">
                                                                    <label class="form-check-label" >Opción 5</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="mu-perm-6" value="1">
                                                                    <label class="form-check-label" >Opción 6</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Modificación Usuarios - End -->
                                        </div>

                                        <div class="tab-pane fade" id="consulta-usuario">
                                            <!-- Form Consulta Usuarios - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-check-user" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar DNI</label>
                                                            <input type="text" name="dni-check" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Usuario</label>
                                                            <input type="text" name="cu-username" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="cu-email" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Contraseña</label>
                                                            <input type="password" name="cu-password" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Repetir contraseña</label>
                                                            <input type="password" name="cu-password2" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Nombre(s)</label>
                                                            <input type="text" name="cu-name" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Apellido(s)</label>
                                                            <input type="text" name="cu-lastname" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Sexo</label>
                                                            <!--<input type="text" name="cu-sex" class="form-control" disabled>-->
                                                            <select class="form-control" name="cu-sex" disabled>
                                                                <option value="1">Masculino</option>
                                                                <option value="0">Femenino</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>DNI</label>
                                                            <input type="text" name="cu-dni" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Fecha de nacimiento</label>
                                                            <input type="text" name="cu-birth" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="cu-street" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="cu-number" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="cu-floor" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="cu-department" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="cu-city" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>País</label>
                                                            <input type="text" name="cu-country" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Empresa</label>
                                                            <input type="text" name="cu-companyid" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Empresa</label>
                                                            <input type="text" name="cu-company" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Usuario Activo</label>
                                                            <select class="form-control" name="cu-active" disabled>
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Permisos</label>
                                                            <div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"  name="cu-perm-1" disabled>
                                                                    <label class="form-check-label" >Opción 1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"  name="cu-perm-2" disabled>
                                                                    <label class="form-check-label" >Opción 2</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"  name="cu-perm-3" disabled>
                                                                    <label class="form-check-label" >Opción 3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"  name="cu-perm-4" disabled>
                                                                    <label class="form-check-label" >Opción 4</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"  name="cu-perm-5" disabled>
                                                                    <label class="form-check-label" >Opción 5</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"  name="cu-perm-6" disabled>
                                                                    <label class="form-check-label" >Opción 6</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Consulta Usuarios - End -->
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Usuarios - End -->

                    <!-- Empresas - Start -->
                    <div class="modal-panel-bg" id="panel-empresas">
                        <div class="modal-panel">
                            
                            <div class="row px-3 py-2">
                                <div class="col-12">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="display-4">Empresas</h5>
                                        <ul class="nav nav-tabs d-none d-lg-flex">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#alta-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-file-earmark-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                    <path fill-rule="evenodd" d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                                                    </svg>
                                                    Alta
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#baja-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-file-earmark-minus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                    <path fill-rule="evenodd" d="M5.5 9a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                    Baja
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#modificacion-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z"/>
                                                    <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z"/>
                                                    </svg>
                                                    Modificación
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#consulta-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-file-earmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                    <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                    Consulta
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="nav-item dropdown d-sm-flex d-md-flex d-lg-none d-xl-none">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" data-toggle="tab" href="#alta-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-file-earmark-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                    <path fill-rule="evenodd" d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                                                    </svg>
                                                    Alta
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#baja-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-file-earmark-minus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                    <path fill-rule="evenodd" d="M5.5 9a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                    Baja
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#modificacion-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z"/>
                                                    <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z"/>
                                                    </svg>
                                                    Modificación
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#consulta-empresa">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-file-earmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                    <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                    Consulta
                                                </a>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning btn-sm m-0" id="panel-empresas-close">Cerrar</button>
                                    </div>
                                   
                                    <hr class="mx-0 my-1">
                                    <div id="myTabContent" class="tab-content">

                                        <div class="tab-pane fade active show" id="alta-empresa">
                                            <!-- Form Alta Empresa - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-new-empresa" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Razón Social</label>
                                                            <input type="text" name="ne-razon" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>CUIT</label>
                                                            <input type="text" name="ne-cuit" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="ne-street" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="ne-number" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="ne-floor" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="ne-department" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Postal</label>
                                                            <input type="text" name="ne-cp" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="ne-city" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>País</label>
                                                            <input type="text" name="ne-country" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Teléfono</label>
                                                            <input type="text" name="ne-phone" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="ne-email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Tipo de Contrato</label>
                                                            <select class="form-control" name="ne-contract">
                                                                <option value="1">Básico</option>
                                                                <option value="1">Pro</option>
                                                                <option value="1">Premium</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Empresa Activa</label>
                                                            <select class="form-control" name="ne-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Alta Empresa - End -->
                                        </div>

                                        <div class="tab-pane fade" id="baja-empresa">
                                            <!-- Form Baja Empresa - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-del-empresa" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar Id Empresa</label>
                                                            <input type="text" name="empresa-check" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Razón Social</label>
                                                            <input type="text" name="de-razon" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>CUIT</label>
                                                            <input type="text" name="de-cuit" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="de-street" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="de-number" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="de-floor" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="de-department" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Postal</label>
                                                            <input type="text" name="de-cp" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="de-city" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>País</label>
                                                            <input type="text" name="de-country" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Teléfono</label>
                                                            <input type="text" name="de-phone" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="de-email" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Tipo de Contrato</label>
                                                            <select class="form-control" name="de-contract" disabled>
                                                                <option value="1">Básico</option>
                                                                <option value="1">Pro</option>
                                                                <option value="1">Premium</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Empresa Activa</label>
                                                            <select class="form-control" name="de-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Baja Empresa - End -->
                                        </div>

                                        <div class="tab-pane fade" id="modificacion-empresa">
                                            <!-- Form Modificación Empresa - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-mod-empresa" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar Id Empresa</label>
                                                            <input type="text" name="empresa-check" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Razón Social</label>
                                                            <input type="text" name="me-razon" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>CUIT</label>
                                                            <input type="text" name="me-cuit" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="me-street" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="me-number" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="me-floor" class="form-control">
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="me-department" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Postal</label>
                                                            <input type="text" name="me-cp" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="me-city" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>País</label>
                                                            <input type="text" name="me-country" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Teléfono</label>
                                                            <input type="text" name="me-phone" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="me-email" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Tipo de Contrato</label>
                                                            <select class="form-control" name="me-contract">
                                                                <option value="1">Básico</option>
                                                                <option value="1">Pro</option>
                                                                <option value="1">Premium</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Empresa Activa</label>
                                                            <select class="form-control" name="me-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Modificación Empresa - End -->
                                        </div>

                                        <div class="tab-pane fade" id="consulta-empresa">
                                            <!-- Form Consulta Empresa - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-check-empresa" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar Id Empresa</label>
                                                            <input type="text" name="empresa-check" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Razón Social</label>
                                                            <input type="text" name="ce-razon" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>CUIT</label>
                                                            <input type="text" name="ce-cuit" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Calle</label>
                                                            <input type="text" name="ce-street" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Número</label>
                                                            <input type="text" name="ce-number" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Piso</label>
                                                            <input type="text" name="ce-floor" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>Dpto</label>
                                                            <input type="text" name="ce-department" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Código Postal</label>
                                                            <input type="text" name="ce-cp" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Ciudad</label>
                                                            <input type="text" name="ce-city" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>País</label>
                                                            <input type="text" name="ce-country" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Teléfono</label>
                                                            <input type="text" name="ce-phone" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="text" name="ce-email" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Tipo de Contrato</label>
                                                            <select class="form-control" name="ce-contract" disabled>
                                                                <option value="1">Básico</option>
                                                                <option value="1">Pro</option>
                                                                <option value="1">Premium</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Empresa Activa</label>
                                                            <select class="form-control" name="ce-active" disabled>
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Consulta Empresa - End -->
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Empresas - End -->

                    <!-- Contratos - Start -->
                    <div class="modal-panel-bg" id="panel-contratos">
                        <div class="modal-panel">
                            
                            <div class="row px-3 py-2">
                                <div class="col-12">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="display-4">Contratos</h5>
                                        <ul class="nav nav-tabs d-none d-lg-flex">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#alta-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmark-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z"/>
                                                    </svg>   
                                                    Alta
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#baja-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmark-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M5.5 6.5A.5.5 0 0 1 6 6h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                    Baja
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#modificacion-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z"/>
                                                    <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z"/>
                                                    </svg>
                                                    Modificación
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#consulta-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                    Consulta
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="nav-item dropdown d-sm-flex d-md-flex d-lg-none d-xl-none">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" data-toggle="tab" href="#alta-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmark-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z"/>
                                                    </svg>    
                                                    Alta
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#baja-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmark-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M5.5 6.5A.5.5 0 0 1 6 6h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                    Baja
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#modificacion-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z"/>
                                                    <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z"/>
                                                    </svg>
                                                    Modificación
                                                </a>
                                                <a class="dropdown-item" data-toggle="tab" href="#consulta-contrato">
                                                    <svg width="1.4em" height="1.4em" viewBox="0 0 18 18" class="bi bi-bookmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                                    <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    </svg>
                                                    Consulta
                                                </a>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning btn-sm m-0" id="panel-contratos-close">Cerrar</button>
                                    </div>
                                   
                                    <hr class="mx-0 my-1">
                                    <div id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade active show" id="alta-contrato">

                                            <!-- Form Alta Contrato - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-new-contracts" autocomplete="off">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-8">
                                                            <label>Descripción</label>
                                                            <input type="text" name="nc-desc" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Precio</label>
                                                            <input type="text" name="nc-price" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Duración en Meses</label>
                                                            <input type="text" name="nc-life" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Máxima de Usuarios</label>
                                                            <input type="text" name="nc-max-users" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Contrato Activo</label>
                                                            <select class="form-control" name="nc-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Alta Contrato - End -->

                                        </div>
                                        <div class="tab-pane fade" id="baja-contrato">

                                            <!-- Form Baja Contrato - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-del-contract" autocomplete="off">

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar Id Contrato</label>
                                                            <input type="text" name="contract-check" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-8">
                                                            <label>Descripción</label>
                                                            <input type="text" name="dc-desc" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Precio</label>
                                                            <input type="text" name="dc-price" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Duración en Meses</label>
                                                            <input type="text" name="dc-life" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Máxima de Usuarios</label>
                                                            <input type="text" name="dc-max-users" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Contrato Activo</label>
                                                            <select class="form-control" name="dc-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Baja Contrato - End -->

                                        </div>
                                        <div class="tab-pane fade" id="modificacion-contrato">

                                            <!-- Form Modificación Contrato - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-mod-contract" autocomplete="off">

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar Id Contrato</label>
                                                            <input type="text" name="contract-check" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-8">
                                                            <label>Descripción</label>
                                                            <input type="text" name="mc-desc" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Precio</label>
                                                            <input type="text" name="mc-price" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Duración en Meses</label>
                                                            <input type="text" name="mc-life" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Máxima de Usuarios</label>
                                                            <input type="text" name="mc-max-users" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Contrato Activo</label>
                                                            <select class="form-control" name="mc-active">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="last-form-row form-row">
                                                        <div class="form-group col-md-8">
                                                            <div class="form-msg"></div>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <button type="button" class="btn btn-block btn-dark reset">Reset</button>
                                                        </div>
                                                        <div class="form-group col-md-2 mb-0">
                                                            <button type="submit" class="btn btn-block btn-warning">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Modificación Contrato - End -->

                                        </div>
                                        <div class="tab-pane fade" id="consulta-contrato">

                                            <!-- Form Consulta Contrato - Start -->
                                            <div class="form-height col-12 mt-3 text-dark">
                                                <form class="form-check-contract" autocomplete="off">

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Ingresar Id Contrato</label>
                                                            <input type="text" name="contract-check" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-8">
                                                            <label>Descripción</label>
                                                            <input type="text" name="cc-desc" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Precio</label>
                                                            <input type="text" name="cc-price" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Duración en Meses</label>
                                                            <input type="text" name="cc-life" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Máxima de Usuarios</label>
                                                            <input type="text" name="cc-max-users" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Contrato Activo</label>
                                                            <select class="form-control" name="cc-active" disabled>
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Form Consulta Contrato - End -->

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Contratos - End -->
                    
                </div>
                <!-- Panel - End -->
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

            $('form').submit(function(){

                var form = $(this).attr('class');

                if($('.' + form).find('[name="dni-check"]').val() !== '')
                {
                    $('.' + form).find('[name="dni-check"]').val('');
                }

                if($('.' + form).find('[name="empresa-check"]').val() !== '')
                {
                    $('.' + form).find('[name="empresa-check"]').val('');
                }
                
                if($('.' + form).find('[name="contract-check"]').val() !== '')
                {
                    $('.' + form).find('[name="contract-check"]').val('');
                }

                $.ajax({
                    url : 'scripts/validateForm.php',
                    type: 'POST',
                    dataType: 'json',
                    data: 'usersForm=' + form + '&' + $('.' + form).serialize(),
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

            $('[name="dni-check"]').on('keyup', function(e){

                var form = $($(this)[0].form).attr('class');

                $.ajax({
                    url : 'scripts/validateForm.php',
                    type: 'POST',
                    dataType: 'json',
                    data: 'usersForm=' + form + '&' + $(this).serialize(),
                    success: function(data){
                        
                        if(data.status == 1)
                        {
                            $.map(data, function(v, k){

                                $('.' + data.form).find('input[type="checkbox"]').each(function(){
                                    if($(this).prop('name') == k)
                                    {
                                        $('[name="' + k + '"]').prop('checked', (v == 1 ? true : false));
                                    }
                                });

                                $('.' + data.form).find('select').each(function(){
                                    if($(this).prop('name') == k)
                                    {
                                        $('select[name="' + k + '"]').find('option[value="' + v + '"]').prop('selected', 'selected');
                                    }
                                });

                                $('[name="' + k + '"]').val(v);

                            });
                        }
                        else
                        {
                            $.map(data, function(v, k){
                                $('[name="' + k + '"]').val(v);
                            }); 
                        }

                    }
                });

                return false;
            });

            $('[name="empresa-check"]').on('keyup', function(e){

                var form = $($(this)[0].form).attr('class');

                $.ajax({
                    url : 'scripts/validateForm.php',
                    type: 'POST',
                    dataType: 'json',
                    data: 'usersForm=' + form + '&' + $(this).serialize(),
                    success: function(data){
                        
                        if(data.status == 1)
                        {
                            $.map(data, function(v, k){

                                $('.' + data.form).find('input[type="checkbox"]').each(function(){
                                    if($(this).prop('name') == k)
                                    {
                                        $('[name="' + k + '"]').prop('checked', (v == 1 ? true : false));
                                    }
                                });

                                $('.' + data.form).find('select').each(function(){
                                    if($(this).prop('name') == k)
                                    {
                                        $('select[name="' + k + '"]').find('option[value="' + v + '"]').prop('selected', 'selected');
                                    }
                                });

                                $('[name="' + k + '"]').val(v);

                            });
                        }
                        else
                        {
                            $.map(data, function(v, k){
                                $('[name="' + k + '"]').val(v);
                            }); 
                        }

                    }
                });

                return false;
            });

            $('[name="contract-check"]').on('keyup', function(e){

                var form = $($(this)[0].form).attr('class');

                $.ajax({
                    url : 'scripts/validateForm.php',
                    type: 'POST',
                    dataType: 'json',
                    data: 'usersForm=' + form + '&' + $(this).serialize(),
                    success: function(data){
                        
                        if(data.status == 1)
                        {
                            $.map(data, function(v, k){

                                $('.' + data.form).find('input[type="checkbox"]').each(function(){
                                    if($(this).prop('name') == k)
                                    {
                                        $('[name="' + k + '"]').prop('checked', (v == 1 ? true : false));
                                    }
                                });

                                $('.' + data.form).find('select').each(function(){
                                    if($(this).prop('name') == k)
                                    {
                                        $('select[name="' + k + '"]').find('option[value="' + v + '"]').prop('selected', 'selected');
                                    }
                                });

                                $('[name="' + k + '"]').val(v);

                            });
                        }
                        else
                        {
                            $.map(data, function(v, k){
                                $('[name="' + k + '"]').val(v);
                            }); 
                        }

                    }
                });

                return false;
            });

            $('.reset').on('click', function(){

                var form = $($(this)[0].form).attr('class');

                $('.' + form).find('input').each(function(){

                    if($(this).attr('type') == 'checkbox')
                    {
                        $(this).prop('checked', false);
                    }
                    else
                    {
                        $(this).val('');
                    }
                });

            });

            $('.csv').on('click', function(){
                var form = $($(this)[0].form).attr('class');
                var args = '';

                $('.' + form).find('select').each(function(){

                    var name = $(this).attr('name');
                    args += (name + '=' + $('[name="' + name + '"]').val() + '&');

                });

                window.location.href = 'reporteador/reporte.php?gen=CSV&' + args;
                return false;
            });

            $('.pdf').on('click', function(){
                var form = $($(this)[0].form).attr('class');
                var args = '';

                var reptype = 'reptype=' + $('.' + form).find('[name="reptype"]').val() + '&';
                args += reptype;

                $('.' + form).find('select').each(function(){

                    var name = $(this).attr('name');
                    args += (name + '=' + $('[name="' + name + '"]').val() + '&');

                });

                window.location.href = 'reporteador/reporte.php?gen=PDF&' + args;
                return false;
            });

            $('.form-rep-user').on('change', function(){

                $.ajax({
                    url : 'reporteador/reporte2.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $('.table-users tbody').empty();
                    },
                    success: function(data){

                        if(data.length > 0)
                        {
                            $.each(data, function(i, d){
                                $('.table-users').append('<tr><td>' + d.UID + '</td><td>' + d.NOMBRE + '</td><td>' + d.APELLIDO + '</td><td>' + d.USUARIO + '</td><td>' + d.DNI + '</td><td>' + d.EMAIL + '</td></tr>');
                            });
                        }
                        else
                        {
                            $('.table-users').append('<tr><td colspan="6" style="text-align: center;">Sin resultados</td></tr>');

                        }

                    }
                });

                return false;

            });

            $('.form-rep-contract').on('change', function(){

                $.ajax({
                    url : 'reporteador/reporte2.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $('.table-contracts tbody').empty();
                    },
                    success: function(data){

                        if(data.length > 0)
                        {
                            $.each(data, function(i, d){
                                $('.table-contracts').append('<tr><td>' + d.CID + '</td><td>' + d.PRECIO + '</td><td>' + d.MAXUSUARIOS + '</td><td>' + d.MESES + '</td></tr>');
                            });
                        }
                        else
                        {
                            $('.table-contracts').append('<tr><td colspan="6" style="text-align: center;">Sin resultados</td></tr>');

                        }

                    }
                });

                return false;

            });

            $('.form-rep-business').on('change', function(){

                $.ajax({
                    url : 'reporteador/reporte2.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $('.table-business tbody').empty();
                    },
                    success: function(data){

                        if(data.length > 0)
                        {
                            $.each(data, function(i, d){
                                $('.table-business').append('<tr><td>' + d.EID + '</td><td>' + d.RAZONSOCIAL + '</td><td>' + d.EMAIL + '</td></tr>');
                            });
                        }
                        else
                        {
                            $('.table-business').append('<tr><td colspan="6" style="text-align: center;">Sin resultados</td></tr>');

                        }

                    }
                });

                return false;

            });
            
            $('[name="nu-companyid"]').on('change', function(){

                if($(this).val() !== 'Seleccionar')
                {
                    var company = $('[name="nu-companyid"]').find('option[value="' + $(this).val() + '"]').data().company;
                    $('[name="nu-company"]').val(company);
                }
                else
                {
                    $('[name="nu-company"]').val('');
                }
                return false;

            });

            $('[name="mu-companyid"]').on('change', function(){

                if($(this).val() !== 'Seleccionar')
                {
                    var company = $('[name="mu-companyid"]').find('option[value="' + $(this).val() + '"]').data().company;
                    $('[name="mu-company"]').val(company);
                }
                else
                {
                    $('[name="mu-company"]').val('');
                }
                return false;
                
            });

        });    
    </script>
    <!-- Include - End -->
</body>
</html>