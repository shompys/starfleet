<?php

class Usuario{

    private $id_usuario;
    private $us_nombre;
    private $us_apellido;
    private $us_usuario;
    private $us_email;
    private $us_fecha;
    private $us_dni;
    private $us_sexo;
    private $us_calle;
    private $us_altura;
    private $us_piso;
    private $us_dpto;
    private $us_ciudad;
    private $us_pais;
    private $us_contrasena;
    private $us_permiso;
    private $us_activo;
    private $us_firstlogin;
    private $empresa_id;

    public function __construct($id_usuario, $us_nombre, $us_apellido, $us_usuario, $us_email, $us_fecha, $us_dni, $us_sexo, $us_calle, $us_altura, $us_piso, $us_dpto, $us_ciudad, $us_pais, $us_contrasena, $us_permiso, $us_activo, $us_firstlogin, $empresa_id){

        $this -> id_usuario = $id_usuario;
        $this -> us_nombre = $us_nombre;
        $this -> us_apellido = $us_apellido;
        $this -> us_usuario = $us_usuario;
        $this -> us_email = $us_email;
        $this -> us_fecha = $us_fecha;
        $this -> us_dni = $us_dni;
        $this -> us_sexo = $us_sexo;
        $this -> us_calle = $us_calle;
        $this -> us_altura = $us_altura;
        $this -> us_piso = $us_piso;
        $this -> us_dpto = $us_dpto;
        $this -> us_ciudad = $us_ciudad;
        $this -> us_pais = $us_pais;
        $this -> us_contrasena = $us_contrasena;
        $this -> us_permiso = $us_permiso;
        $this -> us_activo = $us_activo;
        $this -> us_firstlogin = $us_firstlogin;
        $this -> empresa_id = $empresa_id;

    }
    //-------------------------getter and setter------------
    
    
    public function getId_usuario(){
        return $this -> id_usuario;
    }
    public function setId_usuario($id_usuario){
        $this -> id_usuario = $id_usuario; 
    }
    public function getUs_nombre(){
        return $this -> us_nombre;
    }
    public function setUs_nombre($us_nombre){
        $this -> us_nombre = $us_nombre; 
    }
    public function getUs_apellido(){
        return $this -> us_apellido;
    }
    public function setUs_apellido($us_apellido){
        $this -> us_apellido = $us_apellido; 
    }
    public function getUs_usuario(){
        return $this -> us_usuario;
    }
    public function setUs_usuario($us_usuario){
        $this -> us_usuario = $us_usuario; 
    }
    public function getUs_email(){
        return $this -> us_email;
    }
    public function setUs_email($us_email){
        $this -> us_email = $us_email; 
    }
    public function getUs_fecha(){
        return $this -> us_fecha;
    }
    public function setUs_fecha($us_fecha){
        $this -> us_fecha = $us_fecha; 
    }
    public function getUs_dni(){
        return $this -> us_dni;
    }
    public function setUs_dni($us_dni){
        $this -> us_dni = $us_dni; 
    }
    public function getUs_sexo(){
        return $this -> us_sexo;
    }
    public function setUs_sexo($us_sexo){
        $this -> us_sexo = $us_sexo;
    }
    public function getUs_calle(){
        return $this -> us_calle;
    }
    public function setUs_calle($Us_calle){
        $this -> us_calle = $us_calle;
    }
    public function getUs_altura(){
        return $this -> us_altura;
    }
    public function setUs_altura($us_altura){
        $this -> us_altura = $us_altura;
    }
    public function getUs_piso(){
        return $this -> us_piso;
    }
    public function setUs_piso($us_piso){
        $this -> us_piso = $us_piso;
    }
    public function getUs_dpto(){
        return $this -> us_dpto;
    }
    public function setUs_dpto($us_dpto){
        $this -> us_dpto = $us_dpto;
    }
    public function getUs_ciudad(){
        return $this -> us_ciudad;
    }
    public function setUs_ciudad(){
        $this -> us_ciudad = $us_ciudad;
    }
    public function getUs_pais(){
        return $this -> us_pais;
    }
    public function setUs_pais($us_pais){
        $this -> us_pais = $us_pais;
    }
    public function getUs_contrasena(){
        return $this -> us_contrasena;
    }
    public function setUs_contrasena($us_contrasena){
        $this -> us_contrasena = $us_contrasena; 
    }
    public function getUs_permiso(){
        return $this -> us_permiso;
    }
    public function setUs_permiso($us_permiso){
        $this -> us_permiso = $us_permiso;
    }
    public function getUs_activo(){
        return $this -> us_activo;
    }
    public function setUs_activo($us_activo){
        $this -> us_activo = $us_activo;
    }
    public function getUs_firstlogin(){
        return $this -> us_firstlogin;
    }
    public function setUs_firstlogin($us_firstlogin){
        $this -> us_firstlogin = $us_firstlogin;
    }
    public function getEmpresa_id(){
        return $this -> empresa_id;
    }
    public function setEmpresa_id($empresa_id){
        $this -> empresa_id = $empresa_id;
    }
    //----------------------------
    
}