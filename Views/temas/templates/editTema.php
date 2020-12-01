<div id="some_activity">
	<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v6.0&appId=544238222898183&autoLogAppEvents=1"></script>
	<div class="fb-cont">
		<div class="fb-page" data-href="https://www.facebook.com/Lenodula/" data-tabs="" data-width="" data-height="240" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
			<blockquote cite="https://www.facebook.com/Lenodula/" class="fb-xfbml-parse-ignore">
				<a href="https://www.facebook.com/Lenodula/"></a>
			</blockquote>
		</div><br><br>
	</div><br>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
	<article id="main">
		<div id="indexHeader" class="divHeader">
			<i class="material-icons">edit</i>
			<h1>Editar tema</h1>
		</div><br>
		<div id="divEditTema">
			<h2>"<?= $titulo; ?>"</h2>
			<p>Última modificación:&nbsp;<?= $controlador->funcion('alfa_months',$fecha_p); ?></p>
			<form class="frm" method="post" action="" id="frmPubTema">
				<br><label class="frmlbl" for="titulo">Título del tema</label><br>
				<input type="text" class="inptxt" id="titulo" name="titulo" value="<?= $titulo; ?>"><br>
				<br><br><label class="frmlbl" for="tags">*Opcional, Palabras Clave (escribe palabras clave y presiona Enter)</label><br>
				<div id="insert_tags">
					<?php 
						$tags_caps = explode(",", $tags);
						foreach ($tags_caps as $captg):
							if($captg != ""):
					?>
						<span><?= $captg; ?><span class="del_tag"><b>x</b></span></span>
					<?php
							endif;	
						endforeach;
					 ?>
					<input type="text" id="tags" name="tags" value="" autocomplete="off">
				</div><br>
				<input type="hidden" id="tags_hidden" name="tags_hidden" value="<?= $tags; ?>">
				<br><label class="frmlbl" for="fecha_limite_respuesta">Fecha límite para admitir respuestas</label><br>
				<input type="date" class="inpdate" id="fecha_limite_respuesta" name="fecha_limite_respuesta" value="<?= $fecha_limite; ?>"><br>
				<br><label class="frmlbl" for="hora_limite_respuesta" id="hrlresp">Hora límite</label><br>
				<input type="time" class="inptime" id="hora_limite_respuesta" name="hora_limite_respuesta" value="<?= $hora_limite; ?>" disabled="disabled"><br>
				<br><label class="frmlbl" for="permiso_archivo">¿Puede subir archivos el usuario?</label><br><br>
				<div class="contSelect">
 		 		<select name="permiso_archivo" id="permiso_archivo">
 		 			<option>¿Permitir archivos?...</option>
 		 			<option <?php if($permiso_a == 1) print "selected"; ?>>Sí</option>
 		 			<option <?php if($permiso_a == 0) print "selected"; ?>>No</option>
 		 		</select>
 		 		</div><br>
 		 		<label class="frmlbl" for="titulo">*Opcional, MARCAR SI ES UN EXAMEN...</label><br>
 		 		<input type="checkbox" name="nivel_tema" value="1" id="nivel_tema" <?= $check; ?>><br><br>
 		 		<a class="underl href_action" href="/temas/ayuda/examen"><label class="frmlbl"><i class="material-icons">help</i>&nbsp;¿como crear un examen?...</label></a><br><br><br>
 		 		<a class="underl href_action" href="/temas/ver/<?= $argumento; ?>"><p>VER PUBLICACIÓN <i class="material-icons">visibility</i></p></a>
 		 		<?php
 		 			$p = explode(".", $argumento); 
 		 			$post_tema = array('id' => $p[1], 'ti' => $p[0], 'pt' => 'pt');
 					$post_tema = base64_encode(json_encode($post_tema));
 		 		 ?>
 		 		<input type="hidden" id="post_dats_tema" name="post_dats_tema" value="<?= $post_tema; ?>">
			</form>
			<?php 
				new Views\Editor('root', ($contenido), $lista_archivos, 'comentar', 'files_tut');
			 ?>
			 <div id="lstGames">
			 	<div id="headLstGm"><p class="advice"><i class="material-icons">category</i>&nbsp;Actividades</p><button class="btn btnRegular" id="notif_games">notificar nuevos</button></div>
			 	<div id="bodyLstGm">
			 		<div id="divLstGm">

			<?php 
					if(!empty($list_games)):
						foreach($list_games as $gm):
							if($gm['tip'] == 1):
								$ref = "/temas/wordfind/".$argumento."?wrf=".$gm['id'];
								$ico_g = "wordfind.svg";
								$del = "del_wrfnd";
							elseif($gm['tip'] == 2):
								$ref = "/temas/guessword/".$argumento."?gwr=".$gm['id'];
								$ico_g = "guessword.svg";
								$del = "del_guessw";
							elseif($gm['tip'] == 3):
								$ref = "/temas/timeline/".$argumento."?tml=".$gm['id'];
								$ico_g = "timeline.svg";
								$del = "del_timel";
							endif;
			?>			<div class="div_game">
							<div class="elm_game">
							<a href="<?= $ref; ?>" class="underl href_action inline">
								<img src="/Views/template/images/<?= $ico_g; ?>" alt="ico_game" width="20">
								<span>&nbsp;<?= $gm['nom']; ?></span>
							</a>
							</div>
							<div class="<?= $del; ?>">
								<i class="material-icons i_delete">delete</i>
							</div>
						</div>
			<?php
						endforeach;
					endif;
			 ?>
			 		</div>
			 	</div>
			</div>
		</div><br>
		<script type="text/javascript" src="/Views/template/js/base64ende.js"></script>
	</article>
</div>