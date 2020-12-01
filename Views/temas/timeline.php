<?php 
  if(is_array($callback_datos)){
    $dats = $callback_datos;

    if(!empty($dats)){

      $nom = $dats['nombre_timeline'];
      $fes = $dats['fechas'];
      $dts = $dats['datos'];
      $img = $dats['image_timeline'];

      $fes = substr($fes, 0, -1);
      $fes = explode(",", $fes);

      $dts = substr($dts, 0, -1);
      $dts = explode(",", $dts);

      $img = substr($img, 0, -1);
      $img = explode(",", $img);


      include_once("templates/verTimeLine.php");
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