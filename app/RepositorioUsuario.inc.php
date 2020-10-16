<?php

class RepositorioUsuario{

    public static function insertarUsuario($conexion, $objUsuario){
        $usuario_insertado = false;

        if(isset($conexion)){
            try{
                $sql = "INSERT INTO usuarios(us_nombre, us_apellido, us_usuario, us_email,
                        us_fecha, us_dni, us_sexo, us_calle, us_altura, us_piso,
                        us_dpto, us_ciudad, us_pais, us_contrasena, us_permiso, us_activo, us_firstlogin, empresa_id) 
                        VALUES(:nombre, :apellido, :usuario, :email, :fecha, :dni, :sexo,
                        :calle, :altura, :piso, :dpto, :ciudad, :pais, :contrasena, :permiso, :activo, :firstlogin, :empresa_id)";
                
                $nombreTemp= $objUsuario ->getUs_nombre();
                $apellidoTemp= $objUsuario ->getUs_apellido(); 
                $usuarioTemp= $objUsuario -> getUs_usuario();
                $emailTemp= $objUsuario -> getUs_email();
                $fechaTemp= $objUsuario -> getUs_fecha();
                $dniTemp= $objUsuario -> getUs_dni();
                $sexo= $objUsuario -> getUs_sexo();
                $calle= $objUsuario -> getUs_calle();
                $altura= $objUsuario -> getUs_altura();
                $piso= $objUsuario -> getUs_piso();
                $dpto= $objUsuario -> getUs_dpto();
                $ciudad= $objUsuario -> getUs_ciudad();
                $pais= $objUsuario -> getUs_pais();
                $contrasena= $objUsuario ->getUs_contrasena();
                $permiso = $objUsuario -> getUs_permiso();
                $activo = $objUsuario -> getUs_activo();
                $firstlogin = $objUsuario -> getUs_firstlogin();
                $empresa_id = $objUsuario -> getEmpresa_id();
                
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam( ':nombre', $nombreTemp, PDO::PARAM_STR);
                $sentencia -> bindParam( ':apellido', $apellidoTemp, PDO::PARAM_STR);
                $sentencia -> bindParam( ':usuario', $usuarioTemp, PDO::PARAM_STR);
                $sentencia -> bindParam( ':email', $emailTemp, PDO::PARAM_STR);
                $sentencia -> bindParam( ':fecha', $fechaTemp, PDO::PARAM_STR);
                $sentencia -> bindParam( ':dni', $dniTemp, PDO::PARAM_STR);
                $sentencia -> bindParam( ':sexo', $sexo, PDO::PARAM_STR);
                $sentencia -> bindParam( ':contrasena', $contrasena, PDO::PARAM_STR);
                $sentencia -> bindParam( ':calle', $calle, PDO::PARAM_STR);
                $sentencia -> bindParam( ':altura', $altura, PDO::PARAM_STR);
                $sentencia -> bindParam( ':piso', $piso, PDO::PARAM_STR);
                $sentencia -> bindParam( ':dpto', $dpto, PDO::PARAM_STR);
                $sentencia -> bindParam( ':ciudad', $ciudad, PDO::PARAM_STR);
                $sentencia -> bindParam( ':pais', $pais, PDO::PARAM_STR);
                $sentencia -> bindParam( ':permiso', $permiso, PDO::PARAM_STR);
                $sentencia -> bindParam( ':activo', $activo, PDO::PARAM_STR);
                $sentencia -> bindParam( ':firstlogin', $firstlogin, PDO::PARAM_STR);
                $sentencia -> bindParam( ':empresa_id', $empresa_id, PDO::PARAM_STR);

                $usuario_insertado = $sentencia -> execute();

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMesagge();
            }
        }
        return $usuario_insertado;
    }

    public static function usuario_existe($conexion,$usuario){
        $existeUs = true;
        if(isset($conexion)){

            try{
                $sql = "SELECT us_usuario from usuarios WHERE us_usuario = :usuario ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetchAll();

                if(count($resultado)){
                    $existeUs = true;
                }else{
                    $existeUs = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $existeUs;
    }
    public static function email_existe($conexion,$email){
        $existeMail = true;
        if(isset($conexion)){

            try{
                $sql = "SELECT us_email from usuarios WHERE us_email = :email ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetchAll();

                if(count($resultado)){
                    $existeMail = true;
                }else{
                    $existeMail = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $existeMail;
    }
    public static function dni_existe($conexion,$dni){
        $existeDni = true;
        if(isset($conexion)){

            try{
                $sql = "SELECT us_dni from usuarios WHERE us_dni = :dni ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':dni', $dni, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetchAll();

                if(count($resultado)){
                    $existeDni = true;
                }else{
                    $existeDni = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $existeDni;
    }

    public static function obtener_usuario_por_email($conexion, $email){
        $usuario = null;

        if(isset($conexion)){
            try{
                include_once 'Usuario.inc.php';
                $sql = "SELECT * FROM usuarios WHERE BINARY us_email = :email";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $usuario = new Usuario($resultado['id_usuario'],
                                           $resultado['us_nombre'],
                                           $resultado['us_apellido'],
                                           $resultado['us_usuario'],
                                           $resultado['us_email'],
                                           $resultado['us_fecha'],
                                           $resultado['us_dni'],
                                           $resultado['us_sexo'],
                                           $resultado['us_calle'],
                                           $resultado['us_altura'],
                                           $resultado['us_piso'],
                                           $resultado['us_dpto'],
                                           $resultado['us_ciudad'],
                                           $resultado['us_pais'],
                                           $resultado['us_contrasena'],
                                           $resultado['us_permiso'],
                                           $resultado['us_activo'],
                                           $resultado['us_firstlogin'],
                                           $resultado['empresa_id']
                                        );
                }

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $usuario; //Obtengo Null si el mail es incorrecto y el array del usuario a quien corresponda el email
    }

    public static function actualizar_clave($conexion, $id_usuario, $nueva_clave){

        $actualizacion_correcta = false;

        if(isset($conexion)){
            try{
                $sql="UPDATE usuarios SET us_contrasena = :nueva_clave WHERE id_usuario = :id_usuario ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':nueva_clave', $nueva_clave, PDO :: PARAM_STR);
                $sentencia -> bindParam(':id_usuario', $id_usuario, PDO :: PARAM_STR);
                
                $actualizacion_correcta = $sentencia -> execute();

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $actualizacion_correcta;

    }

    public static function obtener_usuario_por_id($conexion, $id_usuario){
        $usuario = null;

        if(isset($conexion)){
            try{
                include_once 'Usuario.inc.php';
                $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $usuario = new Usuario($resultado['id_usuario'],
                                           $resultado['us_nombre'],
                                           $resultado['us_apellido'],
                                           $resultado['us_usuario'],
                                           $resultado['us_email'],
                                           $resultado['us_fecha'],
                                           $resultado['us_dni'],
                                           $resultado['us_sexo'],
                                           $resultado['us_calle'],
                                           $resultado['us_altura'],
                                           $resultado['us_piso'],
                                           $resultado['us_dpto'],
                                           $resultado['us_ciudad'],
                                           $resultado['us_pais'],
                                           $resultado['us_contrasena'],
                                           $resultado['us_permiso'],
                                           $resultado['us_activo'],
                                           $resultado['us_firstlogin'],
                                           $resultado['empresa_id']
                                        );
                }

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $usuario; //Obtengo Null si el id es incorrecto y el array del usuario a quien corresponda el id
    }

    public static function usuario_activo($conexion,$email){
        $act = null;
        if(isset($conexion)){

            try{
                $sql = "SELECT us_activo from usuarios WHERE us_email = :email ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetch();

                if($resultado['us_activo'] === '1'){
                    $act = true;
                }else{
                    $act = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $act;//true si esta activo
    }

    public static function usuario_activo_por_dni($conexion, $dni){
        $act= null;
        if(isset($conexion)){
            try{
                $sql = "SELECT us_activo FROM usuarios WHERE us_dni = :dni";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':dni', $dni, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                if($resultado['us_activo'] === '1'){
                    $act = true;
                }else{
                    $act = false;
                }

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $act; // true si esta activo
    }

    public static function usuarioSetActivo($conexion, $dni, $activo){
        $status = false;
        
        if(isset($conexion)){
            try{
                $sql="UPDATE usuarios SET us_activo = :activo WHERE us_dni = :dni ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':activo', $activo, PDO::PARAM_STR);
                $sentencia -> bindParam(':dni', $dni, PDO::PARAM_STR);
                $status = $sentencia -> execute();
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $status;
    }    

    public static function firstlogin($conexion,$email){
        $act = false;
        if(isset($conexion)){

            try{
                $sql = "SELECT us_firstlogin from usuarios WHERE us_email = :email ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetch();

                if($resultado['us_firstlogin'] === '1'){
                    $act = true;
                }else{
                    $act = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $act;//true si firstlogin
    }
    
    public static function modificar_firstlogin($conexion, $firstlogin, $email){
        $mf = false;
        
        if(isset($conexion)){
            try{
                $sql="UPDATE usuarios SET us_firstlogin = :firstlogin WHERE us_email = :email";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':firstlogin', $firstlogin, PDO :: PARAM_STR);
                $sentencia -> bindParam(':email', $email, PDO :: PARAM_STR);
                $mf = $sentencia -> execute();
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $mf;
        
    }

    public static function update_usuario_por_dni($conexion, $objUser, $dni_){
        $upd = false;
        
        if(isset($conexion)){
            try{
                $sql="UPDATE usuarios SET us_nombre = :nombre, us_apellido = :apellido, 
                      us_usuario = :usuario, us_email = :email, us_fecha = :fecha,
                      us_dni = :dni,
                      us_sexo = :sexo, us_calle = :calle,
                      us_altura = :altura, us_piso = :piso, us_dpto = :dpto,
                      us_ciudad = :ciudad, us_pais = :pais,
                      us_contrasena = :contrasena ,us_permiso = :permiso,
                      us_activo = :activo, empresa_id = :empresa_id
                      WHERE us_dni = :dni_";

                $nombre = $objUser ->getUs_nombre();
                $apellido = $objUser ->getUs_apellido(); 
                $usuario = $objUser -> getUs_usuario();
                $email = $objUser -> getUs_email();
                $fecha = $objUser -> getUs_fecha();
                $dni = $objUser -> getUs_dni();
                $sexo = $objUser -> getUs_sexo();
                $calle = $objUser -> getUs_calle();
                $altura = $objUser -> getUs_altura();
                $piso = $objUser -> getUs_piso();
                $dpto = $objUser -> getUs_dpto();
                $ciudad = $objUser -> getUs_ciudad();
                $pais = $objUser -> getUs_pais();
                $contrasena = $objUser -> getUs_contrasena();
                $permiso = $objUser -> getUs_permiso();
                $activo = $objUser -> getUs_activo();
                $empresa = $objUser -> getEmpresa_id();
                
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam( ':nombre', $nombre, PDO::PARAM_STR);
                $sentencia -> bindParam( ':apellido', $apellido, PDO::PARAM_STR);
                $sentencia -> bindParam( ':usuario', $usuario, PDO::PARAM_STR);
                $sentencia -> bindParam( ':email', $email, PDO::PARAM_STR);
                $sentencia -> bindParam( ':fecha', $fecha, PDO::PARAM_STR);
                $sentencia -> bindParam( ':dni', $dni, PDO::PARAM_STR);
                $sentencia -> bindParam( ':sexo', $sexo, PDO::PARAM_STR);
                $sentencia -> bindParam( ':calle', $calle, PDO::PARAM_STR);
                $sentencia -> bindParam( ':altura', $altura, PDO::PARAM_STR);
                $sentencia -> bindParam( ':piso', $piso, PDO::PARAM_STR);
                $sentencia -> bindParam( ':dpto', $dpto, PDO::PARAM_STR);
                $sentencia -> bindParam( ':ciudad', $ciudad, PDO::PARAM_STR);
                $sentencia -> bindParam( ':pais', $pais, PDO::PARAM_STR);
                $sentencia -> bindParam( ':contrasena', $contrasena, PDO::PARAM_STR);
                $sentencia -> bindParam( ':permiso', $permiso, PDO::PARAM_STR);
                $sentencia -> bindParam( ':activo', $activo, PDO::PARAM_STR);
                $sentencia -> bindParam( ':empresa_id', $empresa, PDO::PARAM_STR);
                $sentencia -> bindParam( ':dni_', $dni_, PDO::PARAM_STR);
                
                $upd = $sentencia -> execute();
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $upd;
    }

    public static function buscar_usuarios_dni($conexion, $dni){ // ojo pass inventada
        $usuario = null;
        
        if(isset($conexion)){
            try{
                $sql= "SELECT * FROM usuarios WHERE us_dni = :dni";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':dni', $dni, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();
                
                if(!empty($resultado)){
                    $usuario = new Usuario($resultado['id_usuario'],
                    $resultado['us_nombre'],
                    $resultado['us_apellido'],
                    $resultado['us_usuario'],
                    $resultado['us_email'],
                    $resultado['us_fecha'],
                    $resultado['us_dni'],
                    $resultado['us_sexo'],
                    $resultado['us_calle'],
                    $resultado['us_altura'],
                    $resultado['us_piso'],
                    $resultado['us_dpto'],
                    $resultado['us_ciudad'],
                    $resultado['us_pais'],
                    'password',//$resultado['us_contrasena'],
                    $resultado['us_permiso'],
                    $resultado['us_activo'],
                    $resultado['us_firstlogin'],
                    $resultado['empresa_id']
                 );
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $usuario;
    }
    public static function obtener_empresaid_dni($conexion, $dni){
        $id = null;

        if(isset($conexion)){
            try{
                $sql="SELECT empresa_id FROM usuarios WHERE us_dni = :dni";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':dni', $dni, PDO::PARAM_STR);
                $sentencia -> execute();
                $res = $sentencia -> fetch();
                $name = $res['empresa_id'];

            }catch(PDOExceptio $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $name;
    }
    
    

}