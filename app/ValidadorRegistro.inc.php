<?php

class ValidadorRegistro{

    private $nombre;
    private $apellido;
    private $usuario;
    private $email;
    private $fecha;
    private $dni;
    private $sexo;
    private $calle;
    private $altura;
    private $piso;
    private $dpto;
    private $ciudad;
    private $pais;
    private $contrasena;
    private $contrasena2;
    private $permiso;
    private $empresa;
    private $empresa_id;
    private $activo;

    private $error_nombre;
    private $error_apellido;
    private $error_usuario;
    private $error_email;
    private $error_fecha;
    private $error_dni;
    private $error_sexo;
    private $error_calle;
    private $error_altura;
    private $error_piso;
    private $error_dpto;
    private $error_ciudad;
    private $error_pais;
    private $error_contrasena;
    private $error_contrasena2;
    private $error_permiso;
    private $error_empresa;
    private $error_empresa_id;
    private $error_activo;
    
    
    public function __construct($nombre, $apellido, $usuario, $email, $fecha, $dni, $sexo, $calle, $altura, $piso, $dpto, $ciudad, $pais, $contrasena, $contrasena2, $permiso,$empresa, $empresa_id, $activo, $conexion){
        
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> usuario = $usuario;
        $this -> email = $email;
        $this -> fecha = $fecha;
        $this -> dni = $dni;
        $this -> sexo = $sexo;
        $this -> calle = $calle;
        $this -> altura = $altura;
        $this -> piso = $piso;
        $this -> dpto = $dpto;
        $this -> ciudad = $ciudad;
        $this -> pais = $pais;
        $this -> permiso = $permiso;
        $this -> empresa = $empresa;
        $this -> empresa_id = $empresa_id;
        $this -> activo = $activo;

        $this -> error_nombre = $this -> validar_nombre($nombre);
        $this -> error_apellido = $this -> validar_apellido($apellido);
        $this -> error_usuario = $this -> validar_usuario($conexion, $usuario);
        $this -> error_email = $this -> validar_email($conexion, $email);
        $this -> error_fecha = $this -> validar_fecha($fecha);
        $this -> error_dni = $this -> validar_dni($conexion, $dni);
        $this -> error_sexo = $this -> validar_sexo($sexo);
        $this -> error_calle = $this -> validar_calle($calle);
        $this -> error_altura = $this -> validar_altura($altura);
        $this -> error_piso = $this -> validar_piso($piso);
        $this -> error_dpto = $this -> validar_dpto($dpto);
        $this -> error_ciudad = $this -> validar_ciudad($ciudad);
        $this -> error_pais = $this -> validar_pais($pais);
        $this -> error_contrasena = $this -> validar_contrasena($contrasena);
        $this -> error_contrasena2 = $this -> validar_contrasena2($contrasena, $contrasena2);
        $this -> error_permiso = $this -> validar_permiso($permiso);
        $this -> error_empresa = $this -> validar_empresa($empresa_id, $empresa, $conexion);
        $this -> error_empresa_id = $this -> validar_empresa_id($empresa_id,$empresa, $conexion);
        $this -> error_activo = $this -> validar_activo($activo);

        if($this -> error_contrasena === 1){
            $this -> contrasena = $contrasena;
        }
        if($this -> error_contrasena2 === 1){
            $this -> contrasena2 = $contrasena;
        }


    }
    //estructura para comprobar cada variable si contiene algo
    private function variable_iniciada($variable){
        if(isset($variable) && !empty($variable)){
            return true;
        }else{
            return false;
        }
    }
    //---------------------------------------------------------
    private function validar_nombre($nombre){
        if(!$this -> variable_iniciada($nombre)){
            return 0; //"Debe escribir un nombre."
        }else{
            $this -> nombre = $nombre;
        }
        if(strlen($nombre) < 3){
            return 0;//"Debe ser mayor a 2 caracteres"
        }else if(strlen($nombre) > 20){
            return 0;//"El nombre debe contener maximo 20 caracteres"
        }else if(!preg_match("/^[a-zA-Z]+$/", $nombre)){
            return 0; //"Formato invalido solo se admiten letras";
        }
        return 1; //si no existen errores esto devuelve 1
    }
    //----------------------------------------------------------
    private function validar_apellido($apellido){
        if(!$this -> variable_iniciada($apellido)){
            return 0; //"Debe escribir un apellido.";
        }else{
            $this -> apellido = $apellido;
        }
        if(strlen($apellido) < 3){
            return 0; //"Debe ser mayor a 2 caracteres";
        }else if(strlen($apellido) > 20){
            return 0;//"El apellido debe contener maximo 20 caracteres";
        }else if(!preg_match("/^[a-zA-Z]+$/", $apellido)){
            return 0; //"Formato invalido solo se admiten letras";
        }
        return 1; //si no existen errores esto  devuelve 0
    }
    //--------------------------------------------falta validar si esta repetido 
    private function validar_usuario($conexion, $usuario){
        if(!$this -> variable_iniciada($usuario)){
            return 0; //"Debe escribir un usuario.";
        }else{
            $this -> usuario = $usuario;
        }
        if(strlen($usuario) > 20){
            return 0; //"El usuario debe contener maximo 20 caracteres";
        }else if(RepositorioUsuario::usuario_existe($conexion,$usuario)){
            return 0; //"Este usuario ya esta en uso.";
        }else if("admin" === $usuario || "jonathan" === $usuario || "krusty" === $usuario || "alan" === $usuario){
            return 0; //"Este usuario ya esta en uso (guiño guiño).";
        }else if(!preg_match("/^[\w._-]+$/", $usuario)){
            return 0;//formato invalido
        }
        return 1;
    }
    //---------------------------------- 
    private function validar_email($conexion, $email){
        if(!$this -> variable_iniciada($email)){
            return 0;//"Debe escribir un email.";
        }else{
            $this -> email = $email;
        }
        if(strlen($email) > 50){
            return 0;//"El email debe contener maximo 50 caracteres";
        }
        if(RepositorioUsuario::email_existe($conexion,$email)){
            return 0;//"Este email ya se encuentra registrado.";
        }
        if(!preg_match("/^[\w._-]+\@[\w._-]+\.[\w._-]+$/", $email)){
            return 0;//"Formato invalido. </br>
           // Ejemplo correcto: xxx@xxx.xxx";
        }
        return 1;
    }
    //---------------------------------------------------------------
    private function validar_fecha($fecha){
        if(!$this -> variable_iniciada($fecha)){
            return 0;//"Debe ingresar fecha de nacimiento.";
        }else{
            $this -> fecha = $fecha;
        }
        $actualFecha = date('Y-m-d');
        $fechaDeforme = strtotime('-18 year',strtotime($actualFecha));
        $fechaLinda = date('Y-m-d', $fechaDeforme);
        if($fecha > $fechaLinda){
            return 0;//'Debe ingresar una fecha que supere la edad adulta (18 años)';
        }else if($fecha <= 1930){
            return 0;//'Debe ingresar una fecha mayor o igual a 1930';
        }
        if(!preg_match("/^[\d]{4}(\-|\/)[\d]{2}(\-|\/)[\d]{2}$/", $fecha)){
            return 0;//"Formato invalido. </br>
            //Ejemplo correcto: 0 al 9 </br> xxxx-xx-xx // xxxx/xx/xx";
        }
        return 1;
    }
    private function validar_dni($conexion, $dni){
        if(!$this -> variable_iniciada($dni)){
            return 0;//"Debe escribir un DNI.";
        }else{
            $this -> dni = $dni;
        }
        if(strlen($dni) > 8){
            return 0;//"El DNI debe contener maximo 8 caracteres";
        }else if(strlen($dni) < 7){
            return 0;//"El DNI debe contener como minimo 7 caracteres";
        }else if(!preg_match("/^[\d]+$/", $dni)){
            return 0;//"Formato invalido solo se admiten numeros";
        }else if(RepositorioUsuario::dni_existe($conexion,$dni)){
            return 0;//"Este dni ya esta en uso.";
        }
        return 1;
    }
    private function validar_sexo($sexo){
        if(!$this -> variable_iniciada($sexo)){
            return 0;//"Debe escribir un sexo.";
        }else{
            $this -> sexo = $sexo;
        }
        if(!($sexo === "m" || $sexo === "M" || $sexo === "f" || $sexo === "F")){
            return 0;//Debe ser M o F;
        }
        return 1;
        
    }
    private function validar_contrasena($contrasena){
        if(!$this -> variable_iniciada($contrasena)){
            return 0;//"Debe ingresar una contraseña.";
        }
        return 1;
    }
    private function validar_contrasena2($contrasena, $contrasena2){
        if(!$this -> variable_iniciada($contrasena2)){
            return 0;
        }else if($contrasena !== $contrasena2){
            return 0; //"Las contrasenas no coinciden";
        }
        return 1;
    }

