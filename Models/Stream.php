<?php 
	namespace Models;

	class Stream{

		private $id;
		private $id_usuario;
		private $id_grupo;
		private $stream_tipo;
		private $fecha_stream;
		private $id_comentario;

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
			$pre = "SELECT fecha_stream, id FROM stream WHERE id_grupo = '$this->id_grupo' AND stream_tipo = 'CO' ORDER BY id DESC LIMIT 1;";
			$f = $this->con->returnQuery($pre);
			$fe = $f->fetch_array();

			if($fe['fecha_stream'] < $this->fecha_stream || $this->stream_tipo != 'CO'){

				$sql = "INSERT INTO stream VALUES(NULL, '$this->id_usuario', '$this->id_grupo', '$this->stream_tipo', '$this->fecha_stream', '$this->id_comentario');";
				$r = $this->con->returnQuery($sql);

				if($r){
					return $r;
				}
				else{
					return false;
				}
			}
			else{
				return 'coment';
			}

		}

		public function paginar(){
			$sql = "SELECT id FROM full_view_stream;";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 10);
			return $filas;	
		}

		public function ver(){
			$this->con->charSetMb4();
			
			$sql = "SELECT * FROM full_view_stream ORDER BY id DESC LIMIT $this->limite, 10;";
			$return = $this->con->returnQuery($sql);

			return $return;
		}

	}


 ?>