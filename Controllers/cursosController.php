<?php 
	namespace Controllers;

	use Models\Curso as Curso;
	use Models\Stream as Stream;
	use Classes\Method as Method;
	use Classes\WordCloud as wordCloud;

	class cursosController{

		private $curso;
		private $wrdcloud;
		private $stream;
		private $funcion;

		public function __construct(){
			$this->curso = new Curso();
		}

		public function funcion($funcion, $arg){
			$this->funcion = new Method();
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index(){}

		public function nuevo(){
			if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor'){
				if($_POST){
					$return = $this->registrar_curso();
					return $return;
				}
			}
			else{
				header("Location:".URL);	
			}
		}

		public function avances($arg){
			if($arg == 'my' && isset($_SESSION['userSesion'])){
				$user = $_SESSION['userSesion']['id'];
			}
			else{
				$user = trim(strip_tags($arg));
			}

			$this->curso->set('id_usuario', $user);

			$return = $this->curso->get_all_by_cur();

			return $return;
		}

		public function grafica($arg){
			if($arg == 'my' && isset($_SESSION['userSesion'])){
				$user = $_SESSION['userSesion']['id'];
			}
			else{
				$user = trim(strip_tags($arg));
			}

			$this->curso->set('id_usuario', $user);

			$return = $this->curso->get_all_by_cur();

			return $return;
		}

		public function paginar_calif($arg){
			if(isset($_SESSION['userSesion'])){
				if($arg == 'my'){
					$this->curso->set('id_usuario', $_SESSION['userSesion']['id']);
				}
				else{
					if($_SESSION['userSesion']['rol'] == 'Tutor'){
						$this->curso->set('id_usuario', trim(strip_tags($arg)));
						$this->curso->set('dato_ambiguo', $_SESSION['userSesion']['id']);
					}
					else{
						$this->curso->set('id_usuario', trim(strip_tags($arg)));
					}
				}

				$res = $this->curso->paginar_get_qualifies();
				return $res;
			}
		}

		public function calificaciones($arg){
			if(isset($_SESSION['userSesion'])){
				if($arg == 'my'){
					$this->curso->set('id_usuario', $_SESSION['userSesion']['id']);
				}
				else{
					if($_SESSION['userSesion']['rol'] == 'Tutor'){
						$this->curso->set('id_usuario', trim(strip_tags($arg)));
						$this->curso->set('dato_ambiguo', $_SESSION['userSesion']['id']);
					}
					else{
						$this->curso->set('id_usuario', trim(strip_tags($arg)));
					}
				}

				if(!isset($_GET['page'])){
					$this->curso->set('limite', 0);
				}
				else{
					$lim = filter_var(trim($_GET['page']), FILTER_VALIDATE_INT);
					$lim--;
					$lim *= 20;
					$this->curso->set('limite', $lim);
				}

				if(!isset($_GET['b'])){
					$return = $this->curso->get_qualifies();
				}
				else{
					$ncrso = trim(strip_tags($_GET['b']));
					$this->curso->set('nombre_materia_curso', $ncrso);
					$return = $this->curso->search_qualifies();
				}
				
				$dats = array();

				while($r = $return->fetch_array()){
					$idu = $r['id_usuario'];
					$nom = $r['nombre'];
					$fot = $r['foto'];
					$idc = $r['id_curso'];
					$ncr = $r['nombre_curso'];
					$tit = $r['titulo_tema'];
					$idt = $r['id_tema'];
					$cal = $r['calificacion'];
					$trp = $r['titulo_respuesta'];
					$tim = $r['time_respuesta'];
					$idr = $r['id_respuesta'];

					$dats[] = array('idu' => $idu, 'nom' => $nom, 'fot' => $fot, 'idc' => $idc, 'ncr' => $ncr, 'tit' => $tit, 'idt' => $idt, 'cal' => $cal, 'trp' => $trp, 'tim' => $tim, 'idr' => $idr);
				}

				if(isset($_GET['get_type'])){
					echo json_encode($dats);
				}
				else{
					return $dats;
				}

			}
			else{
				header("Location:". URL);
			}
		}

		public function ver($arg){
			$arg = filter_var($arg, FILTER_VALIDATE_INT);
			$this->curso->set('id', trim(strip_tags($arg)));

			$return = $this->curso->ver();
			$dats = array();

			while($r = $return->fetch_array()){
				$id = $r['id'];
				$nc = $r['nombre_materia_curso'];

				$dats[] = array('id' => $id, 'nc' => $nc);
			}

			if(isset($_GET['get_type'])){
				echo json_encode($dats);
			}
			else{
				return $dats;
			}
		}

		public function activity(){
			$return = $this->curso->get('activity');
			return $return;
		}

		public function borrar(){
			$this->curso->set('id', trim(strip_tags($_POST['idcr'])));
			$this->curso->set('nombre_materia_curso', trim(strip_tags($_POST['nocr'])));
			$return = $this->curso->delete();
			echo $return;
		}

		public function listar($arg, $lim = 0){

			if(!$lim  && isset($_GET['limit'])){
				$lim = $_GET['limit'];
			}

			$this->curso->set('id_grupo', trim(strip_tags($arg)));
			$this->curso->set('limite', $lim);
			$return = $this->curso->ver_todos();
			$dats = array();

			while($r = $return->fetch_array()){
				$id = $r['id'];
				$nc = $r['nombre_materia_curso'];

				$dats[] = array('id' => $id, 'nc' => $nc);
			}

			if(isset($_GET['get_type'])){
				echo json_encode($dats);
			}
			else{
				return $dats;
			}
		}

		public function get_tags_curso($arg){
			$this->curso->set('id_grupo', trim(strip_tags($arg)));
			$r = $this->curso->get_tags_curso();


			$this->wrdcloud = new wordCloud(false, trim(strip_tags($arg)));

			$str = "";

			while($d = $r->fetch_array()) {
				$str = $str.$d['tags'];
			}

			$str = explode(",", strtolower($str));

			for($i = 0; $i < count($str); $i++){
				$this->wrdcloud->addWord(trim($str[$i]));
			}

			$this->wrdcloud->removeWord('a');
			$this->wrdcloud->removeWord('ante');
			$this->wrdcloud->removeWord('bajo');
			$this->wrdcloud->removeWord('cabe');
			$this->wrdcloud->removeWord('con');
			$this->wrdcloud->removeWord('contra');
			$this->wrdcloud->removeWord('de');
			$this->wrdcloud->removeWord('desde');
			$this->wrdcloud->removeWord('hasta');
			$this->wrdcloud->removeWord('para');
			$this->wrdcloud->removeWord('hacia');
			$this->wrdcloud->removeWord('por');
			$this->wrdcloud->removeWord('segun');
			$this->wrdcloud->removeWord('sin');
			$this->wrdcloud->removeWord('sobre');
			$this->wrdcloud->removeWord('tras');
			$this->wrdcloud->removeWord('el');
			$this->wrdcloud->removeWord('la');
			$this->wrdcloud->removeWord('los');
			$this->wrdcloud->removeWord('las');
			$this->wrdcloud->removeWord('si');
			$this->wrdcloud->removeWord('no');
			$this->wrdcloud->setLimit(10);

			return $this->wrdcloud->showCloud();

		}

		public function id_propietario_curso($arg){
			$arg = trim(strip_tags($arg));
			$arg = filter_var($arg, FILTER_VALIDATE_INT);

			$this->curso->set('id', $arg);
			$return = $this->curso->id_propietario_curso();
			$id = $return->fetch_array();

			if(isset($_GET['get_type'])){
				echo $id['id_usuario'];
			}
			else{
				return $id['id_usuario'];
			}
		}

		public function id_grupo_curso($arg){
			$arg = trim(strip_tags($arg));
			$arg = filter_var($arg, FILTER_VALIDATE_INT);

			$this->curso->set('id', $arg);
			$return = $this->curso->id_grupo_curso();
			$id = $return->fetch_array();


			if(isset($_GET['get_type'])){
				echo $id['id_grupo'];
			}
			else{
				return $id['id_grupo'];	
			}
		}

		public function get_nom_grp_curso($arg){
			$arg = trim(strip_tags($arg));
			$arg = filter_var($arg, FILTER_VALIDATE_INT);

			$this->curso->set('id', $arg);
			$return = $this->curso->get_nom_grp_curso();
			$dats = $return->fetch_array();

			return array($dats[0], $dats[1], $this->funcion('normalize', $dats[1]).".".$dats[2]);
		}

		public function registrar_curso(){

			$pd = json_decode(base64_decode($_POST['post_dats']));

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,100}$/", $_POST['nombre_materia_curso'])){
				return "Indica el nombre del Curso o Materia, (No se permiten caracteres especiales, solamente alfa numéricos)!!";
			}

			if(false == preg_match("/^[0-9a-z]{16}$/", $pd->id)){
				return "Id Invaĺido!!";
			}

			if(false == preg_match("/^[0-9a-z\_\s]{3,80}$/", $pd->ng)){
				return "Nombre de grupo inválido!!";
			}

			if(false == preg_match("/^\d*$/", $pd->idg)){
				return "Identificador inválido!!";
			}

			$this->curso->set('id_usuario', trim(strip_tags($pd->id)));
			$this->curso->set('id_grupo', trim(strip_tags($pd->idg)));
			$this->curso->set('nombre_materia_curso', trim(strip_tags($_POST['nombre_materia_curso'])));
			$this->curso->set('fecha_creacion_materia_curso', date("Y-m-d"));

			$res = $this->curso->add();

			if($res){
				$this->stream = new Stream();
				$this->stream->set('id_usuario', trim($pd->id));
				$this->stream->set('id_grupo', trim($pd->idg));
				$this->stream->set('stream_tipo', 'CU');
				$this->stream->set('fecha_stream', date('Y-m-d'));
				$this->stream->set('id_comentario', '0');
				$re = $this->stream->add();

				if($re){
					header("Location:".URL."grupos/ver/".$pd->ng.".".$pd->idg."#actionsGrupo");	
				}
				else{
					return "Error al guardar curso!";
				}
			}
			else if($res === false){
				return "Ya existe un curso con el mismo nombre, elige otro nombre!!";
			}
			else{
				return "Error al guardar curso!!";
			}
			
		}
		
	}


 ?>