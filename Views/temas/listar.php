<?php 
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}
	else{
		$page = 1;
	}

	$curso = new Controllers\cursosController();
	$id_usuario = $curso->id_propietario_curso($argumento);
	$idg = $curso->id_grupo_curso($argumento);

	$unidad = new Controllers\unidadesController();
	$modulos = $unidad->listar($argumento);

	$n_cur_grp = $curso->get_nom_grp_curso($argumento);
 	$curso = $curso->ver($argumento);

	if(isset($_SESSION['userSesion'])){
		$member = $controlador->validar_miembro($_SESSION['userSesion']['id'], $idg);
		if($member == 1 || $id_usuario == $_SESSION['userSesion']['id']){
			$member = true;
			$lista_archivos = $controlador->listar_archivos("listar.".$argumento, 'temresp');
		}
		else{
			$member = false;
		}

		$pclevel = $controlador->get_num_by_cur($argumento);

	}

 	if(!empty($curso)){
 		$idcur = array('id' => $curso[0]['id'], 'nc' => $curso[0]['nc']);					
	}

	include_once("templates/listarTemas.php");
	include_once(MSG."spinner.php");
	include_once(MSG."alert.php");
	
 ?>