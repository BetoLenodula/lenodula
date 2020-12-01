<?php 
	
	require_once "app/fb_init.php";

	if(isset($_SESSION['fb_access_token'])){
		try {
  				// Returns a `Facebook\FacebookResponse` object
  				$response = $fb->get('/me?fields=id,first_name,last_name,email', $_SESSION['fb_access_token']);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
  				echo 'Graph returned an error: ' . $e->getMessage();
  				exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
  				echo 'Facebook SDK returned an error: ' . $e->getMessage();
  				exit;
		}
			$userNode = $response->getGraphUser();

			if(!isset($_SESSION['userSesion'])){
				Config\Autoload::run();
				$new_fb_user = new Controllers\usuariosController();

				$new_fb_user->reg_auth_facebook($userNode['id'], $userNode['first_name'], $userNode['last_name'], $userNode['email']);

				$row = $new_fb_user->login_facebook($userNode['id']);

				$datos = $row->fetch_array();

				$foto = 'https://graph.facebook.com/'.$datos['identificador_unico'].'/picture?type=small';
				$arraySesion = array('id' => $datos['identificador_unico'], 'nombre_user' => $datos['nombre_user'], 'foto' => $foto, 'rol' =>$datos['rol'] ,'id_session' => $datos['ids']);

				$_SESSION['userSesion'] = $arraySesion;
			}
	}
	else{
		
		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$loginUrlFB = $helper->getLoginUrl(URL.'fb-callback.php', $permissions);
		define("URLFB", htmlspecialchars($loginUrlFB));
	}

 ?>