    private function validar_calle($calle){
        if(!$this -> variable_iniciada($calle)){
            return 0;//"Debe ingresar una calle.";
        }else{    
            $this -> calle = $calle;
        }
        if(strlen($calle) < 3){
            return 0; //"Debe ser mayor a 2 caracteres";
        }else if(strlen($calle) > 50){
            return 0;//"La calle debe contener maximo 50 caracteres";
        }else if(!preg_match("/^[\w\.\ ]+$/", $calle)){
            return 0; //"Formato invalido letras numeros puntos y espacios y "_" ";
        }
        return 1; //si no existen errores esto  devuelve 1

    }

    private function validar_altura($altura){
        if(is_null($altura)){
            return 1; //acepta nulo
        }
        if($altura === ""){
            return 1;//acepta vacio
        }
        if(strlen($altura) > 50){
            return 0; //Debe contener como maximo 20 caracteres.
        }else if(!preg_match("/^[\d]+$/", $altura)){
            return 0;//debe ingresar solo numeros
        }
        return 1;
    }
    private function validar_piso($piso){
        if(is_null($piso)){
            return 1; //acepta nulo
        }
        if($piso === ""){
            return 1;//acepta vacio
        }else if(strlen($piso) > 50){
            return 0; // Debe contener como maximo 10 caracteres.
        }else if(!preg_match("/^[a-zA-Z0-9]+$/", $piso)){
            return 0;
        }
        return 1;
    }
    private function validar_dpto($dpto){
        if(is_null($dpto)){
            return 1; //acepta nulo
        }
        if($dpto === ""){
            return 1; 
        }else if(strlen($dpto) > 50){
            return 0; 
        }else if(!preg_match("/^[a-zA-Z0-9]+$/", $dpto)){
            return 0;
        }
        return 1;

    }
    private function validar_ciudad($ciudad){
        if(!$this -> variable_iniciada($ciudad)){
            return 0; //Debe ingresar una ciudad
        }else{
            $this -> ciudad = $ciudad;
        }
        if(strlen($ciudad) < 3){
            return 0; //"Debe ser mayor a 2 caracteres";
        }else if(strlen($ciudad) > 50){
            return 0;//"La ciudad debe contener maximo 50 caracteres";
        }else if(!preg_match("/^[\w\.\ ]+$/", $ciudad)){
            return 0; //"Formato invalido letras numeros puntos y espacios y "_" ";
        }
        return 1; //si no existen errores esto devuelve 1
    }
    private function validar_pais($pais){
        if(!$this -> variable_iniciada($pais)){
            return 0; //Debe ingresar una ciudad
        }else{
            $this -> pais = $pais;
        }
        if(strlen($pais) < 3){
            return 0; //"Debe ser mayor a 2 caracteres";
        }else if(strlen($pais) > 50){
            return 0;//"La ciudad debe contener maximo 50 caracteres";
        }else if(!preg_match("/^[\w\.\ ]+$/", $pais)){
            return 0; //"Formato invalido letras numeros puntos y espacios y "_" ";
        }
        return 1; //si no existen errores esto devuelve 1
    }
    private function validar_permiso($permiso){
        if(!$this -> variable_iniciada($permiso)){
            return 0;
        }else{
            $this -> permiso = $permiso;
        }
        if($permiso === null){
            return 0;
        }
        return 1; 
    }
    private function validar_empresa($empresa_id, $empresa, $conexion){
        if(!$this -> variable_iniciada($empresa)){
            return 0;
        }else{
            $this -> empresa = $empresa;
        }
        if(!RepositorioEmpresa::empresa_existe($conexion,$empresa_id,$empresa)){
            return 0;
        }
        return 1;
    }
    private function validar_empresa_id($empresa_id, $empresa, $conexion){
        if(!$this -> variable_iniciada($empresa_id)){
            return 0;
        }
        if(!RepositorioEmpresa::empresa_existe($conexion,$empresa_id,$empresa)){
            return 0;
        }
        return 1;
    }
    private function validar_activo($activo){
        if(!$this -> variable_iniciada($activo)){
            return 0;
        }
        return 1;
    }
    
