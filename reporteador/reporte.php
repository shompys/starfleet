<?php
require_once '../app/Conexion.inc.php';
require_once '../app/config.inc.php';
require_once '../app/RepositorioContrato.inc.php';
require_once '../app/Contrato.inc.php';
require_once 'ReporterV1.php';


$link = mysqli_connect(NOMBRE_SERVIDOR, NOMBRE_USUARIO, PASSWORD, NOMBRE_BD);

$reptype = isset($_GET['reptype']) && !empty($_GET['reptype']) ? $_GET['reptype'] : null;
$filter = '';

if(isset($_GET['rep-user-business'])){
    
    $activo = isset($_GET['rep-user-active']) && !empty($_GET['rep-user-active']) ? $_GET['rep-user-active'] : null;
    $filter = !empty($_GET['rep-user-business']) ? $_GET['rep-user-business'] : null;

    $miniQuerys = $filter != 'todas' ? " WHERE e.em_razonsocial = '$filter' " : '';

    $active = $activo != 'todos' ? " AND u.us_activo = '$activo' " : '' ;

    $mq = $miniQuerys . $active;

    $query = "SELECT u.id_usuario AS 'UID', u.us_nombre AS 'NOMBRE', u.us_apellido AS 'APELLIDO', u.us_usuario AS 'USUARIO', u.us_dni AS 'DNI', u.us_email AS 'EMAIL'
    FROM usuarios u 
    INNER JOIN empresas e ON u.empresa_id = e.id_empresa
    $mq
    ";
    
}else if(isset($_GET['rep-contract-type'])){
    
    $filter = !empty($_GET['rep-contract-type']) ? $_GET['rep-contract-type'] : null;

    $mq = $filter != 'todos' ? " WHERE con_descripcion = '$filter' " : '';

    $query = "SELECT id_contrato AS 'UID', con_precio AS 'PRECIO', con_maxusuarios AS 'MAX USUARIOS', con_duracionmeses AS 'MESES'
    FROM contratos
    $mq
    ";
    
}else if(isset($_GET['rep-business-contract'])){
    Conexion::abrir_conexion();
    $con =  Conexion::obtener_conexion();
    Conexion::cerrar_conexion();
    /*
    $activo = isset($_GET['rep-business-active']) && !empty($_GET['rep-business-active']) ? $_GET['rep-business-active'] : null;
    $filter = !empty($_GET['rep-business-contract']) ? $_GET['rep-business-contract'] : null;

    $miniQuerys = $filter != 'todos' ? " WHERE c.con_descripcion = '$filter' " : '';

    $active = $activo != 'todas' ? " AND e.em_activo = '$activo' " : '' ;

    $mq = $miniQuerys . $active;

    $query = "SELECT e.id_empresa AS 'EID', e.em_razonsocial AS 'RAZON SOCIAL', e.em_email AS 'EMAIL' 
    FROM empresas e 
    INNER JOIN contratos c ON e.contrato_id = c.id_contrato
    $mq
    ";
    */
    if($_GET['rep-business-contract'] != 'todos'){
        $_arr = RepositorioContrato::obtener_objContrato($con, $_GET['rep-business-contract']);
        $filter = $_arr -> getCon_descripcion();
    }else{
        $filter = $_GET['rep-business-contract'];
    }
    
    $active   = isset($_GET['rep-business-active']) && $_GET['rep-business-active'] !== '' && $_GET['rep-business-active'] !== 'todas' ? " AND e.em_activo = '" . $_GET['rep-business-active'] . "'" : '';
    $business = $_GET['rep-business-contract'] !== '' && $_GET['rep-business-contract'] != 'todos' ? " WHERE e.contrato_id = '" . $_GET['rep-business-contract'] . "'" : '';
    $params   = $business . $active;

    $query = "SELECT e.id_empresa AS 'EID', e.em_razonsocial AS 'RAZONSOCIAL', e.em_email AS 'EMAIL' 
    FROM empresas e 
    INNER JOIN contratos c ON e.contrato_id = c.id_contrato $params";
    
}

$title  = $reptype . ' (' . $filter . ')';
$file   = $filter . date('_dmYhis');


if(isset($_GET['gen']))
{
    switch($_GET['gen'])
    {
        case 'PDF':
            // PDF Gen Reporte
            $pdf = new ReporterV1();
            $pdf->AddPage("L","A4"); // Horizontal
            //$pdf->AddPage("P","A4"); // Vertical
            $pdf->Title($title);
            $pdf->Table($link, $query, array('HeaderColor' => array(52, 58, 64), 'HeaderFontColor' => array(255, 255, 255), 'color2' => array(235, 237, 239), 'RowFontColor' => array(0, 0, 0)));
            //$pdf->Output();
            $pdf->Output($file .'.pdf', 'D');
        break;

        case 'CSV':
            // CSV Gen Reporte
            $csv = new ReporterV1();
            $csv->CSV($link, $query, $file);
        break;
    }
}

//reporte.php?gen=PDF
//reporte.php?gen=CSV