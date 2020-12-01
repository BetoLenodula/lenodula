<?php 
	$res = $callback_datos;

	if($res == 'form'){
		include_once("templates/frmIngresoRegistro.php");
	}
	else if($res == 'signin'){
		$res = "Te registraste en el sistema! Te acabamos de enviar un enlace a tu CORREO para confirmar tu registro. Si no lo úbicas.. checa la bandeja de: (Correo No deseado, o SPAM!)";
		include_once(MSG."advice.php");
		include_once("templates/frmIngresoRegistro.php");
	}
	else{
		include_once(MSG."error.php");
		include_once("templates/frmIngresoRegistro.php");
	}

	include_once(MSG."alert.php");
	include_once(MSG."spinner.php");

 ?>

		