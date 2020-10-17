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
    
    public function getId_empresa(){
        return $this -> id_empresa;
    }
    public function getEm_razonsocial(){
        return $this -> em_razonsocial;
    }
    public function getEm_cuit(){
        return $this -> em_cuit;
    }
    public function getEm_calle(){
        return $this -> em_calle;
    }
    public function getEm_altura(){
        return $this -> em_altura;
    }
    public function getEm_piso(){
        return $this -> em_piso;
    }
    public function getEm_dpto(){
        return $this -> em_dpto;
    }
    public function getEm_ciudad(){
        return $this -> em_ciudad;
    }
    public function getEm_pais(){
        return $this -> em_pais;
    }
    public function getEm_cp(){
        return $this -> em_cp;
    }
    public function getEm_tel(){
        return $this -> em_tel;
    }
    public function getEm_email(){
        return $this -> em_email;
    }
    public function getEm_activo(){
        return $this -> em_activo;
    }
    public function getcontrato_id(){
        return $this -> contrato_id;
    }
}
