<?php 
	namespace Models;

	class Wordfind{
		private $id;
		private $id_tema;
		private $nombre_wrdfnd;
		private $words_wrdfnd;
		private $fecha_wrdfnd;

		private $limite;
		private $dato_ambiguo;
		private $con;

		public function __construct(){
			$this->con = new Conexion();
			$this->con->charSet();
		}

		public function set($campo, $dato){
			$this->$campo = $dato;
		}


		public function new_wordfind(){
			$sqlp = "SELECT id FROM word_finds WHERE nombre_wrdfnd = '$this->nombre_wrdfnd';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "INSERT INTO word_finds VALUES(NULL, '$this->id_tema', '$this->nombre_wrdfnd', '$this->words_wrdfnd', '$this->fecha_wrdfnd');";
				$return = $this->con->returnQuery($sql);
				
				if($return && $this->con->getAffectedRows() == 1){
					return array('true', $this->con->lastInsertId());
				}
			}
			else{
				return false;
			}
		}

		public function ver_wordfind(){
			$sql = "SELECT word_finds.*, titulo FROM word_finds INNER JOIN temas_materia_curso ON word_finds.id_tema = temas_materia_curso.id WHERE titulo LIKE '%$this->dato_ambiguo%' AND word_finds.id = '$this->id' AND CHARACTER_LENGTH(titulo) = CHARACTER_LENGTH('$this->dato_ambiguo');";
			$return = $this->con->returnQuery($sql);
			return $return;
		}


		public function del_wordfind(){
			$sql = "DELETE FROM word_finds WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
			else{
				return "false";
			}

		}
	}

 ?>