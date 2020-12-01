<?php 
	namespace Views;

	class Template_sesion{
		private $ids;
		private $idu;
		private $name;
		private $foto;
		private $rol;
		private $notif_grupos;
		private $notif_foros;
		private $notif_globales;
		private $notif_agenda;
		private $list_grupos;
		private $argument_og;

		private $ntot;

		public function __construct($notify_gr, $notify_fo, $notify_gl, $notif_agenda, $list_groups, $argum_og){
		
		$this->ids     = $_SESSION['userSesion']['id_session'];
		$this->idu     = $_SESSION['userSesion']['id'];
		$this->name    = $_SESSION['userSesion']['nombre_user'];
		$this->foto    = $_SESSION['userSesion']['foto'];
		$this->rol     = $_SESSION['userSesion']['rol'];

		$this->notif_grupos   = $notify_gr;
		$this->notif_foros    = $notify_fo;
		$this->notif_globales = $notify_gl;
		$this->notif_agenda   = $notif_agenda;
		$this->list_grupos    = $list_groups;
		$this->ntot = $notify_gr + $notify_fo + $notify_gl;
		if($argum_og != null){
			$pic_arti = md5($argum_og).".jpg";
			$this->argument_og = explode(".", $argum_og);
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
		<title><?php print "(".$this->ntot.") "; if($this->argument_og != null):print str_replace("_", " ", $this->argument_og[0]);else:print "Lenodula"; endif;?></title>
        <meta content='<?php if($this->argument_og != null):print str_replace("_", " ", $this->argument_og[0]);else:print 'Lenodula'; endif; ?>' property='og:title'>
		<meta content='Crea una cuenta en Lenodula y accede al contenido: "<?php if($this->argument_og != null)print str_replace("_", " ", $this->argument_og[0]);?>" participa y sigue los cursos.' property='og:description'>
		<meta content='<?php if($this->argument_og != null || isset($_GET['url'])):print URL.$_GET['url'];else:print URL; endif; ?>' property='og:url'>
		<meta content='Lenodula' property='og:site_name'>
		<meta content='website' property='og:type'>
		<meta content='<?php if(is_readable($ur_pic)):print URL."Views/template/images/pictures_grps/".$pic_arti;else:print URL.'Views/template/images/logo.jpg'; endif; ?>' property='og:image'>
		<meta property="fb:app_id" content="544238222898183">
		<meta content='Gestor de cursos Lenodula' name='description'>
    	<meta charset="utf-8">
        <meta content='Gestor de contenidos, Aprendizaje en línea, foro de contenidos, grupos, aula virtual, blog, foros, elearning, Lenodula' name='keywords'>
        <meta content="Lenodula Elearning" name="author">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <noscript>
  		<meta http-equiv="Refresh" content="0;URL=<?= URL; ?>none.php">
		</noscript>
		<link rel='shortcut icon' href='/Views/template/images/favicon.ico' type="image/x-icon">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/icons.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/style.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/last_blog.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/calendar.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/editor.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/foro.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/mensajes.css">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/responsive.css" media="(min-width: 551px) and (max-width: 995px)">
		<link rel="stylesheet" type="text/css" href="/Views/template/css/responsive_min.css" media="(max-width: 550px)">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="https://js.pusher.com/3.2/pusher.min.js"></script>
		<script type="text/javascript" src="/Views/template/js/script.js"></script>
	</head>
	<body>
		<header>
			<div id="showUser" class="<?= $this->idu; ?>">
				<div id="userAvatar" style="<?php if($this->ids == 'FB')print "background-image: url($this->foto);";?>">
				<?php 
					if($this->foto == 'none'):
				?>
					<i class="material-icons">account_circle</i>
				<?php
					endif;
					if($this->foto != 'none' && $this->ids != 'FB'):
				?>	
					<img src="/Views/template/images/pictures/<?= $this->foto; ?>" alt="<?= $this->name; ?>_sesion">		
				<?php
					endif;
				 ?>
				</div>
				<span>
				<?php 
					if(strlen($this->name) > 11):
						print substr($this->name, 0, 9)."..";
					else:
						print $this->name;	
					endif;
				?>		
				</span>
			</div>
			<nav id="navigation_bar">
				<a href="/">
					<div class="navicon">
						<span><i class="material-icons">home</i>&nbsp;INICIO</span>
					</div>
				</a>
				<a href="/usuarios/perfil/my">
					<div class="navicon">
						<span><i class="material-icons">perm_identity</i>&nbsp;MI PERFIL</span>
					</div>
				</a>
				<div class="navicon" id="search_grl">
					<span><i class="material-icons">search</i>&nbsp;BUSCAR</span>
				</div>
				<div class="notificon" id="nav_notify_grupos">
					<?php  
						if($this->notif_grupos > 0):
					?>
					<div class="notific" id="notific_groups">
						<span><?php if($this->notif_grupos > 9):print "9+";else:print $this->notif_grupos; endif; ?></span>
					</div>
					<?php
						endif;
					?>
					<span><i class="material-icons ico">group_work</i></span>
					<img class="shift" src="/Views/template/images/shift.png">
					<div class="div_notify" id="div_notify_grupos">
						<div class="head_content_notify">
							<span><i class="material-icons ico">group_work</i>&nbsp;De grupos</span>
						</div>
						<div class="content_notify"><div class="div_content_notify"></div></div>
						<div class="foot_notify">
						</div>
					</div>
				</div>
				<div class="notificon" id="nav_notify_foros">
					<?php  
						if($this->notif_foros > 0):
					?>
					<div class="notific" id="notific_forums">
						<span><?php if($this->notif_foros > 9):print "9+";else:print $this->notif_foros; endif; ?></span>
					</div>
					<?php
						endif;
					?>
					<span><i class="material-icons ico">forum</i></span>
					<img class="shift" src="/Views/template/images/shift.png">
					<div class="div_notify" id="div_notify_foros">
						<div class="head_content_notify">
							<span><i class="material-icons ico">forum</i>&nbsp;De comentarios</span>
						</div>
						<div class="content_notify"><div class="div_content_notify"></div></div>
						<div class="foot_notify">
						</div>
					</div>
				</div>
				<div class="notificon" id="nav_notify_globales">
					<?php  
						if($this->notif_globales > 0):
					?>
					<div class="notific" id="notific_globals">
						<span><?php if($this->notif_globales > 9):print "9+";else:print $this->notif_globales; endif; ?></span>
					</div>
					<?php
						endif;
					?>
					<span><i class="material-icons ico">notifications</i></span>
					<img class="shift" src="/Views/template/images/shift.png">
					<div class="div_notify" id="div_notify_globales">
						<div class="head_content_notify">
							<span><i class="material-icons ico">notifications</i>&nbsp;Globales</span>
						</div>
						<div class="content_notify"><div class="div_content_notify"></div></div>
						<div class="foot_notify">
						</div>
					</div>
				</div>
				<div class="menuicon" id="nav_bars_menu">
					<span><i class="material-icons">menu</i></span>
					<div id="div_bars_menu">
						<ul>
							<a href="/" class="hide_nav">
								<li>&nbsp;<i class="material-icons">home</i>&nbsp; Inicio</li>
							</a>
							<a href="/usuarios/perfil/my" class="hide_nav">
								<li>&nbsp;<i class="material-icons">perm_identity</i>&nbsp; Mi perfil</li>
							</a>
							<a href="/grupos">
								<li>&nbsp;<i class="material-icons">group_work</i>&nbsp; Grupos</li>
							</a>
							<a href="/usuarios">
								<li>&nbsp;<i class="material-icons">people</i>&nbsp; Usuarios</li>
							</a>
							<a href="/mensajes/ver">
								<li>&nbsp;<i class="material-icons">mail</i>&nbsp; Mensajes</li>
							</a>
							<a href="/respuestas/my">
								<li>&nbsp;<i class="material-icons">speaker_notes</i>&nbsp; Todas mis respuestas</li>
							</a>
							<?php 
								if($this->rol == 'Tutor'):
							?>
							<a href="/respuestas/reportadas">
								<li>&nbsp;<i class="material-icons" style="color: #FF9999;">flag</i>&nbsp; Revisar reportes</li>
							</a>
							<?php
								endif;
							 ?>
							<a href="/usuarios/ayuda">
								<li>&nbsp;<i class="material-icons">help</i> &nbsp;Leer ayuda</li>
							</a>
							<a href="/usuarios/cerrar_sesion">
								<li>&nbsp;<i class="material-icons">lock</i>&nbsp; Cerrar sesión</li>
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
						<span>No se han creado grupos!!</span>
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
					new Calendar(null, null, null, 'side', $this->notif_agenda, null, null);
			     ?>
			 	</a>
			</div>
		</aside>
		<a href="/agendas" class="href_action">
			<div class="float_btn_top">
				<?php 
					if($this->notif_agenda && $this->notif_agenda == 1):
				?>
				<i class="material-icons nd" title="Eventos próximos">notifications_active</i>
				<?php
					endif;
			 	?>
				<i class="material-icons fle">event</i>
			</div>
		</a>
		<script type="text/javascript" src="/Views/template/js/notifics.js"></script>
		<script type="text/javascript" src="/Views/template/js/foro.js"></script>
		<script type="text/javascript" src="/Views/template/js/dashboard.js"></script>
		<div id="flt_msg"><a href="/mensajes/ver" class="href_action"><i class="material-icons">drafts</i></a></div>
		<script type="text/javascript" src="/Views/template/js/pusher.js"></script>
	</body>
</html>
<?php

		}

	}
	

 ?>