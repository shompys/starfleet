<?php
include_once '../app/ControlSesion.inc.php';
include_once '../app/ControlCookie.inc.php';
include_once '../app/Redireccion.inc.php';
include_once '../app/config.inc.php';

ControlCookie::cerrar_cookie_sesion();
ControlSesion::cerrar_sesion();
header('refresh: 0;' . RUTA_ADMINISTRADOR);