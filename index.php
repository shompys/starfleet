<?php //el gran enrutador!!!!!! esto sirve para la redirecciones de todo
session_start();
//en el servidor:
//$ruta = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];  
//local:
$ruta = $_SERVER['REQUEST_URI'];

$partes_ruta = explode("/", $ruta); //con explore rompo y armo un array con las partes de la ruta
$partes_ruta = array_filter($partes_ruta);
$partes_ruta = array_slice($partes_ruta, 0);

$ruta_elegida = 'vistas/404.php';

//var_dump($partes_ruta);

if(count($partes_ruta) == 1){
    $ruta_elegida= 'vistas/login.php';
}
if(count($partes_ruta) == 2){
        
    switch($partes_ruta[1]){
        case 'login':
            $ruta_elegida = 'vistas/login.php';
        break;
        case 'inicio':
            $ruta_elegida = 'vistas/inicio.php';
        break;
        case 'recuperarclave':
            $ruta_elegida = 'vistas/recuperar-clave.php';
        break;
        case 'enviar-url':
            $ruta_elegida = 'vistas/enviar-url.php';
        break;
        case 'actualizacion-clave-incorrecto':
            $ruta_elegida = 'vistas/actualizacion-clave-incorrecto.php';
        break;
        case 'administrador':
            $ruta_elegida = 'vistas/administrador.php';
        break;
    }

}
if(count($partes_ruta) == 3 ){ // sitios que necesito enviarle algo el metodo get

    switch($partes_ruta[1]){
        case 'recibir-url':
            $url_personal = $partes_ruta[2];// este es el parametro que enviamos
            $ruta_elegida = 'vistas/recibir-url.php';
        break;
        case 'actualizacion-clave-correcto':
            $usuario = $partes_ruta[2];
            $ruta_elegida = 'vistas/actualizacion-clave-correcto.php';
        break;
        case 'editar-perfil':
            $usuario= $partes_ruta[2];
            $ruta_elegida = 'vistas/editar-perfil.php';
        break;
        case 'administrador':
            $usuario = $partes_ruta[2];
            $ruta_elegida = 'vistas/administrador.php';
        break;
        case 'editar-perfil-administrador':
            $usuario= $partes_ruta[2];
            $ruta_elegida= 'vistas/editar-perfil-administrador.php';
        break;
        case 'abm-administrador':
            $administrador = $partes_ruta[2];
            $ruta_elegida = 'vistas/abm-administrador.php';
        break;
    }
}

require_once $ruta_elegida;


