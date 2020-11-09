<?php

class RepositorioEmpresa{
    
    public static function insertarEmpresa($conexion, $objEmpresa){
        $insertado = false;

        if(isset($conexion)){

            try{
                $sql = "INSERT INTO empresas(em_razonsocial, em_cuit, em_calle, em_altura, em_piso, em_dpto, em_ciudad, em_pais, em_cp, em_tel, em_email, em_activo, contrato_id) 
                        VALUES(:rs, :cuit, :calle, :altura, :piso, :dpto, :ciudad, :pais, :cp, :tel, :email, :activo, :contrato_id )";

                $rs = $objEmpresa -> getEm_razonsocial();
                $cuit = $objEmpresa -> getEm_cuit();
                $calle = $objEmpresa -> getEm_calle();
                $altura = $objEmpresa -> getEm_altura();
                $piso = $objEmpresa -> getEm_piso();
                $dpto = $objEmpresa -> getEm_dpto();
                $ciudad = $objEmpresa -> getEm_ciudad();
                $pais = $objEmpresa -> getEm_pais();
                $cp = $objEmpresa -> getEm_cp();
                $tel = $objEmpresa -> getEm_tel();
                $email = $objEmpresa -> getEm_email();
                $activo = $objEmpresa -> getEm_activo();
                $contrato_id = $objEmpresa -> getContrato_id();

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':rs', $rs, PDO::PARAM_STR);
                $sentencia -> bindParam(':cuit', $cuit, PDO::PARAM_STR);
                $sentencia -> bindParam(':calle', $calle, PDO::PARAM_STR);
                $sentencia -> bindParam(':altura', $altura, PDO::PARAM_STR);
                $sentencia -> bindParam(':piso', $piso, PDO::PARAM_STR);
                $sentencia -> bindParam(':dpto', $dpto, PDO::PARAM_STR);
                $sentencia -> bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
                $sentencia -> bindParam(':pais', $pais, PDO::PARAM_STR);
                $sentencia -> bindParam(':cp', $cp, PDO::PARAM_STR);
                $sentencia -> bindParam(':tel', $tel, PDO::PARAM_STR);
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia -> bindParam(':activo', $activo, PDO::PARAM_STR);
                $sentencia -> bindParam(':contrato_id', $contrato_id, PDO::PARAM_STR);
                
                
                $insertado = $sentencia -> execute();

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $insertado;
    }

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
    public static function empresa_activa($conexion,$id){
        $act = false;
        if(isset($conexion)){

            try{
                $sql = "SELECT em_activo from empresas WHERE id_empresa = :id";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':id', $id, PDO::PARAM_STR);
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

    public static function empresa_activa_por_razon($conexion,$razon){
        $act = false;
        if(isset($conexion)){

            try{
                $sql = "SELECT em_activo from empresas WHERE em_razonsocial = :razon";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':razon', $razon, PDO::PARAM_STR);
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

    public static function razonSocialExiste($conexion, $razonsocial){
        $existe = false;

        if(isset($conexion)){

            try{

                $sql = "SELECT em_razonsocial FROM empresas WHERE em_razonsocial = :razonsocial";
                $sent = $conexion -> prepare($sql);
                $sent -> bindParam(':razonsocial', $razonsocial, PDO::PARAM_STR);
                $sent -> execute();
                $result = $sent -> fetchAll();
                
                if(count($result)){
                    $existe = true;
                }else{
                    $existe = false;
                }
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $existe;
    }

    public static function cuitExiste($conexion, $cuit){
        $existe = false;

        if(isset($conexion)){

            try{

                $sql = "SELECT em_cuit FROM empresas WHERE em_cuit = :cuit";
                $sent = $conexion -> prepare($sql);
                $sent -> bindParam(':cuit', $cuit, PDO::PARAM_STR);
                $sent -> execute();
                $result = $sent -> fetchAll();
                
                if(count($result)){
                    $existe = true;
                }else{
                    $existe = false;
                }
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $existe;
    }
    public static function email_existe($conexion,$email){
        $existe = false;
        if(isset($conexion)){

            try{
                $sql = "SELECT em_email from empresas WHERE em_email = :email ";
                
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia ->fetchAll();

                if(count($resultado)){
                    $existe = true;
                }else{
                    $existe = false;
                }
            }catch (PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $existe;
    }
    public static function obtener_id_empresa_por_cuit($conexion, $cuit){
        $id = null;

        if(isset($conexion)){
            try{

                $sql="SELECT id_empresa FROM empresas WHERE em_cuit = :cuit";
                $sentencia = $conexion -> prepare ($sql);
                $sentencia -> bindParam(':cuit', $cuit, PDO::PARAM_STR);
                $sentencia ->execute();
                $resultado = $sentencia -> fetch();

                if(!empty($resultado)){
                    $id = $resultado['id_empresa'];
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $id;
    }
    /*
    public static function id_empresa_existe($conexion,$razon){
        $existe = true;
        if(isset($conexion)){

            try{
                $sql = "SELECT em_razonsocial from empresas WHERE em_razonsocial = :razon ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':razon', $razon, PDO::PARAM_STR);
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
    */
    public static function obtener_objEmpresa($conexion, $razon){ 
        $empresa = null;
        
        if(isset($conexion)){
            try{
                $sql= "SELECT * FROM empresas WHERE em_razonsocial = :razon";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':razon', $razon, PDO::PARAM_STR);
                $sentencia -> execute();
                $arr = $sentencia -> fetch();
                
                if(!empty($arr)){
                    $empresa = new Empresa($arr['id_empresa'],
                    $arr['em_razonsocial'],
                    $arr['em_cuit'],
                    $arr['em_calle'],
                    $arr['em_altura'],
                    $arr['em_piso'],
                    $arr['em_dpto'],
                    $arr['em_ciudad'],
                    $arr['em_pais'],
                    $arr['em_cp'],
                    $arr['em_tel'],
                    $arr['em_email'],
                    $arr['em_activo'],
                    $arr['contrato_id']
                 );
                }

            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $empresa;
    }

    public static function empresaSetActivo($conexion, $razon, $activo){
        $status = false;
        
        if(isset($conexion)){
            try{
                $sql="UPDATE empresas SET em_activo = :activo WHERE em_razonsocial = :razon ";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':activo', $activo, PDO::PARAM_STR);
                $sentencia -> bindParam(':razon', $razon, PDO::PARAM_STR);
                $status = $sentencia -> execute();
                
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }
        }
        return $status;
    }
    public static function update_empresa_id($conexion, $id_empresa, $objEmpresa){
        $status = false;

        if(isset($conexion)){
            try{
                $sql = "UPDATE empresas SET em_razonsocial = :razon, em_cuit = :cuit, em_calle = :calle,
                        em_altura = :altura, em_piso = :piso, em_dpto = :dpto, em_ciudad = :ciudad, em_pais = :pais,
                        em_cp = :cp, em_tel = :tel, em_email = :email, em_activo = :activo, contrato_id = :contrato_id 
                        WHERE id_empresa = :empresa_id";
                
                $razon = $objEmpresa -> getEm_razonsocial();
                $cuit = $objEmpresa -> getEm_cuit();
                $calle = $objEmpresa -> getEm_calle();
                $altura = $objEmpresa -> getEm_altura();
                $piso = $objEmpresa -> getEm_piso();
                $dpto = $objEmpresa -> getEm_dpto();
                $ciudad = $objEmpresa -> getEm_ciudad();
                $pais = $objEmpresa -> getEm_pais();
                $cp = $objEmpresa -> getEm_cp();
                $tel = $objEmpresa -> getEm_tel();
                $email = $objEmpresa -> getEm_email();
                $activo = $objEmpresa -> getEm_activo();
                $contrato_id = $objEmpresa -> getcontrato_id();
                
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':razon', $razon, PDO::PARAM_STR);
                $sentencia -> bindParam(':cuit', $cuit, PDO::PARAM_STR); 
                $sentencia -> bindParam(':calle',$calle, PDO::PARAM_STR); 
                $sentencia -> bindParam(':altura',$altura, PDO::PARAM_STR); 
                $sentencia -> bindParam(':piso', $piso, PDO::PARAM_STR); 
                $sentencia -> bindParam(':dpto', $dpto, PDO::PARAM_STR); 
                $sentencia -> bindParam(':ciudad', $ciudad, PDO::PARAM_STR); 
                $sentencia -> bindParam(':pais', $pais, PDO::PARAM_STR); 
                $sentencia -> bindParam(':cp', $cp, PDO::PARAM_STR); 
                $sentencia -> bindParam(':tel',$tel, PDO::PARAM_STR); 
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR); 
                $sentencia -> bindParam(':activo', $activo, PDO::PARAM_STR); 
                $sentencia -> bindParam(':contrato_id', $contrato_id, PDO::PARAM_STR);
                $sentencia -> bindParam(':empresa_id', $id_empresa, PDO::PARAM_STR);
                $result = $sentencia -> execute();
                if($result === true){
                    $status = true;
                }
            }catch(PDOException $ex){
                print 'catch de RE::update_empresa_id : ' . $ex  -> getMessage();
            }
        }
        return $status;
    }

    public static function obtener_nombres_empresas($conexion){//falta recibir activo
        $obj = null;

        if(isset($conexion)){
            try{
                $sql="SELECT em_razonsocial FROM empresas WHERE em_activo = 1 ORDER BY id_empresa ASC";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> execute();
                $result = $sentencia -> fetchAll();
                if(!empty($result)){
                    
                    foreach($result as $key => $value){
                        $obj[$key]= $value;
                    }
                }
                
            }catch(PDOException $e){
                'ERROR: ' . $e -> getMessage();
            }
        }
        return $obj;
    }
    public static function empresa_id_razon($conexion){ 
        $empresa = null;
        
        if(isset($conexion)){
            try{
                $sql= "SELECT id_empresa, em_razonsocial FROM empresas";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> bindParam(':razon', $razon, PDO::PARAM_STR);
                $sentencia -> execute();
                $arr = $sentencia -> fetchAll();
                
                if(!empty($arr)){
                    foreach($arr as $k => $v){
                        $empresa[$k] = $v;
                    }
                }
            }catch(PDOException $ex){
                print 'ERROR' . $ex -> getMessage();
            }

        }
        return $empresa;
    }
}