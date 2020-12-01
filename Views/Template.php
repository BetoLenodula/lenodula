<?php 
	namespace Views;

	
	class Template{

		private $list_grupos;
		private $argument_og;

		public function __construct($list_groups, $argum_og){

			$this->list_grupos = $list_groups;
			
			if($argum_og != null){
				$this->argument_og = explode(".", $argum_og);
				$pic_arti = md5($argum_og).".jpg";
				$ur_pic = ROOT."Views/template/images/pictures_grps/".$pic_arti;
			}
			else{
				$this->argument_og = $argum_og;   
				$ur_pic = null;
			}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title><?php if($this->argument_og != null):print str_replace("_", " ", $this->argument_og[0]);else:print "Lenodula"; endif;?></title>
        <meta content='<?php if($this->argument_og != null):print str_replace("_", " ", $this->argument_og[0]);else:print 'Lenodula'; endif; ?>' property='og:title'>
		<meta content='Crea una cuenta en Lenodula y accede al contenido: "<?php if($this->argument_og != null)print str_replace("_", " ", $this->argument_og[0]);?>" participa y sigue los cursos.' property='og:description'>
		<meta content='<?php if($this->argument_og != null || isset($_GET['url'])):print URL.$_GET['url'];else:print URL; endif; ?>' property='og:url'>
		<meta content='Lenodula' property='og:site_name'>
		<meta content='website' property='og:type'>
		<meta content='<?php if(is_readable($ur_pic)):print URL."Views/template/images/pictures_grps/".$pic_arti;else:print URL.'Views/template/images/logo.jpg'; endif; ?>' property='og:image'>
		<meta property="fb:app_id" content="544238222898183">
    	<meta content="Gestor de cursos Lenodula" name="description">
    	<meta charset="utf-8">
        <meta content="Gestor de contenidos, Aprendizaje en línea, foro de contenidos, grupos, aula virtual, blog, foros, elearning, Lenodula" name="keywords">
    	<meta content="Lenodula Elearning" name="author">
    	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    	<noscript>
  		<meta http-equiv="Refresh" content="0;URL=<?= URL; ?>none.php">
		</noscript>
		<link rel="shortcut icon" href="/Views/template/images/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/icons.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/style.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/last_blog.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/calendar.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/editor.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/foro.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/responsive.css" media="(min-width: 551px) and (max-width: 995px)">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/responsive_min.css" media="(max-width: 550px)">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/Views/template/js/script.js"></script>
	</head>
	<body>
		<header>
			<div id="showUser">
			<div class="logo">
				<i class="icon-logo logo_small"></i><small>Len<i class="icon-logo"></i>dula</small>
			</div>
			</div>
			<nav>
				<a href="/">
					<div class="navicon">
						<span><i class="material-icons">home</i>&nbsp;INICIO</span>
					</div>
				</a>
				<a href="/usuarios/ingresar">
					<div class="navicon">
						<span><i class="material-icons">perm_identity</i>&nbsp;INGRESAR</span>
					</div>
				</a>
				<div class="navicon" id="search_grl">
					<span><i class="material-icons">search</i>&nbsp;BUSCAR</span>
				</div>
				<div class="notificon_disabled">
				</div>
				<div class="notificon_disabled">
				</div>
				<div class="notificon_disabled">
				</div>
				<div class="menuicon" id="nav_bars_menu">
					<span><i class="material-icons">menu</i></span>
					<div id="div_bars_menu">
						<ul>
							<a href="/" class="hide_nav">
							<li>&nbsp;<i class="material-icons hide_nav">home</i> &nbsp;Inicio</li>
							</a>
							<a href="/usuarios/ingresar" class="hide_nav">
							<li>&nbsp;<i class="material-icons hide_nav">perm_identity</i> &nbsp;Inicia sesión</li>
							</a>
							<a href="/grupos">
							<li>&nbsp;<i class="material-icons">group_work</i> &nbsp;Grupos</li>
							</a>
							<a href="/usuarios">
							<li>&nbsp;<i class="material-icons">people</i> &nbsp;Usuarios</li>
							</a>
							<a href="/usuarios/ayuda">
							<li>&nbsp;<i class="material-icons">help</i> &nbsp;Leer ayuda</li>
							</a>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<div id="searcher_crs">
			<i class="material-icons cerrarBox">closed</i><br>
			<input class="inptxt outinptxt search_courses" type="text" name="search_grupos" value="" placeholder="Buscar cursos...">
			<a class="href_action" id="button_src_crs" href="">
				<button class="btn btnEdit"><i class="material-icons">search</i></button>
			</a>
		</div>
		<section>
			
<?php
		
		}

		public function __destruct(){
?>	
		</section>
		<aside>
			<div id="contentExpCursos">
				<div id="explorerCursos">
					<div id="explorerHeader">
						<i class="material-icons">account_tree</i>
					</div>
					<div id="explorerBody">
					<ul>
						<?php 
							if(!empty($this->list_grupos)):
								foreach($this->list_grupos as $r):
						?>
						<li id="<?= $r['idg']; ?>_gr" class="li_gr">
							<i class="material-icons">folder</i>
							<span class="sp_ng">&nbsp;<?= $r['nom']; ?></span>
							<ul class="ul_block cr"></ul>
						</li>
						<?php
								endforeach;
						?>
						<img src="/Views/template/images/loading.gif" class="load">
						<?php
							else:
						?>
						<li>
						<img src="/Views/template/images/empty.svg" class="img_empty">
						<span class="advice">No se han creado grupos!!</span>
						</li>
						<?php
							endif;
						 ?>
					</ul>
					</div>
				</div>
			</div>
			<div id='contentCalendar'>
				<a href="/agendas" class="href_action">
				<?php 
					new Calendar(null, null, null, 'side', null, null, null);
				 ?>
				</a>
			</div>
		</aside>
		<script type="text/javascript" src="/Views/template/js/foro.js"></script>
		<script type="text/javascript" src="/Views/template/js/dashboard.js"></script>
	</body>
</html>
<?php

		}

	}
	

 ?>