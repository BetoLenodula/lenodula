<?php
	
	if(isset($_GET['c'])){
		$argumento = $_GET['c'];
	}
	else{
		$argumento = $argumento;
	}

	$curso = new Controllers\cursosController();
	$id_usuario = $curso->id_propietario_curso($argumento);
	$idg = $curso->id_grupo_curso($argumento);

	$n_cur_grp = $curso->get_nom_grp_curso($argumento);

	if(isset($_SESSION['userSesion'])){
		$member = $controlador->validar_miembro($_SESSION['userSesion']['id'], $idg, 'access_member');
		if($member == 1 || $id_usuario == $_SESSION['userSesion']['id']){
			$member = true;
		}
		else{
			$member = false;
		}
	}

	include_once("templates/listarTemas.php");
	include_once(MSG."spinner.php");
	
 ?>