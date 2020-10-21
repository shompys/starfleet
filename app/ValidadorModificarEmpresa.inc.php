<?php

class ValidadorModificarEmpresa{

    private $razonsocial;
    private $cuit;
    private $calle;
    private $altura;
    private $piso;
    private $dpto;
    private $ciudad;
    private $pais;
    private $cp;
    private $tel;
    private $email;
    private $activo;
    private $contrato_id;

    private $error_razonsocial;
    private $error_cuit;
    private $error_calle;
    private $error_altura;
    private $error_piso;
    private $error_dpto;
    private $error_ciudad;
    private $error_pais;
    private $error_cp;
    private $error_tel;
    private $error_email;
    private $error_activo;
    private $error_contrato_id;

    private $cambio_razonsocial;
    private $cambio_cuit;
    private $cambio_calle;
    private $cambio_altura;
    private $cambio_piso;
    private $cambio_dpto;
    private $cambio_ciudad;
    private $cambio_pais;
    private $cambio_cp;
    private $cambio_tel;
    private $cambio_email;
    private $cambio_activo;
    private $cambio_contrato_id;

    public function __construct($_empresaBd, $conexion, $razonsocial, $cuit, $calle, $altura, $piso, $dpto, $ciudad, $pais, $cp, $tel, $email, $activo, $contrato_id){

        $this -> razonsocial = $razonsocial;
        $this -> cuit = $cuit;
        $this -> calle = $calle;
        $this -> altura = $altura;
        $this -> piso = $piso;
        $this -> dpto = $dpto;
        $this -> ciudad = $ciudad;
        $this -> pais = $pais;
        $this -> cp = $cp;
        $this -> tel = $tel;
        $this -> email = $email;
        $this -> activo = $activo;
        $this -> contrato_id = $contrato_id;

        $this -> cambio_razonsocial = $razonsocial == $_empresaBd -> getEm_razonsocial() ? 0 : 1;
        $this -> cambio_cuit = $cuit == $_empresaBd -> getEm_cuit() ? 0 : 1;
        $this -> cambio_calle = $calle == $_empresaBd -> getEm_calle() ? 0 : 1;
        $this -> cambio_altura = $altura == $_empresaBd -> getEm_altura() ? 0 : 1;
        $this -> cambio_piso = $piso == $_empresaBd -> getEm_piso() ? 0 : 1;
        $this -> cambio_dpto = $dpto == $_empresaBd -> getEm_dpto() ? 0 : 1;
        $this -> cambio_ciudad = $ciudad == $_empresaBd -> getEm_ciudad() ? 0 : 1; 
        $this -> cambio_pais = $pais == $_empresaBd -> getEm_pais() ? 0 : 1;
        $this -> cambio_cp = $cp == $_empresaBd -> getEm_cp() ? 0 : 1;
        $this -> cambio_tel = $tel == $_empresaBd -> getEm_tel() ? 0 : 1;
        $this -> cambio_email = $email == $_empresaBd -> getEm_email() ? 0 : 1;
        $this -> cambio_contrato_id = $contrato_id == $_empresaBd -> getContrato_id() ? 0 : 1;

        if($activo != $_empresaBd -> getEm_activo() && $activo == 1){
            $this -> cambio_activo = 1;
        }else{
            $this -> cambio_activo = 0;
        }

        $this -> error_razonsocial = $this -> validar_razonsocial($conexion, $razonsocial, $_empresaBd -> getEm_razonsocial());
        $this -> error_cuit = $this -> validar_cuit($conexion, $cuit, $_empresaBd -> getEm_cuit());
        $this -> error_calle = $this -> validar_calle($calle, $_empresaBd -> getEm_calle());
        $this -> error_altura = $this -> validar_altura($altura, $_empresaBd -> getEm_altura());
        $this -> error_piso = $this -> validar_piso($piso, $_empresaBd -> getEm_piso());
        $this -> error_dpto = $this -> validar_dpto($dpto, $_empresaBd -> getEm_dpto());
        $this -> error_ciudad = $this -> validar_ciudad($ciudad, $_empresaBd -> getEm_ciudad());
        $this -> error_pais = $this -> validar_pais($pais, $_empresaBd -> getEm_pais());
        $this -> error_cp = $this -> validar_cp($cp, $_empresaBd -> getEm_cp());
        $this -> error_tel = $this -> validar_tel($tel, $_empresaBd -> getEm_tel());
        $this -> error_email = $this -> validar_email($conexion, $email, $_empresaBd -> getEm_email());
        $this -> error_activo = $this -> validar_activo($activo, $_empresaBd -> getEm_activo());
        $this -> error_contrato_id = $this -> validar_contrato_id($conexion, $contrato_id, $_empresaBd -> getContrato_id());
    }

