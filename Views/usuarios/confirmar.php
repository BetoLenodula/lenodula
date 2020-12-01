<?php 
	$res = $callback_datos;

	if($res == "true"){
		$res = "Ya confirmamos correctamente tu cuenta, puedes iniciar Sesión!!";
		include_once(MSG."advice.php");
	}
	else if($res == "false"){
		$res == "Algo falló al modificar el Token!!";
		include_once(MSG."error.php");
	}
	else{
		include_once(MSG."error.php");
	}

	include_once(INDEX);

 ?>