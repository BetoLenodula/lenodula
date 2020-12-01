<?php 
	namespace Models;

	class Archivo_tema{
		private $id;
		private $id_usuario;
		private $id_tema;
		private $id_archivo;
		private $nombre_archivo;
		private $mime_archivo;
		private $fecha_archivo;

		private $dato_ambiguo;

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
			$sql = "INSERT INTO archivos_tema VALUES(NULL, '$this->id_usuario', '$this->id_tema', '$this->id_archivo', '$this->nombre_archivo', '$this->mime_archivo', '$this->fecha_archivo');";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function delete(){
			$sql = "DELETE FROM archivos_tema WHERE id_archivo = '$this->id_archivo' AND id = '$this->id';";
			$return = $this->con->returnQuery($sql);

			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
			else{
				return false;
			}
		}

		public function ver(){
			$sql = "SELECT id, id_archivo, nombre_archivo FROM archivos_tema WHERE id_tema = '$this->id_tema' ORDER BY id DESC;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function verarat(){
			$sql = "SELECT archivos_tema.*, temas_materia_curso.titulo FROM archivos_tema INNER JOIN temas_materia_curso ON archivos_tema.id_tema = temas_materia_curso.id WHERE archivos_tema.id_usuario = '$this->id_usuario' AND temas_materia_curso.id_materia_curso = '$this->dato_ambiguo' ORDER BY archivos_tema.id DESC LIMIT 50";

			$return = $this->con->returnQuery($sql);
			return $return;
		}
	}

 ?>