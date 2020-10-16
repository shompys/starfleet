<?php

class RepositorioAbmUsuarios{
    
    public static function insertarAbm($conexion, $objUsuarios){
        $abm_insertado = false;
       // date_default_timezone_set('America/Argentina/Buenos_Aires');
       // $fechaIngreso = date('Y-m-d');

        if(isset($conexion)){
            try{
                $sql = "INSERT INTO abm_usuarios(administrador_id, usuario_id, empresa_id, abmu_accion, abmu_fecha) 
                        VALUES(:administrador_id, :usuario_id, :empresa_id, :abmu_accion, :abmu_fecha)";
                
                $administrador_id = $objUsuarios ->getAdministrador_id();
                $usuario_id = $objUsuarios -> getUsuario_id();
                $empresa_id = $objUsuarios -> getEmpresa_id();
                $abmu_accion = $objUsuarios -> getAbm_accion();
                $abmu_fecha = $objUsuarios -> getAbm_fecha();

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam( ':administrador_id', $administrador_id, PDO::PARAM_STR);
                $sentencia -> bindParam( ':usuario_id', $usuario_id, PDO::PARAM_STR);
                $sentencia -> bindParam( 'empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> bindParam( ':abmu_accion', $abmu_accion, PDO::PARAM_STR);
                $sentencia -> bindParam( ':abmu_fecha', $abmu_fecha, PDO::PARAM_STR);
                $abm_insertado = $sentencia -> execute();
                
            }catch (PDOException $ex){
                print 'ERROR' . $ex ->getMessage();
            }
        }
        return $abm_insertado;
    }
    
    public static function obtener_id_usuario_por_dni($conexion, $dni){
        $id_usuario = null;

        if(isset($conexion)){
            try{

                $sql="SELECT * FROM usuarios WHERE us_dni = :dni";
                $sentencia = $conexion -> prepare ($sql);
                $sentencia -> bindParam(':dni', $dni, PDO::PARAM_STR);
                $sentencia ->execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $id_usuario = $resultado['id_usuario'];
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $id_usuario;
    }

}