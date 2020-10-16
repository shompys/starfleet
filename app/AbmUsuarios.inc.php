<?php
class AbmUsuarios{

private $id_abm_usuario;
private $administrador_id;
private $usuario_id;
private $empresa_id;
private $abm_accion;
private $abm_fecha;

public function __construct($id_abm_usuario,$administrador_id,$usuario_id ,$empresa_id, $abm_accion, $abm_fecha){

    $this -> id_abm_usuario = $id_abm_usuario;
    $this -> administrador_id = $administrador_id;
    $this -> usuario_id = $usuario_id;
    $this -> empresa_id = $empresa_id;
    $this -> abm_accion = $abm_accion;
    $this -> abm_fecha = $abm_fecha;

}

public function getId_abm_usuario(){
    return $this -> id_abm_usuario;
}
public function getAdministrador_id(){
    return $this -> administrador_id;
}
public function setAdministrador_id($administrador_id){
    $this -> administrador_id = $administrador_id; 
}
public function getUsuario_id(){
    return $this -> usuario_id;
}
public function setUsuario_id($usuario_id){
    $this -> usuario_id = $usuario_id; 
}
public function getEmpresa_id(){
    return $this -> empresa_id;
}
public function getAbm_accion(){
    return $this -> abm_accion;
}
public function setAbm_accion($abm_accion){
    $this -> abm_accion = $abm_accion;
}
public function getAbm_fecha(){
    return $this -> abm_fecha;
}
public function setAbm_fecha($abm_fecha){
    $this -> abm_fecha = $abm_fecha;
}
}