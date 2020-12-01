<?php

	namespace Controllers;

	use Models\Comentario as Comentario;
	use Models\Stream as Stream;
	use Classes\Method as Method;
	use Classes\InputFilter as Filter;
	use Classes\WordCloud as wordCloud;

	class comentariosController{

		private $comentario;
		private $funcion;
		private $wrdcloud;
		private $stream;
		private $filter;

		public function __construct(){
			$this->comentario = new Comentario();
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
					$return = $this->registrar_comentario();
					return $return;
				}
			}
			else{
				header("Location:".URL);	
			}
		}

		public function borrar(){
			$this->comentario->set('id', trim(strip_tags($_POST['idc'])));
			$this->comentario->set('id_grupo', trim(strip_tags($_POST['idgr'])));
			$this->comentario->set('id_usuario', trim(strip_tags($_POST['idu'])));

			$return = $this->comentario->delete();
			echo $return;
		}

		public function like(){
			$this->comentario->set('id', trim(strip_tags($_POST['idc'])));
			$this->comentario->set('id_grupo', trim(strip_tags($_POST['idgr'])));
			$this->comentario->set('id_usuario', trim(strip_tags($_POST['idu'])));

			$return = $this->comentario->edit('like');
			echo $return;
		}

		public function dislike(){
			$this->comentario->set('id', trim(strip_tags($_POST['idc'])));
			$this->comentario->set('id_grupo', trim(strip_tags($_POST['idgr'])));
			$this->comentario->set('id_usuario', trim(strip_tags($_POST['idu'])));

			$return = $this->comentario->edit('dislike');
			echo $return;
		}

		public function paginar_comentarios($arg){
			$this->comentario->set('id_grupo', trim(strip_tags($arg)));
			$pages = $this->comentario->paginar();
			return $pages;
		}

		public function paginar_destacados($arg){
			$this->comentario->set('dato_ambiguo', trim(strip_tags($arg)));
			$pages = $this->comentario->paginar_destacados();
			return $pages;
		}

		public function destacar($arg){
			if(isset($_GET['page'])){
				$lim = filter_var($_GET['page'], FILTER_VALIDATE_INT);
			}
			else{
				$lim = false;
			}

			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 10;

			$this->comentario->set('limite', $lim);
			$this->comentario->set('dato_ambiguo', trim(strip_tags($arg)));
			$return = $this->comentario->ver_destacados();
			return $return;
		}

		public function ver_todos($idg, $lim){
			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 9;

			if(isset($_GET['c'])){
				$c = filter_var($_GET['c'], FILTER_VALIDATE_INT);
			}
			else{
				$c = 0;
			}

			$this->comentario->set('limite', $lim);
			$this->comentario->set('id_grupo', $idg);
			$return = $this->comentario->ver_todos($c);
			return $return;
		}


		public function get_tags_comentarios(){
			$r = $this->comentario->get_tags_comentarios();
			$this->wrdcloud = new wordCloud(false, 0);

			$str = "";

			while($d = $r->fetch_array()) {
				$str = $str.$d['hashtags'];
			}

			$str = explode(",", $str);

			for($i = 0; $i < count($str); $i++){
				$this->wrdcloud->addWord(trim($str[$i]));
			}

			$this->wrdcloud->setLimit(5);

			return $this->wrdcloud->showCloud();

		}

		public function comprobar_voto(){
			if(isset($_SESSION['userSesion'])){
				$this->comentario->set('id', trim(strip_tags($_POST['idcom'])));
				$this->comentario->set('id_usuario', $_SESSION['userSesion']['id']);
				$return = $this->comentario->get_vote_survey();
				echo $return;
			}
			else{
				echo "session";
			}
		}

		public function editar(){
			if(strlen(trim($_POST['com'])) > 1500){
				echo "El contenido rebasa el límite permitido!!";
			}
			if(false == preg_match("/^\d*$/", $_POST['idcome'])){
				echo "Id del comentario inválido!!";
			}
			if(false == preg_match("/^\d*$/", $_POST['idgroup'])){
				echo "Id del grupo inválido!!";
			}

			$comment = trim($_POST['com']);
			$this->filter = new Filter(array('br','a','img','p','iframe','meter', 'video'), array('id','class','src','href','frameborder','value','min','max', 'autoplay', 'loop'));
			$comment = $this->filter->process($comment);
			$comment = str_replace(array('"', "'"), '', $comment);
			if(strlen($comment) > 1500){
				echo "El contenido rebasa el límite permitido!!";
			}

			$this->comentario->set('id', trim(strip_tags($_POST['idcome'])));
			$this->comentario->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->comentario->set('id_grupo', trim(strip_tags($_POST['idgroup'])));
			$this->comentario->set('comentario', $comment);			

			$return = $this->comentario->edit_survey();
			echo $return;
		
		}

		public function registrar_comentario(){

			$pd = json_decode(base64_decode($_POST['post_dats_foro']));

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\'\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^\🙂\😀\😃\😄\😂\😍\😘\😜\😐\😏\😔\😷\😪\😴\😎\😭\😱\😡\😈\💩\😺\😹\😼\🙀\😾\🙈\🙉\🙊\💓\💕\💔\👋\👌\👈\👉\👆\👇\👍\👎\👊\💪\👶\👦\👧\👨‍💻\🚶\🚶‍♀️\💃\💑\👨‍❤️‍👨\👩‍❤️‍💋‍👩\🐶\🐱\🐯\🐽\🐭\🐼\🐻\🐥]{1,1500}$/", $_POST['comentario'])){
				return "Falta tu comentario, sobre pasa el límite o utilizaste un caracter extraño!!";
			}

			if(isset($_POST['survey']) && false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^\<\>]{1,244}$/", $_POST['survey'])){
				return "Utilizaste un caracter extraño en las opciones o excede la longitud!!";
			}

			if(false == preg_match("/^[0-9a-z]{16}$/", $pd->idu)){
				return "Id Invaĺido!!";
			}

			if(false == preg_match("/^[0-9a-z\_\s]{3,80}$/", $pd->ng)){
				return "Nombre de grupo inválido!!";
			}

			if(false == preg_match("/^\d*$/", $pd->idg)){
				return "Identificador inválido!!";
			}

			$comment = $this->funcion('findReplaceURL', trim($_POST['comentario']));
			if(is_array($comment)){
				$comment = $comment[0];
				$hashtags = "VIDEO,";
			}
			else{
				$fhash = $this->funcion('findHashTags', trim($comment));
				$comment = $fhash[0];
				$hashtags = $fhash[1].',';
				$hashtags = str_replace("#", '', $hashtags);
			}

			if(isset($_POST['pict_comment']) && !empty($_POST['pict_comment'])){
				if(preg_match("/\b(https?|ftp|file):\/\/[\-A-Za-z0-9+&@#\/%?=~_|!:,.;]*[\-A-Za-z0-9+&@#\/%=~_|]/", $_POST['pict_comment'])){
					$comment = $comment."<br><img src=".trim(strip_tags($_POST['pict_comment']))."><br>";
				}
				else{
					return "La Url de la Imagen no es válida!";
				}
			}
			if(isset($_POST['gif_comment']) && !empty($_POST['gif_comment'])){
				if(preg_match("/\b(https?|ftp|file):\/\/[\-A-Za-z0-9+&@#\/%?=~_|!:,.;]*[\-A-Za-z0-9+&@#\/%=~_|]/", $_POST['gif_comment'])){
					$comment = $comment."<br><video src=".trim(strip_tags($_POST['gif_comment']))." autoplay=true loop=true></video><br>";
				}
				else{
					return "La Url de la Imagen GIF no es válida!";
				}
			}


			if(isset($_POST['survey'])){
				$comment = $comment.trim($_POST['survey']);
				$hashtags = $hashtags."Encuesta,";
			}

			$comment = str_replace(array('"', "'"), '', $comment);

			$this->comentario->set('id_usuario', trim(strip_tags($pd->idu)));
			$this->comentario->set('id_grupo', trim(strip_tags($pd->idg)));
			$this->comentario->set('comentario', $comment);
			$this->comentario->set('hashtags', $hashtags);
			$this->comentario->set('likes', 0);
			$this->comentario->set('dislikes', 0);
			$this->comentario->set('numero_reportes', 0);
			$this->comentario->set('fecha_comentario', date("Y-m-d"));
			$this->comentario->set('numero_respuestas_comentario', 0);

			$res = $this->comentario->add();

			if($res != false){

				$this->stream = new Stream();
				$this->stream->set('id_usuario', trim($pd->idu));
				$this->stream->set('id_grupo', trim($pd->idg));
				if(isset($_POST['survey']) && !empty($_POST['survey'])){
					$this->stream->set('stream_tipo', 'EN');
				}
				else{
					$this->stream->set('stream_tipo', 'CO');
				}
				$this->stream->set('fecha_stream', date('Y-m-d'));
				$this->stream->set('id_comentario', trim($res));
				$re = $this->stream->add();

				if($re || $re == 'coment'){
					header("Location:".URL."grupos/ver/".$pd->ng.".".$pd->idg."#foro");	
				}
				else{
					return "Error!";
				}
			}
			else{
				return "Error al guardar comentario, los # No aceptan acéntos ni eÑe!";
			}
		}	
	}

?>