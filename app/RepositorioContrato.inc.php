<?php

class RepositorioContrato{

    public static function contrato_existe($conexion,$descripcion){
        $existe = null;

        if(isset($conexion)){

            try{
                $sql = "SELECT con_descripcion from contratos WHERE con_descripcion = :descripcion";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetchAll();

                if(count($resultado)){
                    $existe = true;
                }else{
                    $existe = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $existe;
    }

    public static function insertarContrato($conexion, $objContrato){
        $insertado = false;

        if(isset($conexion)){

            try{
                $sql = "INSERT INTO contratos(con_descripcion, con_precio, con_maxusuarios,con_duracionmeses, con_activo) VALUES(:descrip, :precio, :maxusuarios, :duracionmeses, :activo)";

                $desc = $objContrato -> getCon_descripcion();
                $precio = $objContrato -> getCon_precio();
                $maxUser = $objContrato -> getCon_maxusuarios();
                $duracionMeses = $objContrato -> getCon_duracionmeses();
                $activo = $objActivo -> getCon_activo();

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':descrip', $desc, PDO::PARAM_STR);
                $sentencia -> bindParam(':precio', $precio, PDO::PARAM_STR);
                $sentencia -> bindParam(':maxusuarios', $maxUser, PDO::PARAM_STR);
                $sentencia -> bindParam(':duracionmeses', $duracionMeses, PDO::PARAM_STR);
                $sentencia -> bindParam(':activo', $activo, PDO::PARAM_STR);

                $insertado = $sentencia -> execute();

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $insertado;
    }

    public static function obtener_id($conexion, $descripcion){
        $id = null;

        if(isset($conexion)){

            try{
                $sql="SELECT id_contrato FROM contratos WHERE con_descripcion = :descripcion";
                $sentencia = $conexion -> prepare($sql);
                $sentencia ->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();
                
                $id = $resultado['id_contrato'];
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $id;
    }

    public static function contrato_existe_id($conexion,$contrato_id){
        $existe = null;
        if(isset($conexion)){
            try{
                $sql = "SELECT id_contrato from contratos WHERE id_contrato = :contrato_id";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':contrato_id', $contrato_id, PDO::PARAM_STR);
                $sentencia -> execute();
                $result = $sentencia ->fetchAll();
                
                if(count($result)){
                    $existe = true;
                }else{
                    $existe = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex-> getMessage();
            }
        }
        return $existe;
    }

    
                

}