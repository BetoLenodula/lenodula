<?php 
	namespace Config;

	class Route_controller{

		public static function run($request){
			$controlador = $request->getControlador()."Controller";
			$controller_route = ROOT."Controllers".DS.$controlador.".php";

			$metodo = $request->getMetodo();
			$argumento = $request->getArgumento();
			$get_type = $request->getGetType();
			$post_type = $request->getPostType();

			if(is_readable($controller_route)){

				require_once($controller_route);

				$obj_controller = "Controllers\\".$controlador;
				$controlador = new $obj_controller();

				if(! $argumento){
					$callback_datos = call_user_func(array($controlador, $metodo), "");
				}
				else{
					$callback_datos = call_user_func(array($controlador, $metodo), $argumento);
				}

				if($get_type == 'ajax' || $post_type == 'ajax'){
					return "ajax";
				}
				else{
					return $callback_datos;
				}
			}
			else{
				header("Location:".URL);
			}

		}

	}


 ?>