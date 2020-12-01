<?php 
	
	$act_cur = new Controllers\cursosController();
	$actcur = $act_cur->activity(); 

	
	$act_us = new Controllers\usuariosController();
	$actus = $act_us->activity(); 

	$hst = new Controllers\comentariosController();
	$hashtags = $hst->get_tags_comentarios();
	
	include_once("templates/verStream.php");

	include_once(MSG."alert.php");
	include_once(MSG."spinner.php");
	

 ?>