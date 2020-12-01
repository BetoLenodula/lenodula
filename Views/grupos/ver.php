<?php 

	if(!empty($callback_datos)){
			$dats = $callback_datos[0];

			$idg = $dats['id'];

		if(!empty($idg)){
			if(isset($_SESSION['userSesion'])){
				$idu = $_SESSION['userSesion']['id'];
				$member = $controlador->validar_miembro($idu, $idg, 'exist_member');
				$access = $controlador->validar_miembro($idu, $idg, 'access_member');
				$metrica = $controlador->metrica_user_grupo($idu, $idg);
				$metrica = $metrica->fetch_array();
				$events = $controlador->get_events($argumento);

				$url_this = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
				$url_this = trim(strip_tags($url_this.'#events'));
			}
			else{
				$idu = false;
			}

			if(isset($_GET['page'])){
				$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_URL);
				$page = trim(strip_tags($page));
				$page = filter_var($page, FILTER_VALIDATE_INT);
			}
			else{
				$page = 1;
			}

			$someg = $controlador->listar_algunos($idg);
	 		$cursos = new Controllers\cursosController();
	 		$tags = $cursos->get_tags_curso($idg);
	 		$cursos = $cursos->listar($idg, 0);
	 		$members_group = $controlador->ver_miembros($idg, 0);

			$id_usuario = $dats['id_usuario'];
			$foto = $dats['foto_grupo'];
			$nombre_grupo = $dats['nombre_grupo'];
			$descripcion = $dats['descripcion_grupo'];
			$tipo_acceso = $dats['tipo_acceso'];
			$theme = $dats['theme'];
			$color_theme = $dats['color_theme'];
			$fecha_creacion_grupo = $dats['fecha_creacion_grupo'];
			$foto_usr = $dats['foto'];
			$nombre_user = $dats['nombre_user'];

			include_once("templates/wallGrupo.php");
		}
		else{
			$res = "Grupo no existente en el sistema!!";
			include_once(MSG."error.php");
			include_once(INDEX);
		} 

	}
	else{

		$res = $callback_datos[0];
		include_once(MSG."error.php");
		include_once(INDEX);
	}
	
	include_once(MSG."alert.php");
	include_once(MSG."spinner.php");


 ?>