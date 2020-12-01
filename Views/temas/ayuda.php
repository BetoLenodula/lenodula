<?php 
	if($argumento == "examen"){
		include_once("templates/exam.php");
	}
	else{
		$res = "Ayuda no existente en el sistema!!";
		include_once(MSG."error.php");
		include_once(INDEX);
	}
 ?>