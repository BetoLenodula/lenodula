<?php 
	namespace Controllers;	

	use Models\Usuario as Usuario;
	use Classes\Resize as Resize;
	use Classes\PHPMailer as Mail;
	use Classes\Method as Method;
	use Classes\Cache as Cache;

	
	class usuariosController{

		private $usuario;
		private $funcion;

		public function __construct(){
			$this->usuario = new Usuario();
			$this->funcion = new Method();
			
			Cache::configure(array(
    			'cache_path' => ROOT.'cache/users',
    			'expires' => (60 * 60)
			));
		}

		public function funcion($funcion, $arg){
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index(){

			if(isset($_GET['order'])){
				Cache::delete('lstusers');
			}

			$cache = Cache::get('lstusers');

			if(!$cache){
				$return = $this->pagina(1);
				if(!isset($_GET['order'])){
					Cache::put('lstusers', $return);
				}
			}
			else{
				$return = $cache;
			}

			return $return;
		}

		public function ayuda(){}

		public function ingresar(){
			if(!isset($_SESSION['userSesion'])){
				if($_POST){
					if(isset($_POST['ingresar'])){
						$return = $this->iniciar_sesion();
						return $return;
					}

					if(isset($_POST['registrar'])){
						$return = $this->registrar();
						return $return;
					}
				}
				else{
					return "form";
				}
			}
			else{
				header("Location:".URL);
			}
		}

		public function activity(){
			$cache = Cache::get('recent_users');

			if(!$cache){
				$ret = $this->usuario->get('activity');
				$arr = array();
				while($r = $ret->fetch_array()){
					$ids = $r['ids'];
					$idu = $r['identificador_unico'];
					$nom = $r['nombre_user'];
					$fot = $r['foto'];

					$arr[] = array('ids' => $ids, 'idu' => $idu, 'nom' => $nom, 'fot' => $fot);
				}
				$return = $arr;
				Cache::put('recent_users', $return);
			}
			else{
				$return = $cache;
			}

			return $return;
		}

		public function paginar_usuarios(){
			$pages = $this->usuario->paginar();
			return $pages;
		}

		public function contar_puntos(){
			$max_puntos = $this->usuario->contar_puntos();
			return $max_puntos;
		}

		public function buscar($arg){
			if(!$arg) $arg = false;

			$this->usuario->set('dato_ambiguo', trim(strip_tags($arg)));
			$return = $this->usuario->buscar();

			return $return;
		}

		public function ver($arg){

			$this->usuario->set('identificador_unico', trim(strip_tags($arg)));
			$res = $this->usuario->ver();

			$res = $res->fetch_array();

			return array($res['nombre_user'], $res['foto']);
		}

		public function pagina($lim){

			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 10;

			if(isset($_GET['order'])){
				$get = trim(strip_tags($_GET['order']));
			}
			else{
				$get = 0;
			}

			$this->usuario->set('limite', $lim);
			$return = $this->usuario->ver_todos($get);

			$arr = array();

			while($d = $return->fetch_array()) {
				$ids = $d['ids'];
				$idu = $d['identificador_unico'];
				$nom = $d['nombre_user'];
				$fot = $d['foto'];
				$nos = $d['nombres'];
				$ape = $d['apellidos'];
				$rol = $d['rol'];
				$tot = $d['total_puntos'];

				$arr[] = array('ids' => $ids, 'identificador_unico' => $idu, 'nombre_user' => $nom, 'foto' => $fot, 'nombres' => $nos, 'apellidos' => $ape, 'rol' => $rol, 'total_puntos' => $tot);
				}

			return $arr;
		}

		public function confirmar($token){
			if(false == preg_match("/^[0-9a-f]{32}$/", $token)){
				return "El Token es inválido o falta!!";
			}
			$this->usuario->set('codigo_activacion', $token);
			$res = $this->usuario->confirm();
			if($res){
				return "true";
			}
			else{
				return "false";
			}
		}

		public function perfil($arg){
			
			if(isset($_SESSION['userSesion'])){
				$idu = $_SESSION['userSesion']['id'];
				$this->usuario->set('identificador_unico', $idu);
			}

			if($_POST){
				if(isset($_POST['guardar_foto']) &&
					$_POST['guardar_foto'] == 'GUARDAR'){

					$return = $this->subir_foto();
					return $return;
				}
				else{
					$return = $this->editar();
					return $return;
				}
			}
			else{
				if(isset($_SESSION['userSesion'])){
					if($arg == "my"){
						$res = $this->usuario->ver();
					}
					else{
						$this->usuario->set('identificador_unico', trim(strip_tags($arg)));
						$res = $this->usuario->ver();
					}
				}
				else{
					if($arg == "my"){
						return "Se necesita abrir una Sesión para ver un Perfil propio";
					}
					else{
						$this->usuario->set('identificador_unico', trim(strip_tags($arg)));
						$res = $this->usuario->ver();
					}
				}

				if($res){
					return $res;	
				}
				else{
					return "Error al consultar usuarios!!";
				}
			}
		}

		public function editar(){

				if(!empty($_POST['nombre_user']) || $_POST['nombre_user'] != '...'){
					if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]{2,15}$/", $_POST['nombre_user'])){
						return "Nombre de usuario, Solo se permite letras y números y mínimo 2 caracteres (sin espacios)";
					}
				}

				if(!empty($_POST['nombres']) && $_POST['nombres'] != '...'){
					if(false == preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,60}$/", $_POST['nombres'])){
						return "Falta El/Los Nombres, o excede el límite permitido, (No debe contener números o caracteres extraños)!!";
					}
				}

				if(!empty($_POST['apellidos']) && $_POST['apellidos'] != '...'){
					if(false == preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,60}$/", $_POST['apellidos'])){
						return "Faltan Los Apellidos, o excede el límite permitido, (No debe contener números o caracteres extraños)!!";
					}
				}

				if(($_POST['rol'] != 'Tutor') && ($_POST['rol'] != 'Usuario')){
					return "Elige un rol correcto en el sistema!!";
				}

				$this->usuario->set('nombre_user', strip_tags(trim($_POST['nombre_user'])));
				$this->usuario->set('nombres', strip_tags(trim($_POST['nombres'])));
				$this->usuario->set('apellidos', strip_tags(trim($_POST['apellidos'])));
				$this->usuario->set('rol', strip_tags(trim($_POST['rol'])));
				$res = $this->usuario->edit();

				if($res){
					$_SESSION['userSesion']['rol'] = strip_tags(trim($_POST['rol']));
					header("Location:".URL."usuarios/perfil/my");
				}

		}

		public function cerrar_sesion(){
			if(isset($_SESSION['fb_access_token'])){
				unset($_SESSION['fb_access_token']);
			}

			if(isset($_SESSION['userSesion'])){
				$this->usuario->set('identificador_unico', $_SESSION['userSesion']['id']);
				$this->usuario->set_enlinea('unset');
				unset($_SESSION['userSesion']);
			}

			header("Location:".URL);
		}

		public function auth_facebook(){
			if(!isset($_SESSION['userSesion'])){
				header("Location:".htmlspecialchars_decode(URLFB));
			}
			else{
				return false;
			}
		}

		public function reg_auth_facebook($id, $name, $last_name, $email){
			if(empty($email)) $email = '...';
			$this->usuario->set('ids', 'FB');
			$this->usuario->set('identificador_unico', $id);
			$this->usuario->set('foto', 'na');
			$this->usuario->set('nombre_user', $name);
			$this->usuario->set('nombres', '...');
			$this->usuario->set('apellidos', $last_name);
			$this->usuario->set('email', $email);
			$this->usuario->set('password', 'na');
			$this->usuario->set('rol', 'Usuario');
			$this->usuario->set('codigo_activacion', 'na');
			$this->usuario->set('fecha_ingreso', date('Y-m-d'));
			$this->usuario->set('status', 1);
			$this->usuario->set('total_respuestas', 0);
			$this->usuario->set('total_puntos', 0);
			$this->usuario->set('total_gratificaciones', 0);
			$this->usuario->set('enlinea', 0);

			$res = $this->usuario->add();

		}

		public function login_facebook($id){
			$this->usuario->set('identificador_unico', $id);
			$this->usuario->set_enlinea('set');
			$res = $this->usuario->login_fb();
			return $res;
		}

		public static function getsession(){
			if(isset($_SESSION['userSesion'])){
				echo $_SESSION['userSesion']['id'];
			}
		}

		public function iniciar_sesion(){

			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				return "Formato de Email inválido!!";
			}

			if(false == preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&_.]{8,15}$/", $_POST['password'])){
				return "Falta el password o debe ser mínimo de 8 caracteres sin (eñes, ni acentos o algunos caracteres raros)!!";
			}

			$this->usuario->set('email', trim($_POST['email']));
			$this->usuario->set('password', sha1(sha1(trim($_POST['password']))));

			$res = $this->usuario->login();

			$row = $res->fetch_array();

			if(!empty($row['identificador_unico']) && $row['status'] == 1){
				$arraySesion = array('id' => $row['identificador_unico'], 'nombre_user' => $row['nombre_user'], 'foto' => $row['foto'], 'rol' => $row['rol'] ,'id_session' => $row['ids']);

				$this->usuario->set('identificador_unico', $row['identificador_unico']);
				$this->usuario->set_enlinea('set');

				$_SESSION['userSesion'] = $arraySesion;
				header("Location:".URL);
			}
			else if(!empty($row['identificador_unico']) && $row['status'] == 0){
				return "Falta aun confirmar tu cuenta, checa en tu Correo y confirma tu registro!!";
			}
			else{
				return "El Email o el Password, No son los correctos!!";
			}

		}

		public function subir_foto(){
			
			if(!empty($_FILES['foto']['name'])){
				
				$fsize = $_FILES['foto']['size'];
				$ftype = strip_tags(trim($_FILES['foto']['type']));
				$foto = strip_tags(trim($_FILES['foto']['name']));

				if($ftype != 'image/jpeg'){
					return 'Formato de Foto Inválido (Debe ser jpg o jpeg)';
				}

				if($fsize > (3670016)){
					return 'Tamaño de Foto excedido al permitido';
				}
			
				$ruta = ROOT."Views".DS."template".DS."images".DS."pictures".DS;
				opendir($ruta);

				$fotoUp = $ruta.$foto;

				if(move_uploaded_file(strip_tags(trim($_FILES['foto']['tmp_name'])), $fotoUp)){
					$patron = "1234567890abcdefghijklmnopqrstuvwxyz"; 
					$nameFoto="";

					for($i = 0; $i <= 12; $i++) { 
				    	$nameFoto = $nameFoto.$patron{rand(0, 35)}; 
					}

					$nameFoto = $nameFoto.".jpg";


					$imgResize = new Resize($fotoUp);
					$imgResize->resizeImage(90, 90, 'crop');  
					$imgResize->saveImage($ruta.$nameFoto, 100);
					
					if(is_readable($fotoUp)){
						unlink($fotoUp);
					}

					if(isset($_POST['hidefoto']) && !empty($_POST['hidefoto'])){
						$oldfoto = $ruta.trim(strip_tags($_POST['hidefoto']));

						if(is_readable($oldfoto)){
							unlink($oldfoto);
						}
						
						$_SESSION['userSesion']['foto'] = $nameFoto;
					}

					$this->usuario->set('foto', $nameFoto);

					$res = $this->usuario->guardar_foto();

					if($res){
						header("Location:".URL."usuarios/perfil/my");
					}
					else{
						return 'Error al guardar nombre de imagen!';
					}
				}
				else{
					return 'Error al Subir Foto';
				}
			}
			else{
				return 'No has elegido una imagen para subir!!';
			}
			
		}

		public function registrar(){
			if(false == preg_match("/^[0-9a-zA-ZñÑ]{5,15}$/", $_POST['nombre_user'])){
				return "Nombre de usuario, Solo se permite letras y números y mínimo 5 caracteres (sin espacios)";
			}

			if(false == preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,60}$/", $_POST['nombres'])){
				return "Falta El/Los Nombres, o excede el límite, (No debe contener números o caracteres extraños)!!";
			}


			if(false == preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,60}$/", $_POST['apellidos'])){
				return "Faltan Los Apellidos, o excede el límite, (No debe contener números o caracteres extraños)!!";
			}

			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				return "Formato de Email inválido!!";
			}

			if(!filter_var($_POST['remail'], FILTER_VALIDATE_EMAIL)){
				return "Formato de Email inválido al repetirlo!!";
			}

			if($_POST['email'] != $_POST['remail']){
				return "No coinciden los email proporcionados!!";
			}

			if(false == preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&_.]{8,15}$/", $_POST['password'])){
				return "Falta el password o mínimo de 8 caracteres (números y letras), excepto espacios, o algunos caracteres extraños!!";
			}

			if(false == preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&_.]{8,15}$/", $_POST['rpassword'])){
				return "Falta el password al repetirlo o mínimo de 8 caracteres (números y letras), excepto espacios, o algunos caracteres extraños!!";	
			}

			if($_POST['password'] != $_POST['rpassword']){
				return "No coinciden los password porporcionados!!";
			}

			if(($_POST['rol'] != 'Tutor') && ($_POST['rol'] != 'Usuario')){
				return "Elige un rol en el sistema!!";
			}
			$patron = "1234567890abcdefghijklmnopqrstuvwxyz"; 
			$id_u="";

			for($i = 0; $i <= 15; $i++) { 
				 $id_u = $id_u.$patron{rand(0, 35)}; 
			}

			$codigo_activacion = md5(uniqid(rand(), true));

			$this->usuario->set('ids', 'LN');
			$this->usuario->set('identificador_unico', $id_u);
			$this->usuario->set('foto', 'none');
			$this->usuario->set('nombre_user', strip_tags(trim($_POST['nombre_user'])));
			$this->usuario->set('nombres', strip_tags(trim($_POST['nombres'])));
			$this->usuario->set('apellidos', strip_tags(trim($_POST['apellidos'])));
			$this->usuario->set('email', strip_tags(trim($_POST['email'])));
			$this->usuario->set('password', sha1(sha1(strip_tags(trim($_POST['password'])))));
			$this->usuario->set('rol', strip_tags(trim($_POST['rol'])));
			$this->usuario->set('codigo_activacion', $codigo_activacion);
			$this->usuario->set('fecha_ingreso', date('Y-m-d'));
			$this->usuario->set('status', 0);
			$this->usuario->set('total_respuestas', 0);
			$this->usuario->set('total_puntos', 0);
			$this->usuario->set('total_gratificaciones', 0);
			$this->usuario->set('enlinea', 0);

			$res = $this->usuario->add();

			if($res){
				$mail = new Mail();
				$mail->From = (mailFrom);
				$mail->FromName = "LENODULA";
				$mail->AddAddress(strip_tags(trim($_POST['email'])));
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
				$mail->Subject = "Confirmacion";
				$mail->Body = "<h3 color='FF4000'>Lenodula (ELearning LMS)</h3>".
							  "<img src='".URL."Views/template/images/favicon.ico'><br>".	
							  "Para: ".strip_tags(trim($_POST['nombres']))."\n <br>".
							  "Email: ".strip_tags(trim($_POST['email']))."\n <br>".
							  "Tu contraseña registrada en LENODULA fué: <u>".strip_tags(trim($_POST['password']))."</u> \n <br><br>".
							  "<b>Hola <u>".strip_tags(trim($_POST['nombres']))."</u> Te has registrado con éxito, da click en el botón para confirmar tu registro</b> <br><br>".
							  "<a href='".URL."usuarios/confirmar/".$codigo_activacion."' target='_blank'>
							  <button>
							  Confirmar mi registro aquí</button></a>";
				$mail->IsSMTP();
				$mail->Host = mailHost;
				$mail->Port = mailPort;
				$mail->SMTPAuth = true;
				$mail->Username = mailFrom;
				$mail->Password = mailPassword;
				if($mail->Send()){
					return "signin";
				}
				else{
					return "Falló el envio del Email de confirmación";
				}
			}
			else{
				return "No se pudo registrar el usuario, el Correo que proporcionas ya existe en el sistema!!";
			}

		}

	}


 ?>