<?php 
	//dominio
	define("DOMAIN", "localhost"); 
	//constantes de email SMTP
	define("mailFrom", "send@".DOMAIN);
	define("mailHost", "");
	define("mailPassword", "");
	define("mailPort", 25);
	
	//constantes de entorno
	define("DS", DIRECTORY_SEPARATOR);
	define("ROOT", realpath(dirname(__FILE__)).DS);
	define("URL", "http://".DOMAIN."/");
	//define("URL", "http://learnet.".DOMAIN."/");
	define("MSG", ROOT."Views".DS."template".DS."messages".DS);
	define("INDEX", ROOT."Views".DS."usuarios".DS."templates".DS."leeme.php");

	//________________________________________________________________________

	define("HOST", "localhost"); 
	define("USER", "root"); 
	define("PASS", "23e7085a"); 
	define("DB", "lenodula"); 

 ?>