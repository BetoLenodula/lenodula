<?php 
	namespace Controllers;

	use Models\Stream as Stream;
	use Classes\Method as Method;


	class inicioController{

		private $stream;
		private $funcion;

		public function __construct(){
			$this->stream = new Stream();
			$this->funcion = new Method();
		}

		public function funcion($funcion, $arg){
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index(){
		 	$return = $this->pagina(1);
		 	return $return;
		}

		public function pagina($lim){
			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 10;

			$this->stream->set('limite', $lim);
			$return = $this->stream->ver();

			return $return;
		}

		public function paginar_news(){
			$pages = $this->stream->paginar();
			return $pages;
		}

	}


 ?>