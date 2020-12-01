<?php 
	if(is_array($callback_datos)){
		$dats = $callback_datos;

		if(!empty($dats['id'])){
 			$post_g = array('idg' => $dats['id'], 'pref' => 'prefix_group');
 			$idg = base64_encode(json_encode($post_g));
			$nomb_g = $dats['nombre_grupo'];
			$descri = $dats['descripcion_grupo'];
			$acceso = $dats['tipo_acceso'];
			$theme = $dats['theme'];
			$color = $dats['color_theme'];

			$edit_theme = true;
			include_once("templates/frmAddGrupo.php");
		}
		else{

			$res = "Grupo no existente en el sistema!!";
			include_once(MSG."error.php");
			include_once(INDEX);
		}
	}
	else{
		if($callback_datos == 'signin'){
			$res = "Se actualizó correctamente la Información del Grupo, Puedes acceder y editar el contenido!";
			include_once(MSG."advice.php");
			include_once(INDEX);
		}
		else{
			$res = $callback_datos;
			include_once(MSG."error.php");
			include_once(INDEX);
		}
	}


		include_once(MSG."alert.php");

		include_once(MSG."spinner.php");


 ?>