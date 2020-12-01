<?php 
	namespace Controllers;

	use Models\Respuesta_respuesta as RespuestaR;
	use Models\Notificacion_respuesta_tema as NotifResT;
	use Models\Respuesta as Resp;
	use Classes\Method as Method;

	class respuestasrespuestaController{

		private $respuestar;
		private $notif_rt;
		private $funcion;

		public function __construct(){
			$this->respuestar = new RespuestaR();
			$this->funcion = new Method();
		}

		public function funcion($funcion, $arg){
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index(){}

		public function nuevo(){
			$respr = $this->funcion('findReplaceURL', trim($_POST['respr']));
			
			if(is_array($respr)){
				$respr = $respr[1];
			}
			else{
				$respr = $respr;
			}

			$this->respuestar->set('id_respuesta', trim(strip_tags($_POST['idre'])));
			$this->respuestar->set('id_usuario', trim(strip_tags($_POST['idus'])));
			$this->respuestar->set('respuesta_respuesta', $respr);

			if(isset($_POST['menc'])){
				$id_receptor = trim(strip_tags($_POST['menc']));
			}
			else{
				$r = new Resp();
				$r->set('id', trim(strip_tags($_POST['idre'])));
				$id_receptor = $r->get('id_usuario');
			}

			$this->notif_rt = new NotifResT();
			$this->notif_rt->set('id_respuesta', trim(strip_tags($_POST['idre'])));
			$this->notif_rt->set('id_emisor', trim(strip_tags($_POST['idus'])));
			$this->notif_rt->set('id_receptor', $id_receptor);
			
			if(isset($_POST['menc'])){
				$this->notif_rt->set('notificacion_respuesta_tema', "te @ mencionó:");
				$this->notif_rt->set('tipo_notificacion', 'ME');
			}
			else{
				$this->notif_rt->set('tipo_notificacion', 'RR');
				$this->notif_rt->set('notificacion_respuesta_tema', "comentó en tu respuesta:");
			}

			$this->notif_rt->set('fecha_notificacion_respuesta_tema', date("Y-m-d"));

			$this->notif_rt->add();

			$return = $this->respuestar->add();
			echo $return;
		}

		public function ver($arg){
			$this->respuestar->set('id_respuesta', trim(strip_tags($_GET['idre'])));

			if($arg == 'todo'){
				$return = $this->respuestar->ver_todas();
			}
			else if($arg == 'mas'){
				$this->respuestar->set('limite', trim(strip_tags($_GET['lim'])));
				$return = $this->respuestar->ver_mas();	
			}

			$dats = array();

			while ($r = $return->fetch_array()){
				$idr = $r['id'];
				$idu = $r['id_usuario'];
				$res = $r['respuesta_respuesta'];
				$fec = $r['timestamp_respuesta_respuesta'];
				$fot = $r['foto'];
				$nom = $r['nombre_user'];

				$dats[] = array('idr' => $idr, 'idu' => $idu, 'res' => $res, 'fec' => $fec, 'fot' => $fot, 'nom' => $nom);
			}

			echo json_encode($dats);
		}
	}


 ?>