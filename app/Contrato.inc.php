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