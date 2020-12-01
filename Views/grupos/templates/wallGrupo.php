<div id="some_activity">
		<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<iframe width="90%" height="200" style="margin-left:5%; border-radius:8px;" src="https://www.youtube.com/embed/RqUACwx8Tr0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><br>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
 <div id="centralSection">
	<article id="main">
 		<div id="headGroup" style="background-color: <?= $color_theme; ?>;">
 			<?php 
 				if($foto == 'none'):
 			 ?>
 			<i class="material-icons" id="icon_group"><?= $theme; ?></i>
 			<?php 
 				else:
 			 ?>
 			<div class="square_div">
 				<div class="cont_square"><img src="/Views/template/images/pictures_grps/<?= $foto; ?>"></div>
 			</div>
 			<?php 
 				endif;
 			 ?>
 			<p id="head_name_group">
 				<?= $nombre_grupo; ?>
 			</p>
 			<i class="material-icons" id="min_icon_group">dashboard</i>
 		<?php
 			if( isset($_SESSION['userSesion']) && $id_usuario == $idu):
 				include_once(MSG."frmPicture.php");
 		?>
 		<a class="href_action" href="/grupos/editar/<?= $controlador->funcion("normalize", $nombre_grupo); ?>.<?= $idg; ?>"><i class="material-icons" id="edt_grp">edit</i></a>
 		<i class="material-icons open_file_box">photo_camera</i>
 		<?php
 			endif;
 		?>
 			<div id="bk1"></div>
 			<div id="bk2"></div>
 			<div id="bk3"></div>
 			<div id="bk4"></div>
 		</div>
 		<div id="descriptionGroup">
 			<i class="material-icons" style="color: <?= $color_theme; ?>; --borde_icth:<?= $color_theme; ?>"><?= $theme; ?></i>&nbsp;
 			<?= $descripcion;?>
 		 <div class="triangulo arrow"></div>
 		</div> 
 		<div id="actionsGrupo">
 			<?php 
 				if(isset($_SESSION['userSesion'])):
 					if($id_usuario != $idu):
 						if($member == 0):
 			?>
 			<a class="href_action" href="/grupos/unirse/<?= $controlador->funcion("normalize", $nombre_grupo); ?>.<?= $idg; ?>">
 			<button class="btn btnEdit"><i class="material-icons ico">exposure_plus_1</i> unirse</button>
 			</a>
 			<?php
 						else:
 			?>

 			<a class="href_action" href="/grupos/abandonar/<?= $controlador->funcion("normalize", $nombre_grupo); ?>.<?= $idg; ?>">
 			<button class="btn btnEdit"><i class="material-icons ico">exposure_neg_1</i> abandonar grupo
 				<?php     if($access == 0):
 				?>
 					<div class="access_pers non_access"><i class="material-icons">sentiment_satisfied</i></div>
 				<?php
 					      else:
 				?>
 					<div class="access_pers aff_access"><i class="material-icons">sentiment_very_satisfied</i></div>
 				<?php	  	
 					      endif;
 				?>
 			</button>
 			</a>
 			<?php
 						endif;
 					else:

 				$post_cur = array('id' => $id_usuario, 'ng' => $controlador->funcion('normalize', $nombre_grupo), 'idg' => $idg);
 				$post_cur = base64_encode(json_encode($post_cur));
 			?>
 			<button class="btn btnEdit" id="nvo_curso" onclick="show_frmcurso();"><i class="material-icons ico">playlist_add</i> crear un curso</button>
 			<div id="divfrm_curso">
 				<?php include_once(ROOT."Views/cursos/templates/frmNuevoCurso.php"); ?>
 			</div>
 			<?php
 					endif;
 			?>
 			 &nbsp;&nbsp;&nbsp;<a href="#warp_foro" class="underl inline"><i class="material-icons">add_comment</i>&nbsp;<span>comentar...</span></a>
 			<?php
 				endif;
 			 ?>

 			<a id="fbshare" target="_blank" href="http://www.facebook.com/sharer.php?u=<?= urlencode(URL.$_GET['url']);  ?>"><button class="btn btnPublish">compartir&nbsp;<img src="/Views/template/images/fbwhite.png" width="12"></button></a> 
 		</div>
 		
 		<div class="manager_group">
 			<span id="acces_i"><i class="material-icons"><?php if($tipo_acceso == 'Privado'):print "vpn_lock";else:print "public";endif; ?></i></span>
 			<a href="/usuarios/perfil/<?= $id_usuario; ?>" title="<?= $nombre_user; ?>">
		<?php 
			if($foto_usr == 'none'):
		?>
			<i class="material-icons">account_circle</i>
		<?php 
			endif;
			if($foto_usr != 'none'):
			
		?>
			<img src="/Views/template/images/pictures/<?= $foto_usr;?>" alt="<?= $nombre_user; ?>_imagen">
		<?php
			endif;
		?>
			<span>Administrador</span>
			</a>
		</div>
		<hr color="F8F8F8">
		<br>
 		<?php 
 			if(isset($_SESSION['userSesion']) && $id_usuario == $idu):
 		?>
 			<button class="btn btnRegular" id="baneos"><i class="material-icons ico ico_btn">power_off</i>&nbsp;<span>bloqueos</span><i class="material-icons">expand_more</i></button>
 			<div id="div_bans">
 				<ul></ul>
 			</div>
 		<?php		
 			endif;
 		?>
 		<div id="slide_div_grupos">
 			<img src="/Views/template/images/loading.gif" width="20" id="loadslidegrp">
 			<div id="head_slide_grupos">
 				<div class="actual_slide" id="slide_cursos"><i class="material-icons">format_indent_increase</i></div>
 				<div id="slide_usuarios_grupo"><i class="material-icons">people_outline</i></div>
 				<div id="slide_metrica"><i class="material-icons">assessment</i></div>
 			</div>
 			<div id="liCursos">
 				<div id="int_liCur">
 			<ul>
 		<?php
 			if(!empty($cursos)):
 			  foreach ($cursos as $val):
 				$idcur = array('id' => $val['id'], 'nc' => $val['nc']);
 		?>
 			<li <?php if(isset($_SESSION['userSesion']) && $id_usuario == $idu) print 'id="'.base64_encode(json_encode($idcur)).'"'; ?> class="li_cur_dash">
 				<a href="/temas/listar/<?= $val['id']; ?>" class="underl href_action" title="<?= $val['nc']; ?>">
 				<i class="material-icons lst_icon_grp">folder_open</i>
 				&nbsp;<span><?php if(strlen($val['nc']) > 28):print substr($val['nc'], 0, 28)." ...";else:print $val['nc'];endif; ?></span>
 				</a>
 		<?php
 				if( isset($_SESSION['userSesion']) && $id_usuario == $idu):
 		?>
 			<button class="btn btnEdit add_tema"><i class="material-icons ico_btn_shd ico_btn">plus_one</i>&nbsp;Tema...</button>
 			&nbsp;<i class="material-icons less_cur i_delete">delete_forever</i>
 		<?php
 				endif;
 		?>
 			</li>
 		<?php
 			  endforeach;
			else:
 		?>
			<br><br><br><br><br><i class="material-icons img_empty">local_cafe</i>
 		<?php		
 			endif;
 		?>	</ul>
 			</div>
 			</div>

 			<div id="liMiembros">
 				<div id="int_liMiemb">
 				<ul>
 		<?php 
 			if(!empty($members_group)):
 			  foreach($members_group as $r):
 		?>
 			<li id="<?= $idg."_".base64_encode($r['idu']); ?>">
 				<a href="/usuarios/perfil/<?= $r['idu']; ?>" class="underl href_action">
 				<div class="pict_slide_group<?php if($r['sta'] == '0') print ' banned'; ?>" style="<?php if($r['ids'] == 'FB') print "background-image: url(https://graph.facebook.com/".$r['idu']."/picture?type=small);";?>" title="<?= $r['nom']; ?>">
			<?php 
				if($r['fot'] == 'none'):
			?>
				<i class="material-icons">account_circle</i>
			<?php 
				endif;
				if($r['fot'] != 'none' && $r['ids'] != 'FB'):
			?>
				<img src="/Views/template/images/pictures/<?= $r['fot'];?>" alt="<?= $r['nom']; ?>_usuario">
			<?php
				endif;
			?>
				</div>&nbsp;
 				<span><?= $r['nom']; ?></span>
 				</a>
 				<div class="online_radio">
 			<?php
 				if( isset($_SESSION['userSesion']) && ($member == 1) || $id_usuario == $idu):
 			?>
 					<i class="material-icons circle <?php if($r['enl'] == 1){ print 'online';}else{ print 'outline';} ?>">lens</i>
        <?php
        		endif;

        		if( isset($_SESSION['userSesion']) && $id_usuario == $idu):
        ?> 					
 					&nbsp;<i class="material-icons more">more_vert</i>
 					<div class="del_ban_user">
 						<p class="ban_memb">Bloquear</p>
 						<p class="del_memb">Eliminar</p>
 						<img src="/Views/template/images/shift.png">
 					</div>
 		<?php
 				endif;
 		?>
 				</div>
 			</li>
 		<?php	
 			  endforeach;
 			else:
 		?>
			<br><br><br><br><br><i class="material-icons img_empty">people_alt</i>
 		<?php		
 			endif;
 		?>	
 				</ul>
 				</div>
 			</div>
			
			<div id="dMetrica">
				<div class='vlin'>
					<i class="material-icons pnt">assignment_turned_in
						<br><span><?php if(isset($metrica) && $metrica['puntos'] != "") print $metrica['puntos']." puntos"; ?></span>
					</i>
				</div>
				<div>
					<i class="material-icons gra">favorite_border
						<br><span><?php if(isset($metrica) && $metrica['gracias'] != "") print $metrica['gracias']." gracias"; ?></span>
					</i>
				</div>
			</div>
 		</div>
		<br>
 		<div id="recent_activity">
 			<div id="tags" class="up_recent">
 				<p><i class="material-icons new_recent">loyalty</i><br>
 					<?php
 					if(!empty($tags)):
 						print $tags;
 					else:
 					?>
 					<i class="material-icons inside_new_recent">emoji_food_beverage</i>
 					<?php	
 					endif;
 					?>
 				</p>
 			</div>
 			<div id="events" class="up_recent">
 				<p><i class="material-icons new_recent">fiber_new</i></p>
 					<div id="new_event_group"><div><i class="material-icons">exposure_plus_1</i></div><i class="material-icons">event</i></div>
 				<?php 
 					if(!empty($events)):
 					  foreach($events as $ev):
 						if($ev['tip'] == 'Tarea')
							$ico = "work";
						if($ev['tip'] == 'Leer')
							$ico = "local_library";
						if($ev['tip'] == 'Recordatorio')
							$ico = "announcement";
						if($ev['tip'] == 'Exámen')
							$ico = "list_alt";
						if($ev['tip'] == 'Otro')
							$ico = "calendar_today";
 				?>
 					<p class="desevnt">
 						<i class="material-icons"><?= $ico; ?></i>&nbsp;&nbsp;
 						<?= $ev['des']; ?><br>
 						<span>
 							<?= $ev['dia']."/".$ev['mes']."/".date('y'); ?>
 							a las <?= $ev['hor']; ?>
 						</span>
 					</p>
 				<?php		
 					  endforeach;
 					?>
 					<p class="desevnt"><a href="/agendas" class="href_action">VER TODOS</a></p>
 					<?php
 					endif;
 				 ?>
 			</div>
 			<div id="other_grps">
 				<p>
 					<i class="material-icons new_recent">fiber_new</i><br>
 					<span class="othg">Otros grupos creados recientemente</span><br><br>
 				</p>
 					<?php 
 						if($someg->num_rows > 0):
 						  while($sg = $someg->fetch_array()):
 					?>	
 						<a href="/grupos/ver/<?= $controlador->funcion('normalize', $sg['nombre_grupo']).'.'.$sg['id']; ?>" class="href_action">
 						<div class="others_g" style="--borde_oth: <?= $sg['color_theme']; ?>">
 							<i class="material-icons ico_others" style="--rad_icon: <?= $sg['color_theme']; ?>"><?= $sg['theme']; ?></i>
 							<span class="othgt"><?= $sg['nombre_grupo']; ?></span>
 						</div>
 						</a>
 					<?php
 						  endwhile;
 						else:
 					?>
 					<i class="material-icons img_empty">eco</i>
 					<?php		
 						endif;
 					 ?>
 			</div>
 		</div><br><br><br>
 		<hr color="F8F8F8">
 		<br>
 		<?php
 			new Views\Foro($idg, $controlador->validar_miembro($idu, $idg, 'access_member'), $controlador->funcion('normalize', $nombre_grupo), $id_usuario, $page);

 			if( isset($_SESSION['userSesion']) && $id_usuario == $idu ):

 				include_once(ROOT."Views/temas/templates/frmNuevoTema.php");
 				include_once(ROOT."Views/unidades/templates/frmAddUnidades.php");
 			endif;
 			if(isset($_SESSION['userSesion']) && ($member == 1) || $id_usuario == $idu):
 				$frmEv = true;
 				include_once(ROOT."Views/agendas/templates/frmEvent.php");	
 			else:
 		?>
	 		<script>
	 		$('#new_event_group').click(function(){
				if(!$('#frmEvent').length){	
					msgAlert('Unete al grupo para agregar Eventos!!');
					cerrar_alert_focus();
				}
				
			})
	 		</script>
 		<?php		
 			endif;
 		 ?>
 		 <script type="text/javascript" src="/Views/template/js/base64ende.js"></script>
	</article>
</div>