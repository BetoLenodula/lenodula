<?php 
	namespace Models;

	class Curso{

		private $id;
		private $id_usuario;
		private $id_grupo;
		private $nombre_materia_curso;
		private $fecha_creacion_materia_curso;

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

		public function get($arg){
			if($arg == 'activity'){
				$sql = "SELECT materias_cursos.id, id_grupo, nombre_materia_curso, nombre_grupo FROM materias_cursos INNER JOIN grupos ON materias_cursos.id_grupo = grupos.id ORDER BY materias_cursos.id DESC LIMIT 5;";
				$return = $this->con->returnQuery($sql);
			}

			return $return;
		}

		public function add(){
			$sqlp = "SELECT id FROM materias_cursos WHERE nombre_materia_curso = '$this->nombre_materia_curso';";
			$r = $this->con->returnQuery($sqlp);

			if($r->num_rows == 0){
				$sql = "INSERT INTO materias_cursos VALUES(NULL, '$this->id_usuario', '$this->id_grupo', '$this->nombre_materia_curso', '$this->fecha_creacion_materia_curso');";
				$return = $this->con->returnQuery($sql);
				return $return;
			}
			else{
				return false;
			}
		}

		public function buscar(){
			$sql = "SELECT materias_cursos.id, nombre_materia_curso, color_theme, theme, nombre_grupo FROM materias_cursos INNER JOIN grupos ON materias_cursos.id_grupo = grupos.id WHERE nombre_materia_curso LIKE '%$this->nombre_materia_curso%' LIMIT 15;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function get_tags_curso(){
			$sql = "SELECT tags FROM temas_materia_curso INNER JOIN materias_cursos ON temas_materia_curso.id_materia_curso = materias_cursos.id AND materias_cursos.id_grupo = '$this->id_grupo' WHERE temas_materia_curso.tags <> '' LIMIT 22;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function id_propietario_curso(){
			$sql = "SELECT id, id_usuario FROM materias_cursos WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			return $return;			
		}

		public function id_grupo_curso(){
			$sql = "SELECT id, id_grupo FROM materias_cursos WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			return $return;	
		}

		public function get_nom_grp_curso(){
			$sql = "SELECT nombre_materia_curso, nombre_grupo, grupos.id FROM materias_cursos INNER JOIN grupos ON materias_cursos.id_grupo = grupos.id WHERE materias_cursos.id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			return $return;		
		}

		public function edit(){
		}

		public function delete(){
			$sql = "DELETE FROM materias_cursos WHERE id = '$this->id' AND nombre_materia_curso = '$this->nombre_materia_curso';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function get_all_by_cur(){
			$sql = "SELECT DISTINCT temas_materia_curso.id_materia_curso AS id_curso, COUNT(materias_cursos.id) AS numero_temas, materias_cursos.nombre_materia_curso, (SELECT COUNT(temas_vistos.id) FROM temas_materia_curso INNER JOIN temas_vistos ON temas_vistos.id_tema = temas_materia_curso.id WHERE temas_vistos.id_usuario = '$this->id_usuario' AND id_materia_curso = id_curso) AS numero_temas_vistos FROM materias_cursos, miembros_grupo, temas_materia_curso WHERE materias_cursos.id_grupo = miembros_grupo.id_grupo AND miembros_grupo.id_usuario = '$this->id_usuario' AND materias_cursos.id = temas_materia_curso.id_materia_curso GROUP BY temas_materia_curso.id_materia_curso ";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function ver(){
			$sql = "SELECT id, nombre_materia_curso FROM materias_cursos WHERE id = '$this->id';";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function ver_todos(){
			$sql = "SELECT id, nombre_materia_curso FROM materias_cursos WHERE id_grupo = '$this->id_grupo' ORDER BY id DESC LIMIT $this->limite, 8;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function paginar_get_qualifies(){
			if(isset($this->dato_ambiguo)){
				$ptem = "AND temas_materia_curso.id_usuario = '$this->dato_ambiguo'";
			}
			else{
				$ptem = "";
			}

			$sql = "SELECT respuestas.id FROM temas_materia_curso INNER JOIN respuestas ON temas_materia_curso.id = respuestas.id_tema INNER JOIN materias_cursos ON temas_materia_curso.id_materia_curso = materias_cursos.id INNER JOIN usuarios ON usuarios.identificador_unico = respuestas.id_usuario WHERE temas_materia_curso.nivel_tema = '1' AND respuestas.id_usuario = '$this->id_usuario' {$ptem};";
			$datos = $this->con->returnQuery($sql);	
			$filas = ceil(($datos->num_rows) / 20);
			return $filas;	
		}

		public function get_qualifies(){
			if(isset($this->dato_ambiguo)){
				$ptem = "AND temas_materia_curso.id_usuario = '$this->dato_ambiguo'";
			}
			else{
				$ptem = "";
			}

			$sql = "SELECT respuestas.id_usuario, usuarios.nombre_user AS nombre, usuarios.foto AS foto, temas_materia_curso.id_materia_curso AS id_curso, materias_cursos.nombre_materia_curso AS nombre_curso, temas_materia_curso.titulo AS titulo_tema, temas_materia_curso.id AS id_tema, respuestas.calificacion, respuestas.timestamp_respuesta AS time_respuesta, respuestas.titulo_respuesta, respuestas.id AS id_respuesta FROM temas_materia_curso INNER JOIN respuestas ON temas_materia_curso.id = respuestas.id_tema INNER JOIN materias_cursos ON temas_materia_curso.id_materia_curso = materias_cursos.id INNER JOIN usuarios ON usuarios.identificador_unico = respuestas.id_usuario WHERE temas_materia_curso.nivel_tema = '1' AND respuestas.id_usuario = '$this->id_usuario' {$ptem} ORDER BY time_respuesta DESC LIMIT $this->limite, 20;";
			$return = $this->con->returnQuery($sql);
			return $return;	
		}

		public function search_qualifies(){
			if(isset($this->dato_ambiguo)){
				$ptem = "AND temas_materia_curso.id_usuario = '$this->dato_ambiguo'";
			}
			else{
				$ptem = "";
			}

			$sql = "SELECT respuestas.id_usuario, usuarios.nombre_user AS nombre, usuarios.foto AS foto, temas_materia_curso.id_materia_curso AS id_curso, materias_cursos.nombre_materia_curso AS nombre_curso, temas_materia_curso.titulo AS titulo_tema, temas_materia_curso.id AS id_tema, respuestas.calificacion, respuestas.timestamp_respuesta AS time_respuesta, respuestas.titulo_respuesta, respuestas.id AS id_respuesta FROM temas_materia_curso INNER JOIN respuestas ON temas_materia_curso.id = respuestas.id_tema INNER JOIN materias_cursos ON temas_materia_curso.id_materia_curso = materias_cursos.id INNER JOIN usuarios ON usuarios.identificador_unico = respuestas.id_usuario WHERE materias_cursos.nombre_materia_curso LIKE '%$this->nombre_materia_curso%' AND temas_materia_curso.nivel_tema = '1' AND respuestas.id_usuario = '$this->id_usuario' {$ptem} ORDER BY time_respuesta DESC;";
			$return = $this->con->returnQuery($sql);
			return $return;	
		}
	}


 ?>