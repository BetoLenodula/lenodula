<?php 
	namespace Models;

	class Archivo_respuesta{
		private $id;
		private $id_usuario;
		private $id_tema;
		private $id_archivo;
		private $nombre_archivo;
		private $mime_archivo;
		private $fecha_archivo;

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
			$sql = "INSERT INTO archivos_respuesta VALUES(NULL, '$this->id_usuario', '$this->id_tema', '$this->id_archivo', '$this->nombre_archivo', '$this->mime_archivo', '$this->fecha_archivo');";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function delete(){
			$sql = "DELETE FROM archivos_respuesta WHERE id_archivo = '$this->id_archivo' AND id = '$this->id';";
			$return = $this->con->returnQuery($sql);

			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
			else{
				return false;
			}
		}

		public function ver(){
			$sql = "SELECT id, id_archivo, nombre_archivo FROM archivos_respuesta WHERE id_tema = '$this->id_tema' AND id_usuario = '$this->id_usuario' ORDER BY id DESC;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function verarat(){
			$sql = "SELECT archivos_respuesta.*, temas_materia_curso.titulo FROM archivos_respuesta INNER JOIN temas_materia_curso ON archivos_respuesta.id_tema = temas_materia_curso.id WHERE archivos_respuesta.id_usuario = '$this->id_usuario' AND temas_materia_curso.id_materia_curso = '$this->dato_ambiguo' ORDER BY archivos_respuesta.id DESC LIMIT 50";

			$return = $this->con->returnQuery($sql);
			return $return;
		}
	}

 ?>