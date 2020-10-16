<?php

class Administrador{

    private $id_administrador;
    private $adm_usuario;
    private $adm_clave;

    public function __construct($id_administrador, $adm_usuario, $adm_clave){
        $this -> id_administrador = $id_administrador;
        $this -> adm_usuario = $adm_usuario;
        $this -> adm_clave = $adm_clave;
    }

    public function getId_administrador(){
        return $this -> id_administrador;
    }
    public function setId_administrador($id_administrador){
        $this -> id_administrador = $id_administrador; 
    }

    public function getAdm_usuario(){
        return $this -> adm_usuario;
    }
    public function setAdm_usuario($adm_usuario){
        $this -> adm_usuario = $adm_usuario; 
    }

    public function getAdm_clave(){
        return $this -> adm_clave;
    }
    public function setAdm_clave($adm_clave){
        $this -> adm_clave = $adm_clave; 
    }


}

