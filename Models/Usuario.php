<?php 
	namespace Models;

	class Usuario{

		private $ids;
		private $identificador_unico;
		private $foto;
		private $nombre_user;
		private $nombres;
		private $apellidos;
		private $email;
		private $password;
		private $rol;
		private $codigo_activacion;
		private $fecha_ingreso;
		private $status;
		private $total_respuestas;
		private $total_puntos;
		private $total_gratificaciones;
		private $enlinea;

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
				$sql = "SELECT identificador_unico, nombre_user, ids, foto FROM usuarios ORDER BY fecha_ingreso DESC LIMIT 4;";
				$return = $this->con->returnQuery($sql);
			}

			return $return;
		}

		public function add(){
			if($this->ids == 'LN'){
				$sqlp = "SELECT identificador_unico FROM usuarios WHERE email = '$this->email';";
			}
			else if($this->ids == 'FB'){
				$sqlp = "SELECT identificador_unico FROM usuarios WHERE identificador_unico = '$this->identificador_unico';";
			}

			$row = $this->con->returnQuery($sqlp);
			$exist = $row->num_rows;

			if($exist == 0){
				$sql = "INSERT INTO usuarios VALUES('$this->ids' ,'$this->identificador_unico' ,'$this->foto', '$this->nombre_user', '$this->nombres', '$this->apellidos', '$this->email', '$this->password', '$this->rol', '$this->codigo_activacion', '$this->fecha_ingreso', '$this->status', '$this->total_respuestas','$this->total_puntos', '$this->total_gratificaciones', '$this->enlinea');";
				$res = $this->con->returnQuery($sql);
				return $res;
			}
			else{
				return false;
			}
		}

		public function edit(){ 
			$sql = "UPDATE usuarios SET nombre_user = '$this->nombre_user', nombres = '$this->nombres', apellidos = '$this->apellidos' WHERE identificador_unico = '$this->identificador_unico';";
			$res = $this->con->returnQuery($sql);
			return $res;
		}

		public function delete(){
			
		}

		public function ver(){
			$sql = "SELECT ids, identificador_unico, nombre_user, foto, nombres, apellidos, email, rol, fecha_ingreso, total_respuestas, total_puntos, total_gratificaciones FROM usuarios WHERE identificador_unico = '$this->identificador_unico';";
			$res = $this->con->returnQuery($sql);
			return $res;
		}

		public function contar_puntos(){
			$sql = "SELECT MAX(total_puntos) AS max_puntos FROM usuarios;";
			$res = $this->con->returnQuery($sql);

			$puntos = $res->fetch_row();

			return $puntos[0];
		}

		public function paginar(){
			$sql = "SELECT identificador_unico FROM usuarios;";
			$datos = $this->con->returnQuery($sql);
			
			$filas = ceil(($datos->num_rows) / 10);
			return $filas;	
		}

		public function ver_todos($arg = 0){
			if($arg === 'max'){
				$sql = "SELECT ids, identificador_unico, nombre_user, foto, nombres, apellidos, rol, total_puntos FROM usuarios ORDER BY total_puntos DESC LIMIT $this->limite, 10;";
			}
			else{
				$sql = "SELECT ids, identificador_unico, nombre_user, foto, nombres, apellidos, rol, total_puntos FROM usuarios LIMIT $this->limite, 10;";	
			}
			
			$res = $this->con->returnQuery($sql);
			return $res;	
		}

		public function buscar(){
			$sql = "SELECT ids, identificador_unico, nombre_user, foto, nombres, apellidos, rol, total_puntos FROM usuarios WHERE nombre_user LIKE '%$this->dato_ambiguo%' OR nombres LIKE '%$this->dato_ambiguo%' OR apellidos LIKE '%$this->dato_ambiguo%' OR rol LIKE '%$this->dato_ambiguo%' ORDER BY total_puntos DESC;";
			$res = $this->con->returnQuery($sql);
			return $res;	
		}

		public function guardar_foto(){
			$sql = "UPDATE usuarios SET foto = '$this->foto' WHERE identificador_unico = '$this->identificador_unico';";
			$res = $this->con->returnQuery($sql);
			return $res;
		}

		public function confirm(){
			$sql = "UPDATE usuarios SET status = 1 WHERE codigo_activacion = '$this->codigo_activacion';";
			$res = $this->con->returnQuery($sql);
			return $res;
		}

		public function set_enlinea($arg){
			if($arg == 'set'){
				$sql = "UPDATE usuarios SET enlinea = '1' WHERE identificador_unico = '$this->identificador_unico';";
			}
			if($arg == 'unset'){
				$sql = "UPDATE usuarios SET enlinea = '0' WHERE identificador_unico = '$this->identificador_unico';";	
			}
			$this->con->simpleQuery($sql);
		}

		public function login(){
			$sql = "SELECT ids, identificador_unico, nombre_user, foto, rol, status FROM usuarios WHERE email = '$this->email' AND password = '$this->password';";
			$res = $this->con->returnQuery($sql);

			return $res;
		}

		public function login_fb(){
			$sql = "SELECT ids, identificador_unico, nombre_user, rol FROM usuarios WHERE identificador_unico = '$this->identificador_unico';";
			$res = $this->con->returnQuery($sql);

			return $res;
		}

	}


 ?>