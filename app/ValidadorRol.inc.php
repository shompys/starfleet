<?php


class ValidadorRol{
    

    public static function verifico_rol($conexion, $usuario){

        $rol= false;

        if(isset($conexion)){

            try{
                $sql= "SELECT * FROM 
                (SELECT id_administrador AS id, adm_usuario AS usuario, 'administrador' AS tipo_usuario FROM administradores UNION ALL
                 SELECT id_usuario AS id, us_email AS usuario, 'usuario' AS tipo_usuario FROM usuarios)x
                 WHERE x.usuario = :usuario";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $rol['id']= $resultado['id'];
                    $rol['usuario'] = $resultado['usuario'];
                    $rol['tipo_usuario'] = $resultado['tipo_usuario'];
                    
                }

            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $rol;


    }

}
