<?php 
	namespace Models;

	class Evento{
		private $id;
		private $id_usuario;
		private $tipo_evento;
		private $descripcion_evento;
		private $dia_evento;
		private $mes_evento;
		private $anio_evento;
		private $hora_evento;
		private $url_referencia;

		private $dato_ambiguo;

		private $con;

		public function __construct(){
			$this->con = new Conexion();
			$this->con->charSet();
		}

		public function set($campo, $dato){
			$this->$campo = $dato;
		}

		public function get($arg){
			if($arg == 'notif'){
				$hoy = date('Y-m-d');
				$prox = strtotime('+ 1 day', strtotime($hoy));
				$prox = date('d', $prox);

				$sql = "SELECT id FROM eventos WHERE id_usuario = '$this->id_usuario' AND mes_evento = '$this->mes_evento' AND anio_evento = '$this->anio_evento' AND (dia_evento = '$this->dato_ambiguo' OR dia_evento = '$prox') LIMIT 1;";	
			}
			if($arg == 'events'){
				$sql = "SELECT DISTINCT dia_evento FROM eventos WHERE id_usuario = '$this->id_usuario' AND mes_evento = '$this->mes_evento' AND anio_evento = '$this->anio_evento' ORDER BY dia_evento;";	
			}
			if($arg == 'alerts'){
				$sql = "SELECT DISTINCT dia_evento FROM eventos WHERE id_usuario = '$this->id_usuario' AND mes_evento = '$this->mes_evento' AND anio_evento = '$this->anio_evento' AND dia_evento = '$this->dato_ambiguo' ORDER BY dia_evento;";	
			}
			if($arg == 'list'){
				$sql = "SELECT * FROM eventos WHERE id_usuario = '$this->id_usuario' AND mes_evento = '$this->mes_evento' AND anio_evento = '$this->anio_evento' AND dia_evento = '$this->dia_evento' ORDER BY hora_evento;";	
			}
			if($arg == 'by_grp'){
				$sql = "SELECT * FROM eventos WHERE id_usuario = '$this->id_usuario' AND mes_evento = '$this->mes_evento' AND anio_evento = '$this->anio_evento' AND url_referencia = '$this->url_referencia' AND (dia_evento = '$this->dia_evento' OR dia_evento > '$this->dia_evento') ORDER BY dia_evento LIMIT 3;";		
			}
			
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function add(){
			$sql = "INSERT INTO eventos VALUES(NULL, '$this->id_usuario', '$this->tipo_evento', '$this->descripcion_evento', '$this->dia_evento', '$this->mes_evento', '$this->anio_evento', '$this->hora_evento', '$this->url_referencia');";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
			else{
				return "false";
			}
		}

		public function delete(){
			$sql = "DELETE FROM eventos WHERE id = '$this->id' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			return $return;

			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
			else{
				return "false";
			}
		}

		public function ver(){
			$sql = "SELECT id_archivo, nombre_archivo FROM archivos_respuesta WHERE id_tema = '$this->id_tema' AND id_usuario = '$this->id_usuario' ORDER BY id DESC;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}
	}

 ?>