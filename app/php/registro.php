<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

include_once 'info.php';
// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$nUsr = (isset($_POST['nUsr'])) ? $_POST['nUsr'] : '';
$aUsr = (isset($_POST['aUsr'])) ? $_POST['aUsr'] : '';
$nCorreo = (isset($_POST['nCorreo'])) ? $_POST['nCorreo'] : '';
$passUsr = (isset($_POST['passUsr'])) ? $_POST['passUsr'] : '';


// Conexion a DB
$con = new SQLite3("../data/data.db");

if ($opcion === 1) {
	if($nUsr === '' || $aUsr === '' || $nCorreo === '' || $passUsr === ''){
		echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				Llena todos los campos
			</div>
			');
	}else{
		
		$usuarioCript = md5($nUsr);
		$correoCript = md5($nCorreo);
		$passCript = md5($passUsr);

		$nombreComUsr = $nUsr.' '.$aUsr;

		$varNavega = $info["browser"];	
		$varVersio = $info["version"];
		$varSitemaO = $info["os"];
		$fechaCap = date('d-m-Y');
		$horaCap = date('g:i:s a');
		$fechaHoraReg = $fechaCap . ' ' . $horaCap;

		
		$cs = $con -> query("SELECT correoMd5 FROM registroUsr WHERE correoMd5 = '$correoCript'");
	
		while ($resul = $cs -> fetchArray()) {
			$correoMd5 = $resul['correoMd5'];
		}
		
		$correoMd5 = (isset($correoMd5)) ?  $correoMd5 : '';

		if($correoMd5 === $correoCript){

			echo json_encode('
			<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
				¡Error! Correo registrado anteriormente
			</div>
			');

		}else{
			$cs = $con -> query("INSERT INTO registroUsr (nombre,apellido,nombreCom,userMd5,correo,correoMd5,password,passDecrypt,usrNavega,usrSO,usrVerSO,usrFechaHoraReg,tipoUsuario,usrActivo) VALUES('$nUsr','$aUsr','$nombreComUsr','$usuarioCript','$nCorreo','$correoCript','$passUsr','$passCript','$varNavega','$varVersio','$varSitemaO','$fechaHoraReg','0','1')");

			echo json_encode('correcto');
		}
	}
}else{
	echo json_encode('');
}

$con -> close();

 ?>