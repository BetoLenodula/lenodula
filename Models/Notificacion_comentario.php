<?php 
	namespace Models;


	class Notificacion_comentario{
		private $id;
		private $foto;
		private $nombre_user;
		private $id_receptor;
		private $id_grupo;
		private $nombre_grupo;
		private $id_emisor;
		private $id_post;
		private $id_page;
		private $fecha;

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
			$sql = "UPDATE respuestas_comentarios_grupo SET vista_respuesta_comentario = '1' WHERE id = '$this->id' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function contar_notificaciones(){
			$sql = "SELECT id FROM full_notificaciones_comentarios WHERE (id_receptor = '$this->id_receptor' AND id_receptor <> id_emisor) OR (mencion = '$this->id_receptor' AND mencion <> id_emisor) LIMIT 10;";
			$return = $this->con->returnQuery($sql);
			$num = $return->num_rows;
			return $num;
		}

		public function ver_todas(){
			$sql = "SELECT * FROM full_notificaciones_comentarios WHERE (id_receptor = '$this->id_receptor' AND id_receptor <> id_emisor) OR (mencion = '$this->id_receptor' AND mencion <> id_emisor) ORDER BY id DESC LIMIT $this->limit, 9;";
			$return = $this->con->returnQuery($sql);
			return $return;
			
		}
		
	}

 ?>