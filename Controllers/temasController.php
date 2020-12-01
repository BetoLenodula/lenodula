<?php 
	namespace Controllers;

	use Models\Tema as Tema;
	use Models\Wordfind as Wordfind;
	use Models\Guessword as Guessword;
	use Models\Timeline as Timeline;
	use Classes\Method as Method;
	use Classes\Resize as Resize;
	use Classes\InputFilter as Filter;
	use Classes\Cache as Cache;

	class temasController{

		private $tema;
		private $funcion;
		private $grupo;
		private $curso;
		private $filter;
		private $archivo;
		private $guesswrd;
		private $wordfnd;
		private $timeline;

		public function __construct(){
			$this->tema = new Tema();
		}

		public function funcion($funcion, $arg){
			$this->funcion = new Method();
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function index(){}

		public function nuevo(){
			if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor'){
				if($_POST){
					$return = $this->registrar_tema();
					return $return;
				}
			}
			else{
				header("Location:".URL);	
			}
		}

		public function ayuda($arg){
		}

		public function borrar(){
			if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor'){
				$this->tema->set('id', trim(strip_tags($_POST['idte'])));
				$this->tema->set('titulo', trim(strip_tags($_POST['tite'])));
				$this->tema->set('id_usuario', trim(strip_tags($_POST['idus'])));

				$return = $this->tema->delete();
				echo $return;
			}
			else{
				header("Location:".URL);
			}
		}

		public function paginar_temas($arg){
			$this->tema->set('id_materia_curso', trim(strip_tags($arg)));
			$pages = $this->tema->paginar();
			return $pages;
		}

		public function addver_tema(){
			$pd = json_decode(base64_decode($_POST['dats']));

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/", $pd->ti)){
				return "Nombre de tema invaĺido!!";
			}
			if(false == preg_match("/^\d*$/", $pd->id)){
				return "Id inválido!!";
			}
			if($pd->pre != 'idt'){
				return "Id inválido!!";
			}

			$this->tema->set('id', $pd->id);
			$this->tema->set('id_usuario', $_SESSION['userSesion']['id']);

			$res = $this->tema->addver_tema();

			if($res){
				echo $res;
			}
		}

		public function get_addver_tema($id){
			$this->tema->set('id', $id);
			$this->tema->set('id_usuario', $_SESSION['userSesion']['id']);

			$res = $this->tema->get_addver_tema();
			return $res;
		}


		public function listar($arg){	
			if(isset($_GET['page'])){
				$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_URL);
				$page = trim(strip_tags($page));
				$lim = filter_var($page, FILTER_VALIDATE_INT);
			}
			else{
				$lim = 1;
			}

			if(!$lim || $lim < 0 || $lim > (10000 * 10000)){
				$lim = 1;	
			}

			$lim--;
			$lim *= 10;

			if($arg){
				$arg = filter_var($arg, FILTER_VALIDATE_INT);
				if($arg < 1) $arg = 1;
				$this->tema->set('id_materia_curso', trim(strip_tags($arg)));
			}

				$this->tema->set('limite', $lim);
			
			if(isset($_GET['idmod']) && isset($_GET['idses'])){
				$idmod = filter_var($_GET['idmod'], FILTER_VALIDATE_INT);
				$this->tema->set('id_unidad', $idmod);
				$this->tema->set('id_usuario', trim($_GET['idses']));
				$return = $this->tema->ver_todos('modulo');
			}
			else{
				$return = $this->tema->ver_todos(null);	
			}
			
			
			$dats = array();

			while($r = $return->fetch_array()){
				$id = $r['id'];
				$ti = $r['titulo'];
				$iu = $r['id_unidad'];
				if(isset($r['id_materia_curso'])){
					$ic = $r['id_materia_curso'];
				}
				else{
					$ic = 'null';
				}
				$fe = $r['fecha_publicacion'];
				if(isset($r['id_tema'])){
					$it = $r['id_tema'];
				}
				else{
					$it = 'null';
				}
				$ni = $r['nivel_tema'];

				$dats[] = array('id' => $id, 'iu' => $iu, 'ic' => $ic ,'ti' => $ti, 'fe' => $this->funcion('alfa_months', $fe), 'it' => $it, 'ni' => $ni);
			}

			if(isset($_GET['get_type'])){
				echo json_encode($dats);
			}
			else{
				return $dats;
			}
		}

		public function searchtag($arg){
			$gr = "";
			$arg = trim(strip_tags($arg));

			if(isset($_GET['g'])){
				$gr = filter_var($_GET['g'], FILTER_VALIDATE_INT);
			}
			else{
				header('Location:'.URL);
			}

			$this->tema->set('tags', $arg);
			$this->tema->set('dato_ambiguo', $gr);
			
			if(isset($_SESSION['userSesion'])){
				$this->tema->set('id_usuario', $_SESSION['userSesion']['id']);
			}
			else{
				$this->tema->set('id_usuario', null);	
			}

			$return = $this->tema->search_by_tag();

			$dats = array();

			while($r = $return->fetch_array()){
				$id = $r['id'];
				$ti = $r['titulo'];
				$iu = $r['id_unidad'];
				$fe = $r['fecha_publicacion'];
				$ius = $r['id_user'];
				$me = $r['member'];
				$it = 'null';

				$dats[] = array('id' => $id, 'ius' => $ius ,'iu' => $iu, 'ti' => $ti, 'fe' => $this->funcion('alfa_months', $fe), 'it' => $it, 'me' =>$me);
			}

			return $dats;

		}

		public function buscar($arg){
			if(is_numeric($arg)){
				header("Location:".URL."temas/listar/".$arg);
			}

			if(isset($_GET['c'])){
				$idmc = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_URL);
				$idmc = trim(strip_tags($idmc));
				$idmc = filter_var($idmc, FILTER_VALIDATE_INT);
			}
			else{
				$idmc = 0;
			}

			$this->tema->set('dato_ambiguo', trim(strip_tags($arg)));
			$this->tema->set('id_materia_curso', $idmc);
			$return = $this->tema->buscar();
			$dats = array();

			while($r = $return->fetch_array()){
				$id = $r['id'];
				$ti = $r['titulo'];
				$iu = $r['id_unidad'];
				$fe = $r['fecha_publicacion'];

				$dats[] = array('id' => $id, 'iu' => $iu, 'ti' => $ti, 'fe' => $this->funcion('alfa_months', $fe));
			}

			return $dats;
		}

		public function get_ids_g_p($arg){
			$this->tema->set('id', trim(strip_tags($arg)));
			$this->curso = new cursosController();

			$idc = $this->get_id_curso($arg);
			$idg = $this->curso->id_grupo_curso($idc);
			$idu = $this->curso->id_propietario_curso($idc);
			$member = $this->validar_miembro($_SESSION['userSesion']['id'], $idg);

			$arr = array($idu, $member);
			return $arr;
		}


		public function get_id_curso($arg){
			$this->tema->set('id_materia_curso', trim(strip_tags($arg)));
			$return = $this->tema->get_id_curso();
			return $return;
		}

		public function get_titulo($arg){
			$this->tema->set('id', trim(strip_tags($arg)));
			$return = $this->tema->get('titulo');
			return $return;
		}

		public function get_id_usuario($arg){
			$this->tema->set('id', trim(strip_tags($arg)));
			$return = $this->tema->get('id_usuario');
			return $return;
		}

		public function get_num_by_cur($arg){
			$arg = filter_var($arg, FILTER_VALIDATE_INT);
			if(isset($_GET['like']) && (preg_match("/^[0-9a-z]{15,16}$/", $_GET['like']))){
				$ses = trim($_GET['like']);
			}
			else{
				$ses = $_SESSION['userSesion']['id'];
			}

			$this->tema->set('id_usuario', $ses);
			$this->tema->set('id_materia_curso', trim(strip_tags($arg)));
			$return = $this->tema->get_num_by_cur();

			if($return[0] != 0){
				$r = ceil((100 * $return[1]) / $return[0]);
			}
			else{
				$r = 0;
			}
			
			return $r;	
		}

		

		public function ver($arg){
			if(!$arg) $arg = false;

			if(isset($_SESSION['userSesion'])){
				if($_FILES){
					$r = $this->attach_archivo($arg, "respuesta");
				}

					$arg = explode(".", $arg);
					$id = filter_var(end($arg), FILTER_VALIDATE_INT);
					$arg = $arg[0];

					$getids = $this->get_ids_g_p($id);
					$idu = $getids[0];
					$member = $getids[1];

					$this->tema->set('titulo', trim(strip_tags($arg)));
					
					Cache::configure(array(
		    			'cache_path' => ROOT.'cache/themes',
		    			'expires' => (60 * 60 * 24)
					));

					if($member == 1 || $idu == $_SESSION['userSesion']['id']){
						$cache = Cache::get('vtema'.$id);

						if(!$cache){
							$ret = $this->tema->ver();
							$return = $ret->fetch_array();
							Cache::put('vtema'.$id, $return);
						}
						else{
							$return = $cache;
						}

						return array($return, $arg.".".$id);
					}
					else{
						header("Location: ".URL);
					}
			}
			else{
				header("Location: ".URL);
			}
		}


		public function editar($arg){
			if(isset($_SESSION['userSesion'])){
				if($_FILES){
					$return = $this->attach_archivo($arg, "tema");
				}
				else{
					$return = $this->actualizar_tema($arg);
				}
				return $return;
			}
			else{
				header("Location: ".URL);
			}
		}

		public function saveCanvas(){
			if(array_key_exists('img',$_REQUEST)){
			    $imgData = base64_decode(substr($_REQUEST['img'],22));

			    if(isset($_POST['rsrc'])){
			    	$resource = base64_decode($_POST['rsrc']);
			    }
			    else{
			    	return false;
			    }

			    if(isset($_POST['arg'])){
			    	$arg = base64_decode($_POST['arg']);
			    	$id = explode(".", $arg);
					$id = end($id);
					$id = intval($id);
			    }
			    else{
			    	return false;
			    }


			    $patron = "1234567890abcdefghijklmnopqrstuvwxyz"; 
				$id_file = "";

				for($i = 0; $i <= 13; $i++){ 
		    		$id_file = $id_file.$patron{rand(0, 35)}; 
				}
				$id_file = $id_file.".jpg";

				if($resource == 'tema'){
					$route = ROOT.'Resources'.DS.'files_tut'.DS;
				}
				if($resource == 'respuesta'){
					$route = ROOT.'Resources'.DS.'files_usr'.DS;	
				}
			 
			    $file = $route.$id_file;

			
			    if (file_exists($file)){ unlink($file); }
			        $fp = fopen($file, 'w');
			        fwrite($fp, $imgData);
			        fclose($fp);

			        $this->archivo = new archivosController();
					$nf = "";
			        if($resource == 'tema'){
						$nf = $this->archivo->nuevo_at($id, $id_file, $id_file, 'image/jpeg');
					}
					if($resource == 'respuesta'){
						$nf = $this->archivo->nuevo_ar($id, $id_file, $id_file, 'image/jpeg');
					}
			        
			        if($nf){
						echo "true";
					}
					else{
						echo 'false';
					}
			}
		}

		public function saveRecord(){

			if(isset($_FILES['file']) and !$_FILES['file']['error']){
		    	
				if(isset($_POST['rsrc'])){
			    	$resource = trim($_POST['rsrc']);
			    }
			    else{
			    	return false;
			    }

			    if(isset($_POST['arg'])){
			    	$arg = trim($_POST['arg']);
			    	$id = explode(".", $arg);
					$id = end($id);
					$id = intval($id);
			    }
			    else{
			    	return false;
			    }

				$patron = "1234567890abcdefghijklmnopqrstuvwxyz"; 
				$id_file = "";

				for($i = 0; $i <= 13; $i++){ 
		    		$id_file = $id_file.$patron{rand(0, 35)}; 
				}
				$id_file = $id_file.".mp3";

				if($resource == 'tema'){
					$route = ROOT.'Resources'.DS.'files_tut'.DS;
				}
				if($resource == 'respuesta'){
					$route = ROOT.'Resources'.DS.'files_usr'.DS;	
				}
			 
			    $file = $route.$id_file;	

			    if (file_exists($file)){ unlink($file); }
			    move_uploaded_file($_FILES['file']['tmp_name'], $file);		

			    $this->archivo = new archivosController();
				$nf = "";
		        if($resource == 'tema'){
					$nf = $this->archivo->nuevo_at($id, $id_file, $id_file, 'audio/mpeg');
				}
				if($resource == 'respuesta'){
					$nf = $this->archivo->nuevo_ar($id, $id_file, $id_file, 'audio/mpeg');
				}
		        
		        
				if($nf){
					echo "true";
				}
				else{
					echo "false";
				}
		   
			}
		}

		public function attach_archivo($arg, $resource){
			$file = $_FILES['archivo']['name'];
			$size = $_FILES['archivo']['size'];
			$type = $_FILES['archivo']['type'];

			if(!empty($file)){
				if($size < (5242880)){
					$mime = array("text/plain","text/rtf","text/html","text/css","text/x-c++src","text/x-csrc","application/dxf","application/dwg","application/pdf","application/sql","application/x-javascript","application/x-php","application/zip","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document",
						 "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.presentationml.presentation",
						 "application/vnd.ms-powerpoint","application/vnd.ms-publisher","application/java","application/x-rar","application/rar","audio/mpeg","audio/ogg","audio/x-m4a", "image/jpeg", "image/png", "image/gif", "video/mp4");
					if(in_array($type, $mime)){
						
						$id = explode(".", $arg);
						$id = filter_var(end($id), FILTER_VALIDATE_INT);
						$id = intval($id);

						$patron = "1234567890abcdefghijklmnopqrstuvwxyz"; 
						$id_file = "";

						for($i = 0; $i <= 13; $i++){ 
				    		$id_file = $id_file.$patron{rand(0, 35)}; 
						}

						$ext = explode(".", $file);
						$ext = end($ext);
						$id_file = $id_file.".".$ext;
					
						if($resource == 'tema'){
							$route = ROOT.'Resources'.DS.'files_tut'.DS;
						}
						if($resource == 'respuesta'){
							$route = ROOT.'Resources'.DS.'files_usr'.DS;	
						}

						opendir($route);
						$source = $route.$id_file;


						if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif'){
							copy(trim(strip_tags($_FILES['archivo']['tmp_name'])), $route.$file);	
						}
						else{
							copy(trim(strip_tags($_FILES['archivo']['tmp_name'])), $source);	
						}
						

						if(is_uploaded_file($_FILES['archivo']['tmp_name'])){

							if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif'){
								$timg = getimagesize($route.$file);

							if($timg[0] < 2200){
									$imgResize = new Resize($route.$file);
									
										if($timg[0] < 500){
											$width = $timg[0];
											$height = $timg[1];
										}
										else if($timg[0] < 800){
											$width = ceil($timg[0] / 1.2);
											$height = ceil($timg[1] / 1.2);
										}
										else if($timg[0] > 800){
											$width = ceil($timg[0] / 3);
											$height = ceil($timg[1] / 3);
										}
										else if($timg[0] > 1200){
											$width = ceil($timg[0] / 4);
											$height = ceil($timg[1] / 4);	
										}
										else if($timg[0] > 1600){
											$width = ceil($timg[0] / 5);
											$height = ceil($timg[1] / 5);	
										}
										else if($timg[0] > 2000){
											$width = ceil($timg[0] / 6);
											$height = ceil($timg[1] / 6);		
										}
										

									$imgResize->resizeImage($width, $height, 'crop');  
									$imgResize->saveImage($source, 62);

								}

								if(is_readable($route.$file)){
									unlink($route.$file);
								}
							}

							$this->archivo = new archivosController();
							$nf = "";
							if($resource == 'tema'){
								$nf = $this->archivo->nuevo_at($id, $id_file, $file, $type);
							}
							if($resource == 'respuesta'){
								$nf = $this->archivo->nuevo_ar($id, $id_file, $file, $type);
							}

							if($nf){
								if($resource == 'tema'){
									header("Location:".URL."temas/editar/".$arg."#archivosVisor");
								}
								if($resource == 'respuesta'){
									header("Location:".URL."temas/ver/".$arg."#archivosVisor");
								}
							}
							else{
								return 'Problema al registrar el archivo!!';
							}

						}
						else{
							return 'Error al cargar archivo !!';
						}
					}
					else{
						return 'Tipo de archivo no permitido !!';
					}
				}
				else{
					return 'El tamaño del archivo es mayor a 5 MB !!';
				}
			}
			else{
				return 'No elegiste ningún archivo !!';
			}
		}

		function listar_archivos($arg, $tfile){
			$id = explode(".", $arg);
			$id = filter_var(end($id), FILTER_VALIDATE_INT);
			$this->archivo = new archivosController();

			if($tfile == 'tema'){
				$return = $this->archivo->ver_at($id);
			}
			if($tfile == 'respuesta'){
				$return = $this->archivo->ver_ar($id);	
			}
			if($tfile == 'temresp'){
				$return = $this->archivo->ver_arat($id);		
			}
			return $return;
		}

		public function crearwordfind($arg){
			    $argup = $arg;
				$arg = explode(".", $arg);
				$id = filter_var(end($arg), FILTER_VALIDATE_INT);
				
				$getids = $this->get_ids_g_p($id);
				$idu = $getids[0];
				$member = $getids[1];
				if($idu == $_SESSION['userSesion']['id']){
					if($_POST){
						if(empty($_POST['nombre'])){
							return "Indica un nombre!";
						}
						if(strlen($_POST['nombre']) > 100){
							return "El nombre es muy largo!";
						}
						if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{1,100}$/", $_POST['nombre'])){
							return "El nombre NO debe tener caracteres extraños!!";
						}

						if(empty($_POST['tags_hidden'])){
					        return "Agrega palabras!!";
					    }
					    if(strlen($_POST['tags_hidden']) > 300){
					        return "Son demasiadas palabras!!";
					    }
					    if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,]{1,300}$/", $_POST['tags_hidden'])){
					        return "No utilices caracteres extraños ni ESPACIOS, solamente palabras!";
					    }

					    $this->wordfnd = new Wordfind();

					    $this->wordfnd->set('id_tema', $id);
					    $this->wordfnd->set('nombre_wrdfnd', trim($_POST['nombre']));
					    $this->wordfnd->set('words_wrdfnd', trim($_POST['tags_hidden']));
					    $this->wordfnd->set('fecha_wrdfnd', date('Y-m-d'));

					    $res = $this->wordfnd->new_wordfind();

					    if(is_array($res)){
							echo $argup."?wrf=".$res[1];	
						}
						else if($res == false){
							echo "exist";
						}
						else{
							echo "error";
						}
					}

				}
				else{
					header("Location:". URL);
				}
		}

		public function wordfind($arg){
			if(isset($_GET['wrf'])){
				if(is_numeric($_GET['wrf'])){
					$arg = explode(".", $arg);
					$tit = $arg[0];

					$idw = trim(strip_tags($_GET['wrf']));

					$this->wordfnd = new Wordfind();

					$this->wordfnd->set('id', $idw);
					$this->wordfnd->set('dato_ambiguo', $tit);

					$res = $this->wordfnd->ver_wordfind();
					return $res;
				}
				else{
					header("Location:". URL);
				}
			}
			else{
				header("Location:". URL);
			}
		}

		public function del_wordfind(){
			if(isset($_SESSION['userSesion'])){
				if(isset($_POST['idgm']) && is_numeric($_POST['idgm'])){
					$this->wordfnd = new Wordfind();
					$this->wordfnd->set('id', trim($_POST['idgm']));
					$res = $this->wordfnd->del_wordfind();
					echo $res;
				}
			}
			else{
				echo "ses";
			}
		}

		public function list_games($arg){
			$arg = explode(".", $arg);
			$id = filter_var(end($arg), FILTER_VALIDATE_INT);

			if(isset($_GET['limit'])){
				$lim = trim(strip_tags($_GET['limit']));
			}
			else{
				$lim = 0;
			}

			$this->tema->set('id_tema', $id);
			$this->tema->set('limite', $lim);
			$res = $this->tema->list_games();

			$dats = array();
			while($r = $res->fetch_array()){
				$id  = $r['id'];
				$nom = $r['nombre'];
				$tip = $r['tipo'];
				$fec = $r['fecha'];

				$dats[] = array('id' => $id, 'nom' => $nom, 'tip' => $tip, 'fec' => $fec);
			}

			if(isset($_GET['get_type'])){
				echo json_encode($dats);
			}
			else{
				return $dats;	
			}
		}

		public function crearguesswrd($arg){
			$argup = $arg;
			$arg = explode(".", $arg);
			$id = filter_var(end($arg), FILTER_VALIDATE_INT);
			
			$getids = $this->get_ids_g_p($id);
			$idu = $getids[0];
			$member = $getids[1];

			if($idu == $_SESSION['userSesion']['id']){
				if($_POST){
					if(empty($_POST['nombre'])){
						return "Indica un nombre o título!";
					}
					if(strlen($_POST['nombre']) > 100){
						return "El nombre es muy largo!";
					}
					if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{1,100}$/", $_POST['nombre'])){
						return "El nombre NO debe tener caracteres extraños!!";
					}

					if(empty($_POST['words'])){
				        return "Agrega palabras!!";
				    }
				    if(strlen($_POST['words']) > 400){
				        return "Son demasiadas palabras!!";
				    }
				    if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,]{1,400}$/", $_POST['words'])){
				        return "No utilices caracteres extraños, solamente palabras y sin espacios!";
				    }
				    if(empty($_POST['clues'])){
				        return "Agrega pistas!!";
				    }
				    if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,\s\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{1,}$/", $_POST['clues'])){
				        return "No utilices caracteres extraños en las pistas!";
				    }
				    if(isset($_POST['pic_guess'])){
				    	$pic = trim(strip_tags($_POST['pic_guess']));
				    }
				    else{
				    	$pic = 'na';
				    }

				    $this->guesswrd = new Guessword();

				    $this->guesswrd->set('id_tema', $id);
				    $this->guesswrd->set('nombre_guesswrd', trim($_POST['nombre']));
				    $this->guesswrd->set('image_guesswrd', $pic);
				    $this->guesswrd->set('words', trim($_POST['words']));
				    $this->guesswrd->set('clues', trim($_POST['clues']));
				    $this->guesswrd->set('fecha_guesswrd', date('Y-m-d'));

				    $res = $this->guesswrd->new_guessword();

				    if(is_array($res)){
						echo $argup."?gwr=".$res[1];	
					}
					else if($res == false){
						echo "exist";
					}
					else{
						echo "error";
					}
				}

			}
			else{
				header("Location:". URL);
			}
		}

		public function guessword($arg){
			if(isset($_GET['gwr'])){
				if(is_numeric($_GET['gwr'])){
					$arg = explode(".", $arg);
					$tit = $arg[0];

					$idg = trim(strip_tags($_GET['gwr']));
					$this->guesswrd = new Guessword();

					$this->guesswrd->set('id', $idg);
					$this->guesswrd->set('dato_ambiguo', $tit);

					Cache::configure(array(
		    			'cache_path' => ROOT.'cache/elements/guesswrds',
		    			'expires' => (60 * 60 * 24)
					));
					$cache = Cache::get('guessw'.$idg);

					if(!$cache){
						$res = $this->guesswrd->ver_guessword();
						$ret = $res->fetch_array();
						Cache::put('guessw'.$idg, $ret);	
					}
					else{
						$ret = $cache;
					}
					
					return $ret;
				}
				else{
					header("Location:". URL);
				}
			}
			else{
				header("Location:". URL);
			}
		}

		public function del_guessword(){
			if(isset($_SESSION['userSesion'])){
				if(isset($_POST['idgm']) && is_numeric($_POST['idgm'])){
					$this->guesswrd = new Guessword();
					$this->guesswrd->set('id', trim($_POST['idgm']));
					$res = $this->guesswrd->del_guessword();
					echo $res;
				}
			}
			else{
				echo "ses";
			}
		}

		public function creartimeline($arg){
			$argup = $arg;
			$arg = explode(".", $arg);
			$id = filter_var(end($arg), FILTER_VALIDATE_INT);
			
			$getids = $this->get_ids_g_p($id);
			$idu = $getids[0];
			$member = $getids[1];

			if($idu == $_SESSION['userSesion']['id']){
				if($_POST){
					if(empty($_POST['nombre'])){
						return "Indica un nombre o título!";
					}
					if(strlen($_POST['nombre']) > 100){
						return "El nombre o título es muy largo!";
					}
					if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{1,100}$/", $_POST['nombre'])){
						return "El nombre o título NO debe tener caracteres extraños!!";
					}

					if(empty($_POST['fechas'])){
				        return "Agrega fechas!!";
				    }
				    if(strlen($_POST['fechas']) > 400){
				        return "Son demasiadas fechas!!";
				    }
				    if(false == preg_match("/^[0-9\,\-]{1,400}$/", $_POST['fechas'])){
				        return "No utilices caracteres extraños en las fechas, solamente números y guiones y sin espacios!";
				    }
				    if(empty($_POST['datos'])){
				        return "Agrega datos para las fechas!!";
				    }
				    if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,\s\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{1,}$/", $_POST['datos'])){
				        return "No utilices caracteres extraños en los datos de las fechas!";
				    }
				    if(isset($_POST['pic_timel'])){
				    	$pic = trim(strip_tags($_POST['pic_timel']));
				    }
				    else{
				    	$pic = 'na';
				    }

				    $this->timeline = new Timeline();

				    $this->timeline->set('id_tema', $id);
				    $this->timeline->set('nombre_timeline', trim($_POST['nombre']));
				    $this->timeline->set('image_timeline', $pic);
				    $this->timeline->set('fechas', trim($_POST['fechas']));
				    $this->timeline->set('datos', trim($_POST['datos']));
				    $this->timeline->set('fecha_timeline', date('Y-m-d'));

				    $res = $this->timeline->new_timeline();

				    if(is_array($res)){
						echo $argup."?tml=".$res[1];	
					}
					else if($res == false){
						echo "exist";
					}
					else{
						echo "error";
					}
				}

			}
			else{
				header("Location:". URL);
			}
		}

		public function timeline($arg){
			if(isset($_GET['tml'])){
				if(is_numeric($_GET['tml'])){
					$arg = explode(".", $arg);
					$tit = $arg[0];

					$idt = trim(strip_tags($_GET['tml']));
					$this->timeline = new Timeline();

					$this->timeline->set('id', $idt);
					$this->timeline->set('dato_ambiguo', $tit);

					Cache::configure(array(
		    			'cache_path' => ROOT.'cache/elements/timelines',
		    			'expires' => (60 * 60 * 24)
					));
					$cache = Cache::get('timelin'.$idt);

					if(!$cache){
						$res = $this->timeline->ver_timeline();
						$ret = $res->fetch_array();
						Cache::put('timelin'.$idt, $ret);	
					}
					else{
						$ret = $cache;
					}

					
					return $ret;
				}
				else{
					header("Location:". URL);
				}
			}
			else{
				header("Location:". URL);
			}
		}

		public function del_timeline(){
			if(isset($_SESSION['userSesion'])){
				if(isset($_POST['idgm']) && is_numeric($_POST['idgm'])){
					$this->timeline = new Timeline();
					$this->timeline->set('id', trim($_POST['idgm']));
					$res = $this->timeline->del_timeline();
					echo $res;
				}
			}
			else{
				echo "ses";
			}
		}

		public function actualizar_tema($arg){
				$argup = $arg;
				$arg = explode(".", $arg);
				$id = filter_var(end($arg), FILTER_VALIDATE_INT);
				
				$getids = $this->get_ids_g_p($id);
				$idu = $getids[0];
				$member = $getids[1];

				if($idu == $_SESSION['userSesion']['id']){
					if($_POST){
						$pd = json_decode(base64_decode($_POST['post_dats_tema']));

						if(false == preg_match("/^[0-9a-z\_\s]{1,100}$/", $pd->ti)){
							return "Id inválido!!";
						}

						if(false == preg_match("/^\d*$/", $pd->id)){
							return "Id Invaĺido!!";
						}

						if($pd->pt != 'pt'){
							return "Id Invaĺido!!";	
						}

						if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/", $_POST['titulo'])){
							return "Indica el Título del Tema, (No se permiten caracteres especiales, solamente alfa numéricos)!!";
						}

						if(!empty($_POST['tags_hidden']) && false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,\s]{1,300}$/", $_POST['tags_hidden'])){
							return "No utilices caracteres extraños para las palabras clave, solo palabras, números separadas por (coma)";
						}

						if((!empty($_POST['fecha_limite_respuesta'])) && (false == preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['fecha_limite_respuesta']))){
							return "Indica un formato de Fecha correcto, por favor!!";
						}

						if(($_POST['permiso_archivo'] != 'Sí') && ($_POST['permiso_archivo'] != 'No')){
							return "Indica un tipo de permiso de archivos!!";
						}

						if($_POST['permiso_archivo'] == 'Sí'){
							$perm = 1;
						}
						if($_POST['permiso_archivo'] == 'No'){
							$perm = 0;
						}

						if(empty($_POST['fecha_limite_respuesta'])){
							$feclim = "NULL";
						}
						else{
							$feclim = "'".$_POST['fecha_limite_respuesta']."'";
						}
						if(empty($_POST['hora_limite_respuesta'])){
							$horlim = "NULL";
						}
						else{
							$horlim = "'".$_POST['hora_limite_respuesta']."'";
						}

						if(isset($_POST['nivel_tema']) && $_POST['nivel_tema'] == 1){
							$nivtem = $_POST['nivel_tema'];
						}
						else{
							$nivtem = 0;
						}

						$ctema = html_entity_decode(trim($_POST['content_tema']));
						$this->filter = new Filter(array('br','a','img','p','span','div','audio','figure','iframe','b','i','u','h1','blockquote','ul','ol','li','table','tbody','tr','td','font','label','input','textarea','select','option','fieldset', 'video'), array('id','class','align','src','href','color','face','contenteditable','width','height','style','allowfullscreen','frameborder','controls','download','type','value'));
						$ctema = addslashes($ctema);
						$ctema = $this->filter->process($ctema);
						$ctema = htmlentities($ctema);

						$tags = $this->funcion('remove_accents_marks', strip_tags($_POST['tags_hidden']));


						$this->tema->set('id', $pd->id);
						$this->tema->set('titulo', trim(strip_tags($_POST['titulo'])));
						$this->tema->set('contenido', $ctema);
						$this->tema->set('tags', $tags);
						$this->tema->set('fecha_publicacion', date("Y-m-d"));
						$this->tema->set('fecha_limite_respuesta', $feclim);
						$this->tema->set('hora_limite_respuesta', $horlim);
						$this->tema->set('permiso_archivo', $perm);
						$this->tema->set('nivel_tema', $nivtem);

						$return = $this->tema->edit();
						if($return){
							Cache::configure(array(
    							'cache_path' => ROOT.'cache/themes'
							));
							Cache::delete('vtema'.$pd->id);
							echo $return;
						}
					}
					else{
						$return = $this->ver($argup);
					}
					return $return;
				}
				else{
					header("Location: ".URL);	
				}
		}

		public function validar_miembro($idu, $idg = 0){
			$this->grupo = new gruposController();

			if(!$idg && isset($_GET['idgr'])){
				$idg = $_GET['idgr'];
			}

			$idu = trim(strip_tags($idu));
			$idg = filter_var($idg, FILTER_VALIDATE_INT);

			$return = $this->grupo->validar_miembro($idu, $idg, 'access_member');

			if(isset($_GET['get_type'])){
				echo $return;
			}
			else{
				return $return;
			}
		}

		public function votar_tema(){
			if(isset($_SESSION['userSesion'])){
				if(isset($_POST['idgr'])){
					$this->tema->set('id', trim(strip_tags($_POST['idgr'])));
					$this->tema->set('id_usuario', $_SESSION['userSesion']['id']);

					$return = $this->tema->votar_tema();
					echo $return;
				}
			}
			else{
				echo "sesion";
			}
		}

		public function add_tema(){
			$pd = json_decode(base64_decode($_POST['pd']));

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/", $_POST['titulo'])){
				return "Indica el Título del Tema, (No se permiten caracteres especiales, solamente alfa numéricos)!!";
			}
			if(false == preg_match("/^\d*$/", $pd->idc)){
				return "Id Invaĺido!!";
			}
			if($pd->pr != 'dat_cur'){
				return "Id Invaĺido!!";
			}

			$idu = explode("-", $_POST['idu']);
			$idu = $idu[0];

			if(false == preg_match("/^\d*$/", trim($idu))){
				return "Id Invaĺido!!";
			}


			$type = array('ñ', 'Ñ');
			$titulo = str_replace($type, "n", trim(strip_tags($_POST['titulo'])));

			$this->tema->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->tema->set('id_unidad', trim(strip_tags($idu)));
			$this->tema->set('id_materia_curso', trim(strip_tags($pd->idc)));
			$this->tema->set('titulo', $titulo);
			$this->tema->set('contenido', htmlentities("<br>"));
			$this->tema->set('tags', '');
			$this->tema->set('fecha_publicacion', date("Y-m-d"));
			$this->tema->set('fecha_limite_respuesta', "NULL");
			$this->tema->set('hora_limite_respuesta', "NULL");
			$this->tema->set('permiso_archivo', 0);
			$this->tema->set('nivel_tema', 0);
			$this->tema->set('likes_tema', 0);

			$res = $this->tema->add();

			if(is_array($res)){
				echo $this->funcion('normalize', $_POST['titulo']).".".$res[1];	
			}
			else if($res == false){
				echo "exist";
			}
			else{
				echo "error";
			}
		}

		public function registrar_tema(){

			$pd = json_decode(base64_decode($_POST['post_dats_t']));

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/", $_POST['titulo'])){
				return "Indica el Título del Tema, (No se permiten caracteres especiales, solamente alfa numéricos)!!";
			}

			if((!empty($_POST['fecha_limite_respuesta'])) && (false == preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['fecha_limite_respuesta']))){
				return "Indica un formato de Fecha correcto, por favor!!";
			}

			if(($_POST['permiso_archivo'] != 'Sí') && ($_POST['permiso_archivo'] != 'No')){
				return "Indica un tipo de permiso de archivos!!";
			}						

			if(false == preg_match("/^\d*$/", $pd->id)){
				return "Id Invaĺido!!";
			}

			if(false == preg_match("/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,100}$/", $pd->nc)){
				return "Nombre de curso inválido!!";
			}

			if($_POST['permiso_archivo'] == 'Sí'){
				$perm = 1;
			}
			if($_POST['permiso_archivo'] == 'No'){
				$perm = 0;
			}

			if(empty($_POST['fecha_limite_respuesta'])){
				$feclim = "NULL";
			}
			else{
				$feclim = "'".$_POST['fecha_limite_respuesta']."'";
			}
			if(empty($_POST['hora_limite_respuesta'])){
				$horlim = "NULL";
			}
			else{
				$horlim = "'".$_POST['hora_limite_respuesta']."'";
			}


			$type = array('ñ', 'Ñ');
			$titulo = str_replace($type, "n", trim(strip_tags($_POST['titulo'])));

			$this->tema->set('id_usuario', $_SESSION['userSesion']['id']);
			$this->tema->set('id_unidad', 0);
			$this->tema->set('id_materia_curso', trim(strip_tags($pd->id)));
			$this->tema->set('titulo', $titulo);
			$this->tema->set('contenido', htmlentities("<br>"));
			$this->tema->set('tags', '');
			$this->tema->set('fecha_publicacion', date("Y-m-d"));
			$this->tema->set('fecha_limite_respuesta', trim(strip_tags($feclim)));
			$this->tema->set('hora_limite_respuesta', trim(strip_tags($horlim)));
			$this->tema->set('permiso_archivo', $perm);
			$this->tema->set('nivel_tema', 0);
			$this->tema->set('likes_tema', 0);

			$res = $this->tema->add();

			if(is_array($res)){
				header("Location:".URL."temas/editar/".$this->funcion('normalize', $_POST['titulo']).".".$res[1]);	
			}
			else if($res == false){
				return "Ya existe un tema con el mismo nombre, elige otro nombre!!";
			}
			else{
				return "Error al guardar tema!!";
			}
			
		}
		
	}


 ?>