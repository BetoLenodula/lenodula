<?php 
	namespace Models;


	class Notificacion_respuesta_tema{
		
		private $id;
		private $tipo_notificacion;
		private $id_emisor;
		private $id_receptor;
		private $notificacion_respuesta_tema;
		private $id_respuesta;
		private $fecha_notificacion_respuesta_tema;

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

		public function get($campo){
			return $this->$campo;
		}

		public function add(){

			if($this->tipo_notificacion == 'GR'){
				$sqlp = "SELECT id FROM votos_gratifica WHERE id_usuario = '$this->id_emisor' AND id_respuesta = '$this->id_respuesta';";
				$r = $this->con->returnQuery($sqlp);

				$n = $r->num_rows;	

				if($n == 1){
					return "false";
				}
			}
			if($this->tipo_notificacion == 'CA'){
				$sqlp = "SELECT id FROM notificaciones_respuestas_tema WHERE id_respuesta = '$this->id_respuesta' AND tipo_notificacion = '$this->tipo_notificacion';";
				$r = $this->con->returnQuery($sqlp);

				$n = $r->num_rows;	

				if($n == 1){
					return "false";
				}
			}

			$sql = "INSERT INTO notificaciones_respuestas_tema VALUES(NULL, '$this->tipo_notificacion', '$this->id_emisor', '$this->id_receptor', '$this->notificacion_respuesta_tema', '$this->id_respuesta', '$this->fecha_notificacion_respuesta_tema');";
			$return = $this->con->returnQuery($sql);
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function delete(){
			$sql = "DELETE FROM notificaciones_respuestas_tema WHERE id = '$this->id' AND id_receptor = '$this->id_receptor' AND id_respuesta = '$this->id_respuesta';";
			$return = $this->con->returnQuery($sql);
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function contar_notificaciones(){
			$sql = "SELECT id FROM full_notificaciones_respuestas WHERE id_receptor = '$this->id_receptor' AND id_receptor <> id_emisor LIMIT 10;";
			$return = $this->con->returnQuery($sql);
			$num = $return->num_rows;
			return $num;
		}

		public function ver_todas(){
			$sql = "SELECT * FROM full_notificaciones_respuestas WHERE id_receptor = '$this->id_receptor' AND id_receptor <> id_emisor ORDER BY id DESC LIMIT $this->limite, 9;";
			$return = $this->con->returnQuery($sql);
			return $return;
			
		}
		
	}

 ?>