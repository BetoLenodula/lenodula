<div id="some_activity">
	<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<iframe width="90%" height="200" style="margin-left:5%; border-radius:8px;" src="https://www.youtube.com/embed/NjJq8-u9mmo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><br>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
	<article id="main">
		<div id="indexHeader" class="divHeader">
			<i class="material-icons">chrome_reader_mode</i>
			<h1><?= $titulo; ?></h1>
		</div><br>
		<div id="body_article">
			 <div id="header_body_article">
			 	<?php
			 		if($foto == 'none'):
			 			$ur = "/Views/template/images/account_circle.svg";
			 		else:
			 			$ur = "/Views/template/images/pictures/".$foto;		
			 		endif;
			 	 ?>
			 	 <div style="background-image:url(<?= $ur; ?>);"></div>
			 	<span>&nbsp;<?= print $name; ?></span>
			 <?php 
				if($id_usuario == $_SESSION['userSesion']['id']):
			 ?>
			<a href="/temas/editar/<?= $controlador->funcion('normalize', $titulo).'.'.$dats['id'];  ?>" class="href_action"><i id='edt_tems' class="material-icons">edit</i></a>
			<?php 
				else:
			?>
			<span id="love_tem"><b><?= $likes; ?></b>&nbsp;<i class="material-icons">favorite</i></span>
			<?php		
				endif;
			 ?>
			</div>
			<?php 
				if($contenido != '&lt;br&gt;'):
			?>
				<div id="theme_article_section">
			<?php
					print html_entity_decode($contenido);
			?>
				</div>
				<?php 
					if(!empty($list_games)):
				 ?>
		<br><br><div id="lstGamesT">
					<div id="headLstGm"><p class="advice"><i class="material-icons">category</i>&nbsp;Actividades</p></div>
					<div id="bodyLstGm">
						<div id="divLstGm">
				<?php 
					  foreach($list_games as $gm):
						if($gm['tip'] == 1):
							$ref = "/temas/wordfind/".$argumento."?wrf=".$gm['id'];
							$ico_g = "wordfind.svg";
						elseif($gm['tip'] == 2):
							$ref = "/temas/guessword/".$argumento."?gwr=".$gm['id'];
							$ico_g = "guessword.svg";
						elseif($gm['tip'] == 3):
							$ref = "/temas/timeline/".$argumento."?tml=".$gm['id'];
							$ico_g = "timeline.svg";
						endif;
				?>
						<div class="div_game">
							<div class="elm_game">
								<a href="<?= $ref; ?>" class="href_action inline">
									<img src="/Views/template/images/<?= $ico_g; ?>" alt="ico_game" width="20" class="imggame">
									<span>&nbsp;<?= $gm['nom']; ?></span>	
								</a><br>
							</div>
						</div>
				<?php
					  endforeach;
				 ?>
				 	    </div>	
				 	</div>
				</div>
				<?php 
					endif;

					if($nivel == 1):

 						$pos_res = array('idu' => $_SESSION['userSesion']['id'], 'idt' => $dats['id'], 'ti' => $controlador->funcion('normalize', $titulo));
 						$pos_res = base64_encode(json_encode($pos_res));
				 ?>
				<br><br><button class=" btn btnPublish send_exam" id="<?= $pos_res; ?>"><i class="material-icons ico">send</i>&nbsp;TERMINAR Y ENVIAR</button><br><br><hr color="F8F8F8">
				<?php
				?>
				<script type="text/javascript" src="/Views/template/js/editor.js"></script>
				<?php
					endif;
				?>
			<br><hr color='F8F8F8'><span class="timestamp"><i class="material-icons">watch_later</i>&nbsp;Última Modificación: <?= $controlador->funcion('alfa_months', $fecha_p); ?></span>
			<?php 
					if($view_tema == 0 && $contenido != '&lt;br&gt;'):
			?>
			<br><br>&nbsp;<button class="btn btnRegular read_tema" id="<?= $dat_tema; ?>"><i class="material-icons ico ico_btn">done_all</i>&nbsp;<span>Marcar como leído</span></button>
			<?php	
					else:
			?>
			<br><br>&nbsp;<button class="btn btnRegular"><i class="material-icons ico ico_btn">check_circle</i>&nbsp;<span>Leído</span></button>
			<?php			
					endif;
			?>
			<button class="btn btnEdit" id="new_event_tema"><i class="material-icons ico ico_btn">event</i>&nbsp;<span>Agendar</span></button>
			<?php
				else:
			?>
			<i class="material-icons img_empty">web</i>
			<?php
				endif;
			 ?>
		</div>
		<hr color="F8F8F8">

		<?php 
			if($nivel == 0 && $contenido != '&lt;br&gt;'):
				new Views\Foro_topic($dats['id'], $permiso_a, $controlador->funcion('normalize', $titulo), $lista_archivos, $page, $id_usuario, $fecha_limite, $hora_limite);
			endif;

			$nomev = $titulo." (Tema)";
			$frmEv = true;
			include_once(ROOT."Views/agendas/templates/frmEvent.php");	
		 ?>
		 <script type="text/javascript" src="/Views/template/js/base64ende.js"></script>
	</article>
</div>