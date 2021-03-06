<?php

class ValidadorModificarContrato{

    private $desc;
    private $precio;
    private $maxUser;
    private $duracionMeses;
    private $activo;
    private $err_desc;
    private $err_precio;
    private $err_maxUser;
    private $err_duracionMeses;
    private $err_activo;

    public function __construct($_contratoBd, $desc, $precio, $maxUser, $duracionMeses, $activo, $conex){

        $this -> cambio_desc = $desc == $_contratoBd -> getCon_descripcion() ? 0 : 1; 
        $this -> cambio_precio = $precio == $_contratoBd -> getCon_precio() ? 0 : 1;
        $this -> cambio_maxUser = $maxUser == $_contratoBd -> getCon_maxUsuarios() ? 0 : 1;
        $this -> cambio_duracionMeses = $duracionMeses == $_contratoBd -> getCon_duracionmeses() ? 0 : 1;

        if($activo != $_contratoBd -> getCon_activo() && $activo == 1){
            $this -> cambio_activo = 1;
        }else{
            $this -> cambio_activo = 0;
        }

        $this -> desc = $desc;
        $this -> precio = $precio;
        $this -> maxUser = $maxUser;
        $this -> duracionMeses = $duracionMeses;
        $this -> activo = $activo;

        $this -> err_desc = $this -> validar_desc($conex, $desc, $_contratoBd -> getCon_descripcion());
        $this -> err_precio = $this -> validar_precio($precio, $_contratoBd -> getCon_precio());
        $this -> err_maxUser = $this -> validar_maxUser($maxUser, $_contratoBd -> getCon_maxUsuarios());
        $this -> err_duracionMeses = $this -> validar_duracionMeses($duracionMeses, $_contratoBd -> getCon_duracionMeses());
        $this -> err_activo = $this -> validar_activo($activo, $_contratoBd -> getCon_activo());
        
    }

    private function var_iniciada($var){
        if(preg_match("/^[\S]+$/", $var)){
            return true;//no hay espacios raros
        }else{
            return false;
        }
    }

    private function validar_desc($con, $desc, $_contratoBd){
        if($desc != $_contratoBd){
            if($this -> var_iniciada($desc)){
                $this -> desc = $desc;
            }else{
                return 0;
            }
            if(strlen($desc) > 50){
                return 0;
            }else if(RepositorioContrato::contrato_existe($con, $desc)){
                return 0;
            }
        }
        return 1;
    }

    private function validar_precio($precio, $_contratoBd){
        if($precio != $_contratoBd){
            if($this -> var_iniciada($precio)){
                $this -> precio = $precio;
            }else{
                return 0;
            }
            if(strlen($precio) > 50){
                return 0;
            }else if(!preg_match("/^[\d]+$/", $precio)){
                return 0;
            }
        }    
        return 1;
    }
    private function validar_maxUser($maxUser, $_contratoBd){
        if($maxUser != $_contratoBd){
            if($this -> var_iniciada($maxUser)){
                $this -> maxUser = $maxUser;
            }else{
                return 0;
            }
            if(strlen($maxUser) > 50){
                return 0;
            }else if(!preg_match("/^[\d]+$/", $maxUser)){
                return 0;
            }
        }   
        return 1;
    }
    private function validar_duracionMeses($duracionMeses, $_contratoBd){
        if($duracionMeses != $_contratoBd){
            if($this -> var_iniciada($duracionMeses)){
                $this -> duracionMeses = $duracionMeses;
            }else{
                return 0;
            }
            if(strlen($duracionMeses) > 50){
                return 0;
            }else if(!preg_match("/^[\d]+$/", $duracionMeses)){
                return 0;
            }
        }
        return 1;
    }
    private function validar_activo($activo, $_contratoBd){
        if($activo != $_contratoBd){
            if($this -> var_iniciada($activo)){
                $this -> activo = $activo;
            }else{
                return 0;
            }
            if(isset($activo) && !empty($activo)){
                return 1;
            }else{
                return 0;
            }
        }
        return 1;
    }

    public function getErrorDesc(){
        return $this -> err_desc;
    }
    public function getErrorPrecio(){
        return $this -> err_precio;
    }
    public function getErrorMaxUser(){
        return $this -> err_maxUser;
    }
    public function getErrorDuracionMeses(){
        return $this -> err_duracionMeses;
    }
    public function getErrorActivo(){
        return $this -> err_activo;
    }
    public function getDesc(){
        return $this -> desc;
    }
    public function getPrecio(){
        return $this -> precio;
    }
    public function getMaxUser(){
        return $this -> maxUser;
    }
    public function getDuracionMeses(){
        return $this -> duracionMeses;
    }
    public function getActivo(){
        return $this -> activo;
    }

    public function registro_valido(){
        if(
        $this -> err_desc === 1 &&
        $this -> err_precio === 1 &&
        $this -> err_maxUser === 1 &&
        $this -> err_duracionMeses === 1 &&
        $this -> err_activo === 1
        ){
            return true;
        }else{
            return false;
        }
    }
    public function existe_cambio(){
        if($this -> cambio_desc === 1 || 
        $this -> cambio_precio === 1 || 
        $this -> cambio_maxUser === 1 ||
        $this -> cambio_duracionMeses === 1 ||
        $this -> cambio_activo === 1
        ){
            return true;
        }else{
            return false;
        }
    }
}