<?php

class AbmContratos{

    private $id_abm_contrato;
    private $administrador_id;
    private $contrato_id;
    private $abmc_accion;
    private $abmc_fecha;

    public function __construct($id_abm_contrato, $administrador_id, $contrato_id, $abmc_accion, $abmc_fecha){

        $this -> id_abm_contrato = $id_abm_contrato; 
        $this -> administrador_id = $administrador_id;
        $this -> contrato_id = $contrato_id;
        $this -> abmc_accion = $abmc_accion;
        $this -> abmc_fecha = $abmc_fecha;
    }

    public function getId_abm_contrato(){
        return $this -> Id_abm_contrato;
    }
    public function getAdministrador_id(){
        return $this -> administrador_id;
    }
    public function getcontrato_id(){
        return $this -> contrato_id;
    }
    public function getAbmc_accion(){
        return $this -> abmc_accion;
    }
    public function getAbmc_fecha(){
        return $this -> abmc_fecha;
    }
    
}