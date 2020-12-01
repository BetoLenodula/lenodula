<?php 
	if(is_object($callback_datos)){
		$dats = $callback_datos->fetch_array();

		if(!empty($dats)){

			$nom = $dats['nombre_wrdfnd'];
			$wrs = $dats['words_wrdfnd'];

			$wrs = substr($wrs, 0, -1);
			$wrs = explode(",", $wrs);

			$words = "";
			foreach($wrs as $wrd){
				$words .= "'".$wrd."',";
			}
			$words = substr($words, 0, -1);

			include_once("templates/verWordFind.php");
		}
		else{
			$res = "No existe ese módulo";
			include_once(INDEX);
			include_once(MSG."error.php");
		}
	}
	else{
		$res = "Módulo inexistente";
		include_once(INDEX);
		include_once(MSG."error.php");
	}
	include_once(MSG."alert.php");

 ?>