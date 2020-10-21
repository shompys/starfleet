<?php
//require_once '../autoload.php'; no quiere funcionar en hostinger
require_once '../app/AbmContratos.inc.php';
require_once '../app/AbmEmpresas.inc.php';
require_once '../app/AbmUsuarios.inc.php';
require_once '../app/Administrador.inc.php';
require_once '../app/Conexion.inc.php';
require_once '../app/config.inc.php';
require_once '../app/Contrato.inc.php';
require_once '../app/ControlCookie.inc.php';
require_once '../app/ControlSesion.inc.php';
require_once '../app/Empresa.inc.php';
require_once '../app/Redireccion.inc.php';
require_once '../app/RepositorioAbmContratos.inc.php';
require_once '../app/RepositorioAbmEmpresas.inc.php';
require_once '../app/RepositorioAbmUsuarios.inc.php';
require_once '../app/RepositorioAdministrador.inc.php';
require_once '../app/RepositorioContrato.inc.php';
require_once '../app/RepositorioEmpresa.inc.php';
require_once '../app/RepositorioRecuperacionClave.inc.php';
require_once '../app/RepositorioUsuario.inc.php';
require_once '../app/Usuario.inc.php';
require_once '../app/ValidadorAltaEmpresas.inc.php';
require_once '../app/ValidadorClave.inc.php';
require_once '../app/ValidadorContratos.inc.php';
require_once '../app/ValidadorLogin.inc.php';
require_once '../app/ValidadorModificarEmpresa.inc.php';
require_once '../app/ValidadorModificarUsuario.inc.php';
require_once '../app/ValidadorRegistro.inc.php';
require_once '../app/ValidadorRol.inc.php';
require_once '../phpmailer/emails.php';
header('Content-Type: application/json');

    if(isset($_POST['requestForm'])){
        $form = $_POST['requestForm'];
    }
    if(isset($_POST['requestPin']) && $_POST['requestPin'] != ''){
        $form= 'requestPin';
    }
    if(isset( $_POST['usersForm'])){
        $form = $_POST['usersForm'];
    }

    switch($form){
        case 'signin':
            $recordar = isset($_POST['signinRemember']) ? $_POST['signinRemember'] : "false";
        
            Conexion::abrir_conexion();
            $validador = new ValidadorLogin($_POST['signinEmail'], $_POST['signinPassword'], Conexion::obtener_conexion());
            Conexion::cerrar_conexion();
            
            if($validador -> obtener_error() === 1 && !is_null($validador -> obtener_usuario()) && $validador -> obtener_tipo() === 'administrador'){
                
                ControlSesion::iniciar_sesion(
                    $validador -> obtener_usuario() -> getId_administrador(),
                    $validador -> obtener_usuario() -> getAdm_usuario()
                );
                
                $datos['status']= 1;
        
            }
            if($validador -> obtener_error() === 1 && !is_null($validador -> obtener_usuario()) && $validador -> obtener_tipo() === 'usuario'){
                //iniciar sesion
                Conexion::abrir_conexion();
                if(RepositorioUsuario::firstLogin(Conexion::obtener_conexion(), $_POST['signinEmail'])){
                    $datos['firstlogin'] = 1;//alan
                }else{
                    ControlSesion::iniciar_sesion(
                        $validador -> obtener_usuario() -> getId_usuario(),
                        $validador ->obtener_usuario() -> getUs_usuario()
                    );
                }
                Conexion::cerrar_conexion();
                
                $datos['status']= 1;
        
            }
            
            if($validador -> obtener_error() === 0){
                $datos['status'] = 0;
        
            }
            
            if($datos['status'] !== 0 && $recordar === 'true'){
                ControlCookie::iniciar_cookie_sesion($_SESSION['id_usuario'],$_SESSION['nombre_usuario']);
            }
            
            echo json_encode($datos);
        break;
        case 'request':
            $email = isset($_POST['requestEmail']) ? $_POST['requestEmail'] : "false";
            $alan['status'] = 0;
            Conexion::abrir_conexion();
    
            if(RepositorioUsuario::email_existe(Conexion::obtener_conexion(),$email)){
                if(RepositorioUsuario::usuario_activo(Conexion::obtener_conexion(), $email)){
                    function pinRand($long){ 
                        $num = "0123456789";
                        $cantCaracter = strlen($num);
                        $pin = '';
                        
                        for($i= 0; $i < $long; $i++){
                            $pin .= $num[rand(0, $cantCaracter - 1)];
                        }
                        return $pin;
                    }
                    $objUser = RepositorioUsuario::obtener_usuario_por_email(Conexion::obtener_conexion(),$email);
                    $pin = pinRand(6);
                    if(emails::enviar_pin($pin,$objUser)){
                        $expired = 0;
                        if(RepositorioRecuperacionClave::generar_peticion(Conexion::obtener_conexion(), $objUser -> getId_usuario(), $pin, $expired)){
                            $alan['status'] = 1;
                        }
                    }
                }    
            }
    
            Conexion::cerrar_conexion();
    
            echo json_encode($alan);
        break;
        case 'requestPin':
            $email = isset($_POST['requestEmail']) ? $_POST['requestEmail'] : "false";
            $pin = isset($_POST['requestPin']) ? $_POST['requestPin'] : "false";
            $alan['status'] = 0;
            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fechaPin = RepositorioRecuperacionClave::obtener_fecha_por_pin_unix($conexion,$pin);
            $df= time() - ($fechaPin + 10800);
            
            if(RepositorioUsuario::email_existe($conexion,$email)){
                if(RepositorioUsuario::usuario_activo($conexion, $email)){
                    if($df <= 120 && RepositorioRecuperacionClave::comprobar_expiracion($conexion, $pin)){    
                        if(!is_null($id_usuario = RepositorioRecuperacionClave::obtener_id_usuario_por_url_secreta($conexion, $pin))){
    
                            if(!is_null(RepositorioUsuario::obtener_usuario_por_id($conexion, $id_usuario))){
    
                                $alan['status'] = 1;
    
                            }
                        }
                    }
                    $objUser = RepositorioUsuario::obtener_usuario_por_email($conexion, $email);
                    $expired = 1;
                    $pin_estado = RepositorioRecuperacionClave::modificar_pin_estado($conexion, $expired, $objUser -> getId_usuario(), $pin);
                }     
            }
            echo json_encode($alan);
        break;
        case 'change':
            $email = isset($_POST['changeEmail']) ? $_POST['changeEmail'] : "false";
            $pass1 = isset($_POST['changePassword']) ? $_POST['changePassword'] : null;
            $pass2 = isset($_POST['changePassword2']) ? $_POST['changePassword2'] : null;
            $alan['status'] = 0;
            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();
            if(RepositorioUsuario::email_existe($conexion ,$email)){
                if(RepositorioUsuario::usuario_activo($conexion , $email)){
                    $validadorClave = new ValidadorClave($pass1, $pass2);
                    if($validadorClave -> obtener_error() === 1 && !is_null($validadorClave -> obtener_error())){//pass validados
                        $objUser = RepositorioUsuario::obtener_usuario_por_email($conexion , $email);
    
                        $clave_cifrada = password_hash($pass1, PASSWORD_DEFAULT, array("cost"=> 10) );
                        $clave_actualizada = RepositorioUsuario :: actualizar_clave($conexion , $objUser -> getId_usuario(), $clave_cifrada);
                        
                            if($clave_actualizada){
                                $firstlogin= 0;
                                RepositorioUsuario::modificar_firstlogin($conexion , $firstlogin, $email);
                                $alan['status'] = 1;
                            }       
                    }
                }    
            }
            
            echo json_encode($alan);
        break;
        case 'contrato_alta':
            ControlSesion::sesion_iniciada();
            $alan['status'] = 0;
            $desc = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : null;
            $maxUser = isset($_POST['maxUser']) ? $_POST['maxUser'] : null;
            $meses = isset($_POST['meses']) ? $_POST['meses'] : null;
            //-------------------------------------------------------insercion-------------------
            Conexion::abrir_conexion();
            $validador = new ValidadorContratos(
                        $desc, $precio, $maxUser, $meses, 
                        Conexion::obtener_conexion()
                        );
            //si valido todo ok
            if($validador -> registro_Valido()){
                $contrato = new Contrato('', $validador -> getDesc(),
                                            $validador -> getPrecio(),
                                            $validador -> getMaxUser(),
                                            $validador -> getDuracionMeses()
                                        );
                $insertado = RepositorioContrato::insertarContrato(Conexion::obtener_conexion(), $contrato);
                if($insertado){
                    $administrador_id = $_SESSION['id_usuario'];
                    $contrato_id= RepositorioContrato::obtener_id(Conexion::obtener_conexion(), $validador -> getDesc());
                    $fecha = fechaActual();
                    $abm_contratos = new AbmContratos('', $administrador_id, $contrato_id, 'ALTA', $fecha);
                    $insertado2 = RepositorioAbmContratos::insertarAbmContratos(Conexion::obtener_conexion(),$abm_contratos);
                    
                    $alan['status'] = 1;
                }
            }else{
                $err = array(
                    'descripcion' => $validador -> getErrorDesc(),
                    'precio' => $validador -> getErrorPrecio(),
                    'maxUser' => $validador ->getErrorMaxUser(),
                    'meses' => $validador -> getErrorDuracionMeses()
                );
            }
            Conexion::cerrar_conexion();
            if($alan['status'] === 0){
                foreach($err as $clave => $valor){
                    if($valor === 0){
                        $alan[$clave] = $valor;
                    }
                }
            }
            echo json_encode($alan);

        break;
        case 'form-new-empresa':
            ControlSesion::sesion_iniciada();
            $json['status'] = 0;

            foreach($_POST as $key => $value){
                $objForm[$key] = isset($value) && !empty($value) ? $value : null;
            }
            
            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();
            $validador = new ValidadorAltaEmpresas($objForm['ne-razon'],$objForm['ne-cuit'], 
                                                    $objForm['ne-street'], $objForm['ne-number'], 
                                                    $objForm['ne-floor'], $objForm['ne-department'], 
                                                    $objForm['ne-city'], $objForm['ne-country'], 
                                                    $objForm['ne-cp'], $objForm['ne-phone'], 
                                                    $objForm['ne-email'], $objForm['ne-active'], 
                                                    $objForm['ne-contract'], $conexion);
            
            
            if($validador -> registro_valido()){
                $accion= 'ALTA';
                $_empresa = new Empresa('', $validador -> getRazonsocial(), $validador -> getCuit(),$validador -> getCalle(), $validador -> getAltura(), $validador -> getPiso(),
                $validador -> getDpto(), $validador -> getCiudad(), $validador -> getPais(), $validador -> getCp(), $validador -> getTel(), $validador -> getEmail(),
                $validador -> getActivo(), $validador -> getContrato_id());
                
                if(RepositorioEmpresa::insertarEmpresa($conexion, $_empresa)){
                    emails::aviso_alta_empresa($_empresa);
                    $json['status'] = procesoAbmEmpresas($conexion, $accion, $_empresa -> getEm_cuit()) ? 1 : 0;

                }
                
            }
            
            $error = array(
                'ne-razon' => $validador -> getError_razonsocial(),
                'ne-cuit' => $validador -> getError_cuit(),
                'ne-street' => $validador -> getError_calle(),
                'ne-number' => $validador -> getError_altura(),
                'ne-floor' => $validador -> getError_piso(),
                'ne-department' => $validador -> getError_dpto(),
                'ne-city' => $validador -> getError_ciudad(),
                'ne-country' => $validador -> getError_pais(),
                'ne-cp' => $validador -> getError_cp(),
                'ne-phone' => $validador -> getError_tel(),
                'ne-email' => $validador -> getError_email(),
                'ne-active' => $validador -> getError_activo(),
                'ne-contract' => $validador -> getError_contrato_id()
            );
            foreach($error as $key => $value){
                $json[$key] = $value;
            }
            echo json_encode($json);
        break;
        case 'form-del-empresa':
            ControlSesion::sesion_iniciada();
            $json['form'] = 'form-del-empresa';
            $json['status'] = 0;
            
            $check = isset($_POST['empresa-check']) && !empty($_POST['empresa-check']) ? $_POST['empresa-check'] : null;
            $activo = isset($_POST['de-active']) ? $_POST['de-active'] : null;

            
            if($check !== null){
                ControlSesion::datito($check);
            }

            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();

            if(RepositorioEmpresa::razonSocialExiste($conexion, $check)){
                $json['status'] = 1;
                $_empresa = RepositorioEmpresa::obtener_objEmpresa($conexion, $check);
                
                $json['de-razon'] = $_empresa -> getEm_razonsocial();
                $json['de-cuit'] = $_empresa -> getEm_cuit();
                $json['de-street'] = $_empresa -> getEm_calle();
                $json['de-number'] = $_empresa -> getEm_altura();
                $json['de-floor'] = $_empresa -> getEm_piso();
                $json['de-department'] = $_empresa -> getEm_dpto();
                $json['de-city'] = $_empresa -> getEm_ciudad();
                $json['de-country'] = $_empresa -> getEm_pais();
                $json['de-cp'] = $_empresa -> getEm_cp();
                $json['de-phone'] = $_empresa -> getEm_tel();
                $json['de-email'] = $_empresa -> getEm_email();
                $json['de-active'] = $_empresa -> getEm_activo();
                $json['de-contract'] = $_empresa -> getContrato_id();

            }
            
            if($check === null){
                $_empresaBd = RepositorioEmpresa::obtener_objEmpresa($conexion, $_SESSION['data']);
                if($activo == '0'){
                    $accion = 'BAJA';
                    if(RepositorioEmpresa::empresa_activa_por_razon($conexion,$_SESSION['data'])){            
                        if(RepositorioEmpresa::empresaSetActivo($conexion, $_SESSION['data'], $activo)){
                            
                            $_abm_empresa = new AbmEmpresas('', $_SESSION['id_usuario'], $_empresaBd -> getId_empresa(), $accion, fechaActual());
                            
                            $json['status'] = RepositorioAbmEmpresas::insertarAbmEmpresas($conexion,$_abm_empresa) ? 1 : 0;

                            
                        }
                    }
                }
                ControlSesion::destruirDatito();
            }

            echo json_encode($json);
        break;
        case 'form-mod-empresa':
            ControlSesion::sesion_iniciada();
            $json['form'] = 'form-mod-empresa';
            $json['status'] = 0;
            foreach($_POST as $key => $value){
                $dataFront[$key] = isset($value) && !empty($value) ? $value : null;
            }
            if($dataFront['empresa-check'] !== null){
                ControlSesion::datito($dataFront['empresa-check']);
            }
            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();

            if(RepositorioEmpresa::razonSocialExiste($conexion, $dataFront['empresa-check'])){
                $json['status'] = 1;
                $_empresa = RepositorioEmpresa::obtener_objEmpresa($conexion, $dataFront['empresa-check']);
                
                $json['me-razon'] = $_empresa -> getEm_razonsocial();
                $json['me-cuit'] = $_empresa -> getEm_cuit();
                $json['me-street'] = $_empresa -> getEm_calle();
                $json['me-number'] = $_empresa -> getEm_altura();
                $json['me-floor'] = $_empresa -> getEm_piso();
                $json['me-department'] = $_empresa -> getEm_dpto();
                $json['me-city'] = $_empresa -> getEm_ciudad();
                $json['me-country'] = $_empresa -> getEm_pais();
                $json['me-cp'] = $_empresa -> getEm_cp();
                $json['me-phone'] = $_empresa -> getEm_tel();
                $json['me-email'] = $_empresa -> getEm_email();
                $json['me-active'] = $_empresa -> getEm_activo();
                $json['me-contract'] = $_empresa -> getContrato_id();

            }
            
            if($dataFront['empresa-check'] === null && isset($_SESSION['data'])){

                $_empresaBd = RepositorioEmpresa::obtener_objEmpresa($conexion, $_SESSION['data']);
                
                foreach($_POST as $key => $value){
                    $dataFront[$key] = isset($value) && !empty($value) ? $value : null;
                }
                $validador = new ValidadorModificarEmpresa($_empresaBd, $conexion, $dataFront['me-razon'], $dataFront['me-cuit'], 
                $dataFront['me-street'], $dataFront['me-number'], $dataFront['me-floor'], $dataFront['me-department'], 
                $dataFront['me-city'], $dataFront['me-country'], $dataFront['me-cp'], $dataFront['me-phone'], $dataFront['me-email'], 
                $dataFront['me-active'], $dataFront['me-contract']);

                if($validador -> existe_cambio()){
                    if($validador -> registro_valido()){

                        $accion="MODIFICADO";
                        $_empresa = new Empresa('',$validador -> getrazonsocial(), $validador -> getcuit(),
                        $validador -> getcalle(), $validador -> getaltura(), $validador -> getpiso(), $validador -> getdpto(),
                        $validador -> getciudad(), $validador -> getpais(), $validador -> getcp(), $validador -> gettel(),
                        $validador -> getemail(), $validador -> getactivo(), $validador -> getContrato_id());
                        
                        $empresaModify = RepositorioEmpresa:: update_empresa_id($conexion, $_empresaBd -> getId_empresa(), $_empresa);
                        if($empresaModify){

                            $_abm_empresa = new AbmEmpresas('', $_SESSION['id_usuario'], $_empresaBd -> getId_empresa(), $accion, fechaActual());
                            
                            if(RepositorioAbmEmpresas::insertarAbmEmpresas($conexion, $_abm_empresa)){
                                
                                if($_empresaBd -> getEM_Activo() == '0'){
                                    emails::aviso_alta_empresa($_empresa);
                                }else{
                                    emails::aviso_modificado_empresa($_empresa);
                                }
                                $json['status'] = 1;
                                
                            }
                        }
                    }else{
                        $err = array(
                            'me-razon' => $validador -> getError_razonsocial(),
                            'me-cuit' => $validador -> getError_cuit(),
                            'me-street' => $validador -> getError_calle(),
                            'me-number' => $validador -> getError_altura(),
                            'me-floor' => $validador -> getError_piso(),
                            'me-department' => $validador -> getError_dpto(),
                            'me-city' => $validador -> getError_ciudad(),
                            'me-country' => $validador -> getError_pais(),
                            'me-cp' => $validador -> getError_cp(),
                            'me-phone' => $validador -> getError_tel(),
                            'me-email' => $validador -> getError_email(),
                            'me-active' => $validador -> getError_activo(),
                            'me-contract' => $validador -> getError_contrato_id()
                        );
                        foreach($err as $key => $value){
                            $json[$key] = $value;
                        }
                    }
                }else{
                    $json['status'] = 1;
                }
                ControlSesion::destruirDatito();
            }

            echo json_encode($json);

        break;
        case 'form-new-user':
            ControlSesion::sesion_iniciada();
            $alan['status'] = 0;
            
            foreach($_POST as $key => $value){

                $objForm[$key] = isset($value) && !empty($value) ? $value : null;

                if(substr($key, 2, 6) === '-perm-'){
                    $checks [] = substr($key,8) . ':' . $value;  
                }
                
                if($key === 'usersForm'){
                    $alan[$key] = $value; 
                }
            }
            
            $permiso = isset($checks) ? implode(',', $checks) : null;
            
            Conexion::abrir_conexion();
            $conexion= Conexion::obtener_conexion();
            Conexion::cerrar_conexion();
            $validador = new ValidadorRegistro($objForm['nu-name'], $objForm['nu-lastname'], $objForm['nu-username'], $objForm['nu-email'], $objForm['nu-birth'],
                                                $objForm['nu-dni'], $objForm['nu-sex'], $objForm['nu-street'], $objForm['nu-number'], $objForm['nu-floor'], 
                                                $objForm['nu-department'], $objForm['nu-city'], $objForm['nu-country'], $objForm['nu-password'], $objForm['nu-password2'], 
                                                $permiso, $objForm['nu-company'], $objForm['nu-companyid'], $objForm['nu-active'], $conexion
                                              );
            
            //la empresa existe en el validador lo confirmo!!!
            if($validador -> registro_valido()){

                $maxUser = RepositorioEmpresa::max_usuarios_contrato($conexion,$validador->getempresa_id());
                $cantUser = RepositorioEmpresa::cantidad_usuarios_empresaid($conexion, $validador ->getempresa_id());
                $empresaActiva = RepositorioEmpresa:: empresa_activa($conexion, $validador -> getEmpresa_id());
                if($cantUser < $maxUser && $empresaActiva){// maximo de usuarios x empresas y empresa activa

                    $firstlogin = 1;
                    $accion="ALTA";

                    $usuario = new Usuario(
                                            '',$validador -> getNombre(), $validador -> getApellido(),
                                               $validador -> getUsuario(),$validador -> getEmail(),
                                               $validador -> getFecha(), $validador -> getDni(),
                                               $validador -> getSexo(), $validador -> getCalle(),
                                               $validador -> getAltura(), $validador -> getPiso(),
                                               $validador -> getDpto(), $validador -> getCiudad(), $validador -> getPais(),
                                               password_hash($validador ->getContrasena(), PASSWORD_DEFAULT, array("cost"=> 10)),
                                               $validador -> getPermiso(), $validador -> getActivo(), $firstlogin, $validador -> getEmpresa_id()
                                          );
                    
                    $userInsert = RepositorioUsuario :: insertarUsuario($conexion, $usuario);
                    if($userInsert){

                        $abm_usuarios_insertado = procesoAbmUsuarios($conexion,$accion, $usuario -> getUs_dni(),$usuario -> getEmpresa_id());
                        if($abm_usuarios_insertado && emails::aviso_alta_usuario($usuario)){

                            $alan['status'] = 1;

                        }
                    }
                }
            }
                $error = array(
                    'nu-name' => $validador -> getErrorNombre(),
                    'nu-lastname' => $validador -> getErrorApellido(),
                    'nu-username' => $validador -> getErrorUsuario(),
                    'nu-email' => $validador -> getErrorEmail(),
                    'nu-birth' => $validador -> getErrorFecha(),
                    'nu-dni' => $validador -> getErrorDni(),
                    'nu-sex' => $validador -> getErrorSexo(),
                    'nu-password' => $validador -> getErrorContrasena(),
                    'nu-password2' => $validador -> getErrorContrasena2(),
                    'nu-street' => $validador -> getErrorCalle(),
                    'nu-number' => $validador -> getErrorAltura(),
                    'nu-floor' => $validador -> getErrorPiso(),
                    'nu-department' => $validador -> getErrorDpto(),
                    'nu-city' => $validador -> getErrorCiudad(),
                    'nu-country' => $validador -> getErrorPais(),
                    'nu-perm-1' => $validador -> getErrorPermiso(),
                    'nu-perm-2' => $validador -> getErrorPermiso(),
                    'nu-perm-3' => $validador -> getErrorPermiso(),
                    'nu-perm-4' => $validador -> getErrorPermiso(),
                    'nu-perm-5' => $validador -> getErrorPermiso(),
                    'nu-perm-6' => $validador -> getErrorPermiso(),
                    'nu-company' => $validador -> getErrorEmpresa(),
                    'nu-companyid' => $validador -> getErrorEmpresa_id(),
                    'nu-active' => $validador -> getErrorActivo()
                  );


            foreach($error as $clave => $valor){
                $alan[$clave] = $valor;
            }
           
            echo json_encode($alan);

        break;
        case 'form-del-user':
            ControlSesion::sesion_iniciada();
            $json['form'] = 'form-del-user';
            $search = isset($_POST['dni-check']) && !empty($_POST['dni-check'])  ? $_POST['dni-check'] : null;
            $activo = isset($_POST['du-active']) ? $_POST['du-active'] : null;
            if($search !== null){
                ControlSesion::datito($search); //no viste nada guiño guiño
            }
            
            
            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();
            if(RepositorioUsuario::dni_existe($conexion, $search)){
                    $json['status'] = 1;
                    $resultado = RepositorioUsuario::buscar_usuarios_dni($conexion, $search);
                    $empresaName = RepositorioEmpresa::obtener_nombre_empresa($conexion, $resultado -> getEmpresa_id());
                
                $array = checkMostrar('du-perm-', $resultado -> getUs_permiso());
                
                foreach($array as $key => $value){
                    $json[$key] = $value;
                }

                if($resultado -> getUs_sexo() === 'M'){
                    $sex = '1';
                }else{
                    $sex = '0';
                }
                
                $json['du-name'] = $resultado ->getUs_nombre();
                $json['du-lastname'] = $resultado ->getUs_apellido();
                $json['du-username'] = $resultado -> getUs_usuario();
                $json['du-email'] = $resultado -> getUs_email();
                $json['du-birth'] = $resultado -> getUs_fecha();
                $json['du-dni'] = $resultado -> getUs_dni();
                $json['du-password'] = $resultado -> getUs_contrasena();
                $json['du-password2'] = $resultado -> getUs_contrasena();
                $json['du-street'] = $resultado -> getUs_calle();
                $json['du-number'] = $resultado -> getUs_altura();
                $json['du-floor'] = $resultado -> getUs_piso();
                $json['du-department'] = $resultado -> getUs_dpto();
                $json['du-city'] = $resultado -> getUs_ciudad();
                $json['du-country'] = $resultado -> getUs_pais();
                $json['du-companyid'] = $resultado -> getEmpresa_id();
                $json['du-active'] = $resultado -> getUs_Activo();
                $json['du-company'] = $empresaName;
            }
            
            if($search === null){
                
                if($activo === '0'){
                    $accion = 'BAJA';
                    
                    if(RepositorioUsuario::usuario_activo_por_dni($conexion,$_SESSION['data'])){    //si el usuario activo osea 1 true          
                        if(RepositorioUsuario::usuarioSetActivo($conexion,$_SESSION['data'],$activo)){
                            $empresa_id = RepositorioUsuario::obtener_empresaid_dni($conexion, $_SESSION['data']);
                            $json['status'] = procesoAbmUsuarios($conexion,$accion,$_SESSION['data'],$empresa_id) ? 1 : 0;
                            
                        }
                    } 
                }
                ControlSesion::destruirDatito();
            }
            
            echo json_encode($json);
    
        break;
        case 'form-mod-user':
            ControlSesion::sesion_iniciada();
            $json['form'] = 'form-mod-user';
            $json['status'] = 0;
            $search = isset($_POST['dni-check']) && !empty($_POST['dni-check'])  ? $_POST['dni-check'] : null;

            if($search !== null){
                ControlSesion::datito($search); //no viste nada guiño guiño
            }

            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();

            if(RepositorioUsuario::dni_existe($conexion, $search)){
                $json['status'] = 1;
                $resultado = RepositorioUsuario::buscar_usuarios_dni($conexion, $search);
                $empresaName = RepositorioEmpresa::obtener_nombre_empresa($conexion, $resultado -> getEmpresa_id());

                $array = checkMostrar('mu-perm-', $resultado -> getUs_permiso());
                
                foreach($array as $key => $value){
                    $json[$key] = $value;
                }
                
                if($resultado -> getUs_sexo() === 'M'){
                    $json['mu-sex'] = $sex = '1';
                }else{
                    $json['mu-sex'] = $sex = '0';
                }
                    $json['mu-name'] = $resultado ->getUs_nombre();
                    $json['mu-lastname'] = $resultado ->getUs_apellido();
                    $json['mu-username'] = $resultado -> getUs_usuario();
                    $json['mu-email'] = $resultado -> getUs_email();
                    $json['mu-birth'] = $resultado -> getUs_fecha();
                    $json['mu-dni'] = $resultado -> getUs_dni();
                    $json['mu-password'] = $resultado -> getUs_contrasena();
                    $json['mu-password2'] = $resultado -> getUs_contrasena();
                    $json['mu-street'] = $resultado -> getUs_calle();
                    $json['mu-number'] = $resultado -> getUs_altura();
                    $json['mu-floor'] = $resultado -> getUs_piso();
                    $json['mu-department'] = $resultado -> getUs_dpto();
                    $json['mu-city'] = $resultado -> getUs_ciudad();
                    $json['mu-country'] = $resultado -> getUs_pais();
                    $json['mu-companyid'] = $resultado -> getEmpresa_id();
                    $json['mu-active'] = $resultado -> getUs_Activo();
                    $json['mu-company'] = $empresaName;
                    $json['dni-check'] = $search;
                   
            }
            //-----------------------------------------------------------------------------------------------------
            if($search === null && isset($_SESSION['data'])){
                
                $usuarioBd = RepositorioUsuario::buscar_usuarios_dni($conexion, $_SESSION['data']);
                
                foreach($_POST as $key => $value){
                    $objForm[$key] = isset($value) && !empty($value) ? $value : null;

                    if(substr($key, 2, 6) === '-perm-'){
                        $checks [] = substr($key,8) . ':' . $value; 
                    }

                }
                
                $permiso = isset($checks) ? implode(',', $checks) : null;
                
                if($objForm['mu-sex'] == 1){
                    $objForm['mu-sex'] = 'M';
                }else{
                    $objForm['mu-sex'] = 'F';
                }
                
                $validador = new ValidadorModificarUsuario($objForm['mu-name'], $objForm['mu-lastname'], $objForm['mu-username'], $objForm['mu-email'], $objForm['mu-birth'],
                $objForm['mu-dni'], $objForm['mu-sex'], $objForm['mu-street'], $objForm['mu-number'], $objForm['mu-floor'], 
                $objForm['mu-department'], $objForm['mu-city'], $objForm['mu-country'], $objForm['mu-password'], $objForm['mu-password2'], 
                $permiso, $objForm['mu-company'], $objForm['mu-companyid'], $objForm['mu-active'], $usuarioBd,$conexion
                );
            
                if($validador -> existe_cambio()){
                    
                    if($validador -> registro_valido()){
                        
                        $maxUser = RepositorioEmpresa::max_usuarios_contrato($conexion,$validador->getEmpresa_id());
                        $cantUser = RepositorioEmpresa::cantidad_usuarios_empresaid($conexion, $validador ->getEmpresa_id());
                        $empresaActiva = RepositorioEmpresa:: empresa_activa($conexion, $validador -> getEmpresa_id());
                        
                        if($cantUser < $maxUser && $empresaActiva){
                            
                            if($usuarioBd -> getUs_activo() == 0){  // si el usuario esta en 0 quiere decir que tuvo q ver sido activado.
                                $firstlogin = 1;
                            }else{
                                $firstlogin = 0;
                            }  

                            $accion="MODIFICADO";

                            $objUser = new Usuario(
                                                    '',$validador -> getNombre(), $validador -> getApellido(),
                                                    $validador -> getUsuario(),$validador -> getEmail(),
                                                    $validador -> getFecha(), $validador -> getDni(),
                                                    $validador -> getSexo(), $validador -> getCalle(),
                                                    $validador -> getAltura(), $validador -> getPiso(),
                                                    $validador -> getDpto(), $validador -> getCiudad(), $validador -> getPais(),
                                                    password_hash($validador ->getContrasena(), PASSWORD_DEFAULT, array("cost"=> 10)),
                                                    $validador -> getPermiso(), $validador -> getActivo(), $firstlogin, $validador -> getEmpresa_id()
                                                );
                                                 
                            $userModify = RepositorioUsuario::update_usuario_por_dni($conexion,$objUser,$_SESSION['data']);
                            
                            if($userModify){

                                $abm_usuarios_insertado = procesoAbmUsuarios($conexion,$accion, $objUser -> getUs_dni(), $objUser -> getEmpresa_id());
                                if($abm_usuarios_insertado){
                                    
                                    if($usuarioBd -> getUs_Activo() == '0'){
                                        
                                        emails::aviso_alta_usuario($objUser); //el usuario es avisado q fue dado de alta nuevamente
                                        
                                    }else{
                                        
                                        emails::aviso_modificado_usuario($objUser);
                                        
                                    }
                                    
                                    $json['status'] = 1;
                                    
                                    
                                }
                            }                                     
                                            
                        }

                    }else{
                        
                        $error = array(
                            'mu-name' => $validador -> getErrorNombre(),
                            'mu-lastname' => $validador -> getErrorApellido(),
                            'mu-username' => $validador -> getErrorUsuario(),
                            'mu-email' => $validador -> getErrorEmail(),
                            'mu-birth' => $validador -> getErrorFecha(),
                            'mu-dni' => $validador -> getErrorDni(),
                            'mu-sex' => $validador -> getErrorSexo(),
                            'mu-password' => $validador -> getErrorContrasena(),
                            'mu-password2' => $validador -> getErrorContrasena2(),
                            'mu-street' => $validador -> getErrorCalle(),
                            'mu-number' => $validador -> getErrorAltura(),
                            'mu-floor' => $validador -> getErrorPiso(),
                            'mu-department' => $validador -> getErrorDpto(),
                            'mu-city' => $validador -> getErrorCiudad(),
                            'mu-country' => $validador -> getErrorPais(),
                            'mu-perm-1' => $validador -> getErrorPermiso(),
                            'mu-perm-2' => $validador -> getErrorPermiso(),
                            'mu-perm-3' => $validador -> getErrorPermiso(),
                            'mu-perm-4' => $validador -> getErrorPermiso(),
                            'mu-perm-5' => $validador -> getErrorPermiso(),
                            'mu-perm-6' => $validador -> getErrorPermiso(),
                            'mu-company' => $validador -> getErrorEmpresa(),
                            'mu-companyid' => $validador -> getErrorEmpresa_id(),
                            'mu-active' => $validador -> getErrorActivo()
                        );
                        $json['status'] = 0;
                        foreach($error as $clave => $valor){
                            $json[$clave] = $valor;
                        }
                    }
                    
                }else{
                    $json['status'] = 1;
                }
                ControlSesion::destruirDatito();
            }
            
            echo json_encode($json);
            
        break;
        case 'form-check-user':
            $json['form'] = 'form-check-user';
            $json['status'] = 0;
            $search = isset($_POST['dni-check']) ? $_POST['dni-check'] : null;
            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();
            if(repositorioUsuario::dni_existe($conexion, $search)){
                $resultado = RepositorioUsuario::buscar_usuarios_dni($conexion, $search);
                $empresaName = RepositorioEmpresa::obtener_nombre_empresa($conexion, $resultado -> getEmpresa_id());
                
                $array=checkMostrar('cu-perm-', $resultado -> getUs_permiso());
                
                foreach($array as $key => $value){
                    $json[$key] = $value;
                }
                
                if($resultado -> getUs_sexo() === 'M'){
                    $json['cu-sex'] = $sex = '1';
                }else{
                    $json['cu-sex'] = $sex = '0';
                }
                    $json['cu-name'] = $resultado ->getUs_nombre();
                    $json['cu-lastname'] = $resultado ->getUs_apellido();
                    $json['cu-username'] = $resultado -> getUs_usuario();
                    $json['cu-email'] = $resultado -> getUs_email();
                    $json['cu-birth'] = $resultado -> getUs_fecha();
                    $json['cu-dni'] = $resultado -> getUs_dni();
                    $json['cu-password'] = $resultado -> getUs_contrasena();
                    $json['cu-password2'] = $resultado -> getUs_contrasena();
                    $json['cu-street'] = $resultado -> getUs_calle();
                    $json['cu-number'] = $resultado -> getUs_altura();
                    $json['cu-floor'] = $resultado -> getUs_piso();
                    $json['cu-department'] = $resultado -> getUs_dpto();
                    $json['cu-city'] = $resultado -> getUs_ciudad();
                    $json['cu-country'] = $resultado -> getUs_pais();
                    $json['cu-companyid'] = $resultado -> getEmpresa_id();
                    $json['cu-active'] = $resultado -> getUs_Activo();
                    $json['cu-company'] = $empresaName;
                    $json['status'] = 1;
            }
            
            sleep(1);
            echo json_encode($json);

        break;
        case 'form-liendro':
            $json['status'] = 0;
            foreach($_POST as $key => $value){
                $objForm[$key] = isset($value) && !empty($value) ? $value : null;
            }
            Conexion::abrir_conexion();
            $conexion = Conexion::obtener_conexion();
            Conexion::cerrar_conexion();
            $_validado = new ValidadorAltaEmpresas($objForm['le-razon'],$objForm['le-cuit'], 
                                                    $objForm['le-street'], $objForm['le-number'], 
                                                    $objForm['le-floor'], $objForm['le-department'], 
                                                    $objForm['le-city'], $objForm['le-country'], 
                                                    $objForm['le-cp'], $objForm['le-phone'], 
                                                    $objForm['le-email'], 1, 
                                                    $objForm['le-contract'], $conexion);
            if($_validado -> registro_valido()){
                emails::aviso_nueva_empresa($_validado);
                $json['status'] = 1;
            }
            
            $json['le-razon'] = $_validado -> getError_razonsocial();
            $json['le-cuit'] = $_validado -> getError_cuit();
            $json['le-street'] = $_validado -> getError_calle();
            $json['le-number'] = $_validado -> getError_altura();
            $json['le-floor'] = $_validado -> getError_piso();
            $json['le-department'] = $_validado -> getError_dpto();
            $json['le-city'] = $_validado -> getError_ciudad();
            $json['le-country'] = $_validado -> getError_pais();
            $json['le-cp'] = $_validado -> getError_cp();
            $json['le-phone'] = $_validado -> getError_tel();
            $json['le-email'] = $_validado -> getError_email();
            $json['le-active'] = $_validado -> getError_activo();
            $json['le-contract'] = $_validado -> getError_contrato_id();
            
            echo json_encode($json);                     
        break;
    }
    function fechaActual(){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = date('Y-m-d');
        return $date;
    }
    function checkMostrar($nameForm, $permisos){
        $a = explode(",", $permisos);
        
        foreach($a as $key => $value){
             $b[] = explode(':', $value);
        }
        foreach($b as $key => $value){
                $c[$nameForm . $value[0]] = (int)$value[1];
        }
        
        return $c;
    }
    function procesoAbmUsuarios($conexion,$accion,$dni,$empresa_id){
        $fechaActual = fechaActual();
        
        $id_administrador = $_SESSION['id_usuario'];
        
        $id_usuario = RepositorioUsuario :: obtener_id_usuario_por_dni($conexion, $dni);
        $abm_usuario = new AbmUsuarios('',$id_administrador, $id_usuario, $empresa_id, $accion, $fechaActual);
        if(RepositorioAbmUsuarios::insertarAbm($conexion, $abm_usuario)){
            return true;
        }else{
            return false;
        }
        
    }
    function procesoAbmEmpresas($conexion, $accion, $cuit){
        $fecha = fechaActual();
        $id_administrador = $_SESSION['id_usuario'];
        $empresa_id = RepositorioEmpresa::obtener_id_empresa_por_cuit($conexion, $cuit);
        $_abm_empresa = new AbmEmpresas('', $id_administrador, $empresa_id, $accion, $fecha);
        
        if(RepositorioAbmEmpresas::insertarAbmEmpresas($conexion,$_abm_empresa)){
            return true;
        }else{
            return false;
        }
    }
    
    
    

    