<?php 
	if(isset($_SESSION['userSesion'])){
		$ses = $_SESSION['userSesion']['id'];
	}
	
	include_once("templates/frmConfirmDel.php");
	include_once("templates/default.php");
	include_once(MSG."alert.php");
	include_once(MSG."spinner.php");

 ?>