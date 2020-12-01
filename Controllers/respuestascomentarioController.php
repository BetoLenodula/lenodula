<?php 
	namespace Controllers;

	use Models\Respuesta_comentario_grupo as Respuesta;
	use Classes\Method as Method;

	class respuestascomentarioController{

		private $respuesta;
		private $funcion;

		public function __construct(){
			$this->respuesta = new Respuesta();
			$this->funcion = new Method();
		}

		public function funcion($funcion, $arg){
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index(){}

		public function nuevo(){
			$resp = $this->funcion('findReplaceURL', trim($_POST['resp']));
			
			if(is_array($resp)){
				$resp = $resp[1];
			}
			else{
				$resp = $resp;
			}
			$this->respuesta->set('id_comentario', trim(strip_tags($_POST['idco'])));
			$this->respuesta->set('id_usuario', trim(strip_tags($_POST['idus'])));
			$this->respuesta->set('id_page', trim(strip_tags($_POST['page'])));
			$this->respuesta->set('respuesta_comentario', $resp);
			$this->respuesta->set('fecha_respuesta_comentario', date('Y-m-d'));
			$this->respuesta->set('vista_respuesta_comentario', 0);
			$this->respuesta->set('mencion', trim(strip_tags($_POST['menc'])));

			$return = $this->respuesta->add();
			echo $return;
		}

		public function ver($arg){
			$this->respuesta->set('id_comentario', trim(strip_tags($_GET['idc'])));
			if($arg == 'todo'){
				$return = $this->respuesta->ver_todas();
			}
			else if($arg == 'mas'){
				$this->respuesta->set('limite', trim(strip_tags($_GET['lim'])));
				$return = $this->respuesta->ver_mas();	
			}

			$dats = array();

			while ($r = $return->fetch_array()){
				$idr = $r['id'];
				$idu = $r['id_usuario'];
				$res = $r['respuesta_comentario'];
				$fec = $r['fecha_respuesta_comentario'];
				$fot = $r['foto'];
				$nom = $r['nombre_user'];

				$dats[] = array('idr' => $idr, 'idu' => $idu, 'res' => $res, 'fec' => $fec, 'fot' => $fot, 'nom' => $nom);
			}

			echo json_encode($dats);
		}
	}


 ?>