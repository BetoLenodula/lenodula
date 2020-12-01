<?php

	$ids    = $_SESSION['userSesion']['id_session'];
	$idu    = $_SESSION['userSesion']['id'];
	$name   = $_SESSION['userSesion']['nombre_user'];
	$foto   = $_SESSION['userSesion']['foto'];
	$rol    = $_SESSION['userSesion']['rol'];
	
	$t = new Controllers\temasController();

	include_once("templates/vistaRespuesta.php");
	include_once(MSG."spinner.php");
	include_once(MSG."alert.php");

 ?>