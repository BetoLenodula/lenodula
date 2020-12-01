<?php 
	$res = $callback_datos	;

	if(is_object($res)){
		$datos = $res->fetch_array();

		$idu = $datos['identificador_unico'];
		
		if(!empty($idu)){
			$ids = $datos['ids'];
			$nombre_user = $datos['nombre_user'];
			$foto = $datos['foto'];
			$nombres = $datos['nombres'];
			$apellidos = $datos['apellidos'];
			$email = $datos['email'];
			$rol = $datos['rol'];
			$t_resp = $datos['total_respuestas'];
			$t_punt = $datos['total_puntos'];
			$t_grat = $datos['total_gratificaciones'];
			$fecha_ing = $datos['fecha_ingreso'];
			$stars = 0;

			$stars = $controlador->funcion('stars_points', $t_punt);

			$cur = new Controllers\cursosController();
			$cur = $cur->avances($argumento);

			include_once("templates/editVerPerfil.php");
		}
		else{
			$res = "Usuario no existente en el sistema!!";
			include_once(MSG."error.php");
			include_once(INDEX);
		}
	}
	else{
		include_once(MSG."error.php");
		include_once(INDEX);	
	}

	include_once(MSG."alert.php");
	include_once(MSG."spinner.php");

 ?>