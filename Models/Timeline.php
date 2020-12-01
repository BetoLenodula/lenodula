<?php 
	namespace Models;

	class Timeline{

		private $id;
		private $id_tema;
		private $nombre_timeline;
		private $image_timeline;
		private $fechas;
		private $datos;
		private $fecha_timeline;

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

		public function new_timeline(){
			$sqlp = "SELECT id FROM timelines WHERE nombre_timeline = '$this->nombre_timeline';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "INSERT INTO timelines VALUES(NULL, '$this->id_tema', '$this->nombre_timeline', '$this->image_timeline', '$this->fechas', '$this->datos', '$this->fecha_timeline');";
				$return = $this->con->returnQuery($sql);
				
				if($return && $this->con->getAffectedRows() == 1){
					return array('true', $this->con->lastInsertId());
				}
			}
			else{
				return false;
			}
		}

		public function ver_timeline(){
			$sql = "SELECT timelines.*, titulo FROM timelines INNER JOIN temas_materia_curso ON timelines.id_tema = temas_materia_curso.id WHERE titulo LIKE '%$this->dato_ambiguo%' AND timelines.id = '$this->id' AND CHARACTER_LENGTH(titulo) = CHARACTER_LENGTH('$this->dato_ambiguo');";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function del_timeline(){
			$sql = "DELETE FROM timelines WHERE id = '$this->id';";
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