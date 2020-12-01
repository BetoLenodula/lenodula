<?php 
	if(!empty($callback_datos)){
		$dats = $callback_datos[0];
	}

	if(!empty($dats['id'])){
	$id_usuario = $dats['id_usuario'];
	$titulo = $dats['titulo'];
	$contenido = $dats['contenido'];
	$fecha_limite = $dats['fecha_limite_respuesta'];
	$hora_limite = $dats['hora_limite_respuesta'];
	$fecha_p = $dats['fecha_publicacion'];
	$permiso_a = $dats['permiso_archivo'];
	$nivel = $dats['nivel_tema'];
	$likes = $dats['likes_tema'];

	$lista_archivos = $controlador->listar_archivos($argumento, 'respuesta');
	$list_games = $controlador->list_games($argumento);

	$url_this = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
	$url_this = trim(strip_tags($url_this));

	$user_dats = new Controllers\usuariosController();
	$user_dats = $user_dats->ver($id_usuario);
	$name = $user_dats[0];
	$foto = $user_dats[1];

		if(isset($_GET['page'])){
			$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_URL);
			$page = trim(strip_tags($page));
			$page = filter_var($page, FILTER_VALIDATE_INT);
		}
		else{
			$page = 1;
		}


 		$dat_tema = array('id' => $dats['id'], 'ti' => $titulo, 'pre' => 'idt');
 		$dat_tema = base64_encode(json_encode($dat_tema));

 		$view_tema = $controlador->get_addver_tema($dats['id']);

		include_once("templates/verTema.php");
	}
	else{
		$res = "Tema no existente en el sistema!!";
		include_once(MSG."error.php");
		include_once(INDEX);
	}
	include_once(MSG."spinner.php");
	include_once(MSG."alert.php");
	
 ?>