<?php
class RepositorioRecuperacionClave{

    public static function generar_peticion($conexion, $id_usuario, $token, $expired){

        $peticion_generada = false;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaIngreso = date('Y-m-d H:i:s');
        if(isset($conexion)){
            try{
                $sql = "INSERT INTO recuperacion_tokens(usuario_id, rec_token, rec_fecha, rec_expired) VALUES(:usuario_id, :token, :fecha, :expired)";
                $sentencia = $conexion -> prepare($sql);

                $sentencia -> bindParam(':usuario_id', $id_usuario, PDO :: PARAM_STR);
                $sentencia -> bindParam(':token', $token, PDO :: PARAM_STR);
                $sentencia -> bindParam(':fecha', $fechaIngreso, PDO :: PARAM_STR);
                $sentencia -> bindParam(':expired', $expired, PDO :: PARAM_STR);
                $peticion_generada = $sentencia -> execute(); //devuelve true or false

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $peticion_generada;
    }

    public static function url_secreta_existe($conexion, $url_secreta){
        $url_existe = false;

        if(isset($conexion)){
            try{

                $sql="SELECT * FROM recuperacion_tokens WHERE rec_token = :url_secreta";
                $sentencia = $conexion -> prepare ($sql);
                $sentencia -> bindParam(':url_secreta', $url_secreta, PDO::PARAM_STR);
                $sentencia ->execute();
                $resultado = $sentencia -> fetchAll();

                if(count($resultado)){
                    $url_existe = true;
                }else{
                    $url_existe = false;
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $url_existe;
    }

    public static function obtener_id_usuario_por_url_secreta($conexion,$url_secreta){
        $id_usuario = null;

        if(isset($conexion)){
            try{

                $sql="SELECT * FROM recuperacion_tokens WHERE rec_token = :url_secreta";
                $sentencia = $conexion -> prepare ($sql);
                $sentencia -> bindParam(':url_secreta', $url_secreta, PDO::PARAM_STR);
                $sentencia ->execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $id_usuario = $resultado['usuario_id'];
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $id_usuario;
    }
    //en desuso 
    public static function eliminar_url_secreta($conexion, $id_usuario ,$url_secreta){

        $peticion= false;

        if(isset($conexion)){

            try{
                $sql ="DELETE FROM recuperacion_tokens WHERE usuario_id = :id_usuario AND rec_token = :url_secreta ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
                $sentencia -> bindParam(':url_secreta', $url_secreta, PDO::PARAM_STR);
                $peticion = $sentencia -> execute();

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $peticion;
    }

    public static function obtener_pin_por_id_usuario($conexion, $id_usuario){
        $pin = null;

        if(isset($conexion)){
            try{

                $sql="SELECT rec_token FROM recuperacion_tokens WHERE usuario_id = :id_usuario";
                $sentencia = $conexion -> prepare ($sql);
                $sentencia -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
                $sentencia ->execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $pin = $resultado['rec_token'];
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $pin;

    }
    public static function obtener_fecha_por_pin_unix($conexion, $pin){
        $fecha= null;

        if(isset($conexion)){
            try{
                
                $sql="SELECT UNIX_TIMESTAMP(rec_fecha) as unix FROM recuperacion_tokens WHERE rec_token = :pin";
                $sentencia = $conexion -> prepare ($sql);
                $sentencia -> bindParam(':pin', $pin, PDO::PARAM_STR);
                $sentencia ->execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $fecha = $resultado['unix'];
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $fecha;
    }
    public static function modificar_pin_estado($conexion, $expired, $id_usuario, $pin){

        $mc = false;
        
        if(isset($conexion)){
            try{
                $sql="UPDATE recuperacion_tokens SET rec_expired = :expired WHERE usuario_id = :id_usuario AND rec_token = :pin ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':expired', $expired, PDO :: PARAM_STR);
                $sentencia -> bindParam(':id_usuario', $id_usuario, PDO :: PARAM_STR);
                $sentencia -> bindParam(':pin', $pin, PDO :: PARAM_STR);
                
                $mc = $sentencia -> execute();
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $mc;
        
    }

    public static function comprobar_expiracion($conexion, $pin){
        $expired= false;

        if($conexion){
            try{
                $sql = "SELECT rec_expired FROM recuperacion_tokens WHERE rec_token = :pin";    
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam('pin', $pin, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();
                
                if(!empty($resultado)){
                    
                    if($resultado['rec_expired'] === '0'){  
                        $expired = true;
                    }
                }
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $expired;//true todavia no expiro
    }

    //creo que en desuso
    public static function mostrar_error($email){

        $error = "No hay resultados de búsqueda vuelve a intentarlo";
        if(!variable_iniciada($email) || !variable_iniciada($email)){
            $error = "Rellena el campo";
        }

        function variable_iniciada($variable){
            if(isset($variable) && !empty($variable)){
                return true;
            }else{
                return false;
            }
        }

        return $error;
    }

}