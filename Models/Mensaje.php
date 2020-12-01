<?php 
	namespace Models;

	class Mensaje{
		private $id;
		private $id_emisor;
		private $id_receptor;
		private $mensaje;
		private $timestamp_mensaje;
		private $mensaje_visto;

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
			$up = "UPDATE mensajes SET mensaje_visto = '1' WHERE mensaje_visto = '0' AND id_receptor = '$this->id_emisor' AND id_emisor = '$this->id_receptor';";
			$this->con->simpleQuery($up);

			$sql = "INSERT INTO mensajes VALUES(NULL, '$this->id_emisor', '$this->id_receptor', '$this->mensaje', NOW(), '$this->mensaje_visto');";
			$r = $this->con->returnQuery($sql);

			if($r && $this->con->getAffectedRows() == 1){
				$return = "true";
			}
			else{
				$return = false;
			}
			return $return;
		}

		public function paginar(){
			$sql = "SELECT id FROM full_view_stream;";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 10);
			return $filas;	
		}

		public function ver(){
			$sql = "SELECT DISTINCT id_emisor, nombre_user, foto, ids FROM mensajes INNER JOIN usuarios ON id_emisor = identificador_unico WHERE id_receptor = '$this->id_receptor' AND mensaje_visto = '0';";
			$return = $this->con->returnQuery($sql);
			return $return;			
		}

		public function ver_ultimo(){
			$sql = "SELECT * FROM mensajes WHERE (id_emisor = '$this->id_emisor' OR id_receptor = '$this->id_emisor') AND (id_emisor = '$this->id_receptor' OR id_receptor = '$this->id_receptor') ORDER BY id DESC LIMIT 1;";
			$return = $this->con->returnQuery($sql);
			return $return;			
		}

		public function ver_ultimos(){
			$sql = "SELECT * FROM mensajes WHERE (id_emisor = '$this->id_emisor' OR id_receptor = '$this->id_emisor') AND (id_emisor = '$this->id_receptor' OR id_receptor = '$this->id_receptor') ORDER BY id DESC LIMIT $this->limite, 8;";
			$return = $this->con->returnQuery($sql);
			return $return;	
		}

		public function notificar(){
			$sql = "SELECT id FROM mensajes WHERE id_receptor = '$this->id_receptor' AND mensaje_visto = '0' LIMIT 1;";
			$return = $this->con->returnQuery($sql);
			$n = $return->num_rows;
			return $n;	
		}
	}

 ?>