<?php
require_once '../app/Conexion.inc.php';
require_once '../app/config.inc.php';
require_once 'ReporterV1.php';
//header('Content-Type: application/json');
$link = mysqli_connect(NOMBRE_SERVIDOR, NOMBRE_USUARIO, PASSWORD, NOMBRE_BD);

$reptype = isset($_POST['reptype']) && !empty($_POST['reptype']) ? $_POST['reptype'] : null;
$json = array();
$filter = '';

    if(isset($_POST['rep-user-business'])){
        /*
        $activo = isset($_POST['rep-user-active']) && !empty($_POST['rep-user-active']) ? $_POST['rep-user-active'] : null;
        
        $filter = !empty($_POST['rep-user-business']) ? $_POST['rep-user-business'] : null;

        $miniQuerys = $filter !== 'todas' ? "e.em_razonsocial = '$filter' AND" : '';

        $active = $activo !== 'todos' ? "u.us_activo = '$activo'" : ''; 
        
        
        $query = "SELECT u.id_usuario AS 'UID', u.us_nombre AS 'NOMBRE', u.us_apellido AS 'APELLIDO', u.us_usuario AS 'USUARIO', u.us_dni AS 'DNI', u.us_email AS 'EMAIL'
        FROM usuarios u 
        INNER JOIN empresas e ON u.empresa_id = e.id_empresa
        WHERE $miniQuerys u.us_activo = '$activo'
        ";
        */
        
        /**
         * Jonax:
         * Ojo con usar este tipo de validación, ya que para el empty() no valida los ceros.-
         * Para validar ceros y que no esté vacía una variable, se usa este tipo: $_POST['rep-user-business'] !== '';
         * el comparador !== a diferencia de !=, hace una comparación a nivel binario, es decir, 'Todos' !== 'todos' devuelve true,
         * porque a nivel binario la 'T' es diferente a la 't'.-
         */

        $active   = isset($_POST['rep-user-active']) && $_POST['rep-user-active'] !== '' && $_POST['rep-user-active'] !== 'todos' ? " AND u.us_activo = '" . $_POST['rep-user-active'] . "'" : '';
        $business = $_POST['rep-user-business'] !== '' && $_POST['rep-user-business'] != 'todas' ? " WHERE e.em_razonsocial = '" . $_POST['rep-user-business'] . "'" : '';
        $params   =  $business . $active;
        
        $query = "SELECT u.id_usuario AS 'UID', u.us_nombre AS 'NOMBRE', u.us_apellido AS 'APELLIDO', u.us_usuario AS 'USUARIO', u.us_dni AS 'DNI', u.us_email AS 'EMAIL'
        FROM usuarios u 
        INNER JOIN empresas e ON u.empresa_id = e.id_empresa $params";
        
        $result = mysqli_query($link, $query);
 
        while($row = $result->fetch_assoc()){
            
            $json[] = $row;
        }
        
        echo json_encode($json);
        
    }else if(isset($_POST['rep-contract-type'])){
        /*
        $filter = !empty($_POST['rep-contract-type']) ? $_POST['rep-contract-type'] : null;
        */

        $business = $_POST['rep-contract-type'] !== '' && $_POST['rep-contract-type'] != 'todos' ? " WHERE con_descripcion = '" . $_POST['rep-contract-type'] . "'" : '';

        $query = "SELECT id_contrato AS 'CID', con_precio AS 'PRECIO', con_maxusuarios AS 'MAXUSUARIOS', con_duracionmeses AS 'MESES'
        FROM contratos $business
        ";
        
        $result = mysqli_query($link, $query);
  
        while($row = $result->fetch_assoc()){
            
            $json[] = $row;
        }

        
        echo json_encode($json);
        
    }else if(isset($_POST['rep-business-contract'])){
        /*
        $activo = isset($_POST['rep-business-active']) && !empty($_POST['rep-business-active']) ? $_POST['rep-business-active'] : null;
        $filter = !empty($_POST['rep-business-contract']) ? $_POST['rep-business-contract'] : null;
    
        $miniQuerys = $filter !== 'todas' ? "c.con_descripcion = '$filter' AND" : '';
        */

        $active = isset($_POST['rep-business-active']) && $_POST['rep-business-active'] !== '' && $_POST['rep-business-active'] !== 'todas' ? " AND e.em_activo = '" . $_POST['rep-business-active'] . "'" : '';
        $business = $_POST['rep-business-contract'] !== '' && $_POST['rep-business-contract'] != 'todos' ? " WHERE e.contrato_id = '" . $_POST['rep-business-contract'] . "'" : '';
        $params = $business . $active;


        $query = "SELECT e.id_empresa AS 'EID', e.em_razonsocial AS 'RAZONSOCIAL', e.em_email AS 'EMAIL' 
        FROM empresas e 
        INNER JOIN contratos c ON e.contrato_id = c.id_contrato $params";
        
        $result = mysqli_query($link, $query);

        while($row = $result->fetch_assoc()){
            
            $json[] = $row;
        }

        
        echo json_encode($json);
    
    }


