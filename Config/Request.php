<?php 
	namespace Config;


	class Request{

		private $controlador;
		private $metodo;
		private $argumento;
		private $get_type;
		private $post_type;

		public function __construct(){
			if(isset($_GET['url'])){

				$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
				$url = trim(strip_tags($url));
				$url = explode("/", $url);
				$url = array_filter($url);

				$this->controlador = strtolower(array_shift($url));
				$this->metodo = strtolower(array_shift($url));

				if(! $this->metodo){
					$this->metodo = "index";
				}

				$this->argumento = strtolower(array_shift($url));
				$this->argumento = filter_var($this->argumento, FILTER_SANITIZE_STRING);

			}
			else{
				if(isset($_SESSION['userSesion'])){
					$this->controlador = "inicio";
					$this->metodo = "index";
				}
				else{
					$this->controlador = "usuarios";
					$this->metodo = "ayuda";	
				}
			}

			if(isset($_GET['get_type'])){
				$this->get_type = filter_input(INPUT_GET, 'get_type', FILTER_SANITIZE_URL);
				$this->get_type = trim(strip_tags($this->get_type));
			}
			else{
				$this->get_type = false;
			}

			if(isset($_POST['post_type'])){
				$this->post_type = filter_input(INPUT_POST, 'post_type', FILTER_SANITIZE_STRING);
				$this->post_type = trim(strip_tags($this->post_type));
			}
			else{
				$this->post_type = false;
			}

		}


		public function getControlador(){
			return $this->controlador;
		}

		public function getMetodo(){
			return $this->metodo;
		}

		public function getArgumento(){
			return $this->argumento;
		}

		public function getGetType(){
			return $this->get_type;
		}

		public function getPostType(){
			return $this->post_type;
		}

	}


 ?>