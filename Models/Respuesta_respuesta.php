<?php 
	namespace Models;


	class Respuesta_respuesta{
		private $id;
		private $id_usuario;
		private $id_respuesta;
		private $respuesta_respuesta;
		private $timestamp_respuesta_respuesta;

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
			$sql = "INSERT INTO respuestas_respuesta VALUES(NULL, '$this->id_usuario', '$this->id_respuesta', '$this->respuesta_respuesta', NOW());";
			$return = $this->con->returnQuery($sql);

			if($return && $this->con->getAffectedRows() == 1){
				$sqlr = "UPDATE respuestas SET numero_respuestas = numero_respuestas + 1 WHERE id = '$this->id_respuesta';";
				$r = $this->con->returnQuery($sqlr);

				if($r){
					return "true";
				}
			}

		}

		public function ver_todas(){
			$sql = "SELECT respuestas_respuesta.id, respuesta_respuesta, timestamp_respuesta_respuesta, id_usuario, foto, nombre_user FROM respuestas_respuesta INNER JOIN usuarios ON id_usuario = identificador_unico WHERE id_respuesta = '$this->id_respuesta' ORDER BY respuestas_respuesta.id DESC LIMIT 5;";
			$return = $this->con->returnQuery($sql);

			if($return){
				return $return;
			}
		}

		public function ver_mas(){
			$sql = "SELECT respuestas_respuesta.id, respuesta_respuesta, timestamp_respuesta_respuesta, id_usuario, foto, nombre_user FROM respuestas_respuesta INNER JOIN usuarios ON id_usuario = identificador_unico WHERE id_respuesta = '$this->id_respuesta' ORDER BY respuestas_respuesta.id DESC LIMIT $this->limite, 5;";
			$return = $this->con->returnQuery($sql);

			if($return){
				return $return;
			}
		}
		
	}


 ?>