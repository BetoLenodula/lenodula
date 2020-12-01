<?php 
	namespace Models;

	class Unidad{
		private $id;
		private $id_materia_curso;
		private $nombre_unidad;

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

		public function add($num, $idu, $fec){
			$str_sq = "";
			$tit_tema = "";


			$sqlp = "SELECT id FROM unidades WHERE nombre_unidad = '$this->nombre_unidad';";
			$n = $this->con->returnQuery($sqlp);

			if($n->num_rows == 0){
				$sql = "INSERT INTO unidades VALUES(NULL, '$this->id_materia_curso', '$this->nombre_unidad');";
				$return = $this->con->returnQuery($sql);

				if($return && $this->con->getAffectedRows() == 1){
					$ids = "SELECT MAX(id) AS id FROM unidades;";
					$r = $this->con->returnQuery($ids);
					$id = $r->fetch_array();

					if($id['id']){

						for($i = 1 ; $i <= $num; $i++){
							$tit_tema = "Topico ".$i;
							$str_sq = $str_sq."(NULL,'$idu','$id[id]','$this->id_materia_curso','$tit_tema','&lt;br&gt;','','$fec', NULL, NULL, '0', '0', '0')";
							if($i < $num){
								$str_sq = $str_sq.",";
							}
						}

						$sqlr = "INSERT INTO temas_materia_curso VALUES ".$str_sq.";";
						$return = $this->con->returnQuery($sqlr);

						if($return){
							return true;
						}
					}
				}
				else{
					return 'fail_insert';
				}
			}
			else{
				return false;
			}
		}

		public function delete(){
			$sql = "DELETE FROM unidades WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function ver_algunos(){
			$sql = "SELECT * FROM unidades WHERE id_materia_curso = '$this->id_materia_curso' LIMIT 10";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function ver_todos(){
			$sql = "SELECT * FROM unidades WHERE id_materia_curso = '$this->id_materia_curso'";
			$return = $this->con->returnQuery($sql);
			return $return;
		}
	}

 ?>