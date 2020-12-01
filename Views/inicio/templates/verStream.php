<div id="main_activity">
			<div id="head_main_activity"><i class="material-icons">fiber_new</i></div>
			<span class="title_act"><i class="material-icons">extension</i>&nbsp;Cursos Recientes</span>
			<?php 
				if($actcur->num_rows > 0):
				  while($a = $actcur->fetch_array()):
			?>
			<a href="/grupos/ver/<?= $controlador->funcion('normalize', $a['nombre_grupo']).'.'.$a['id_grupo']; ?>#actionsGrupo" class='underl href_action'>
				<p>&nbsp;<?= $a['nombre_materia_curso']; ?></p>
			</a>
			<small>(<?= $a['nombre_grupo']; ?>)</small>
			<?php
				  endwhile;
				else:
			?>
			<br>&nbsp;<i class="material-icons dats_img">local_cafe</i>
			<?php		
				endif;
			 ?>
			 <hr color="F6F6F6"><br>
			 <span class="title_act"><i class="material-icons">supervised_user_circle</i>&nbsp;Usuarios Recientes</span>
			 <br>
			 <?php 
			 	if(!empty($actus)):
			 	  foreach($actus as $u):
			 ?>
			<br><a href="/usuarios/perfil/<?= $u['idu']; ?>" class="href_action hactusr">
				  	<div style="<?php if($u['ids'] == 'FB')print "background-image: url(https://graph.facebook.com/$u[idu]/picture?type=small)";?>" class="actusrs">	
					<?php 
						if($u['fot'] == 'none'):
					?>
							<i class="material-icons">person_outline</i>
					<?php 
						endif;
						if($u['fot'] != 'none' && $u['ids'] != 'FB'):
							
					?>
							<img src="/Views/template/images/pictures/<?= $u['fot'];?>" alt="<?= $u['nom']; ?>_imagen">
					<?php
						endif;
					?>
					</div>
				   <span><?= $u['nom']; ?></span>
			</a><br>
			 <?php
			 	  endforeach;
			 ?>
			 <br>
			 <?php
			 	else:
			 ?>
			 <br>&nbsp;<i class="material-icons dats_img">contacts</i>
			 <?php		
			 	endif;
			  ?>
			  <a href="/usuarios" class="href_action underl inline more">VER MÁS&nbsp;<i class="material-icons">launch</i></a>
			  <hr color="F6F6F6"><br>
			  <span class="title_act"><i class="material-icons">loyalty</i>&nbsp;Menciones Destacadas #</span><br><br>
			  <div id="div_hasht">
			  <?php 
			  	if($hashtags == ""):
			  	?>
			  	<i class="material-icons dats_img">emoji_food_beverage</i>
			  	<?php
			  	else:
			  		print $hashtags;
			  	endif;
			   ?>
			  </div>
</div>
<div id="centralSection">
	<article id="main">
		<div class="divHeader" id="indexHeader">
			<i class="material-icons">home_work</i>
			<h1>Inicio</h1>
		</div>
		<div id="feed">
			
		<?php
			if($callback_datos->num_rows > 0):
				$icmsg = "";
	 
			  while($d = $callback_datos->fetch_array()):
		?>	
			<div class="new_notice" style="--color_notice: <?= $d['color_theme'];  ?>;">
				<?php
						if($d['stream_tipo'] == 'GR'):
							$has = "";
							$txt = "Creó el grupo: <b>".$d['nombre_grupo']."</b>, entra, participa y aporta.";
							$icmsg = "group_work";
						endif;
						if($d['stream_tipo'] == 'GE'):
							$has = "";
							$txt = "Editó la información general del grupo: <b>".$d['nombre_grupo']."</b>";
							$icmsg = "build";
						endif; 
						if($d['stream_tipo'] == 'CU'):
							$has = "actionsGrupo";
							$txt = "Creó un nuevo curso en el grupo: <b>".$d['nombre_grupo']."</b>";
							$icmsg = "book";
						endif;
						if($d['stream_tipo'] == 'CO'):
							$has ="warp_foro";
							$txt = "Inició una conversación con un comentario en un grupo";
							$icmsg = "textsms";
						endif;
						if($d['stream_tipo'] == 'EN'):
							$has ="warp_foro";
							$txt = "Publicó una encuesta en un grupo";
							$icmsg = "contact_support";
						endif;
						if($d['stream_tipo'] == 'ME'):
							$has = "";
							$txt = "Se unió recientemente al grupo: <b>".$d['nombre_grupo']."</b> unete también";
							$icmsg = "directions_walk";
						endif;

						$srv = array('id' => $d['id_comentario'], 'idg' => $d['id_grupo'], 'pref' => 'pf');
						$srv = base64_encode(json_encode($srv));
						$srv = str_replace("=", "-", $srv);
					 ?>
				<div class="user_notice">
					<a href="/usuarios/perfil/<?= $d['id_usuario']; ?>" class="href_action">
						<div class="pict_notice" style="<?php if($d['foto'] == 'na')print "background-image: url(https://graph.facebook.com/$d[id_usuario]/picture?type=large)";?>">		
						<?php 
							if($d['foto'] == 'none'):
						?>
							<img src="/Views/template/images/account_circle.svg" alt="<?= $d['nombre_user']; ?>_default">
						<?php 
							endif;
							if($d['foto'] != 'none' && $d['foto'] != 'na'):
						?>
							<img src="/Views/template/images/pictures/<?= $d['foto'];?>" alt="<?= $d['nombre_user']; ?>_imagen">
						<?php
							endif;
						?>
						<i class="material-icons <?= $icmsg; ?>" style="<?php if($icmsg == 'textsms' || $icmsg == 'contact_support'):print '--color_ic: #FF7777;';else:print '--color_ic: rgba(16,173,195,0.6);'; endif;?>"><?= $icmsg; ?></i>
						</div>
					</a>
				</div>
				<div class="body_notice">
					<span><?= $d['nombre_user'];  ?></span>
						<hr size="5">
						<p>
							<?= $txt; ?>&nbsp;&nbsp;<i class="material-icons idic_grp" style="--borde_cir:<?= $d['color_theme']; ?>"><?= $d['theme'];  ?></i><br>
							<small><i class="material-icons">watch_later</i>&nbsp;<?= $controlador->funcion('alfa_months', $d['fecha_stream']); ?></small><br><br>

						    <?php 
						    	if($d['stream_tipo'] == 'CO' || $d['stream_tipo'] == 'EN'):
						    ?>
						 </p>
						    <blockquote>
						    	<?php
						    		if($d['comentario'] == ''):
						    	?>
						    	el usuario eliminó el comentario <i class="material-icons">delete_forever</i><br>
						    	<?php
						    		else:
						    	 ?>
						    	<?= $d['comentario']; ?><br>
						    	<?php 
						    		endif;
						    	 ?>
						    	<span id="/grupos/ver/<?= $controlador->funcion("normalize", $d['nombre_grupo']).".".$d['id_grupo']."?c"."=".$d['id_comentario']."#post-".$d['id_comentario']; ?>" class="shar_comm"><i class="material-icons">reply</i>COPIAR</span>
						    </blockquote>
						    <?php		
						    	endif;
						     ?><br>
									<?php 
										if($d['stream_tipo'] == 'CO' || $d['stream_tipo'] == 'EN'):
									?>
							<div class="srvpost" id="srv_<?= $srv; ?>"></div>
							<a href="/grupos/ver/<?= $controlador->funcion("normalize", $d['nombre_grupo']).".".$d['id_grupo']."?c"."=".$d['id_comentario']."#post-".$d['id_comentario']; ?>" class="href_action">
								<button class="btn btnRegular">

									<?php
											print 'Responder';	
										else:
									?>

							<a href="/grupos/ver/<?= $controlador->funcion("normalize", $d['nombre_grupo']).".".$d['id_grupo']."#".$has; ?>" class="href_action">
								<button class="btn btnRegular">
									<?php
											print 'Seguir enlace';
										endif;
									 ?>
									&nbsp;
									<i class="material-icons ico_btn_shd">launch</i>
								</button>
							</a>
				</div>
			</div>
		<?php
				$icmsg = "";
			  endwhile;
			else:
		?>
			<br><br><i class="material-icons img_empty">eco</i>
			<p class="advice">
				Sin más novedad aún!!
			</p>
		<?php		
			endif;
		 ?>
		 <br>
		</div>
		<div class="linksPaginacion">
			<?php
			  if($callback_datos->num_rows > 0):
				if($metodo == 'pagina' || $metodo == 'index'):
					$pages = $controlador->paginar_news();
					if(!$argumento):
						$pg = 1;
					else:
						$pg = $argumento;
					endif;
			?>
			<a class="paginacion <?php if($pg == 1)print 'sel'; ?> href_action" href="/inicio/pagina/1#feed">1</a>
			<?php

					for($i = $pg; $i <= $pg + 8; $i++):
						if($i != 1 && $i <= $pages):
			?>
			<a class="paginacion <?php if($argumento == $i)print 'sel'; ?> href_action" href="/inicio/pagina/<?= $i; ?>#feed"><?= $i; ?></a>

			<?php
						endif;
					endfor;
					if($i <= $pages):
			?>

			<a href='/inicio/pagina/<?= $i; ?>#feed' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
			<?php	
					endif;
				endif;
			  endif;	
			?>
		</div><br><br>
	</article>
</div>
<script type="text/javascript" src="/Views/template/js/base64ende.js"></script>	