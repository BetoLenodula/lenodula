<?php 
	require_once "src/facebook-sdk-v5/autoload.php";

	//ini_set("session.cookie_lifetime","7200");
	//ini_set("session.gc_maxlifetime","7200");
	session_start();

	$fb = new Facebook\Facebook([
  		'app_id' => '1498743246965302', // Replace {app-id} with your app id
  		'app_secret' => '5c46b9a497914d492294765c03f5e1e0',
  		'default_graph_version' => 'v2.2',
  	]);

 ?>