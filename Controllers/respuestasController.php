<?php 
	namespace Controllers;

	use Models\Respuesta as Respuesta;
	use Models\Tema as Tema;
	use Classes\InputFilter as Filter;
	use Models\Notificacion_respuesta_tema as NotifResT;
	use Classes\Method as Method;

	class respuestasController{

		private $respuesta;
		private $notif_rt;
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
			if(isset($_SESSION['userSesion'])){
				if($_POST){
					$return = $this->registrar_respuesta();
					return $return;
				}
			}
			else{
				header("Location:".URL);	
			}
		}


		public function borrar(){
			$this->respuesta->set('id', trim(strip_tags($_POST['idr'])));
			$this->respuesta->set('id_tema', trim(strip_tags($_POST['idte'])));
			$this->respuesta->set('id_usuario', trim(strip_tags($_POST['idu'])));

			$return = $this->respuesta->delete();
			echo $return;
		}

		public function calificar(){
			if(false == preg_match("/^\d*$/", $_POST['cal'])){
				echo "false";
				return false;
			}

			if($_POST['cal'] < 1 || $_POST['cal'] > 10){
				echo "false";
				return false;
			}

			$this->respuesta->set('id', trim(strip_tags($_POST['idr'])));
			$this->respuesta->set('id_tema', trim(strip_tags($_POST['idte'])));
			$this->respuesta->set('id_usuario', trim(strip_tags($_POST['idu'])));
			$this->respuesta->set('calificacion', trim(strip_tags($_POST['cal'])));

			$id_receptor = $this->respuesta->get('id_usuario');
			$this->respuesta->set('dato_ambiguo', $id_receptor);
			
			$this->notif_rt = new NotifResT();
			$this->notif_rt->set('tipo_notificacion', 'CA');
			$this->notif_rt->set('id_respuesta', trim(strip_tags($_POST['idr'])));
			$this->notif_rt->set('id_emisor', trim(strip_tags($_POST['idu'])));
			$this->notif_rt->set('id_receptor', $id_receptor);
			$this->notif_rt->set('notificacion_respuesta_tema', "calificó tu respuesta:");
			$this->notif_rt->set('fecha_notificacion_respuesta_tema', date("Y-m-d"));

			$n = $this->notif_rt->add();

			if($n == "true"){
				$return = $this->respuesta->qualify();
				echo $return;
			}
		}


		public function grateful(){
			$this->respuesta->set('id', trim(strip_tags($_POST['idr'])));
			$this->respuesta->set('id_tema', trim(strip_tags($_POST['idte'])));
			$this->respuesta->set('id_usuario', trim(strip_tags($_POST['idu'])));

			$id_receptor = $this->respuesta->get('id_usuario');
			
			$this->notif_rt = new NotifResT();
			$this->notif_rt->set('tipo_notificacion', 'GR');
			$this->notif_rt->set('id_respuesta', trim(strip_tags($_POST['idr'])));
			$this->notif_rt->set('id_emisor', trim(strip_tags($_POST['idu'])));
			$this->notif_rt->set('id_receptor', $id_receptor);
			$this->notif_rt->set('notificacion_respuesta_tema', "agradeció tu respuesta:");
			$this->notif_rt->set('fecha_notificacion_respuesta_tema', date("Y-m-d"));

			$n = $this->notif_rt->add();

			if($n == "true"){
				$return = $this->respuesta->edit('grateful');
				echo $return;
			}
		}


		public function paginar_respuestas($arg){
			$this->respuesta->set('id_tema', trim(strip_tags($arg)));
			$pages = $this->respuesta->paginar();
			return $pages;
		}

		public function paginar_my($arg = null){
			if(isset($_SESSION['userSesion'])){
				$this->respuesta->set('id_usuario', trim(strip_tags($_SESSION['userSesion']['id'])));
				if(isset($arg) && $arg == 'true'){
					$this->respuesta->set('dato_ambiguo', 'examen');
				}
				
				$return = $this->respuesta->paginar_my();

				return $return;
			}
			else{
				header('Location:'.URL);	
			}
		}

		public function ver_todos($idt, $lim){
			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 5;

			$this->respuesta->set('limite', $lim);
			$this->respuesta->set('id_tema', $idt);
			$return = $this->respuesta->ver_todos();
			return $return;
		}

		public function get_id_tema($arg){
			$this->respuesta->set('id', $arg);
			$dat = $this->respuesta->get('id_tema');

			return $dat;
		}


		public function pagina($lim){
			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 5;

			if(isset($_SESSION['userSesion'])){
				if(isset($_GET['exams']) && $_GET['exams'] == 'true'){
					$this->respuesta->set('dato_ambiguo', 'examen');
				}

				$this->respuesta->set('limite', $lim);
				$this->respuesta->set('id_usuario', trim(strip_tags($_SESSION['userSesion']['id'])));
				$return = $this->respuesta->listar();

				return $return;
			}
			else{
				header("Location: ".URL);
			}
		}

		public function my(){
			if(isset($_SESSION['userSesion'])){
				if(isset($_GET['exams']) && $_GET['exams'] == 'true'){
					$this->respuesta->set('dato_ambiguo', 'examen');
				}
				$return = $this->pagina(1);

				return $return;
			}
			else{
				header("Location: ".URL);
			}
		}


		public function buscar($arg){
			if(isset($_SESSION['userSesion'])){
				if(!$arg) $arg = false;

				$this->respuesta->set('dato_ambiguo', trim(strip_tags($arg)));
				$return = $this->respuesta->buscar();

				return $return;
			}
			else{
				header("Location: ".URL);
			}
		}

		public function paginar_rep(){
			if(isset($_SESSION['userSesion'])){
				$this->respuesta->set('id_usuario', trim(strip_tags($_SESSION['userSesion']['id'])));
				$return = $this->respuesta->paginar_rep();

				return $return;
			}
			else{
				header('Location:'.URL);	
			}
		}

		public function reportadas(){
			
			if(isset($_GET['page']) && is_numeric($_GET['page'])){
				$lim = trim(strip_tags($_GET['page']));
			}
			else{
				$lim = 1;
			}

			$lim--;
			$lim *= 5;

			if(isset($_SESSION['userSesion'])){
				if($_SESSION['userSesion']['rol'] == 'Tutor'){
					$this->respuesta->set('limite', $lim);
					$this->respuesta->set('id_usuario', $_SESSION['userSesion']['id']);
					$res = $this->respuesta->ver_reportes();
					return $res;
				}
				else{
					header("Location:". URL);
				}
			}
			else{
				header("Location:". URL);
			}
		}

		public function ver($arg){
			if(isset($_SESSION['userSesion'])){
				if(!$arg) $arg = false;
				$id = filter_var($arg, FILTER_VALIDATE_INT);
				if($id < 1) $id = 1;

				$idt = $this->get_id_tema($arg);

				$tem = new temasController();

				$getids = $tem->get_ids_g_p($idt);
				$idu = $getids[0];
				$member = $getids[1];


				if($member == 1 || $idu == $_SESSION['userSesion']['id']){

					$this->respuesta->set('id', trim(strip_tags($id)));

					$return = $this->respuesta->ver();

					return $return;
				}
				else{
					header("Location: ".URL);
				}
			}
			else{
				header("Location: ".URL);
			}

		}

		public function reportar(){
			if(isset($_SESSION['userSesion'])){
				if(isset($_POST['idr']) && is_numeric($_POST['idr'])){
					$this->respuesta->set('id', trim($_POST['idr']));
					$this->respuesta->set('id_usuario', $_SESSION['userSesion']['id']);
					
					$res = $this->respuesta->reportar();
					echo $res;
				}
			}
			else{
				echo "ses";
			}
		}

		public function registrar_respuesta(){

			$pd = json_decode(base64_decode($_POST['post_dats_respuestas']));

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\'\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,150}$/", $_POST['titulo_respuesta'])){
				return "Falta el título de la respuesta, o utilizaste un caracter extraño!!";
			}

			if(false == preg_match("/^[0-9a-z]{15,16}$/", $pd->idu)){
				return "Id Invaĺido!!";
			}

			if(false == preg_match("/^[0-9a-z\_\s]{1,100}$/", $pd->ti)){
				return "Nombre de tema inválido!!";
			}

			if(false == preg_match("/^\d*$/", $pd->idt)){
				return "Identificador inválido!!";
			}

			if(isset($_POST['calif'])){
				if(false == preg_match("/^\d*$/", $_POST['calif'])){
					return "Calificación no válida!!";
				}
				else{
					$calif = trim($_POST['calif']);
				}
			}
			else{
				$calif = 0;
			}


			$cresp = html_entity_decode(trim($_POST['content_resp']));
			$this->filter = new Filter(array('br','a','img','p','span','div','audio','figure','iframe','b','i','u','h1','blockquote','ul','ol','li','table','tbody','tr','td','font', 'input','textarea','select','option'), array('id','class','align','src','href','color','face','contenteditable','width','height','style','allowfullscreen','frameborder', 'controls','download', 'type', 'checked','value','selected'));
			$cresp = addslashes($cresp);
			$cresp = $this->filter->process($cresp);
			$cresp = htmlentities($cresp);

			$this->respuesta->set('id_usuario', trim(strip_tags($pd->idu)));
			$this->respuesta->set('id_tema', trim(strip_tags($pd->idt)));
			$this->respuesta->set('titulo_respuesta', trim(strip_tags($_POST['titulo_respuesta'])));
			$this->respuesta->set('respuesta', $cresp);
			$this->respuesta->set('numero_respuestas', 0);
			$this->respuesta->set('gratificaciones', 0);
			$this->respuesta->set('calificacion', $calif);
			$this->respuesta->set('total_reportes', 0);

			if(isset($_POST['exam']) && $_POST['exam'] == 1){
				$this->respuesta->set('dato_ambiguo', trim($_POST['exam']));
			}
			else{
				$this->respuesta->set('dato_ambiguo', 0);	
			}


			$res = $this->respuesta->add();

			if($res != "false" && $res != 'exist' && $res != 'caduc'){
				$this->respuesta->set('dato_ambiguo', trim($pd->idu));
				$this->respuesta->add_points();

				$tem = new Tema();
				$tem->set('id', $pd->idt);
				$id_receptor = $tem->get('id_usuario');
				
				$this->notif_rt = new NotifResT();
				$this->notif_rt->set('tipo_notificacion', 'RE');
				$this->notif_rt->set('id_respuesta', $res);
				$this->notif_rt->set('id_emisor', trim(strip_tags($pd->idu)));
				$this->notif_rt->set('id_receptor', $id_receptor);
				$this->notif_rt->set('notificacion_respuesta_tema', "respondió a uno de tus temas:");
				$this->notif_rt->set('fecha_notificacion_respuesta_tema', date("Y-m-d"));
				$n = $this->notif_rt->add();

				if($n){
					echo $n;
				}
			}
			else{
				echo $res;
			}
		}	
	}


 ?>