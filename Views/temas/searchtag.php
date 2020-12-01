<?php 
	
	if(!empty($callback_datos)){
		$id_usuario = $callback_datos[0]['ius'];
		$me = $callback_datos[0]['me'];
	}
	else{
		$id_usuario = null;
		$me = null;
	}

	if(!empty($callback_datos)){
		if(isset($_SESSION['userSesion'])){
			if($me != null || $id_usuario == $_SESSION['userSesion']['id']){
				$member = true;
			}
			else{
				$member = false;
			}
		}
	}
	else{
		$member = false;
	}

	include_once("templates/listarTemas.php");
	include_once(MSG."spinner.php");

 ?>