    private function variable_iniciada($var){
        if(isset($var) && !empty($var)){
            return true;
        }else{
            return false;
        }
    }
    private function validar_razonsocial($conexion, $razonsocial, $_empresaBd){
        if($razonsocial != $_empresaBd){
            if(!$this -> variable_iniciada($razonsocial)){
                return 0;
            }
            if(strlen($razonsocial) > 50 ){
                return 0;
            }else if(RepositorioEmpresa::razonSocialExiste($conexion, $razonsocial)){
                return 0;
            }
        }
        return 1;
    }
    private function validar_cuit($conexion, $cuit, $_empresaBd){
        if($cuit != $_empresaBd){
            if(!$this -> variable_iniciada($cuit)){
                return 0;
            }else if(strlen($cuit) > 50){
                return 0;
            }else if(RepositorioEmpresa::cuitExiste($conexion, $cuit)){
                return 0;
            }
        }
        return 1;
    }
    private function validar_calle($calle, $_empresaBd){
        if($calle != $_empresaBd){
            if(!$this -> variable_iniciada($calle)){
                return 0;
            }else if(strlen($calle) > 50){
                return 0;
            }else if(!preg_match("/^[\w\.\ ]+$/", $calle)){
                return 0;
            }
        }
        return 1;
    }
    private function validar_altura($altura, $_empresaBd){
        if($altura != $_empresaBd){
            if(is_null($altura)){
                return 1; //acepta nulo
            }
            if($altura === ""){
                return 1;//acepta vacio
            }
            if(strlen($altura) > 50){
                return 0; //Debe contener como maximo 20 caracteres.
            }else if(!preg_match("/^[\d]+$/", $altura)){
                return 0;//debe ingresar solo numeros
            }
        }
        return 1;
    }
    private function validar_piso($piso, $_empresaBd){
        if($piso != $_empresaBd){
            if(is_null($piso)){
                return 1; 
            }
            if($piso === ""){
                return 1;
            }else if(strlen($piso) > 50){
                return 0; 
            }else if(!preg_match("/^[a-zA-Z0-9]+$/", $piso)){
                return 0;
            }
        }
        return 1;
    }
    private function validar_dpto($dpto, $_empresaBd){
        if($dpto != $_empresaBd){
            if(is_null($dpto)){
                return 1; 
            }
            if($dpto === ""){
                return 1; 
            }else if(strlen($dpto) > 50){
                return 0; 
            }else if(!preg_match("/^[a-zA-Z0-9]+$/", $dpto)){
                return 0;
            }
        }
        return 1;
    }
    private function validar_ciudad($ciudad, $_empresaBd){
        if($ciudad != $_empresaBd){
            if(!$this -> variable_iniciada($ciudad)){
                return 0; 
            }
            if(strlen($ciudad) < 3){
                return 0; 
            }else if(strlen($ciudad) > 50){
                return 0;
            }else if(!preg_match("/^[\w\.\ ]+$/", $ciudad)){
                return 0; //"Formato invalido letras numeros puntos y espacios y "_" ";
            }
        }
        return 1; 
    }
    private function validar_pais($pais, $_empresaBd){
        if($pais != $_empresaBd){
            if(!$this -> variable_iniciada($pais)){
                return 0; 
            }
            if(strlen($pais) < 3){
                return 0; 
            }else if(strlen($pais) > 50){
                return 0;
            }else if(!preg_match("/^[a-zA-Z\ ]+$/", $pais)){
                return 0; 
            }
        }
        return 1; 
    }
    private function validar_cp($cp, $_empresaBd){
        if($cp != $_empresaBd){
            if(!$this -> variable_iniciada($cp)){
                return 0; 
            }
            if(strlen($cp) > 50){
                return 0; 
            }else if(!preg_match("/^[\d]+$/", $cp)){
                return 0;//debe ingresar solo numeros
            }
        }
        return 1;
    }
    private function validar_tel($tel, $_empresaBd){
        if($tel != $_empresaBd){
            if(is_null($tel)){
                return 1;
            }
            if($tel === ""){
                return 1;
            }else if(strlen($tel) > 50){
                return 0;
            }else if(!preg_match("/^[\d]+$/", $tel)){
                return 0;
            }
        }
        return 1;
    }
    private function validar_email($conexion, $email, $_empresaBd){
        if($email != $_empresaBd){
            if(!$this -> variable_iniciada($email)){
                return 0;
            }
            if(strlen($email) > 50){
                return 0;
            }
            if(RepositorioEmpresa::email_existe($conexion,$email)){
                
                return 0;
            }
            if(!preg_match("/^[\w._-]+\@[\w._-]+\.[\w._-]+$/", $email)){
                return 0;//"Formato invalido. </br>
            // Ejemplo correcto: xxx@xxx.xxx";
            }
        }
        return 1;
    }
    private function validar_activo($activo, $_empresaBd){
        if($activo != $_empresaBd){
            if(!$this -> variable_iniciada($activo)){
                return 0; 
            }
        }
        return 1;
    }
    private function validar_contrato_id($conexion, $contrato_id, $_empresaBd){
        if($contrato_id != $_empresaBd){
            if(!$this -> variable_iniciada($contrato_id)){
                return 0; 
            }
            if(!RepositorioContrato::contrato_existe_id($conexion,$contrato_id)){
                return 0;
            }
        }
        return 1;
    }
    public function getRazonsocial(){
        return $this -> razonsocial;
    }
    public function getCuit(){
        return $this -> cuit;
    }
    public function getCalle(){
        return $this -> calle;
    }
    public function getAltura(){
        return $this -> altura;
    }
    public function getPiso(){
        return $this -> piso;
    }
    public function getDpto(){
        return $this -> dpto;
    }
    public function getCiudad(){
        return $this -> ciudad;
    }
    public function getPais(){
        return $this -> pais;
    }
    public function getCp(){
        return $this -> cp;
    }
    public function getTel(){
        return $this -> tel;
    }
    public function getEmail(){
        return $this -> email;
    }
    public function getActivo(){
        return $this -> activo;
    }
    public function getContrato_id(){
        return $this -> contrato_id;
    }
    public function getError_razonsocial(){
        return $this -> error_razonsocial;
    }
    public function getError_cuit(){
        return $this -> error_cuit;
    }
    public function getError_calle(){
        return $this -> error_calle;
    }
    public function getError_altura(){
        return $this -> error_altura;
    }
    public function getError_piso(){
        return $this -> error_piso;
    }
    public function getError_dpto(){
        return $this -> error_dpto;
    }
    public function getError_ciudad(){
        return $this -> error_ciudad;
    }
    public function getError_pais(){
        return $this -> error_pais;
    }
    public function getError_cp(){
        return $this -> error_cp;
    }
    public function getError_tel(){
        return $this -> error_tel;
    }
    public function getError_email(){
        return $this -> error_email;
    }
    public function getError_activo(){
        return $this -> error_activo;
    }
    public function getError_contrato_id(){
        return $this -> error_contrato_id;
    }

