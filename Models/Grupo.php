<?php 
	namespace Models;
	use Classes\Cache as Cache;


	class Grupo extends Miembro_grupo{

		private $id;
		private $id_usuario;
		private $foto_grupo;
		private $nombre_grupo;
		private $descripcion_grupo;
		private $tipo_acceso;
		private $theme;
		private $color_theme;
		private $fecha_creacion_grupo;

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
			if($arg == 'creador'){
				$sql = "SELECT id_usuario FROM grupos WHERE id = '$this->id_grupo';";
				$return = $this->con->returnQuery($sql);
			}
			return $return;
		}

		public function add(){
			$sqlp = "SELECT nombre_grupo FROM grupos WHERE nombre_grupo = '$this->nombre_grupo';";

			$row = $this->con->returnQuery($sqlp);
			$exist = $row->num_rows;

			if($exist == 0){
				$s = "SELECT nombre_grupo FROM grupos WHERE id_usuario = '$this->id_usuario';";

				$r = $this->con->returnQuery($s);
				$lgr = $r->num_rows;

				if($lgr < 2){
					$sql = "INSERT INTO grupos VALUES(NULL, '$this->id_usuario', '$this->foto_grupo', '$this->nombre_grupo', '$this->descripcion_grupo', '$this->tipo_acceso', '$this->theme', '$this->color_theme', '$this->fecha_creacion_grupo');";
					$return = $this->con->returnQuery($sql);

					if($return && $this->con->getAffectedRows() == 1){
						$idg = "SELECT MAX(id) AS id FROM grupos;";
						$r = $this->con->returnQuery($idg);
						$id = $r->fetch_array();
						return $id['id'];
					}
					else{
						return false;
					}
				}
				else{
					return "limgrps";
				}
			}
			else{
				return false;
			}
		}

		public function edit(){
			$sqlp = "SELECT nombre_grupo FROM grupos WHERE nombre_grupo = '$this->nombre_grupo' AND id <> '$this->id';";

			$row = $this->con->returnQuery($sqlp);
			$exist = $row->num_rows;

			if($exist == 0){
				$sql = "UPDATE grupos SET nombre_grupo = '$this->nombre_grupo', descripcion_grupo = '$this->descripcion_grupo', tipo_acceso = '$this->tipo_acceso', color_theme = '$this->color_theme' WHERE id = '$this->id';";
				$return = $this->con->returnQuery($sql);

				if($return && $this->con->getAffectedRows() == 1){
					return $this->id;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			
		}

		public function confirm_pass(){
			$sql = "SELECT grupos.id_usuario FROM grupos INNER JOIN usuarios ON grupos.id_usuario = usuarios.identificador_unico WHERE usuarios.password = '$this->dato_ambiguo' AND grupos.id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			
			if($return->num_rows > 0){
				return true;
			}
			else{
				return false;
			}
		}

		public function delete(){
			$sql = "DELETE FROM grupos WHERE id = '$this->id' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return true;
			}
			else{
				return false;
			}
		}

		public function guardar_foto(){
			$sql = "UPDATE grupos SET foto_grupo = '$this->foto_grupo' WHERE id = '$this->id';";
			$res = $this->con->returnQuery($sql);
			return $res;
		}

		public function contar_grupos(){
			$sql = "SELECT id FROM grupos;";
			$row = $this->con->returnQuery($sql);
			$filas = $row->num_rows;
			return $filas;
		}


		public function paginar(){
			$sql = "SELECT id FROM grupos;";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 6);
			return $filas;	
		}

		public function buscar(){
			$sql = "SELECT id, id_usuario, nombre_grupo, descripcion_grupo, tipo_acceso, theme, color_theme, fecha_creacion_grupo FROM grupos WHERE nombre_grupo LIKE '%$this->dato_ambiguo%' OR tipo_acceso LIKE '%$this->dato_ambiguo%' ORDER BY id DESC;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public function ver_mis_grupos($s = 0){
			if($s == 1){
				$sql = "SELECT id, id_usuario, nombre_grupo FROM grupos WHERE id_usuario = '$this->id_usuario' ORDER BY id DESC;";
			}
			else{
				$sql = "SELECT id, id_usuario, nombre_grupo, descripcion_grupo, tipo_acceso, theme, color_theme, fecha_creacion_grupo FROM grupos WHERE id_usuario = '$this->id_usuario' ORDER BY id DESC;";
			}
			
			$return = $this->con->returnQuery($sql);
			return $return;	
		}

		public function ver_grupos_miembro(){
			$sql = "SELECT grupos.id AS id, id_usuario, nombre_grupo, descripcion_grupo, tipo_acceso, theme, color_theme, fecha_creacion_grupo FROM grupos INNER JOIN miembros_grupo ON grupos.id = miembros_grupo.id_grupo WHERE miembros_grupo.id_usuario = '$this->id_usuario' AND acceso_grupo = '1' ORDER BY grupos.id DESC;";
			$return = $this->con->returnQuery($sql);
			return $return;	
		}

		public function ver_todos(){
			$sql = "SELECT id, id_usuario, nombre_grupo, descripcion_grupo, tipo_acceso, theme, color_theme, fecha_creacion_grupo FROM grupos ORDER BY id DESC LIMIT $this->limite, 6;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		public static function listar(){
			Cache::configure(array(
    			'cache_path' => ROOT.'cache/board_lsgrp',
    			'expires' => (60 * 30)
			));


			$cache = Cache::get('lstgroups');

			if(!$cache){
				require_once("Conexion.php");
				$con = new Conexion();
				$con->charSet();
				$sql = "SELECT id, nombre_grupo FROM grupos ORDER BY id DESC LIMIT 20;";
				$ret = $con->returnQuery($sql);
				$arr = array();

				while($r = $ret->fetch_array()){
					$idg = $r['id'];
					$nom = $r['nombre_grupo'];

					$arr[] = array('idg' => $idg, 'nom' => $nom);
				}
				
				$return = $arr;
				if(!empty($return)){
					Cache::put('lstgroups', $return);
				}
			}
			else{
				$return = $cache;
			}

			return $return;				
		}

		public function ver(){
			$sql = "SELECT grupos.*, nombre_user, foto FROM grupos INNER JOIN usuarios ON grupos.id_usuario = usuarios.identificador_unico WHERE nombre_grupo LIKE '%$this->nombre_grupo%' AND id = '$this->id' AND CHARACTER_LENGTH(nombre_grupo) = CHARACTER_LENGTH('$this->nombre_grupo');";
			$return = $this->con->returnQuery($sql);
			return $return;	
		}

		public function listar_algunos(){
			$sql = "SELECT nombre_grupo, theme, color_theme, id FROM grupos WHERE id <> '$this->id' LIMIT 3;";
			$return = $this->con->returnQuery($sql);
			return $return;	
		}


		public function validar_miembro($arg){
			if($arg == 'exist_member'){
			$sqlp = "SELECT id_usuario FROM miembros_grupo WHERE id_usuario = '$this->id_usuario' AND id_grupo = '$this->id_grupo';";
			}
			if($arg == 'access_member'){
			$sqlp = "SELECT id_usuario FROM miembros_grupo WHERE id_usuario = '$this->id_usuario' AND id_grupo = '$this->id_grupo' AND acceso_grupo = '1' AND status_miembro = '1';";
			}
			

			$row = $this->con->returnQuery($sqlp);
			$exist = $row->num_rows;
			return $exist;
		}

		public function unirse(){
			$exist_miembro = $this->validar_miembro('exist_member');

			$sqlp = "SELECT id, tipo_acceso FROM grupos WHERE nombre_grupo LIKE '%$this->nombre_grupo%' AND id = '$this->id' AND CHARACTER_LENGTH(nombre_grupo) = CHARACTER_LENGTH('$this->nombre_grupo') AND id_usuario <> '$this->id_usuario';";
			$row = $this->con->returnQuery($sqlp);
			$exist_grupo = $row->num_rows;

			$ta = $row->fetch_array();
			$ta = $ta['tipo_acceso'];

			if($ta == 'Abierto'){
				$this->acceso_grupo = 1;
				$this->status_miembro = 1;
			}

			if(($exist_miembro == 0) && ($exist_grupo == 1)){
				$sql = "INSERT INTO miembros_grupo VALUES(NULL, '$this->id_grupo', '$this->id_usuario', '$this->fecha_agregado', '$this->acceso_grupo', '$this->status_miembro');";
				$return = $this->con->returnQuery($sql);

				if($ta == 'Abierto'){
					return "cut_flow";
				}
				else{
					return $return;	
				}
				
			}
			else{
				return false;
			}
		}

		public function metrica(){
			$sql = "SELECT SUM(calificacion) AS puntos, SUM(gratificaciones) AS gracias FROM full_view_puntos_grupo WHERE id_grupo = '$this->id_grupo' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			return $return;
		}


		public function add_miembro(){
			$exist_miembro = $this->validar_miembro('exist_member');

			if($exist_miembro == 0){
				$sql = "INSERT INTO miembros_grupo VALUES(NULL, '$this->id_grupo', '$this->id_usuario', '$this->fecha_agregado', '$this->acceso_grupo', '$this->status_miembro');";
				$return = $this->con->returnQuery($sql);
				
				if($return && $this->con->getAffectedRows() == 1){
					return "true";
				}
			}
			else{
				return "exist";
			}
		}

		public function abandonar(){
			$exist_miembro = $this->validar_miembro('exist_member');

			$sqlp = "SELECT id FROM grupos WHERE nombre_grupo LIKE '%$this->nombre_grupo%' AND id = '$this->id' AND CHARACTER_LENGTH(nombre_grupo) = CHARACTER_LENGTH('$this->nombre_grupo');";
			$row = $this->con->returnQuery($sqlp);
			$exist_grupo = $row->num_rows;

			if(($exist_miembro == 1) && ($exist_grupo == 1)){
				$sql = "DELETE FROM miembros_grupo WHERE id_grupo = '$this->id_grupo' AND id_usuario = '$this->id_usuario';";
				$return = $this->con->returnQuery($sql);
				if($return){
					$sql = "DELETE FROM notificaciones_grupo WHERE id_grupo = '$this->id_grupo' AND id_emisor = '$this->id_usuario';";
					$return = $this->con->returnQuery($sql);
				}
				return $return;
			}
			else{
				return false;
			}	
		}

		public function ver_baneos(){
			$sql = "SELECT nombre_user, foto, ids, id_usuario FROM miembros_grupo INNER JOIN usuarios ON miembros_grupo.id_usuario = usuarios.identificador_unico WHERE miembros_grupo.status_miembro = '0' AND miembros_grupo.id_grupo = '$this->id_grupo' LIMIT 20;";
			$return = $this->con->returnQuery($sql);
			
			return $return;
		}

		public function banear_miembro(){
			$sql = "UPDATE miembros_grupo SET status_miembro = '0' WHERE id_grupo = '$this->id_grupo' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function desbloquear(){
			$sql = "UPDATE miembros_grupo SET status_miembro = '1' WHERE id_grupo = '$this->id_grupo' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function borrar_miembro(){
			$sql = "DELETE FROM miembros_grupo WHERE id_grupo = '$this->id_grupo' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function aceptar_miembro(){
			$sql = "UPDATE miembros_grupo SET acceso_grupo = '1', status_miembro = '1' WHERE id_grupo = '$this->id_grupo' AND id_usuario = '$this->id_usuario';";
			$return = $this->con->returnQuery($sql);
			
			if($return && $this->con->getAffectedRows() == 1){
				return "true";
			}
		}

		public function ver_miembros(){
			$sql = "SELECT nombre_user, foto, ids, enlinea, id_usuario, status_miembro FROM miembros_grupo INNER JOIN usuarios ON miembros_grupo.id_usuario = usuarios.identificador_unico WHERE (miembros_grupo.acceso_grupo = '1' AND miembros_grupo.status_miembro = '1' OR miembros_grupo.acceso_grupo = '1' AND miembros_grupo.status_miembro = '0') AND miembros_grupo.id_grupo = '$this->id_grupo' LIMIT $this->limite, 8;";
			$return = $this->con->returnQuery($sql);
			return $return;
		}

		
	}

 ?>