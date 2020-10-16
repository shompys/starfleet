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

    public function __call($name, $arguments){ 
        $part1 = substr($name, 0, 3);   //extraigo el metodo
        if($part1 === 'get'){   //compruebo si es get
            $nameMethod = substr(strtolower($name),3); //extraigo nombre del atributo 
            if(!isset($this -> $nameMethod)){
                return 'atributo no existe';
            }
            return $this->$nameMethod; // esto es igual al return de un getter!!!
        }else{
            return 'el metodo no existe';
        }
    }

}