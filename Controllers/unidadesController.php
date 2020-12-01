<?php 
	namespace Controllers;

	use Models\Unidad as Unidad;

	class unidadesController{

		private $unidad;

		public function __construct(){
			$this->unidad = new Unidad();
		}

		public function index(){}

		public function nuevo(){
			if(isset($_SESSION['userSesion'])){
				$return = $this->registrar_unidad();

				return $return;
			}
			else{
				header("Location:".URL);
			}

		}

		public function listar($arg){
			$this->unidad->set('id_materia_curso', trim(strip_tags($arg)));
			$return = $this->unidad->ver_todos();
			$dats = array();

			while($r = $return->fetch_array()){
				$id = $r['id'];
				$im = $r['id_materia_curso'];
				$nu = $r['nombre_unidad'];

				$dats[] = array('id' => $id, 'im' => $im,'nu' => $nu);
			}

			return $dats;
		}

		public function listar_dashboard($arg){
			$this->unidad->set('id_materia_curso', trim(strip_tags($arg)));
			$return = $this->unidad->ver_algunos();
			$dats = array();

			while($r = $return->fetch_array()){
				$id = $r['id'];
				$im = $r['id_materia_curso'];
				$nu = $r['nombre_unidad'];

				$dats[] = array('id' => $id, 'im' => $im,'nu' => $nu);
			}

			echo json_encode($dats);
		}

		public function registrar_unidad(){
			$pd = json_decode(base64_decode($_POST['post_dats_un']));

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,80}$/", $_POST['nombre_unidad'])){

				return "Indica un nombre para el módulo!!";
			}

			if(false == preg_match("/^\d*$/", $_POST['numero_temas'])){
				if($_POST['numero_temas'] < 1 || $_POST['numero_temas'] > 40){
					return "El número de temas no está en el rango";
				}
				else{
					return "El campo (Número de temas) no es un número válido!!";
				}
			}

			if(false == preg_match("/^\d*$/", $pd->id)){
				return "Id Invaĺido!!";
			}

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,100}$/", $pd->nc)){
				return "Nombre de curso inválido!!";
			}


			$this->unidad->set('nombre_unidad', trim(strip_tags($_POST['nombre_unidad'])));
			$this->unidad->set('id_materia_curso', $pd->id);

			$return = $this->unidad->add($_POST['numero_temas'], $_SESSION['userSesion']['id'], date('Y-m-d'));

			if($return === true){
				header("Location:".URL."temas/listar/".$pd->id."#m");
			}
			else if($return === false){
				return "Ya existe un módulo con ese Nombre, elige otro nombre!!";
			}
			else if($return == 'fail_insert'){
				return "Falló al guardar el módulo!!";
			}
			else{
				return "Falló el Insert del módulo!!";
			}
		}

	}

 ?>