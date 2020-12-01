<?php 
	namespace Models;

	class Respuesta{
		private $id;
		private $id_usuario;
		private $id_tema;
		private $titulo_respuesta;
		private $respuesta;
		private $timestamp_respuesta;
		private $numero_respuestas;
		private $gratificaciones;
		private $calificacion;
		private $total_reportes;

		private $dato_ambiguo;
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
			$sql = "SELECT $campo FROM respuestas WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);

			$dat = $return->fetch_array();
			return $dat[$campo];
		}

		public function add(){
			if($this->dato_ambiguo == 1){
				$pre = "SELECT id FROM respuestas WHERE id_usuario = '$this->id_usuario' AND id_tema = '$this->id_tema'";
				$rp = $this->con->returnQuery($pre);
				$exist = $rp->num_rows;

				if($exist > 0){
					return "exist";
				}
			}
			else{
				$exist = 0;
			}

			
			if($exist == 0){
				$act = date("Y-m-dH:i:s");
				$ht = "SELECT fecha_limite_respuesta, hora_limite_respuesta FROM temas_materia_curso WHERE id = '$this->id_tema'";
				$rt = $this->con->returnQuery($ht);
				$hrt = $rt->fetch_array();
				$gua = $hrt['fecha_limite_respuesta'].$hrt['hora_limite_respuesta'];

				if($gua != ""){
					if($act >= $gua){
						return "caduc";
					}
				}

				$sql = "INSERT INTO respuestas VALUES(NULL, '$this->id_usuario', '$this->id_tema', '$this->titulo_respuesta', '$this->respuesta', NOW(), '$this->numero_respuestas', '$this->gratificaciones', '$this->calificacion', '$this->total_reportes');";
				$return = $this->con->returnQuery($sql);
			}

			if($return && $this->con->getAffectedRows() == 1){
				$sqlr = "UPDATE usuarios SET total_respuestas = total_respuestas + 1 WHERE identificador_unico = '$this->id_usuario';";
				$r = $this->con->returnQuery($sqlr);

				if($r && $this->con->getAffectedRows() == 1){

					$sql = "SELECT MAX(id) AS id FROM respuestas;";
					$res = $this->con->returnQuery($sql);

					$maxid = $res->fetch_row();

					return $maxid[0];
					
				}
				else{
					return "false";
				}
			}
			else{
				return "false";
			}
		}

		public function edit($arg){

			$sqlp = "SELECT id FROM votos_gratifica WHERE id_usuario = '$this->id_usuario' AND id_respuesta = '$this->id';";
			$r = $this->con->returnQuery($sqlp);
			
			$voto = "INSERT INTO votos_gratifica VALUES(NULL, '$this->id_usuario', '$this->id');";	

			if($arg == 'grateful'){
				if($r->num_rows == 0){
					$sql = "UPDATE respuestas INNER JOIN usuarios ON respuestas.id_usuario = usuarios.identificador_unico SET respuestas.gratificaciones = respuestas.gratificaciones + 1, usuarios.total_gratificaciones = usuarios.total_gratificaciones + 1 WHERE respuestas.id = '$this->id' AND respuestas.id_tema = '$this->id_tema' AND respuestas.id_usuario <> '$this->id_usuario';";

					$sqlr = $voto; 
				}
			}

			if(isset($sql)){
				$return = $this->con->returnQuery($sql);
					
				if($return && $this->con->getAffectedRows() == 2){
					$v = $this->con->returnQuery($sqlr);
					if($v){
						return "true";
					}
				}
				else{
					return "false";
				}
			}

			
		}

		public function qualify(){
			$sqlp = "SELECT calificacion FROM respuestas WHERE id = '$this->id' AND id_tema = '$this->id_tema' AND calificacion = '0' AND id_usuario <> '$this->id_usuario';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 1){
				$sql = "UPDATE respuestas SET calificacion = '$this->calificacion' WHERE id = '$this->id' AND id_tema = '$this->id_tema' AND id_usuario <> '$this->id_usuario';";
				$return = $this->con->returnQuery($sql);

				if($return && $this->con->getAffectedRows() == 1){
					$res = $this->add_points();
					return $res;
				}
				else{
					return "false";
				}
			}
			else{
				return "false";
			}
		}

		public function add_points(){
			$sql = "UPDATE usuarios SET total_puntos = total_puntos + $this->calificacion WHERE identificador_unico = '$this->dato_ambiguo';";
			$res = $this->con->returnQuery($sql);
			if($res && $this->con->getAffectedRows() == 1){
				return "true";
			}
			else{
				return "false";
			}
		}

		public function delete(){
			$sql = "DELETE FROM respuestas WHERE id = '$this->id' AND id_tema = '$this->id_tema' AND (id_usuario = '$this->id_usuario' OR (SELECT id_usuario FROM temas_materia_curso WHERE id = '$this->id_tema') = '$this->id_usuario');";
			$return = $this->con->returnQuery($sql);

			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
			else{
				return false;
			}
		}

		public function ver(){
			$sql = "SELECT respuestas.*, usuarios.nombre_user, usuarios.foto, usuarios.ids, temas_materia_curso.nivel_tema FROM respuestas INNER JOIN usuarios ON respuestas.id_usuario = usuarios.identificador_unico INNER JOIN temas_materia_curso ON respuestas.id_tema = temas_materia_curso.id WHERE respuestas.id = '$this->id'";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function buscar(){
			$sql = "SELECT respuestas.*, usuarios.nombre_user, usuarios.foto, usuarios.ids, temas_materia_curso.nivel_tema FROM respuestas INNER JOIN usuarios ON respuestas.id_usuario = usuarios.identificador_unico INNER JOIN temas_materia_curso ON respuestas.id_tema = temas_materia_curso.id WHERE respuestas.titulo_respuesta LIKE '%$this->dato_ambiguo%'";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function listar(){
			if(isset($this->dato_ambiguo) && $this->dato_ambiguo == 'examen'){
				$tit = "AND respuestas.titulo_respuesta LIKE '%$this->dato_ambiguo%'";
			}
			else{
				$tit = null;
			}

			$sql = "SELECT respuestas.*, usuarios.nombre_user, usuarios.foto, usuarios.ids, temas_materia_curso.nivel_tema FROM respuestas INNER JOIN usuarios ON respuestas.id_usuario = usuarios.identificador_unico INNER JOIN temas_materia_curso ON respuestas.id_tema = temas_materia_curso.id WHERE respuestas.id_usuario = '$this->id_usuario' {$tit} ORDER BY respuestas.id DESC LIMIT $this->limite, 5";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function ver_reportes(){
			$sql = "SELECT respuestas.*, usuarios.nombre_user, usuarios.foto, usuarios.ids, temas_materia_curso.nivel_tema FROM respuestas INNER JOIN usuarios ON respuestas.id_usuario = usuarios.identificador_unico INNER JOIN temas_materia_curso ON respuestas.id_tema = temas_materia_curso.id WHERE temas_materia_curso.id_usuario = '$this->id_usuario' AND respuestas.total_reportes > 0 ORDER BY respuestas.id DESC LIMIT $this->limite, 5";
			$return = $this->con->returnQuery($sql);
			return $return;
		}


		public function reportar(){
			$sqlp = "SELECT id FROM reportes_respuesta WHERE id_respuesta = '$this->id' AND id_usuario = '$this->id_usuario';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "UPDATE respuestas SET total_reportes = total_reportes + 1 WHERE id = '$this->id';";
				$res = $this->con->returnQuery($sql);
				if($res && $this->con->getAffectedRows() == 1){
					$rp = $this->con->returnQuery("INSERT INTO reportes_respuesta VALUES(NULL, '$this->id_usuario', '$this->id');");
					if($rp && $this->con->getAffectedRows() == 1){
						return "true";
					}
					else{
						return "false";
					}
				}
				else{
					return "false";
				}
			}else{
				return "exist";
			}
		}


		public function paginar(){
			$sql = "SELECT id FROM respuestas WHERE id_tema = '$this->id_tema';";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 5);
			return $filas;	
		}


		public function paginar_my(){
			if(isset($this->dato_ambiguo) && $this->dato_ambiguo == 'examen'){
				$tit = "AND titulo_respuesta LIKE '%$this->dato_ambiguo%'";
			}
			else{
				$tit = null;
			}

			$sql = "SELECT id FROM respuestas WHERE id_usuario = '$this->id_usuario' {$tit};";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 5);
			return $filas;	
		}

		public function paginar_rep(){
			$sql = "SELECT respuestas.id FROM respuestas INNER JOIN temas_materia_curso ON respuestas.id_tema = temas_materia_curso.id WHERE temas_materia_curso.id_usuario = '$this->id_usuario' AND respuestas.total_reportes > 0;";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 5);
			return $filas;
		}

		public function ver_todos(){
			$sql = "SELECT respuestas.*, usuarios.nombre_user, usuarios.foto, usuarios.ids, usuarios.total_puntos FROM respuestas INNER JOIN usuarios ON respuestas.id_usuario = usuarios.identificador_unico WHERE respuestas.id_tema = '$this->id_tema' ORDER BY respuestas.id DESC LIMIT $this->limite, 5;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}
		
	}



 ?>