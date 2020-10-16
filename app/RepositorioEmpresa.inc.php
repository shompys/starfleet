<?php

class RepositorioEmpresa{
    
    public static function empresa_existe($conexion,$empresa_id, $empresa){
        $existe = null;
        if(isset($conexion)){

            try{
                $sql = "SELECT id_empresa from empresas WHERE id_empresa = :empresa_id AND em_razonsocial = :empresa";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> bindParam(':empresa', $empresa, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetchAll();
                if(count($resultado)){
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

    public static function max_usuarios_contrato($conexion, $empresa_id){

        $max= null;

        if(isset($conexion)){

            try{
                $sql = "SELECT c.con_maxusuarios as maximo_de_usuarios 
                FROM empresas e 
                INNER JOIN contratos c 
                ON e.contrato_id = c.id_contrato 
                where e.id_empresa = :empresa_id                
                ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> execute();
                $res = $sentencia ->fetch();

                $max=$res['maximo_de_usuarios'];

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $max;
    }
    public static function obtener_nombre_empresa($conexion, $empresa_id){
        $name = null;

        if(isset($conexion)){
            try{
                $sql="SELECT em_razonsocial FROM empresas WHERE id_empresa = :empresa_id";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> execute();
                $res = $sentencia -> fetch();
                $name = $res['em_razonsocial'];

            }catch(PDOExceptio $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $name;
    }

    public static function duracion_meses_contrato($conexion, $empresa_id){

        $meses= null;

        if(isset($conexion)){

            try{
                $sql = "SELECT c.con_duracionmeses as meses 
                FROM empresas e 
                INNER JOIN contratos c 
                ON e.contrato_id = c.id_contrato 
                where e.id_empresa = :empresa_id                
                ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> execute();
                $res = $sentencia ->fetch();

                $meses=$res['meses'];

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $meses;


    }

    public static function cantidad_usuarios_empresaid($conexion, $empresa_id){//cuenta registros por empresa y por campo activo!!!

        $cantReg= null;

        if(isset($conexion)){

            try{
                $sql = "SELECT count(e.id_empresa) AS cantidad_usuarios 
                FROM empresas e 
                INNER JOIN usuarios u ON u.empresa_id = e.id_empresa 
                WHERE e.id_empresa = :empresa_id
                AND e.em_activo = 1";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam('empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> execute();
                $res = $sentencia -> fetch();
                $cantReg = $res['cantidad_usuarios'];

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $cantReg;
    }

    public static function empresa_activa($conexion,$empresa_id){
        $act = false;
        if(isset($conexion)){

            try{
                $sql = "SELECT em_activo from empresas WHERE id_empresa = :empresa_id";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':empresa_id', $empresa_id, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetch();
                if($resultado['em_activo'] === '1'){
                    $act = true;
                }else{
                    $act = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex-> getMessage();
            }
        }
        return $act;
    }

}