    //----------accesos GETTERSS-------------------------------

    public function getNombre(){
        return $this -> nombre; 
    }
    public function getApellido(){
        return $this -> apellido; 
    }
    public function getUsuario(){
        return $this -> usuario; 
    }
    public function getEmail(){
        return $this -> email;
    }
    public function getFecha(){
        return $this -> fecha;
    }
    public function getDni(){
        return $this -> dni;
    }
    public function getSexo(){
        return $this -> sexo;
    }
    public function getContrasena(){
        return $this -> contrasena;
    }
    public function getContrasena2(){
        return $this -> contrasena2;
    }
    public function getCalle(){
        return $this -> calle;
    }
    public function getAltura(){
        return $this -> altura;
    }
    public function getPiso(){
        return $this -> piso;
    }
    public function getDpto(){
        return $this -> dpto;
    }
    public function getCiudad(){
        return $this -> ciudad;
    }
    public function getPais(){
        return $this -> pais;
    }
    public function getpermiso(){
        return $this -> permiso;
    }
    public function getEmpresa(){
        return $this -> empresa;
    }
    public function getEmpresa_id(){
        return $this -> empresa_id;
    }
    public function getActivo(){
        return $this -> activo;
    }

    //------------error getter------------------
    public function getErrorNombre(){
        return $this -> error_nombre;
    }
    public function getErrorApellido(){
        return $this -> error_apellido; 
    }
    public function getErrorUsuario(){
        return $this -> error_usuario; 
    }
    public function getErrorEmail(){
        return $this -> error_email;
    }
    public function getErrorFecha(){
        return $this -> error_fecha;
    }
    public function getErrorDni(){
        return $this -> error_dni;
    }
    public function getErrorSexo(){
        return $this -> error_sexo;
    }
    public function getErrorContrasena(){
        return $this -> error_contrasena;
    }
    public function getErrorContrasena2(){
        return $this -> error_contrasena2;
    }
    public function getErrorCalle(){
        return $this -> error_calle;
    }
    public function getErrorAltura(){
        return $this -> error_altura;
    }
    public function getErrorPiso(){
        return $this -> error_piso;
    }
    public function getErrorDpto(){
        return $this -> error_dpto;
    }
    public function getErrorCiudad(){
        return $this -> error_ciudad;
    }
    public function getErrorPais(){
        return $this -> error_pais;
    }
    public function getErrorPermiso(){
        return $this -> error_permiso;
    }
    public function getErrorEmpresa(){
        return $this -> error_empresa;
    }
    public function getErrorEmpresa_id(){
        return $this -> error_empresa_id;
    }
    public function getErrorActivo(){
        return $this -> error_activo;
    }

//--------------------------------------------------------------------------------------------
    public function registro_valido(){
        if($this -> error_nombre === 1 && 
           $this -> error_apellido === 1 && 
           $this -> error_usuario === 1 &&
           $this -> error_email === 1 &&
           $this -> error_fecha === 1 &&
           $this -> error_dni === 1 &&
           $this -> error_contrasena === 1 &&
           $this -> error_calle === 1 &&
           $this -> error_altura === 1 &&
           $this -> error_piso === 1 &&
           $this -> error_dpto === 1 &&
           $this -> error_ciudad === 1 &&
           $this -> error_pais === 1 &&
           $this -> error_permiso === 1 &&
           $this -> error_empresa === 1 &&
           $this -> error_empresa_id === 1 &&
           $this -> error_activo === 1
           ){
            return true;
        }else{
            return false;
        }
    }
   
}

?>