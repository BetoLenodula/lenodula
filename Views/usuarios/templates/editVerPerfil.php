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
			<div class="divHeader" id="indexHeader">
				<i class="material-icons">&#xE55A;</i>
				<h1><?= $nombre_user; ?></h1>
			</div>
			<div id="bodyMiPerfil">
				<?php 
					if($foto == 'none' || $foto != 'na'):
						if($argumento == 'my'):
							include_once(MSG."frmPicture.php");
						endif;
					endif;
				 ?>
				<div id="BodyMiPerfil">
					<div class="barf" id="barf1"></div>
					<div class="barf" id="barf2"></div>
					<div class="barf" id="barf3"></div>
					<div class="barf" id="barf4"></div>
					<div class="barf" id="barf5"></div>
					<div class="barf" id="barf6"></div>
					<div class="barf" id="barf7"></div>

					<div id="contentMiPerfil">
						<div id="headContPerfil">
							<div id="fotoShowPerfil">
								<div id="imgPerfil" style="<?php if($ids == 'FB')print "background-image: url(https://graph.facebook.com/$idu/picture?type=large);";?>">
									<?php 
										if($foto == 'none'):
									 ?>
									 	<i class="material-icons account-ico">&#xE55A;</i>
									<?php 
										endif;
										if($foto != 'none' && $ids != 'FB'):
									?>
										<img src="/Views/template/images/pictures/<?= $foto;?>" alt="<?= $nombre_user; ?>_perfil">
									<?php
										endif;
									 ?>
									 <?php
										if($argumento == 'my' && ($foto == 'none' || $foto != 'na')):
									?> 
									 	<button class="btn btnAction open_file_box"><i class="material-icons">photo_camera</i></button>
									 <?php
									 	endif;
									 ?>
								</div>
							</div>
							<div id="userNameperfil">
								<?php
									if($argumento == 'my'):
								?> 
								<span>Mi Perfil</span>
								<?php
									else:
								?>
									<span>Ver Perfil</span>
								<?php
									endif;
								?>
							</div>
						</div><br>
							  <div class="infoProfile">
						<?php 
							if($argumento == 'my' || $rol != 'Tutor'):
						 ?>
							  	<a href="/cursos/avances/<?= $argumento; ?>" class="href_action">
							  	<button class="btn btnAction"><i class="material-icons">show_chart</i>&nbsp;ver avance global</button></a>
						<?php 
								if(isset($_SESSION['userSesion'])):
						 ?>
							  	<a href="/cursos/calificaciones/<?= $argumento; ?>" class="href_action">
							  	 <button class="btn btnAction"><i class="material-icons">library_add_check</i>&nbsp;calificaciones
							  	 </button></a>
						<?php 
								endif;
							endif;
						 ?>
							  </div>
							  <br>
						<div id="divDatosPerfil">
							<?php 
								if($argumento == 'my'):
							 		include_once("frmEditPerfil.php");
								else:
							 ?>
							 <div class="infoProfile">
							 	<label>nombre usuario (Rol <?= $rol; ?>)</label><br>
								<div><span><?= $nombre_user; ?></span></div>
								<br><br>
								<label>nombres</label><br>
								<div><span><?= $nombres; ?></span></div>
								<br><br>
								<label>apellidos</label><br>
								<div><span><?= $apellidos; ?></span></div>
								<br><br>
								<label>Registrado desde: <?= $controlador->funcion("alfa_months", $fecha_ing); ?></label><br>
							</div>
							 <?php 
							 	endif;
							  ?>
						</div>
					</div>

					<div id="divPuntuacionPerfil">
						<div id="headerPuntuacion">
							<i class="material-icons">assignment_turned_in</i>
							<span><?= $t_punt; ?> Puntos</span>
						</div>
						<div id="contGratResp">
							<div id="graciasPunt">
								<p>
									<span><?= $t_grat; ?></span>
									<i class="material-icons">favorite_border</i><br>
									Gracias
								</p>
							</div>
							<div id="respuestasPunt">
								<p>
									<span><?= $t_resp; ?></span>
									<i class="material-icons">chat_bubble_outline</i><br>
									Respuestas
								</p>
							</div>
						</div>
						<hr color="CDCDCD">
						<div id="contEstrellas">
							<div>
								<p class="star_prf"><i class="material-icons big_star">star</i><span>x&nbsp;<?= $stars; ?></span></p>
							</div>
						</div>
					</div>

					<div id="curCompleted">
						<?php 
						$nc = 0;
						if($cur->num_rows > 0):
							while($rc = $cur->fetch_array()):
								$perc = ceil(100 * $rc['numero_temas_vistos'] / $rc['numero_temas']);
								
								if($perc == 100):
									$nc++;
						?>
						<a href="/temas/listar/<?= $rc['id_curso']; ?>" title="<?= $rc['nombre_materia_curso']; ?>">
							<img src="/Views/template/images/complete.svg" alt="lenodula_complete_course" width="50">
						</a>
						<?php
								endif;
							endwhile;
						?>
						<br><br><br><br><img src="/Views/template/images/shf.png" alt="shelf_lenodula" width="100%">
						<br><p><?= $nc; ?> cursos completados</p>
						<?php
						else:
						?>
						<br><br><br><br><img src="/Views/template/images/shf.png" alt="shelf_lenodula" width="100%">
						<br><p>Aún no ha completado ningún curso</p>
						<?php
						endif;
						?>	
					</div>

					<div class="bar" id="bar1"></div>
					<div class="bar" id="bar2"></div>
					<div class="bar" id="bar3"></div>
					<div class="bar" id="bar4"></div>
					<div class="bar" id="bar5"></div>

				</div>
			</div>
			<?php 
				if($argumento != 'my' && isset($_SESSION['userSesion']) && $_SESSION['userSesion']['id'] != $argumento):
			 ?>
			<div class="float_btn" id="open_boxmsg"><i class="material-icons">mail</i></div>
			<div id="main_msgs">
				<div id="head_msgs">
					<i class="material-icons" id="closmsg">close</i>
				</div>
				<div id="body_msgs">
					<div id="msgs">
						<div id="topmsgs"></div>
						<div id="bottomsgs"></div>
					</div>
				</div>
				<form action="" method="post" id="frmMsg">
					<textarea name="mensaje" id="mensaje" class="inptxt" placeholder="Mensaje..."></textarea>
					<button type="submit" class="btn btnAction"><i class="material-icons ico">send</i></button>
				</form>	
			</div>
			<audio id='tone_msg' volume='0.6' src='/Views/template/sound/gota.mp3'></audio>
			<script type="text/javascript" src="/Views/template/js/mensajes.js"></script>
			<?php 
				endif;
			 ?>
	</article>
</div>