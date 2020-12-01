<?php 
	namespace Models;

	class Tema{

		private $id;
		private $id_usuario;
		private $id_unidad;
		private $id_materia_curso;
		private $titulo;
		private $contenido;
		private $tags;
		private $fecha_publicacion;
		private $fecha_limite_respuesta;
		private $hora_limite_respuesta;
		private $permiso_archivo;
		private $nivel_tema;
		private $likes_tema;

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
			$sql = "SELECT $campo FROM temas_materia_curso WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);

			$dat = $return->fetch_array();
			return $dat[$campo];
		}

		public function get_num_by_cur(){
			$sql1 = "SELECT id FROM temas_materia_curso WHERE id_materia_curso = '$this->id_materia_curso';";
			$ret1 = $this->con->returnQuery($sql1);

			$dat1 = $ret1->num_rows;

			$sql2 = "SELECT temas_materia_curso.id FROM temas_materia_curso INNER JOIN temas_vistos ON temas_vistos.id_tema = temas_materia_curso.id WHERE temas_vistos.id_usuario = '$this->id_usuario' AND id_materia_curso = '$this->id_materia_curso';";
			$ret2 = $this->con->returnQuery($sql2);

			$dat2 = $ret2->num_rows;

			return array($dat1, $dat2);	
		}


		public function add(){
			$sqlp = "SELECT id FROM temas_materia_curso WHERE titulo = '$this->titulo';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "INSERT INTO temas_materia_curso VALUES(NULL, '$this->id_usuario', '$this->id_unidad', '$this->id_materia_curso', '$this->titulo', '$this->contenido', '$this->tags', '$this->fecha_publicacion', $this->fecha_limite_respuesta, $this->hora_limite_respuesta, '$this->permiso_archivo', '$this->nivel_tema', '$this->likes_tema');";
				$return = $this->con->returnQuery($sql);
				
				if($return && $this->con->getAffectedRows() == 1){
					return array('true', $this->con->lastInsertId());
				}
			}
			else{
				return false;
			}
		}

		public function votar_tema(){
			$sqlp = "SELECT id FROM votos_tema WHERE id_usuario = '$this->id_usuario' AND id_tema = '$this->id';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "UPDATE temas_materia_curso SET likes_tema = likes_tema + 1 WHERE id = '$this->id';";
				$return = $this->con->returnQuery($sql);
				if($return && $this->con->getAffectedRows() == 1){
					$s = "INSERT INTO votos_tema VALUES(NULL, '$this->id_usuario', '$this->id');";
					$v = $this->con->returnQuery($s);
					
					if($s){
						return "ok";
					}
				}
			}
			else{
				return "exist";
			}
		}

		public function addver_tema(){
			$sqlp = "SELECT id FROM temas_vistos WHERE id_usuario = '$this->id_usuario' AND id_tema = '$this->id';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "INSERT INTO temas_vistos VALUES(NULL, '$this->id_usuario', '$this->id');";		
				$return = $this->con->returnQuery($sql);		
				if($return && $this->con->getAffectedRows() == 1){
					return 'true';
				}
			}
			else{
				return false;
			}
		}

		public function get_addver_tema(){
			$sql = "SELECT id FROM temas_vistos WHERE id_usuario = '$this->id_usuario' AND id_tema = '$this->id';";
			$r = $this->con->returnQuery($sql);

			$res = $r->num_rows;
			return $res;
		}

		public function get_id_curso(){
			$sql = "SELECT id_materia_curso FROM temas_materia_curso WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			$r = $return->fetch_array();
			return $r['id_materia_curso'];
		}

		public function edit(){
			$sql = "UPDATE temas_materia_curso SET titulo = '$this->titulo', contenido = '$this->contenido', tags = '$this->tags', fecha_publicacion = '$this->fecha_publicacion', fecha_limite_respuesta = $this->fecha_limite_respuesta, hora_limite_respuesta = $this->hora_limite_respuesta, permiso_archivo = '$this->permiso_archivo', nivel_tema = '$this->nivel_tema' WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			if($return && $this->con->getAffectedRows() == 1){
				$return = 'true';
			}
			else{
				$return = 'false';
			}
			return $return;
		}

		public function delete(){
			$sql = "DELETE FROM temas_materia_curso WHERE id = '$this->id' AND titulo = '$this->titulo';";
			$return = $this->con->returnQuery($sql);
			if($return && $this->con->getAffectedRows() == 1){
				$return = 'true';
			}
			else{
				$return = 'false';
			}
			
			return $return;
		}



		public function ver(){
			$sql = "SELECT * FROM temas_materia_curso WHERE titulo LIKE '%$this->titulo%' AND id = '$this->id' AND CHARACTER_LENGTH(titulo) = CHARACTER_LENGTH('$this->titulo');";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function buscar(){
			$sql = "SELECT id, id_unidad, titulo, fecha_publicacion FROM temas_materia_curso WHERE id_materia_curso = '$this->id_materia_curso' AND titulo LIKE '%$this->dato_ambiguo%' ORDER BY id DESC;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function paginar(){
			$sql = "SELECT id FROM temas_materia_curso WHERE id_materia_curso = '$this->id_materia_curso' AND id_unidad = 0;";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 10);
			return $filas;	
		}

		public function ver_todos($arg){
			if($arg == 'modulo'){

				$sql = "SELECT id, id_unidad, id_materia_curso, titulo, fecha_publicacion, nivel_tema, (SELECT id_tema FROM temas_vistos WHERE id_usuario = '$this->id_usuario' AND id_tema = temas_materia_curso.id) AS id_tema FROM temas_materia_curso WHERE id_unidad = '$this->id_unidad' ORDER BY id";
				
			}
			else{
				$sql = "SELECT id, id_unidad, titulo, fecha_publicacion, nivel_tema FROM temas_materia_curso WHERE id_materia_curso = '$this->id_materia_curso' AND id_unidad = 0 ORDER BY id DESC LIMIT $this->limite, 10;";	
			}
			
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function search_by_tag(){
			$sql = "SELECT temas_materia_curso.id AS id, id_unidad, titulo, fecha_publicacion, materias_cursos.id_usuario AS id_user, (SELECT id_usuario FROM miembros_grupo WHERE id_usuario = '$this->id_usuario' AND id_grupo ='$this->dato_ambiguo' AND acceso_grupo = '1' AND status_miembro = '1') AS member FROM temas_materia_curso INNER JOIN materias_cursos ON temas_materia_curso.id_materia_curso = materias_cursos.id WHERE temas_materia_curso.tags LIKE '%$this->tags%' AND materias_cursos.id_grupo = '$this->dato_ambiguo';";
			$return = $this->con->returnQuery($sql);
			return $return;

		}

		public function list_games(){
			$sql = "SELECT word_finds.id, word_finds.nombre_wrdfnd AS nombre, 1 AS tipo, word_finds.fecha_wrdfnd AS fecha FROM word_finds WHERE word_finds.id_tema = '$this->id_tema' UNION SELECT guesses_words.id, guesses_words.nombre_guesswrd AS nombre, 2 AS tipo, guesses_words.fecha_guesswrd AS fecha FROM guesses_words WHERE guesses_words.id_tema = '$this->id_tema' UNION SELECT timelines.id, timelines.nombre_timeline AS nombre, 3 AS tipo, timelines.fecha_timeline AS fecha FROM timelines WHERE timelines.id_tema = '$this->id_tema' ORDER BY fecha DESC LIMIT $this->limite, 5;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}
	}


 ?>