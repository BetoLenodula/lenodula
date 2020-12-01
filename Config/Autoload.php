<?php 
	namespace Config;

	class Autoload{

		public static function run(){
			spl_autoload_register(function($class){

				$file = ROOT.str_replace("\\", "/", $class).".php";

				if(is_readable($file)){
					require_once($file);
				}
				else{
					print "No se encontró la clase solicitada! ".$file;

				}
			});
		} 

	}


 ?>