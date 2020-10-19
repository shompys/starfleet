<?php

class RepositorioAbmEmpresas{

    public static function insertarAbmEmpresas($conexion, $objEmpresa){
        $insertado = false;

        if(isset($conexion)){
            try{
                $sql = "INSERT INTO abm_empresas(administrador_id, empresa_id, abme_accion, abme_fecha) 
                        VALUES(:administrador_id, :empresa_id, :abme_accion, :abme_fecha)";
                
                $administrador_id = $objEmpresa -> getAdministrador_id();
                $empresa_id = $objEmpresa -> getEmpresa_id();
                $abme_accion = $objEmpresa -> getAbme_accion();
                $abme_fecha = $objEmpresa -> getAbme_fecha();

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam( ':administrador_id', $administrador_id, PDO::PARAM_STR);
                $sentencia -> bindParam( ':empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> bindParam( ':abme_accion', $abme_accion, PDO::PARAM_STR);
                $sentencia -> bindParam( ':abme_fecha', $abme_fecha, PDO::PARAM_STR);
                $insertado = $sentencia -> execute();
                
            }catch (PDOException $ex){
                print 'ERROR' . $ex ->getMessage();
            }
        }
        return $insertado;
    }
}