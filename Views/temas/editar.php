<?php 
	if(is_array($callback_datos)){
	
		$dats = $callback_datos[0];

		if(!empty($dats['id'])){
			$titulo = $dats['titulo'];
			$contenido = $dats['contenido'];
			$tags = $dats['tags'];
			$fecha_limite = $dats['fecha_limite_respuesta'];
			$hora_limite = $dats['hora_limite_respuesta'];
			$fecha_p = $dats['fecha_publicacion'];
			$permiso_a = $dats['permiso_archivo'];
			$nivel = $dats['nivel_tema'];

			if($nivel == 1){
				$check = "checked";
			}
			else{
				$check = null;
			}

			$lista_archivos = $controlador->listar_archivos($argumento, 'tema');
			$list_games = $controlador->list_games($argumento);

			include_once("templates/editTema.php");
		}
		else{
			$res = "Tema no existente en el sistema!!";
			include_once(MSG."error.php");
			include_once(INDEX);
		}
	}
	else{
		$res = $callback_datos;
		include_once(MSG."error.php");
		include_once(INDEX);
	}

	include_once(MSG."spinner.php");
	include_once(MSG."alert.php");
	
 ?>