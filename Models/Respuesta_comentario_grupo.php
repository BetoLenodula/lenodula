<?php 
	namespace Models;


	class Respuesta_comentario_grupo{
		private $id;
		private $id_comentario;
		private $id_usuario;
		private $id_page;
		private $respuesta_comentario;
		private $fecha_respuesta_comentario;
		private $vista_respuesta_comentario;
		private $mencion;

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
			$sql = "INSERT INTO respuestas_comentarios_grupo VALUES(NULL, '$this->id_comentario', '$this->id_usuario', '$this->id_page','$this->respuesta_comentario', '$this->fecha_respuesta_comentario', '$this->vista_respuesta_comentario', '$this->mencion');";
			$return = $this->con->returnQuery($sql);

			if($return && $this->con->getAffectedRows() == 1){
				$sqlr = "UPDATE comentarios_grupo SET numero_respuestas_comentario = numero_respuestas_comentario + 1 WHERE id = '$this->id_comentario';";
				$r = $this->con->returnQuery($sqlr);

				if($r){
					return "true";
				}
			}

		}


		public function ver_todas(){
			$sql = "SELECT respuestas_comentarios_grupo.id, respuesta_comentario, fecha_respuesta_comentario, id_usuario, foto, nombre_user FROM respuestas_comentarios_grupo INNER JOIN usuarios ON id_usuario = identificador_unico WHERE id_comentario = '$this->id_comentario' ORDER BY respuestas_comentarios_grupo.id DESC LIMIT 5;";
			$return = $this->con->returnQuery($sql);

			if($return){
				return $return;
			}
		}


		public function ver_mas(){
			$sql = "SELECT respuestas_comentarios_grupo.id, respuesta_comentario, fecha_respuesta_comentario, id_usuario, foto, nombre_user FROM respuestas_comentarios_grupo INNER JOIN usuarios ON id_usuario = identificador_unico WHERE id_comentario = '$this->id_comentario' ORDER BY respuestas_comentarios_grupo.id DESC LIMIT $this->limite, 5;";
			$return = $this->con->returnQuery($sql);

			if($return){
				return $return;
			}
		}
		
	}


 ?>