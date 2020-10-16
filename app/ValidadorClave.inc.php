<?php

class ValidadorClave{

    private $error;

    public function __construct($contrasena1, $contrasena2){
        $this -> error = 1;
        
        if( !$this -> variable_iniciada($contrasena1) || !$this -> variable_iniciada($contrasena2)) {
             $this -> error = 0;//"Debes rellenar todos los campos";
        }else if($contrasena1 !== $contrasena2){
            $this -> error = 0;//"Las contraseñas no coinciden";
        }

    }

    private function variable_iniciada($variable){
        if(isset($variable) && !empty($variable)){
            return true;
        }else{
            return false;
        }
    }

    public function obtener_error(){
        return $this -> error;
    }
    /*public function mostrar_error(){
        if ($this -> error !== ''){
            echo "<div class='aviso'>";
            echo $this -> error;
            echo "</div>";
        }
    }*/    
}
