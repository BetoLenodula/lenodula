<?php 
	if(is_array($callback_datos)){
		
		$dats = $callback_datos;	

		if(!empty($dats)){

			$nom = $dats['nombre_guesswrd'];
			$wrs = $dats['words'];
			$cls = $dats['clues'];
			$img = $dats['image_guesswrd'];

			$wrs = substr($wrs, 0, -1);
			$wrs = explode(",", $wrs);

			$cls = substr($cls, 0, -1);
			$cls = explode(",", $cls);

			$img = substr($img, 0, -1);
			$img = explode(",", $img);

			$words = "";
			foreach($wrs as $wrd){
				$words .= "'".$wrd."',";
			}
			$words = substr($words, 0, -1);

			$clues = "";
			foreach($cls as $cle){
				$clues .= "'".$cle."',";
			}
			$clues = substr($clues, 0, -1);

			$images = "";
			foreach($img as $ime){
				$images .= "'".$ime."',";
			}
			$images = substr($images, 0, -1);

			include_once("templates/verGuessWrd.php");
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