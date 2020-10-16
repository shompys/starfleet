<?php

class RepositorioAdministrador{

    public static function insertar_administrador($conexion, $adm_usuario){

        $usuario_insertado = false;

        if(isset($conexion)){
            try{
                $sql = "INSERT INTO administradores(adm_usuario,adm_clave)VALUES(:usuario, :clave)"; 
                        
                
                $nombreTemp= $adm_usuario ->getAdm_usuario();
                $claveTemp= $adm_usuario ->getAdm_clave(); 


                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam( ':usuario', $nombreTemp, PDO::PARAM_STR);
                $sentencia -> bindParam( ':clave', $claveTemp, PDO::PARAM_STR);

                $usuario_insertado = $sentencia -> execute();

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMesagge();
            }
        }
        return $usuario_insertado;

    }

    public static function obtener_administrador_por_usuario($conexion, $usuario){
        $administrador = null;

        if(isset($conexion)){
            try{
                include_once 'Administrador.inc.php';
                $sql = "SELECT * FROM administradores WHERE BINARY adm_usuario = :usuario";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $administrador = new Administrador($resultado['id_administrador'],
                                                       $resultado['adm_usuario'],
                                                       $resultado['adm_clave']
                                           );
                }

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $administrador; //Obtengo Null si el mail es incorrecto y el array del usuario a quien corresponda el usuario
    }
    public static function obtener_administrador_por_id($conexion, $id){
        $administrador = null;

        if(isset($conexion)){
            try{
                include_once 'Administrador.inc.php';
                $sql = "SELECT * FROM administradores WHERE id_administrador = :id_administrador";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id_administrador', $id, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $administrador = new Administrador($resultado['id_administrador'],
                                                       $resultado['adm_usuario'],
                                                       $resultado['adm_clave']
                                           );
                }

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $administrador;
    }

    public static function verificar_rol($conexion, $usuario){
        $rol= false;

        if(isset($conexion)){

            try{
                $sql= "SELECT adm_usuario FROM administradores WHERE adm_usuario = :usuario";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                if(count($resultado)){
                    $rol= true;
                }else{
                    $rol = false;
                }

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $rol;
    }


}