    public function registro_valido(){
        if($this -> error_razonsocial === 1 && 
           $this -> error_cuit === 1 && 
           $this -> error_calle === 1 &&
           $this -> error_altura === 1 &&
           $this -> error_piso === 1 &&
           $this -> error_dpto === 1 &&
           $this -> error_ciudad === 1 &&
           $this -> error_pais === 1 &&
           $this -> error_cp === 1 &&
           $this -> error_tel === 1 &&
           $this -> error_email === 1 &&
           $this -> error_activo === 1 &&
           $this -> error_contrato_id === 1
           ){
            return true;
        }else{
            return false;
        }
    }
    public function existe_cambio(){
        if($this -> cambio_razonsocial === 1 ||
           $this -> cambio_cuit === 1 ||
           $this -> cambio_calle === 1 ||
           $this -> cambio_altura === 1 ||
           $this -> cambio_piso === 1 ||
           $this -> cambio_dpto === 1 ||
           $this -> cambio_ciudad === 1 ||
           $this -> cambio_pais === 1 ||
           $this -> cambio_cp === 1 ||
           $this -> cambio_tel === 1 ||
           $this -> cambio_email === 1 ||
           $this -> cambio_activo === 1 ||
           $this -> cambio_contrato_id === 1
        ){
            return true;
        }else{
            return false;
        }
    }
    
}