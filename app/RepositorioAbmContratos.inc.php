<?php

class RepositorioAbmContratos{
    
    public static function insertarAbmContratos($conexion, $objContrato){
        $insertado = false;

        if(isset($conexion)){
            try{
                $sql = "INSERT INTO abm_contratos(administrador_id, contrato_id, abmc_accion, abmc_fecha) 
                        VALUES(:administrador_id, :contrato_id, :abmc_accion, :abmc_fecha)";
                
                $administrador_id = $objContrato -> getAdministrador_id();
                
                $contrato_id = $objContrato -> getContrato_id();
                $abmc_accion = $objContrato -> getAbmc_accion();
                $abmc_fecha = $objContrato -> getAbmc_fecha();

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam( ':administrador_id', $administrador_id, PDO::PARAM_STR);
                $sentencia -> bindParam( ':contrato_id', $contrato_id, PDO::PARAM_STR);
                $sentencia -> bindParam( ':abmc_accion', $abmc_accion, PDO::PARAM_STR);
                $sentencia -> bindParam( ':abmc_fecha', $abmc_fecha, PDO::PARAM_STR);
                $insertado = $sentencia -> execute();

            }catch (PDOException $ex){
                print 'ERROR' . $ex ->getMessage();
            }
        }
        return $insertado;
    }
}