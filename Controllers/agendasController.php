<?php 
	namespace Controllers;

	use Models\Evento as Evento;


	class agendasController{

		private $event;

		public function __construct(){
			$this->event = new Evento();
		}

		public function index(){
			return $this->ver(date('Y-m'));
		}

		public function ver($fecha){
			if(!$fecha){
				$fecha = date('Y-m');
			}

			if(isset($_SESSION['userSesion'])){
				$eventos = $this->get_events($fecha);
				$alertas = $this->get_alerts($fecha);
			}
			else{
				$eventos = null;
				$alertas = null;
			}

			return array($eventos, $alertas);
		}

		public function get_by_group($arg){
			$mon = intval(date('m'));
			$day = intval(date('d'));
			$yea = date('Y');

			$this->event->set('dia_evento', $day);
			$this->event->set('mes_evento', $mon);
			$this->event->set('anio_evento', $yea);
			$this->event->set('url_referencia', 'grupos/ver/'.$arg."#events");
			$this->event->set('id_usuario', $_SESSION['userSesion']['id']);

			$return = $this->event->get('by_grp');

				$dats = array();

				while ($r = $return->fetch_array()) {
					$ide = $r['id'];
					$idu = $r['id_usuario'];
					$des = $r['descripcion_evento'];
					$dia = $r['dia_evento'];
					$mes = $r['mes_evento'];
					$hor = $r['hora_evento'];
					$tip = $r['tipo_evento'];
					$url = $r['url_referencia'];

					$dats[] = array('ide' => $ide, 'idu' => $idu, 'des' => $des, 'hor' => $hor, 'tip' => $tip, 'url' => $url, 'dia' => $dia, 'mes' => $mes);
				}

			return $dats;
		}

		public function listar(){
			if(isset($_SESSION['userSesion'])){
				if(false == preg_match("/^[0-9]{4}$/", $_POST['an'])){
					return false;
				}
				if(false == preg_match("/^[0-9]{1,2}$/", $_POST['mo'])){
					return false;
				}

				if(false == preg_match("/^[0-9]{1,2}$/", $_POST['da'])){
					return false;
				}

				$this->event->set('id_usuario', $_SESSION['userSesion']['id']);
				$this->event->set('mes_evento', trim(strip_tags($_POST['mo'])));
				$this->event->set('anio_evento', trim(strip_tags($_POST['an'])));
				$this->event->set('dia_evento', trim(strip_tags($_POST['da'])));

				$return = $this->event->get('list');

				$dats = array();

				while ($r = $return->fetch_array()) {
					$ide = $r['id'];
					$idu = $r['id_usuario'];
					$des = $r['descripcion_evento'];
					$hor = $r['hora_evento'];
					$tip = $r['tipo_evento'];
					$url = $r['url_referencia'];

					$dats[] = array('ide' => $ide, 'idu' => $idu, 'des' => $des, 'hor' => $hor, 'tip' => $tip, 'url' => $url);
				}

				echo json_encode($dats);
			}
		}

		public function get_new_notif($arg){
			$d = explode("-", trim($arg));

			$y = $d[0];
			$m = $d[1];

			$this->event->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->event->set('anio_evento', $y);
			$this->event->set('mes_evento', $m);
			$this->event->set('dato_ambiguo', date('d'));

			$return = $this->event->get('notif');

			return $return->num_rows;
		}

		public function get_events($arg){
			$d = explode("-", trim($arg));

			$y = $d[0];
			$m = $d[1];

			$this->event->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->event->set('anio_evento', $y);
			$this->event->set('mes_evento', $m);

			$return = $this->event->get('events');

			$dats = array();

			while($r = $return->fetch_array()) {
				$dats[] = ltrim($r['dia_evento'], "0");
			}	

			return $dats;
		}


		public function get_alerts($arg){
			$d = explode("-", trim($arg));

			$y = $d[0];
			$m = $d[1];

			$this->event->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->event->set('anio_evento', $y);
			$this->event->set('mes_evento', $m);
			$this->event->set('dato_ambiguo', (date('d')));

			$return = $this->event->get('alerts');

			$dats = array();

			while($r = $return->fetch_array()) {
				$dats[] = ltrim($r['dia_evento'], "0");
			}	

			return $dats;
		}

		public function borrar_evento(){
			$idb64 = base64_decode(trim($_POST['idevb64']));

			$id = explode("-", $idb64);

			if(false == preg_match("/^\d*$/", $id[0])){
				return "Id inválido!";
			}
			if(false == preg_match("/^[0-9a-z]{15,16}$/", $id[1])){
				return "Id inválido!";
			}
			if(false == preg_match("/^\d*$/", trim($_POST['idattach']))){
				return "Id inválido!";
			}
			if($id[0] != trim($_POST['idattach'])){
				return "Id inválido!";
			}

			$this->event->set('id', $id[0]);
			$this->event->set('id_usuario', $id[1]);

			$res = $this->event->delete();

			if($res == "true"){
				echo 'true';
			}
			else{
				echo 'false';
			}
		}

		public function nuevoevento(){

			if(isset($_SESSION['userSesion'])){

				if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,150}$/", $_POST['descripcion_evento'])){
					return "Indica un nombre para el Evento, asegurate que no haya caracteres raros!!";
				}

				if(false == preg_match("/^[0-9]{2}:[0-9]{2}$/", $_POST['hora_evento'])){
					return "Indica una 'Hora' válida para el Evento!!";
				}

				if($_POST['tipo_evento'] != 'Tarea' && $_POST['tipo_evento'] != 'Leer' && $_POST['tipo_evento'] != 'Recordatorio' && $_POST['tipo_evento'] != 'Exámen' && $_POST['tipo_evento'] != 'Otro'){
					return "Elige un tipo de Evento que sea válido!!";
				}

				if(isset($_POST['post_data_event'])){

					$pd = json_decode(base64_decode($_POST['post_data_event']));

					if(false == preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $pd->dat) || $pd->sub != 'sudate'){
						return "Id inválido!!";
					}

					$fec = explode("-", $pd->dat);
					
				}

				if(isset($_POST['fecha_evento'])){
					if(false == preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['fecha_evento'])){
						return "Id inválido!!";
					}

					$fec = explode("-", trim(strip_tags($_POST['fecha_evento'])));
				}

				$y = $fec[0];
				$m = $fec[1];
				$d = $fec[2];

				if($m < 10){
					$nm = ltrim($m, "0");
				}
				else{
					$nm = $m;
				}

				if(isset($_POST['reference'])){

					$url = base64_decode($_POST['reference']);
					$url = trim(strip_tags($url));
				}
				else{
					$url = 'none';
				}

				$this->event->set('id_usuario', $_SESSION['userSesion']['id']);
				$this->event->set('tipo_evento', trim($_POST['tipo_evento']));
				$this->event->set('descripcion_evento', trim(strip_tags($_POST['descripcion_evento'])));
				$this->event->set('dia_evento', $d);
				$this->event->set('mes_evento', $m);
				$this->event->set('anio_evento', $y);
				$this->event->set('hora_evento', trim(strip_tags($_POST['hora_evento'])));
				$this->event->set('url_referencia', $url);

				$r = $this->event->add();

				if($r == 'true'){
					header("Location:".URL."agendas/ver/".$y."-".$nm);
				}

			}
			else{
				header("Location:".URL);
			}
		}

	}

 ?>