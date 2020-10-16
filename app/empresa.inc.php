<?php

class Empresa{
    private $id_empresa;
    private $em_razonsocial;
    private $em_cuit;
    private $em_calle;
    private $em_altura;
    private $em_piso;
    private $em_dpto;
    private $em_ciudad;
    private $em_pais;
    private $em_cp;
    private $em_tel;
    private $em_email;
    private $em_activo;
    private $contrato_id;
    

    public function __construct($id_empresa, $em_razonsocial, $em_cuit, $em_calle, $em_altura, $em_piso, $em_dpto, $em_ciudad, $em_pais, $em_cp, $em_tel, $em_email, $em_activo, $contrato_id){
        
        $this -> id_empresa = $id_empresa;
        $this -> em_razonsocial = $em_razonsocial;
        $this -> em_cuit = $em_cuit;
        $this -> em_calle = $em_calle;
        $this -> em_altura = $em_altura;
        $this -> em_piso = $em_piso;
        $this -> em_dpto = $em_dpto;
        $this -> em_ciudad = $em_ciudad;
        $this -> em_pais = $em_pais;
        $this -> em_cp = $em_cp;
        $this -> em_tel = $em_tel;
        $this -> em_email = $em_email;
        $this -> em_activo = $em_activo;
        $this -> contrato_id = $contrato_id;
    }
    //auto getters!!
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
