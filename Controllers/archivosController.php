<?php 
	namespace Controllers;

	use Models\Archivo_tema as Archivo_tema;
	use Models\Archivo_respuesta as Archivo_resp;

	class archivosController{
		private $archivo_t;
		private $archivo_r;

		public function __construct(){
			$this->archivo_t = new Archivo_tema();
			$this->archivo_r = new Archivo_resp();
		}

		public function index(){}

		public function nuevo_at($id_tema, $id_archivo, $nombre_archivo, $mime){
			$this->archivo_t->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->archivo_t->set('id_tema', trim(strip_tags($id_tema)));
			$this->archivo_t->set('id_archivo', trim(strip_tags($id_archivo)));
			$this->archivo_t->set('nombre_archivo', trim(strip_tags($nombre_archivo)));
			$this->archivo_t->set('mime_archivo', trim(strip_tags($mime)));
			$this->archivo_t->set('fecha_archivo', date("Y-m-d"));
			
			$return = $this->archivo_t->add();
			return $return;
		}

		public function borrar_at(){
			$this->archivo_t->set('id', trim(strip_tags($_POST['ida'])));
			$this->archivo_t->set('id_archivo', trim(strip_tags($_POST['idar'])));

			$return = $this->archivo_t->delete();

			if($return == 'true'){
				$ruta = ROOT."Resources".DS.trim($_POST['di']).DS;
				opendir($ruta);

				$file = $ruta.trim($_POST['idar']);
				if(is_readable($file)){
					unlink($file);
					echo $return;
				}
				else{
					echo 'ruta invalida '.$file;
				}
			}

		}

		public function ver_at($id){
			$this->archivo_t->set('id_tema', $id);
			$return = $this->archivo_t->ver();
			return $return;
		}

		public function nuevo_ar($id_tema, $id_archivo, $nombre_archivo, $mime){
			$this->archivo_r->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->archivo_r->set('id_tema', trim(strip_tags($id_tema)));
			$this->archivo_r->set('id_archivo', trim(strip_tags($id_archivo)));
			$this->archivo_r->set('nombre_archivo', trim(strip_tags($nombre_archivo)));
			$this->archivo_r->set('mime_archivo', trim(strip_tags($mime)));
			$this->archivo_r->set('fecha_archivo', date("Y-m-d"));
			
			$return = $this->archivo_r->add();
			return $return;
		}


		public function borrar_ar(){
			$this->archivo_r->set('id', trim(strip_tags($_POST['ida'])));
			$this->archivo_r->set('id_archivo', trim(strip_tags($_POST['idar'])));

			$return = $this->archivo_r->delete();

			
			if($return == 'true'){
				$ruta = ROOT."Resources".DS.trim($_POST['di']).DS;
				opendir($ruta);

				$file = $ruta.trim($_POST['idar']);
				if(is_readable($file)){
					unlink($file);
					echo $return;
				}
				else{
					echo 'ruta invalida '.$file;
				}
			}
		}

		public function ver_ar($id){
			$this->archivo_r->set('id_tema', $id);
			$this->archivo_r->set('id_usuario', $_SESSION['userSesion']['id']);
			$return = $this->archivo_r->ver();
			return $return;
		}

		public function ver_arat($id){
			$this->archivo_t->set('dato_ambiguo', $id);
			$this->archivo_t->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->archivo_r->set('dato_ambiguo', $id);
			$this->archivo_r->set('id_usuario', $_SESSION['userSesion']['id']);

			$return1 = $this->archivo_t->verarat();
			$return2 = $this->archivo_r->verarat();
			return array($return1, $return2);
		}

	}

 ?>