<?php 
		$res = $callback_datos;

		if($res == 'form'){
			include_once("templates/frmAddGrupo.php");
		}
		else if($res == 'signin'){
			$res = "Creaste un Grupo, ya puedes organizar y crear contenido o agregar usuarios!";
			include_once(MSG."advice.php");
			include_once("templates/frmAddGrupo.php");
		}
		else{
			include_once(MSG."error.php");
			include_once("templates/frmAddGrupo.php");
		}

		include_once(MSG."alert.php");

		include_once(MSG."spinner.php");

 ?>