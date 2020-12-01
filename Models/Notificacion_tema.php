<?php 
	namespace Models;


	class Notificacion_tema{
		
		private $id;
		private $id_emisor;
		private $id_receptor;
		private $titulo;
		private $fecha_publicacion;
		private $nombre_user;
		private $fecha_rango_limite;

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
		}

		public function delete(){
		}

		public function contar_notificaciones(){
			$sql = "SELECT id FROM full_notificaciones_temas WHERE id_receptor = '$this->id_receptor' AND id_receptor <> id_emisor AND fecha_publicacion > fecha_rango_limite LIMIT 10;";
			$return = $this->con->returnQuery($sql);
			$num = $return->num_rows;
			return $num;
		}

		public function ver_todas(){
			$sql = "SELECT * FROM full_notificaciones_temas WHERE id_receptor = '$this->id_receptor' AND id_receptor <> id_emisor AND  fecha_publicacion > fecha_rango_limite ORDER BY fecha_publicacion DESC LIMIT 15;";
			$return = $this->con->returnQuery($sql);
			return $return;
			
		}
		
	}

 ?>