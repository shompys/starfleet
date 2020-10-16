<?php

class ControlCookie{

    public static function iniciar_cookie_sesion($id, $usuario){
        if(session_id() == ''){
            session_start();
        }
        require_once "config.inc.php";
        setcookie('id', $id, time() + 604800,'/');
        setcookie('usuario', $usuario, time() + 604800, '/');
    }
    public static function cerrar_cookie_sesion(){
        if(session_id() == ''){
            session_start();
        }
        if(isset($_COOKIE['id'])){
            setcookie('id', $_COOKIE['id'], time() - 1,'/');
        }
        if(isset($_COOKIE['usuario'])){
            setcookie('usuario', $_COOKIE['usuario'], time() - 1, '/');
        }
        session_destroy();
    }
    public static function cookie_iniciada_sesion(){
        if(session_id() == ''){
            session_start();
        }
        if(isset($_COOKIE['id']) && isset($_COOKIE['usuario'])){
            return true;
        }else{
            return false;
        }

    }

}
