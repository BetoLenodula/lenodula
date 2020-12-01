<div id="some_activity">
	<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<div id="blg_lenodula">
		<div id="head_blg_lnd"></div>
		<div id="body_blg_lnd"></div>
	</div><br>
	<script crossorigin="anonymous" src="/Views/template/js/blog_lnd_api.js"></script>
	<script>
		last_blog();
	</script>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
	<article id="main">
		<div id="indexHeader" class="divHeader">
			<i class="material-icons">speaker_notes</i>
			<h1>Respuestas</h1>
		</div><br>
		<?php 
			if($metodo != 'ver' && $metodo != 'reportadas' && !isset($_GET['exams'])):
		 ?>
		<div id="searching_dats">
			<input class="inptxt outinptxt search_input" type="text" name="search_user" value="" placeholder="Buscar respuestas...">
			<a class="href_action" id="button_search" href=""><button class="btn btnEdit"><i class="material-icons">search</i></button></a>
		</div><br>
			<a href="/respuestas/my?exams=true" class="underl href_action inline">
				<p align="center">
					<i class="material-icons">fact_check</i>
					&nbsp;ver solo mis examenes...
				</p>
			</a><br>
			<?php 
				if($rol == 'Tutor'):
			 ?>
			<a href="/respuestas/buscar/examen" class="underl href_action inline">
				<p align="center">
					<i class="material-icons">fact_check</i>
					&nbsp;ver todos los examenes...			
				</p>
			</a><br>
		<?php 
				endif;
			endif;
			if($metodo == 'ver' || $metodo == 'buscar' || isset($_GET['exams'])):
		 ?>
		<a href="/respuestas/my" class="inline underl href_action"><p align="center"><i class="material-icons">speaker_notes</i>&nbsp;ver todas mis respuestas...</p></a>
		<?php
			endif;
			if($metodo == 'my' || $metodo == 'pagina' && $metodo != 'ver'):
		?>
		<span class="advice">&nbsp;&nbsp;<i class="material-icons">face</i> yo:</span>
		<?php 
			elseif($metodo != 'my' && $metodo != 'ver'):
		?>
		<span class="advice">&nbsp;&nbsp;<i class="material-icons">person_search</i></span>
		<?php
			endif;
		 ?>
		<div class="contentResps" id="foro">
		<?php 
			if($metodo == 'reportadas'):
		?>
			<div align="center"><span class="advice" style="color:#FF9999;"><i class="material-icons">flag</i>&nbsp;&nbsp;RESPUESTAS REPORTADAS</span></div><br>
		<?php
			endif;

		if($callback_datos->num_rows > 0):
		  while($r = $callback_datos->fetch_array()):

			$tem = $t->funcion('normalize', $t->get_titulo($r['id_tema']));
			$admin = $t->get_id_usuario($r['id_tema']);
			
				
			$id = array('id' => $r['id'], 'idt' => $r['id_tema'], 'pref' => 'pf');
			$id = base64_encode(json_encode($id));
			$id = str_replace("=", "-", $id);
		 ?> 
		<div>
			<br><hr color='F8F8F8'>
			<a href="/temas/ver/<?= $tem.'.'.$r['id_tema']; ?>" class="underl inline href_action">
				&nbsp;<i class="material-icons">launch</i>&nbsp;
				<span>IR AL TEMA</span>
			</a><br><br>
		<div class="content_comment" id="pf_<?= $id; ?>">
			<div class="head_comment">
				<div class="pictComment" style="<?php if($r['ids'] == 'FB')print "background-image: url(https://graph.facebook.com/$r[id_usuario]/picture?type=small);";?>">
				<?php 
					if($r['foto'] == 'none'):
				?>
					<i class="material-icons account-ico">account_circle</i>
				<?php 
					endif;
					if($r['foto'] != 'none' && $r['ids'] != 'FB'):
				?>
					<img src="/Views/template/images/pictures/<?= $r['foto'];?>" alt="<?= $r['nombre_user']; ?>_usuario">
				<?php
					endif;
				?>
				</div>
				<a href="/usuarios/perfil/<?= $r['id_usuario'] ?>"><span><?= $r['nombre_user']; ?></span></a>
				<?php
					if($idu ==  $r['id_usuario']):
				?>
				<span class="del_respuesta"><i class="material-icons">delete</i></span>
				<?php
					elseif($idu == $admin):
				?>
				<div class="qualify">
				<input type="range" name="calif" value="<?= $r['calificacion']; ?>" min="0" max="10" class="range">
				<button class="btn btnPublish qualified"><small><?= $r['calificacion']; ?></small>&nbsp;pt.&nbsp;<i class="material-icons ico ico_btn">send</i></button>
				</div>
				<?php		
					endif;
				?>
			</div>
			<article>
				<h1 align="center"><?= '"'.$r['titulo_respuesta'].'"'; ?></h1>
				<div>
				<?php 
					if($r['nivel_tema'] == 1):
						if($idu == $r['id_usuario'] || $idu == $admin):
							print html_entity_decode($r['respuesta']); 
						else:
					?>
					<div class="priv_resp"><i class="material-icons">visibility_off</i><br>Esta respuesta no es visible para tí, ya que es un examen de otro usuario.</div>
					<?php
						endif;
					else:
						print html_entity_decode($r['respuesta']); 
					endif;
				?>
				</div><br><br>
				<span>
					<i class="material-icons">watch_later</i>&nbsp;<?= $r['timestamp_respuesta']; ?><br>
					<i class="material-icons" style="color:#10ADC3;">assignment</i>&nbsp;<span style="color:#10ADC3;">CALIFICACIÓN:&nbsp;<?= $r['calificacion']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php 
						if($metodo == "reportadas"):
					?>
					<i class="material-icons" style="color:#FF4444;">flag</i>&nbsp;<span style="color:#FF4444;">REPORTES:&nbsp;<?= $r['total_reportes']; ?></span>
					<?php
						endif;
					 ?>
				</span>
			</article>
			<div class="foot_comment">
				<div class="foot_comment_votes">
					<div class="grateful"><i class="material-icons">favorite_border</i>&nbsp;<span><?= $r['gratificaciones']; ?></span></div>
					<div class="reply"><i class="material-icons">comment</i>&nbsp;<span class="hide_span">RESPONDE</span></div>
				</div>
				<div class="foot_comment_actions">
					<div class="view_replies_reply"><span><b>Ver&nbsp;<span class="num_replies"><?= $r['numero_respuestas']; ?></span>&nbsp;Resp.</b></span></div>
					<?php 
						if($idu == $admin && $r['id_usuario'] != $admin):
					?>
					<div class="del_respuesta"><i class="material-icons">delete</i>&nbsp;<span class="hide_span">Eliminar</span></div>
					<?php
						else:
					?>
					<div class="report"><i class="material-icons <?php if($idu != $r['id_usuario']) print'reprt'; ?>">flag</i>&nbsp;<span class="hide_span">Reportar</span></div>
					<?php
						endif;
					 ?>
				</div>
			</div>
			<?php
				if($idu):
					$post_reply_reply = array('id' => $r['id'], 'idu' => $idu);
					$post_reply_reply = base64_encode(json_encode($post_reply_reply));
			?>
			<div class="reply_comment">
				<div class="pict_reply" style="<?php if($ids == 'FB')print "background-image: url(https://graph.facebook.com/$idu/picture?type=small);";?>">
					<?php 
					if($foto == 'none'):
					?>
					<i class="material-icons account-ico">account_circle</i>
					<?php 
					endif;
					if($foto != 'none' && $ids != 'FB'):
					?>
					<img src="/Views/template/images/pictures/<?= $foto;?>" alt="<?= $name; ?>_usuario">
					<?php
					endif;
					?>
				
				</div>
				<div class="divfrm_reply">
					<form method="post" action="" id="frmRespuestaRespuestaForo">
						<textarea class="inptxt" id="respuesta_respuesta" name="respuesta_respuesta" placeholder="Respuesta..." required></textarea>
						<input type="hidden" id="post_reply_reply" name="post_reply_reply" value="<?= $post_reply_reply; ?>">
					</form>
				</div>
				<div class="div_buttons_reply">
					<div class="send_reply_reply"><span><i class="material-icons">send</i></span></div>
					<div class="cancel_reply cerrar_reply"><span><i class="material-icons">close</i></span></div>
				</div>
			</div>
			<?php
				endif;
			?>
			<div class="content_replies"></div>
		</div><br>
		</div>		
		<?php 
		  endwhile;	
		?>
			<script>
				$('.question').each(function(i){
					cont = 0;
					$(this).find('input, select, textarea').each(function(){
						val = $(this).val();
						check = $(this).attr('checked');
						opt = $(this).find('option[selected=selected]').val();
						optcl = $(this).find('option[selected=selected]').attr('class');

						if((val == '.1' && check == 'checked') || (opt == '.1' && optcl == '1')){
							cont++;
						}
					})
					if(cont > 0){
						$(this).css({'border':'1px solid #FFBBBB', 'box-shadow': 'inset 3px 0 0 #FFBBBB', 'background-color': '#FFFDFD'});
					}
				})
			</script>
		<?php
		else:
		?>
		<i class="material-icons img_empty">chat_bubble_outline</i>
		<p class="advice">No tienes respuestas ni aportes recientes!!</p>
		<?php	
		endif;	
		 ?>
		</div>
		 <div class="linksPaginacion">
			<?php
				$pages = 0;
				$get = "";
			  if($callback_datos->num_rows > 0):
				if($metodo == 'pagina' || $metodo == 'my'):
					if(isset($_GET['exams']) && $_GET['exams'] == 'true'):
						$get = "?exams=true";
						$pages = $controlador->paginar_my('true');
					else:
						$pages = $controlador->paginar_my();
					endif;

					if(!$argumento):
						$pg = 1;
					else:
						$pg = $argumento;
					endif;
			?>
			<a class="paginacion <?php if($pg == 1)print 'sel'; ?> href_action" href="/respuestas/pagina/1<?= $get; ?>">1</a>
			<?php

					for($i = $pg; $i <= $pg + 8; $i++):
						if($i != 1 && $i <= $pages):
			?>
			<a class="paginacion <?php if($argumento == $i)print 'sel'; ?> href_action" href="/respuestas/pagina/<?= $i.$get; ?>"><?= $i; ?></a>

			<?php
						endif;
					endfor;
					if($i <= $pages):
			?>
			<a href='/respuestas/pagina/<?= $i.$get; ?>' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
			<?php			
					endif;
				endif;
				if($metodo == 'reportadas'):
					$pages = $controlador->paginar_rep();

					if(!isset($_GET['page'])):
						$pg = 1;
					else:
						$pg = $_GET['page'];
					endif;
			?>
			<a class="paginacion <?php if($pg == 1)print 'sel'; ?> href_action" href="/respuestas/reportadas?page=1">1</a>
			<?php

					for($i = $pg; $i <= $pg + 8; $i++):
						if($i != 1 && $i <= $pages):
			?>
			<a class="paginacion <?php if($argumento == $i)print 'sel'; ?> href_action" href="/respuestas/reportadas?page=<?= $i; ?>"><?= $i; ?></a>

			<?php
						endif;
					endfor;
					if($i <= $pages):
			?>
			<a href='/respuestas/reportadas?page=<?= $i; ?>' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
			<?php			
					endif;
				endif;
			  endif;	
			?>
		</div><br>
		<script type="text/javascript" src="/Views/template/js/base64ende.js"></script>
	</article>
</div>