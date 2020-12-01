<?php 
	namespace Models;

	class Guessword{

		private $id;
		private $id_tema;
		private $nombre_guesswrd;
		private $image_guesswrd;
		private $words;
		private $clues;
		private $fecha_guesswrd;

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

		public function new_guessword(){
			$sqlp = "SELECT id FROM guesses_words WHERE nombre_guesswrd = '$this->nombre_guesswrd';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "INSERT INTO guesses_words VALUES(NULL, '$this->id_tema', '$this->nombre_guesswrd', '$this->image_guesswrd', '$this->words', '$this->clues', '$this->fecha_guesswrd');";
				$return = $this->con->returnQuery($sql);
				
				if($return && $this->con->getAffectedRows() == 1){
					return array('true', $this->con->lastInsertId());
				}
			}
			else{
				return false;
			}
		}

		public function ver_guessword(){
			$sql = "SELECT guesses_words.*, titulo FROM guesses_words INNER JOIN temas_materia_curso ON guesses_words.id_tema = temas_materia_curso.id WHERE titulo LIKE '%$this->dato_ambiguo%' AND guesses_words.id = '$this->id' AND CHARACTER_LENGTH(titulo) = CHARACTER_LENGTH('$this->dato_ambiguo');";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function del_guessword(){
			$sql = "DELETE FROM guesses_words WHERE id = '$this->id';";
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