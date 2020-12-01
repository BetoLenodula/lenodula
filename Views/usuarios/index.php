<?php 
	if(isset($_SESSION['userSesion'])){
		$_GET['n_grupos'] = true;
		$grupos = new Controllers\gruposController();
		$grupos = $grupos->buscar('my');
	}

	include_once("templates/listaUsuarios.php");
	include_once(MSG."alert.php");

	include_once(MSG."spinner.php");
 ?>