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

        if(isset($conexion, $objContrato)){

            try{
                $sql = "INSERT INTO contratos(con_descripcion, con_precio, con_maxusuarios,con_duracionmeses, con_activo) VALUES(:descrip, :precio, :maxusuarios, :duracionmeses, :activo)";

                $desc = $objContrato -> getCon_descripcion();
                $precio = $objContrato -> getCon_precio();
                $maxUser = $objContrato -> getCon_maxusuarios();
                $duracionMeses = $objContrato -> getCon_duracionmeses();
                $activo = $objContrato -> getCon_activo();

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

    public static function obtener_todos_nombres_contratos($conexion){//donde el contrato este activo!!!
        $obj = null;

        if(isset($conexion)){
            try{
                $sql="SELECT id_contrato, con_descripcion FROM contratos WHERE con_activo = 1 ORDER BY id_contrato ASC";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> execute();
                $result = $sentencia -> fetchAll();
                if(!empty($result)){
                    
                    foreach($result as $key => $value){
                        $obj[$key]= $value;
                    }
                }
                
            }catch(PDOException $e){
                'ERROR DE CONTRATO_EXISTE_iD: ' . $e -> getMessage();
            }
        }
        return $obj;
    }

    public static function obtener_objContrato($conexion, $id){ 
        $contrato = null;
        
        if(isset($conexion)){
            try{
                $sql= "SELECT * FROM contratos WHERE id_contrato = :id";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id', $id, PDO::PARAM_STR);
                $sentencia -> execute();
                $arr = $sentencia -> fetch();
                
                if(!empty($arr)){
                    $contrato = new Contrato(
                    $arr['id_contrato'],
                    $arr['con_descripcion'],
                    $arr['con_precio'],
                    $arr['con_maxusuarios'],
                    $arr['con_duracionmeses'],
                    $arr['con_activo']
                 );
                }

            }catch(PDOException $ex){
                print 'ERROR en repContrato' . $ex -> getMessage();
            }

        }
        return $contrato;
    }

    public static function contrato_activa_por_id($conexion,$id){
        $act = false;
        if(isset($conexion)){

            try{
                $sql = "SELECT con_activo from contratos WHERE id_contrato = :id";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id', $id, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetch();
                if($resultado['con_activo'] === '1'){
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
    public static function contratoSetActivo($conexion, $id, $activo){
        $status = false;
        
        if(isset($conexion)){
            try{
                $sql="UPDATE contratos SET con_activo = :activo WHERE id_contrato = :id ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':activo', $activo, PDO::PARAM_STR);
                $sentencia -> bindParam(':id', $id, PDO::PARAM_STR);
                $status = $sentencia -> execute();
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $status;
    }
    public static function update_contrato_id($conexion, $id_contrato, $objContrato){
        $status = false;

        if(isset($conexion)){
            try{
                $sql = "UPDATE contratos SET con_descripcion = :descripcion, con_precio = :precio, con_maxusuarios = :usuario, con_duracionmeses = :meses, con_activo = :activo
                        WHERE id_contrato = :id_contrato";
                
                $descripcion = $objContrato -> getCon_descripcion();
                $precio = $objContrato -> getCon_precio();
                $usuario = $objContrato -> getCon_maxusuarios();
                $meses = $objContrato -> getCon_duracionmeses();
                $activo = $objContrato -> getCon_activo();
   
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $sentencia -> bindParam(':precio', $precio, PDO::PARAM_STR);
                $sentencia -> bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $sentencia -> bindParam(':meses', $meses, PDO::PARAM_STR);
                $sentencia -> bindParam(':activo', $activo, PDO::PARAM_STR);

                $sentencia -> bindParam(':id_contrato', $id_contrato, PDO::PARAM_STR);
                $result = $sentencia -> execute();
                
                if($result === true){
                    $status = true;
                }
            }catch(PDOException $ex){
                print 'catch de RC::update_contrato_id : ' . $ex  -> getMessage();
            }
        }
        return $status;
    }
                

}