<?php 
	namespace Controllers;

	use Models\Curso as Curso;

	class buscarController{

		private $curso;

		public function __construct(){
			$this->curso = new Curso();	
		}

		public function resultado($arg){
			$this->curso->set('nombre_materia_curso', trim($arg));
			$res = $this->curso->buscar();
			return $res;			
		}

	}


 ?>