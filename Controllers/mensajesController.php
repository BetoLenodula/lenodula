<?php 
	namespace Controllers;

	use Models\Mensaje as Mensaje;
	use Classes\Method as Method;
	use Classes\Pusher as Pusher;

	class mensajesController{
		private $msg;
		private $push;
		private $funcion;

		public function __construct(){
			$this->msg = new Mensaje();
			$this->funcion = new Method();
			$this->push = new Pusher('dddb561a0b4e2067e172', '74184f20a6a581897b06', '288156');
		}


		public function funcion($funcion, $arg){
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index(){}

		public function ver(){
			if(isset($_SESSION['userSesion'])){
				$this->msg->set('id_receptor', $_SESSION['userSesion']['id']);
				$r = $this->msg->ver();

				$dats = array();

				while($d = $r->fetch_array()) {
					$ide = $d['id_emisor'];
					$nom = $d['nombre_user'];
					$fot = $d['foto'];
					$ids = $d['ids'];

					$dats[] = array('ide' => $ide, 'nom' => $nom, 'fot' => $fot, 'ids' => $ids);
				}

				return array_reverse($dats);
			}
			else{
				header("Location:".URL);
			}
		}

		public function nuevo(){
			if($_POST){
				if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#]{1,800}$/", $_POST['mensaje'])){
					return "Caracteres extraños en el mensaje!";
				}
				if(false == preg_match("/^[0-9a-z]{15,16}$/", $_POST['recept'])){
					return "Id de usuario incorrecto!";
				}

				$mensaje = $this->funcion('findReplaceURL', trim(strip_tags($_POST['mensaje'])));
				
				if(is_array($mensaje)){
					$mensaje = $mensaje[0];
				}
				else{
					$mensaje = $mensaje;
				}

				$this->msg->set('id_emisor', $_SESSION['userSesion']['id']);
				$this->msg->set('id_receptor', trim($_POST['recept']));
				$this->msg->set('mensaje', $mensaje);
				$this->msg->set('mensaje_visto', 0);

				$r = $this->msg->add();

				if($r == 'true'){
					$this->push->trigger('port_msg', 'mensaje', array('resp' => 'ok', 'emit' => $_SESSION['userSesion']['id'], 'recp' => trim($_POST['recept'])));
				}

				echo $r;
			}
		}

		public function get_lasts(){
			if(isset($_SESSION['userSesion'])){
				if(false == preg_match("/^[0-9a-z]{15,16}$/", $_GET['recept'])){
					return "Id de usuario incorrecto!";
				}

				$this->msg->set('id_emisor', $_SESSION['userSesion']['id']);
				$this->msg->set('id_receptor', trim($_GET['recept']));
				$this->msg->set('limite', trim($_GET['limit']));
				$r = $this->msg->ver_ultimos();

				$dats = array();

				$r = $this->msg->ver_ultimos();
				$idu = $_SESSION['userSesion']['id'];

				while($d = $r->fetch_array()) {
					$ide = $d['id_emisor'];
					$idr = $d['id_receptor'];
					$msg = $d['mensaje'];
					$tms = $d['timestamp_mensaje'];

					$dats[] = array('ide' => $ide, 'idr' => $idr, 'msg' => $msg, 'tms' => $tms, 'idu' => $idu);
				}

				$arr = array_reverse($dats);
				echo json_encode($arr);
			}
		}

		public function get_lmsg(){

			if(false == preg_match("/^[0-9a-z]{15,16}$/", $_GET['recept'])){
				return "Id de usuario incorrecto!";
			}

			$this->msg->set('id_emisor', $_SESSION['userSesion']['id']);
			$this->msg->set('id_receptor', trim($_GET['recept']));

			$dats = array();

			$r = $this->msg->ver_ultimo();
			$idu = $_SESSION['userSesion']['id'];

			while($d = $r->fetch_array()) {
				$ide = $d['id_emisor'];
				$idr = $d['id_receptor'];
				$msg = $d['mensaje'];
				$tms = $d['timestamp_mensaje'];

				$dats[] = array('ide' => $ide, 'idr' => $idr, 'msg' => $msg, 'tms' => $tms, 'idu' => $idu);
			}

			echo json_encode($dats);

		}
	}

 ?>