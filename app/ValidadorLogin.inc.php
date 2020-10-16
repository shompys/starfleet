<?php
    //include_once 'RepositorioUsuario.inc.php';
    //include_once 'ValidadorRol.inc.php';
    
    class ValidadorLogin {

        private $usuario;
        private $rol;
        private $activo;
        private $error;
        //private $contrasena;

        public function __construct($email, $contrasena, $conexion){

            $this -> error = 1; //compruebo si los campos fueron rellenados
            
            if(!$this -> variable_iniciada($email) || !$this -> variable_iniciada($contrasena)){
                $this -> usuario = null;
                $this -> error = 0;//"Debes introducir tu email y tu contraseña";
            }else{
                
                $tipo = ValidadorRol::verifico_rol($conexion, $email);
                if(!$tipo === false){
                    $this -> rol = $tipo['tipo_usuario'];
                    switch($tipo['tipo_usuario']){
                        case 'usuario':
                            //1 primera vez de ingreso ojo que puede estar ya/// 2 empresa que corresponde
                            $this -> usuario = RepositorioUsuario :: obtener_usuario_por_email($conexion, $email); //Estoy guardando objusuario
                            $this -> activo = RepositorioUsuario :: usuario_activo($conexion, $email);

                            //var_dump($this -> usuario -> getempresa_id());
                            //atencion!! aca metodo de validacion que la empresa este operativa

                            if(is_null($this -> usuario) || !password_verify($contrasena, $this -> usuario -> getUs_contrasena()) || $this -> activo === false){
                            $this -> error = 0;//"Datos incorrectos";
                            }
                        break;
                        case 'administrador':
                            $this -> usuario = RepositorioAdministrador :: obtener_administrador_por_usuario($conexion, $email);
                            if(is_null($this -> usuario) || !password_verify($contrasena, $this -> usuario -> getAdm_clave())){
                            $this -> error = 0; // "Datos incorrectos";
                            }
                        break;
                    }
                }else{
                    $this -> rol = 0;
                    $this -> error = 0;
                    
                }
            }
            
        }

        

        private function variable_iniciada($variable){
            if(isset($variable) && !empty($variable)){
                return true;
            }else{
                return false;
            }
        }
        public function obtener_tipo(){
            return $this -> rol;
        }
        public function obtener_usuario(){
            return $this -> usuario;
        }
        public function obtener_error(){
            return $this -> error;
        }
        /*public function mostrar_error(){
            if ($this -> error !== ''){
                echo "<br>";
                echo "<div class='alert alert-danger' role='alert'>";
                echo $this -> error;
                echo "</div>";
            }
        }*/
    }
?>