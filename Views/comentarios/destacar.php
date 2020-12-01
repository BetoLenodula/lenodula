<?php 
	
	$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
	$url = trim(strip_tags($url));
	$url = explode("/", $url);
	$arg = $url[2];

	if(isset($_GET['page'])){
		$page = trim(strip_tags($_GET['page']));
	}
	else{
		$page = 1;
	}
	
	$datos = $callback_datos;
	
	include_once("templates/verComents.php");
	include_once(MSG."alert.php");

 ?>