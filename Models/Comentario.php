<?php 
	namespace Models;

	
	class Comentario{

		private $id;
		private $id_usuario;
		private $id_grupo;
		private $comentario;
		private $hashtags;
		private $likes;
		private $dislikes;
		private $numero_reportes;
		private $fecha_comentario;
		private $numero_respuestas_comentario;

		private $dato_ambiguo;
		private $limite;
		private $con;

		public function __construct(){
			$this->con = new Conexion();
			$this->con->charSet();
		}

		public function set($campo, $dato){
			$this->$campo = $dato;
		}

		public function get($campo){
			return $this->$campo;
		}

		public function add(){
			$this->con->charSetMb4();

			$sql = "INSERT INTO comentarios_grupo VALUES(NULL, '$this->id_usuario', '$this->id_grupo', '$this->comentario', '$this->hashtags', '$this->likes', '$this->dislikes', '$this->numero_reportes', '$this->fecha_comentario', '$this->numero_respuestas_comentario');";
			$return = $this->con->returnQuery($sql);

			if($return && $this->con->getAffectedRows() == 1){
				$idc = "SELECT MAX(id) AS id FROM comentarios_grupo;";
				$r = $this->con->returnQuery($idc);
				$id = $r->fetch_array();
				return $id['id'];
			}
			else{
				return false;
			}
		}

		public function edit($arg){

			$sqlp = "SELECT id FROM votos WHERE id_usuario = '$this->id_usuario' AND id_comentario = '$this->id';";
			$r = $this->con->returnQuery($sqlp);
			
			$voto = "INSERT INTO votos VALUES(NULL, '$this->id_usuario', '$this->id');";	


			$sql = null;
			
			if($arg == 'like'){
				if($r->num_rows == 0){
					$sql = "UPDATE comentarios_grupo SET likes = likes + 1 WHERE id = '$this->id' AND id_grupo = '$this->id_grupo' AND id_usuario <> '$this->id_usuario';";
					$sqlr = $voto; 
				}
			}
			if($arg == 'dislike'){
				if($r->num_rows == 0){
					$sql = "UPDATE comentarios_grupo SET dislikes = dislikes + 1 WHERE id = '$this->id' AND id_grupo = '$this->id_grupo' AND id_usuario <> '$this->id_usuario';";	
					$sqlr = $voto;	
				}
			}
			if($arg == 'report'){
				$sql = "UPDATE comentarios_grupo SET numero_reportes = numero_reportes + 1 WHERE id = '$this->id' AND id_grupo = '$this->id_grupo' AND id_usuario <> '$this->id_usuario';";
			}

			
			$return = $this->con->returnQuery($sql);
				
			if($return && $this->con->getAffectedRows() == 1){
				$v = $this->con->returnQuery($sqlr);
				if($v){
					return "true";
				}
			}

			
		}

		public function get_vote_survey(){
			$sqlp = "SELECT id FROM votos_encuesta WHERE id_usuario = '$this->id_usuario' AND id_comentario = '$this->id';";
			$r = $this->con->returnQuery($sqlp);
			if($r->num_rows == 0){
				$voto = "INSERT INTO votos_encuesta VALUES(NULL, '$this->id_usuario', '$this->id');";
				$v = $this->con->returnQuery($voto);
				if($v && $this->con->getAffectedRows() == 1){
					return "true";
				}
			}
			else{
				return "false";
			}
		}

		public function edit_survey(){
			$this->con->charSetMb4();
			
			$sql = "UPDATE comentarios_grupo SET comentario = '$this->comentario' WHERE id = '$this->id' AND id_grupo = '$this->id_grupo';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "Gracias por tu voto!!";
			}
			else{
				return "false";
			}
		}

		public function delete(){
			$d = "DELETE FROM stream WHERE id_comentario = '$this->id';";
			$this->con->simpleQuery($d);
			$sql = "DELETE FROM comentarios_grupo WHERE id = '$this->id' AND id_grupo = '$this->id_grupo' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);

			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function ver(){

		}

		public function get_tags_comentarios(){
			$sql = "SELECT hashtags FROM comentarios_grupo WHERE hashtags <> '' LIMIT 36;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}


		public function paginar(){
			$sql = "SELECT id FROM comentarios_grupo WHERE id_grupo = '$this->id_grupo';";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 9);
			return $filas;	
		}
		
		public function paginar_destacados(){
			$sql = "SELECT id FROM comentarios_grupo WHERE hashtags LIKE '%$this->dato_ambiguo%';";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 10);
			return $filas;	
		}

		public function ver_destacados(){
			$this->con->charSetMb4();
			$sql = "SELECT comentarios_grupo.*, usuarios.nombre_user, usuarios.foto, usuarios.ids, grupos.nombre_grupo FROM comentarios_grupo INNER JOIN usuarios ON comentarios_grupo.id_usuario = usuarios.identificador_unico INNER JOIN grupos ON comentarios_grupo.id_grupo = grupos.id WHERE hashtags LIKE '%$this->dato_ambiguo%' ORDER BY comentarios_grupo.id DESC LIMIT $this->limite, 10;";

			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function ver_todos($id = 0){
			$this->con->charSetMb4();
			
			if($id != 0){
				$sql = "SELECT comentarios_grupo.*, usuarios.nombre_user, usuarios.foto, usuarios.ids FROM comentarios_grupo INNER JOIN usuarios ON comentarios_grupo.id_usuario = usuarios.identificador_unico WHERE comentarios_grupo.id = '$id' UNION SELECT comentarios_grupo.*, usuarios.nombre_user, usuarios.foto, usuarios.ids FROM comentarios_grupo INNER JOIN usuarios ON comentarios_grupo.id_usuario = usuarios.identificador_unico WHERE comentarios_grupo.id_grupo = '$this->id_grupo' LIMIT $this->limite, 9;";
			}
			else{
				$sql = "SELECT comentarios_grupo.*, usuarios.nombre_user, usuarios.foto, usuarios.ids FROM comentarios_grupo INNER JOIN usuarios ON comentarios_grupo.id_usuario = usuarios.identificador_unico WHERE comentarios_grupo.id_grupo = '$this->id_grupo' ORDER BY comentarios_grupo.id DESC LIMIT $this->limite, 9;";
			}

			$return = $this->con->returnQuery($sql);
			return $return;
		}
	}

 ?>