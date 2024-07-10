<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$txtBuscador = (isset($_POST['txtBuscador'])) ? $_POST['txtBuscador'] : '';

// Intradas del form
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$fechaRecarga = (isset($_POST['fechaRecarga'])) ? $_POST['fechaRecarga'] : '';
$registrado = (isset($_POST['registrado'])) ? $_POST['registrado'] : '';
$asignado = (isset($_POST['asignado'])) ? $_POST['asignado'] : '';
$numEmpRespAsig = (isset($_POST['numEmpRespAsig'])) ? $_POST['numEmpRespAsig'] : '';
$nomRespAsig = (isset($_POST['nomRespAsig'])) ? strtoupper($_POST['nomRespAsig']) : '';
$diviAsig = (isset($_POST['diviAsig'])) ? $_POST['diviAsig'] : '';
$numEmpRecib = (isset($_POST['numEmpRecib'])) ? $_POST['numEmpRecib'] : '';
$nombreRecib = (isset($_POST['nombreRecib'])) ? strtoupper($_POST['nombreRecib']) : '';
$fechaRecib = (isset($_POST['fechaRecib'])) ? $_POST['fechaRecib'] : '';

// Conexion a DB
$con = new SQLite3("../data/data.db") or die("Problemas para conectar");

// Opciones del CRUD
switch ($opcion) {
    // Insertar
    case 1 :
        
        break;
    // Actualizar
    case 2 :
        $cs = $con -> query("UPDATE controlTelefonos SET fechaRecarga = '$fechaRecarga', registrado = '$registrado', asignado = '$asignado', numEmpRespAsig = '$numEmpRespAsig', nomRespAsig = '$nomRespAsig', diviAsig = '$diviAsig', numEmpRecib = '$numEmpRecib', nombreRecib = '$nombreRecib', fechaRecib = '$fechaRecib' WHERE id = '$id'");
        break;
    // Leer
    case 4 :
        $cs = $con -> query("SELECT * FROM controlTelefonos WHERE id = '$txtBuscador'");
        $datos = array();
        $i = 0;

        while ($resul = $cs -> fetchArray()) {
            $datos[$i]['id'] = $resul['id'];
            $datos[$i]['marca'] = $resul['marca'];
            $datos[$i]['modelo'] = $resul['modelo'];
            $datos[$i]['sim'] = $resul['sim'];
            $datos[$i]['serie'] = $resul['serie'];
            $datos[$i]['imei1'] = $resul['imei1'];
            $datos[$i]['imei2'] = $resul['imei2'];
            $datos[$i]['numCompra'] = $resul['numCompra'];
            $datos[$i]['correo'] = $resul['correo'];
            $datos[$i]['pws'] = $resul['pws'];
            $datos[$i]['platafoma'] = $resul['platafoma'];
            $datos[$i]['link'] = $resul['link'];
            $datos[$i]['fechaRecarga'] = $resul['fechaRecarga'];
            $datos[$i]['registrado'] = $resul['registrado'];
            $datos[$i]['asignado'] = $resul['asignado'];
            $datos[$i]['numEmpRespAsig'] = $resul['numEmpRespAsig'];
            $datos[$i]['nomRespAsig'] = $resul['nomRespAsig'];
            $datos[$i]['diviAsig'] = $resul['diviAsig'];
            $datos[$i]['numEmpRecib'] = $resul['numEmpRecib'];
            $datos[$i]['nombreRecib'] = $resul['nombreRecib'];
            $datos[$i]['fechaRecib'] = $resul['fechaRecib'];
            $i++;
        
        }

        break;
}

$datos = (isset($datos) ? $datos : '');
echo json_encode($datos);

$con -> close();


?>