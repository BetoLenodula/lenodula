<?php
	namespace Controllers;

	use Models\Notificacion_grupo as NotifGrupo;
	use Models\Notificacion_comentario as NotifComment;
	use Models\Notificacion_respuesta_tema as NotifResT;
	use Models\Notificacion_tema as NotifTem;
	use Models\Mensaje as Mensaje;
	use Models\Stream as Stream;

	class notificacionesController{

		private $notif_grupo;
		private $notif_comment;
		private $notif_restem;
		private $notif_tem;
		private $stream;
		private $notif_msg;

		public function __construct(){
			$this->notif_grupo = new NotifGrupo();
			$this->notif_comment = new NotifComment();
			$this->notif_restem = new NotifResT();
			$this->notif_msg = new Mensaje();
			$this->notif_tem = new NotifTem();
		}

		public function num_notificaciones_grupo(){
			$this->notif_grupo->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$res = $this->notif_grupo->contar_notificaciones();
			return $res;
		}

		public function aceptar(){
			$this->notif_grupo->set('id_grupo', trim(strip_tags($_POST['idgr'])));
			$this->notif_grupo->set('id_emisor', trim(strip_tags($_POST['idem'])));
			$this->notif_grupo->set('id_receptor', trim(strip_tags($_POST['idre'])));
			$this->notif_grupo->set('notificacion_grupo', "te aceptó en el grupo");
			$this->notif_grupo->set('fecha_notificacion_grupo', date('Y-m-d'));

			$return = $this->notif_grupo->add();

			if($return){

				$this->stream = new Stream();
				$this->stream->set('id_usuario', trim($_POST['idre']));
				$this->stream->set('id_grupo', trim($_POST['idgr']));
				$this->stream->set('stream_tipo', 'ME');
				$this->stream->set('fecha_stream', date('Y-m-d'));
				$this->stream->set('id_comentario', '0');

				$re = $this->stream->add();
				echo $return;
			}
		}

		public function borra_notif_grupo(){
			$this->notif_grupo->set('id', trim(strip_tags($_POST['idno'])));
			$this->notif_grupo->set('id_emisor', trim(strip_tags($_POST['idem'])));
			$this->notif_grupo->set('id_grupo', trim(strip_tags($_POST['idgr'])));

			$return = $this->notif_grupo->delete();
			echo $return;
		}

		public function notificaciones_grupo(){
			$this->notif_grupo->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$this->notif_grupo->set('limite', trim($_GET['limit']));
			$return = $this->notif_grupo->ver_todas();

			$dats = array();

			while($r = $return->fetch_array()){
				$idn = $r['id'];
				$not = $r['notificacion_grupo'];
				$fec = $r['fecha_notificacion_grupo'];
				$ide = $r['id_emisor'];
				$idr = $r['id_receptor'];
				$idg = $r['id_grupo'];
				$nom = $r['nombre_user'];
				$ngr = $r['nombre_grupo'];
				$fot = $r['foto'];

				$dats[] = array('idn' =>$idn, 'not' => $not, 'fec' => $fec, 'ide' => $ide, 'idr' => $idr, 'idg' => $idg, 'nom' => $nom, 'fot'=>$fot,'ngr' => $ngr);
			}
			echo json_encode($dats);
		}



		public function num_notificaciones_comentarios(){
			$this->notif_comment->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$res = $this->notif_comment->contar_notificaciones();
			return $res;
		}


		public function notificaciones_comentarios(){
			$this->notif_comment->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$this->notif_comment->set('limit', trim($_GET['limit']));
			$return = $this->notif_comment->ver_todas();

			$dats = array();
			
			while($r = $return->fetch_array()){
				$idn = $r['id'];
				$fot = $r['foto'];
				$nom = $r['nombre_user'];
				$idr = $r['id_receptor'];
				$idg = $r['id_grupo'];
				$ngr = $r['nombre_grupo'];
				$ide = $r['id_emisor'];
				$idp = $r['id_post'];
				$ipg = $r['id_page']; 
				$fec = $r['fecha'];
				$men = $r['mencion'];

				$dats[] = array('idn' => $idn, 'fot' => $fot, 'nom' => $nom, 'idr' => $idr, 'idg' => $idg, 'ngr' => $ngr, 'ide' => $ide, 'idp' => $idp, 'ipg' => $ipg, 'fec' => $fec, 'men' => $men);
			}
			echo json_encode($dats);

		}


		public function borrar_notificacion_comentario(){
			$this->notif_comment->set('id', trim(strip_tags($_POST['idno'])));
			$this->notif_comment->set('id_usuario', trim(strip_tags($_POST['idem'])));

			$return = $this->notif_comment->delete();
			echo $return;
		}

		public function num_notificaciones_respuestas(){
			$this->notif_restem->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$res = $this->notif_restem->contar_notificaciones();
			return $res;
		}


		public function notificaciones_respuestas(){
			$this->notif_restem->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$this->notif_restem->set('limite', trim($_GET['limit']));
			$return = $this->notif_restem->ver_todas();

			$dats = array();

			while($r = $return->fetch_array()){
				$nom = $r['nombre_user'];
				$fot = $r['foto'];
				$idn = $r['id'];
				$tip = $r['tipo_notificacion'];
				$ide = $r['id_emisor'];
				$idr = $r['id_receptor'];
				$not = $r['notificacion_respuesta_tema'];
				$ire = $r['id_respuesta'];
				$fec = $r['fecha_notificacion_respuesta_tema'];
				$idt = $r['id_tema'];
				$tte = $r['titulo'];

				$dats[] = array('nom' => $nom, 'fot' => $fot, 'idn' => $idn, 'tip' => $tip, 'ide' => $ide, 'idr' => $idr, 'not' => $not, 'ire' => $ire, 'fec' => $fec, 'idt' => $idt, 'tte' => $tte);
			}
			echo json_encode($dats);
		}


		public function borrar_notificacion_respuestas(){
			$this->notif_restem->set('id', trim(strip_tags($_POST['idno'])));
			$this->notif_restem->set('id_receptor', trim(strip_tags($_POST['idre'])));
			$this->notif_restem->set('id_respuesta', trim(strip_tags($_POST['ires'])));

			$return = $this->notif_restem->delete();
			echo $return;
		}


		public function num_notificaciones_temas(){
			$this->notif_tem->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$res = $this->notif_tem->contar_notificaciones();
			return $res;
		}

		public function notificaciones_temas(){
			$this->notif_tem->set('id_receptor', trim(strip_tags($_SESSION['userSesion']['id'])));
			$return = $this->notif_tem->ver_todas();

			$dats = array();

			while($r = $return->fetch_array()){
				$ide = $r['id_emisor'];
				$idr = $r['id_receptor'];
				$tit = $r['titulo'];
				$idt = $r['id'];
				$fep = $r['fecha_publicacion'];
				$nom = $r['nombre_user'];
				$frl = $r['fecha_rango_limite'];
				$nit = $r['nivel_tema'];

				$dats[] = array('ide' => $ide, 'idr' => $idr, 'tit' => $tit, 'idt' => $idt, 'fep' => $fep, 'nom' => $nom, 'frl' => $frl, 'nit' => $nit);
			}
			echo json_encode($dats);
		}


		public function notificar_mensajes(){
			$this->notif_msg->set('id_receptor', $_SESSION['userSesion']['id']);

			$return = $this->notif_msg->notificar();

			if(isset($_GET['get_type']) && $_GET['get_type'] == 'ajax'){
				echo $return; 
			}
			else{
				return $return;
			}
		}
	}


 ?>