<?php 
	namespace Models;


	class Notificacion_grupo{
		
		private $id;
		private $id_emisor;
		private $id_receptor;
		private $id_grupo;
		private $notificacion_grupo;
		private $fecha_notificacion_grupo;

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
			$sqlp = "SELECT id_usuario FROM grupos WHERE id = '$this->id_grupo'";
			$row = $this->con->returnQuery($sqlp);
			$exist = $row->num_rows;

			if($exist == 1){
				
				if(!$this->id_receptor){
					$row = $row->fetch_array();
					$this->id_receptor = $row['id_usuario'];
				}

				$sql = "INSERT INTO notificaciones_grupo VALUES(NULL, '$this->id_emisor', '$this->id_receptor', '$this->id_grupo', '$this->notificacion_grupo', '$this->fecha_notificacion_grupo');";
				$return = $this->con->returnQuery($sql);

				if($return && $this->con->getAffectedRows() == 1){
					return "true";
				}
			}
			else{
				return false;
			}
		}

		public function delete(){
			$sql = "DELETE FROM notificaciones_grupo WHERE id = '$this->id' AND id_emisor = '$this->id_emisor' AND id_grupo = '$this->id_grupo';";
			$return = $this->con->returnQuery($sql);
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function contar_notificaciones(){
			$sql = "SELECT id FROM notificaciones_grupo WHERE id_receptor = '$this->id_receptor' LIMIT 10;";
			$return = $this->con->returnQuery($sql);
			$num = $return->num_rows;
			return $num;
		}

		public function ver_todas(){
			$sql = "SELECT * FROM full_notificaciones_grupo WHERE id_receptor = '$this->id_receptor' ORDER BY id DESC LIMIT $this->limite, 9;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}
		
	}

 ?>