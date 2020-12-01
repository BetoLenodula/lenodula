<?php
	namespace Controllers;

	use Models\Grupo as Grupo;
	use Models\Notificacion_grupo as NotifGrupo;
	use Models\Stream as Stream;
	use Classes\Method as Method;
	use Classes\Resize as Resize;
	use Classes\Cache as Cache;

	class gruposController{

		private $grupo;
		private $funcion;
		private $notif_grupo;
		private $stream;

		public function __construct(){
			$this->grupo  = new Grupo();	
			Cache::configure(array(
    			'cache_path' => ROOT.'cache/groups',
    			'expires' => (60 * 60 * 24)
			));
		}


		public function funcion($funcion, $arg){
			$this->funcion = new Method();
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index($lim){
			$return = $this->pagina(1);
			return $return;
		}


		public function pagina($lim){
			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 6;

			$this->grupo->set('limite', $lim);
			$return = $this->grupo->ver_todos();

			return $return;
		}

		public function confirmar_pass_borrar(){
			if(isset($_SESSION['userSesion'])){

				if($_POST['passw'] == ""){
					return "Falta proporcionar un password!";	
				}

				if(strlen($_POST['passw']) < 8){
					return "El pasword debe tener al menos 8 caracteres!!";
				}

				if(strlen($_POST['passw']) > 15){
					return "El pasword es muy largo!!";
				}

				if(false == preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&_.]{8,15}$/", $_POST['passw'])){
					return "El password no tiene el formato correcto, quiza tenga caracteres no permitidos!";
				}
				

				$this->grupo->set('id_usuario', trim($_SESSION['userSesion']['id']));
				$this->grupo->set('dato_ambiguo', sha1(sha1(trim($_POST['passw']))));

				$res = $this->grupo->confirm_pass();

				if($res){
					echo "true";
				}
				else{
					echo "false";
				}

			}
			else{
				echo "ses";
			}
		}

		public function borrar(){
			if(isset($_SESSION['userSesion'])){
				$this->grupo->set('id', trim($_POST['idgr']));
				$this->grupo->set('id_usuario', trim($_SESSION['userSesion']['id']));

				$res = $this->grupo->delete();

				if($res){
					echo "true";
				}
				else{
					echo "false";
				}
			}
			else{
				echo "ses";
			}
		}


		public function buscar($arg){
			if(!$arg) $arg = false;

			if($arg == 'my'){
				if(isset($_SESSION['userSesion'])){
					$this->grupo->set('id_usuario', trim(strip_tags($_SESSION['userSesion']['id'])));

					if($_SESSION['userSesion']['rol'] == 'Tutor'){
						if(isset($_GET['n_grupos'])){
							$return = $this->grupo->ver_mis_grupos(1);	
						}
						else{
							$return = $this->grupo->ver_mis_grupos();	
						}
						
					}

					if($_SESSION['userSesion']['rol'] == 'Usuario'){
						$return = $this->grupo->ver_grupos_miembro();		
					}	
				}
				else{
					header("Location:".URL);
				}
			}
			else{
				$this->grupo->set('dato_ambiguo', trim(strip_tags($arg)));
				$return = $this->grupo->buscar();	
			}

			return $return;
		}

		public function ver($arg){
			if(!$arg) $arg = false;

			$arg = explode(".", $arg);
			$id = filter_var(end($arg), FILTER_VALIDATE_INT);
			$arg = $arg[0];

			$this->grupo->set('nombre_grupo', trim(strip_tags($arg)));
			$this->grupo->set('id', trim(strip_tags($id)));

			if($_POST){
				if(isset($_POST['guardar_foto']) &&
					$_POST['guardar_foto'] == 'GUARDAR'){
					$this->subir_foto($arg, $id);
				}
			
			}

			$cache = Cache::get($arg.".".$id);

			if(!$cache){
				$ret = $this->grupo->ver();
				$return = $ret->fetch_array();
				Cache::put($arg.".".$id, $return);
			}
			else{
				$return = $cache;
			}

			return array($return, $arg.".".$id);
		}

		public function subir_foto($name, $id){
			
			if(!empty($_FILES['foto']['name'])){
				
				$fsize = $_FILES['foto']['size'];
				$ftype = strip_tags(trim($_FILES['foto']['type']));
				$foto = strip_tags(trim($_FILES['foto']['name']));

				if($ftype != 'image/jpeg'){
					return 'Formato de Foto Inválido (Debe ser jpg o jpeg)';
				}

				if($fsize > (3520 * 1000)){
					return 'Tamaño de Foto excedido al permitido';
				}
			
				$ruta = ROOT."Views".DS."template".DS."images".DS."pictures_grps".DS;
				opendir($ruta);

				$fotoUp = $ruta.$foto;

				if(isset($_POST['hidefoto']) && !empty($_POST['hidefoto']) && $_POST['hidefoto'] != 'none'){
					$oldfoto = $ruta.trim(strip_tags($_POST['hidefoto']));

					if(is_readable($oldfoto)){
						unlink($oldfoto);
					}
				}

				if(move_uploaded_file(strip_tags(trim($_FILES['foto']['tmp_name'])), $fotoUp)){
					
					$nameFoto = md5($name.".".$id);

					$nameFoto = $nameFoto.".jpg";


					$imgResize = new Resize($fotoUp);
					$imgResize->resizeImage(230, 230, 'crop');  
					$imgResize->saveImage($ruta.$nameFoto, 80);
					
					if(is_readable($fotoUp)){
						unlink($fotoUp);
					}

					$this->grupo->set('foto_grupo', $nameFoto);

					$res = $this->grupo->guardar_foto();

					if($res){
						Cache::delete($name.".".$id);
						header("Location:".URL."grupos/ver/".$name.".".$id);
					}
					else{
						return 'Error al guardar nombre de imagen!';
					}
				}
				else{
					return 'Error al Subir Foto';
				}
			}
			else{
				return 'No has elegido una imagen para subir!!';
			}
			
		}



		public function editar($arg = 0){
			if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor'){
				if($_POST){
					$return = $this->registrar_grupo('edit');
					return $return;
				}
				else{
					$r = $this->ver($arg);
					$return = $r[0];
					if($return['id_usuario'] === $_SESSION['userSesion']['id']){
						Cache::delete($arg);
						return $return; 
					}
					else{
						header("Location:".URL);
					}
				}	
			}
			else{
				header("Location:".URL);
			}
		}

		public function unirse($arg){
			if(!$arg) $arg = false;

			$arg = explode(".", $arg);
			$id = filter_var(end($arg), FILTER_VALIDATE_INT);
			$arg = $arg[0];
			
			if(isset($_SESSION['userSesion'])){
				$this->grupo->set('nombre_grupo', trim(strip_tags($arg)));
				$this->grupo->set('id', trim(strip_tags($id)));
				$this->grupo->set('id_grupo', trim(strip_tags($id)));
				$this->grupo->set('id_usuario', trim(strip_tags($_SESSION['userSesion']['id'])));
				$this->grupo->set('fecha_agregado', date('Y-m-d'));
				$this->grupo->set('acceso_grupo', 0);
				$this->grupo->set('status_miembro', 0);

				$res = $this->grupo->unirse();

				if($res){
					if($res == '1'){
						$this->notif_grupo = new NotifGrupo();
						$this->notif_grupo->set('id_emisor', trim(strip_tags($_SESSION['userSesion']['id'])));
						$this->notif_grupo->set('id_grupo', trim(strip_tags($id)));
						$this->notif_grupo->set('notificacion_grupo', "quiere unirse a tu grupo");
						$this->notif_grupo->set('fecha_notificacion_grupo', date('Y-m-d'));
						$notif = $this->notif_grupo->add();
					}
					else{

						$this->stream = new Stream();
						$this->stream->set('id_usuario', trim($_SESSION['userSesion']['id']));
						$this->stream->set('id_grupo', trim($id));
						$this->stream->set('stream_tipo', 'ME');
						$this->stream->set('fecha_stream', date('Y-m-d'));
						$this->stream->set('id_comentario', '0');

						$re = $this->stream->add();

						$notif = "true";
					}
					

					if($notif){
						header("Location:".URL."grupos/ver/".$arg.".".$id);
					}
					else{
						return "false";
					}
				}
				else{
					return "false";
				}
			}
			else{
				return "false";
			}

		}

		public function add_member(){
			if($_POST){
				$sel = json_decode(base64_decode($_POST['n_grupo']));
				$idu = base64_decode($_POST['post_dats_usid']);

				$pos = explode("_", $sel->pos);
				$pos = end($pos);

				if(false == preg_match( "/^\d*$/", $sel->id)){
					return "Identificador inválido!!";
				}
				if(false == preg_match( "/^\d*$/", $pos)){
					return "Identificador inválido!!";
				}
				if($sel->id != $pos){
					return "Indentificador inválido!!";
				}
				if(false == preg_match("/^[0-9a-z]{15,16}$/", $idu)){
					return "Indentificador de Usuario inválido!!";
				}
				if(false == preg_match("/^[0-9a-z]{16}$/", $_POST['idse'])){
					return "Indentificador de Sesión inválido!!";
				}

				$this->grupo->set('id_usuario', trim(strip_tags($idu)));
				$this->grupo->set('id_grupo', trim(strip_tags($sel->id)));
				$this->grupo->set('fecha_agregado', date("Y-m-d"));
				$this->grupo->set('acceso_grupo', 1);
				$this->grupo->set('status_miembro', 1);

				$return = $this->grupo->add_miembro();

				if($return == 'true'){
					$this->notif_grupo = new NotifGrupo();
					$this->notif_grupo->set('id_emisor', trim(strip_tags($_POST['idse'])));
					$this->notif_grupo->set('id_receptor', trim(strip_tags($idu)));
					$this->notif_grupo->set('id_grupo', trim(strip_tags($sel->id)));
					$this->notif_grupo->set('notificacion_grupo', "te agregó a su grupo");
					$this->notif_grupo->set('fecha_notificacion_grupo', date('Y-m-d'));
					$notif = $this->notif_grupo->add();
					if($notif == 'true'){

						$this->stream = new Stream();
						$this->stream->set('id_usuario', trim($idu));
						$this->stream->set('id_grupo', trim($sel->id));
						$this->stream->set('stream_tipo', 'ME');
						$this->stream->set('fecha_stream', date('Y-m-d'));
						$this->stream->set('id_comentario', '0');

						$re = $this->stream->add();
						echo "true";
					}
				}
				else{
					echo "false";
				}

			}
		}

		public function listar_algunos($id){
			$this->grupo->set('id', trim($id));
			$return = $this->grupo->listar_algunos();
			return $return;
		}

		public function metrica_user_grupo($idu, $idg){
			$this->grupo->set('id_usuario', trim(strip_tags($idu)));
			$this->grupo->set('id_grupo', trim(strip_tags($idg)));

			$return = $this->grupo->metrica();
			return $return;
		}

		public function banear(){
			$this->grupo->set('id_usuario', trim(strip_tags($_POST['use'])));
			$this->grupo->set('id_grupo', trim(strip_tags($_POST['idgr'])));

			$return = $this->grupo->banear_miembro();
			echo $return;	
		}

		public function borrar_miembro(){
			$this->grupo->set('id_usuario', trim(strip_tags($_POST['use'])));
			$this->grupo->set('id_grupo', trim(strip_tags($_POST['idgr'])));

			$return = $this->grupo->borrar_miembro();
			echo $return;	
		}


		public function abandonar($arg){
			if(!$arg) $arg = false;

			$arg = explode(".", $arg);
			$id = filter_var(end($arg), FILTER_VALIDATE_INT);
			$arg = $arg[0];

			if(isset($_SESSION['userSesion'])){
				$this->grupo->set('nombre_grupo', trim(strip_tags($arg)));
				$this->grupo->set('id', trim(strip_tags($id)));
				$this->grupo->set('id_usuario', trim(strip_tags($_SESSION['userSesion']['id'])));

				$this->grupo->set('id_grupo', trim(strip_tags($id)));

				$res = $this->grupo->abandonar();

				if($res){
					header("Location:".URL."grupos/ver/".$arg.".".$id);
				}
				else{
					return "false";
				}
			}
			else{
				return "false";
			}
		}

		public function aceptar_miembro(){
			$this->grupo->set('id_grupo', trim(strip_tags($_POST['idgr'])));
			$this->grupo->set('id_usuario', trim(strip_tags($_POST['idem'])));
			$return = $this->grupo->aceptar_miembro();
			echo $return;
		}

		public function ver_baneos($arg){
			$this->grupo->set('id_grupo', trim(strip_tags($arg)));
			$return = $this->grupo->ver_baneos();

			$dats = array();

			while($r = $return->fetch_array()) {
				$idu = $r['id_usuario'];
				$nom = $r['nombre_user'];
				$ids = $r['ids'];
				$fot = $r['foto'];

				$dats[] = array('idu' => $idu, 'nom' => $nom, 'ids' => $ids, 'fot' => $fot);
			}

			echo json_encode($dats);
		}

		public function desbloquear(){
			$this->grupo->set('id_grupo', trim(strip_tags($_POST['idgr'])));
			$this->grupo->set('id_usuario', trim(strip_tags($_POST['idu'])));
			$return = $this->grupo->desbloquear();
			echo $return;
		}

		public function ver_miembros($arg, $lim = 0){
			if(!$lim  && isset($_GET['limit'])){
				$lim = $_GET['limit'];
			}

			$this->grupo->set('limite', $lim);
			$this->grupo->set('id_grupo', trim(strip_tags($arg)));
			$return = $this->grupo->ver_miembros();

			$dats = array();

			while($r = $return->fetch_array()) {
				$idu = $r['id_usuario'];
				$nom = $r['nombre_user'];
				$ids = $r['ids'];
				$enl = $r['enlinea'];
				$fot = $r['foto'];
				$sta = $r['status_miembro'];

				$dats[] = array('idu' => $idu, 'nom' => $nom, 'ids' => $ids, 'enl' => $enl, 'fot' => $fot, 'sta' => $sta);
			}


			if(isset($_GET['get_type'])){
				echo json_encode($dats);
			}
			else{
				return $dats;
			}
		}

		public function get_events($arg){
			$eve = new agendasController();
			$return = $eve->get_by_group($arg);
			return $return;
		}

		public function get_creador_grupo($arg){
			$this->grupo->set('id_grupo', trim(strip_tags($arg)));
			$return = $this->grupo->get('creador');
			$r = $return->fetch_array();
			echo $r['id_usuario'];
		}

		public function nuevo(){
			if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor'){
				if($_POST){
					$return = $this->registrar_grupo('add');
					return $return;
				}
				else{
					return 'form';
				}	
			}
			else{
				header("Location:".URL);
			}
		}


		public function paginar_grupos(){
			$pages = $this->grupo->paginar();
			return $pages;
		}

		public function validar_miembro($idu, $idg, $arg){
			$this->grupo->set('id_usuario', trim(strip_tags($idu)));
			$this->grupo->set('id_grupo', trim(strip_tags($idg)));

			$return = $this->grupo->validar_miembro($arg);
			return $return;
		}

		public function contar_grupos(){
			$return = $this->grupo->contar_grupos();
			return $return;
		}

		public function registrar_grupo($arg){
			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,80}$/", $_POST['nombre_grupo'])){
				return "Proporciona un Nombre al Grupo, que sea mayor a 3 caracteres, (No caracteres especiales!)";
			}

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{3,250}$/", $_POST['descripcion_grupo'])){
				return "Proporciona una breve descripción al Grupo (250 caracteres máximo) algunos no son soportados!!";
			}

			if(($_POST['tipo_acceso'] != 'Privado') && ($_POST['tipo_acceso'] != 'Abierto')){
				return "Elige un tipo de Acceso al Grupo!";
			}

			if(!$_POST['theme']){
				return "Elige un tema visual que identifique al Grupo!";
			}

			if(false == preg_match("/^\#[0-9a-f]{6}$/", $_POST['color_theme'])){
				return "Elige un color válido para el tema!";
			}

			if(isset($_POST['datpost']) && $arg == 'edit'){
				$pd = json_decode(base64_decode($_POST['datpost']));

				if($pd->pref != 'prefix_group' || !is_numeric($pd->idg)){
					return "Id datos inválidos!";
				}
				else{
					$idg = $pd->idg;
					$this->grupo->set('id', $idg);
				}
			}

			$type = array('ñ', 'Ñ');
			$nombre_grupo = str_replace($type, "n", trim(strip_tags($_POST['nombre_grupo'])));

			$this->grupo->set('id_usuario', trim(strip_tags($_SESSION['userSesion']['id'])));
			$this->grupo->set('foto_grupo', 'none');
			$this->grupo->set('nombre_grupo', $nombre_grupo);
			$this->grupo->set('descripcion_grupo', trim(strip_tags($_POST['descripcion_grupo'])));
			$this->grupo->set('tipo_acceso', trim(strip_tags($_POST['tipo_acceso'])));
			$this->grupo->set('theme', trim(strip_tags(htmlspecialchars($_POST['theme']))));
			$this->grupo->set('color_theme', trim(strip_tags($_POST['color_theme'])));
			$this->grupo->set('fecha_creacion_grupo', date("Y-m-d"));


			if($arg == 'edit'){
				$res = $this->grupo->edit();
				$strtipo = 'GE';
			}
			if($arg == 'add'){
				$res = $this->grupo->add();	
				$strtipo = 'GR';
			}

			if(is_numeric($res)){
				$this->stream = new Stream();
				$this->stream->set('id_usuario', trim($_SESSION['userSesion']['id']));
				$this->stream->set('id_grupo', $res);
				$this->stream->set('stream_tipo', $strtipo);
				$this->stream->set('fecha_stream', date('Y-m-d'));
				$this->stream->set('id_comentario', '0');

				$re = $this->stream->add();

				if($re){
					return "signin";
				}
				else{
					return "Algo falló al guardar el grupo!";
				}
			}
			else if($res == 'limgrps'){
				return "El límite de grupos que puedes crear en esta prueba Online es el justo!";
			}
			else{
				return "El Grupo que quieres crear ya existe, elige otro nombre!";
			}

		}

	}

?>