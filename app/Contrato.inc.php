<?php 

class Contrato{

    private $id_contrato;
    private $con_descripcion;
    private $con_precio;
    private $con_maxusuarios;
    private $con_duracionmeses;
    private $con_activo;

    public function __construct($id_contrato, $con_descripcion, $con_precio, $con_maxusuarios, $con_duracionmeses, $con_activo){

        $this -> id_contrato = $id_contrato;
        $this -> con_descripcion = $con_descripcion;
        $this -> con_precio = $con_precio;
        $this -> con_maxusuarios = $con_maxusuarios;
        $this -> con_duracionmeses = $con_duracionmeses;
        $this -> con_activo = $con_activo;

    }

    public function getId_contrato(){
        return $this -> id_contrato;
    }
    public function getCon_descripcion(){
        return $this -> con_descripcion;
    }
    public function getCon_precio(){
        return $this -> con_precio;
    }
    public function getCon_maxusuarios(){
        return $this -> con_maxusuarios;
    }
    public function getCon_duracionmeses(){
        return $this -> con_duracionmeses;
    }
    public function getCon_activo(){
        return $this -> con_activo;
    }


}