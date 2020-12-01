<?php 

	$res = $callback_datos;

	if(!$argumento){
		$m = null;
		$y = null;

		$yy = date('Y');
		$mm = date('m');
	}
	else{
		$arg = explode("-", $argumento);
		$y = filter_var($arg[0], FILTER_VALIDATE_INT);
		$m = filter_var($arg[1], FILTER_VALIDATE_INT);

		$yy = $y;
		$mm = $m;
	}

	$eventos = $res[0];
	$alertas = $res[1];
	

	
	if($mm == 12){
		$yf = $yy + 1;
		$mf = 0;
		$yb = $yy;
		$mb = $mm;
	}
	else if($mm == 1){
		$yf = $yy;
		$mf = $mm;
		$yb = $yy - 1;
		$mb = 13;
	}
	else{
		$yf = $yy;
		$yb = $yy;
		$mf = $mm;
		$mb = $mm;
	}



	include_once("templates/verActuales.php");

	
	include_once(MSG."alert.php");

 ?>