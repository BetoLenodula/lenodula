<?php
	require_once("config.php");
//_____________________________________________________________________________
	require_once("Config/Autoload.php");
	require_once "run_auth_facebook.php";

	Config\Autoload::run();

	$ls_grs = Models\Grupo::listar();

	$request = new Config\Request();

	$response = Config\Route_controller::run($request); // controlador
	if($response == 'ajax') return false;

	if(is_array($response) && !empty($response)){
		if(is_array($response[0])){
			if(isset($response[1]) && is_string($response[1])){
				$arg_og = $response[1];
			}
			else{
				$arg_og = null;
			}
		}
		else{
			$arg_og = null;
		}
	}
	else{
		$arg_og = null;
	}

	if(isset($_SESSION['userSesion'])){
		
		$nt_agend = new Controllers\agendasController();
		$nag = $nt_agend->get_new_notif(date("Y-m"));

		$notify = new Controllers\notificacionesController();
		$ngr = $notify->num_notificaciones_grupo();
		$nco = $notify->num_notificaciones_comentarios();
		$nms = $notify->notificar_mensajes();
		$ngl = $notify->num_notificaciones_respuestas();
		$nte = $notify->num_notificaciones_temas();
		$glob = $ngl + $nte;
		$nco = $nco + $nms;
		$tmpl = new Views\Template_sesion($ngr, $nco , $glob, $nag, $ls_grs, $arg_og);
	}
	else{
		$tmpl = new Views\Template($ls_grs, $arg_og);
	}
	
	Config\Route_view::run($request, $response); // vista
?>