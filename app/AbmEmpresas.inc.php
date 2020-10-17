<?php

class AbmEmpresas{

    private $id_abm_empresa;
    private $administrador_id;
    private $empresa_id;
    private $abme_accion;
    private $abme_fecha;

    public function __construct($id_abm_empresa, $administrador_id, $empresa_id, $abme_accion, $abme_fecha){
        
        $this -> id_abm_empresa = $id_abm_empresa;
        $this -> administrador_id = $administrador_id;
        $this -> empresa_id = $empresa_id;
        $this -> abme_accion = $abme_accion;
        $this -> abme_fecha = $abme_fecha;

    }

    public function getId_abm_empresa(){
        return $this -> id_abm_empresa;
    }
    public function getAdministrador_id(){
        return $this -> administrador_id;
    }
    public function getEmpresa_id(){
        return $this -> empresa_id;
    }
    public function getAbme_accion(){
        return $this -> abme_accion;
    }
    public function getAbme_fecha(){
        return $this -> abme_fecha;
    }

}