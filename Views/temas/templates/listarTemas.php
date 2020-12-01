<div id="some_activity">
	<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<iframe width="90%" height="200" style="margin-left:5%; border-radius:8px;" src="https://www.youtube.com/embed/8zkxzZbV2m8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><br>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
	<article id="main">
		<div id="indexHeader" class="divHeader">
			<i class="material-icons">format_list_bulleted</i>
			<h1>Curso</h1>
		</div>
		<br><br>
		<div id="listTemas">
		<?php 
			if((!empty($callback_datos) || !empty($modulos)) && $metodo != 'searchtag'):
		?>
			<div id="searching_dats">
				<input class="inptxt outinptxt search_input" type="text" name="search_grupos" value="" placeholder="Buscar...">
				<a class="href_action" id="button_search" href="<?= $argumento; ?>">
					<button class="btn btnEdit"><i class="material-icons">search</i></button>
				</a>
			</div><br><br>
			<a href="/grupos/ver/<?= $n_cur_grp[2].'#actionsGrupo'; ?>" class='inline underl href_action'><i class="material-icons">launch</i>&nbsp;<span>IR AL GRUPO</span></a><br><br>
			<h3><i class="material-icons" style="vertical-align: middle">folder_open</i>&nbsp;<?= $n_cur_grp[0]; ?></h3><br>
			<?php 
				if(isset($_SESSION['userSesion'])):
					if(isset($_GET['like'])):
			?>
			<div align="center"><span class="advice"><i class="material-icons">person_search</i></span></div><br>
			<?php
				else:
			?>
				<div align="center"><span class="advice"><i class="material-icons">face</i> yo</span></div><br>
			<?php
					endif;
				endif;

				if(isset($_SESSION['userSesion']) && $member && $metodo != 'buscar'):
			 ?>
			<button class="btn_normal" id="ver_avance"><i class="material-icons ico">insert_chart_outlined</i>&nbsp;<?php if(!isset($_GET['like'])):print 'Mis avances..';else: print 'Avance..';endif; ?>&nbsp;<i class="material-icons">expand_more</i></button>
			<div id="chart_curso">
				<div class="aqua" style="--percent: <?= 100 - $pclevel."%"; ?>;"></div>
				<p class="advice"><?= $pclevel."%"; ?></p>
			</div>
			<?php 
				if(!isset($_GET['like'])):
			 ?>
			<button class="btn_normal" id="ver_archs_curs"><i class="material-icons ico">file_copy</i>&nbsp;Mis archivos..&nbsp;<i class="material-icons">expand_more</i></button>
			<div id="archivosVisor" class="archs_curso">
				<div id="headArchivosVisor">
					<p class="advice" align='left'><i class="material-icons ico">file_copy</i>&nbsp;Mis archivos del curso</p>
				</div> 
				<div id="bodyArchivosVisor">
					<?php
						while($dt = $lista_archivos[0]->fetch_array()):
							$tft = $controlador->funcion('returnClassExt', $dt['id_archivo']);
					?>
					<div class="files_div" id="<?= base64_encode($dt['id']); ?>">
					<div class="file_elem <?= $tft; ?>" style="<?php if($tft == 'attach_image')print '--bkimg:'.'url(/Resources/files_tut/'.$dt['id_archivo'].')';?>" title="<?= $dt['nombre_archivo']; ?>">	
						<a href="/Resources/files_tut/<?= $dt['id_archivo']; ?>" download="<?= $dt['nombre_archivo']; ?>"><?php if(strlen($dt['nombre_archivo']) > 26):print substr($dt['nombre_archivo'],0,26)."..";else:print $dt['nombre_archivo']; endif; ?>&nbsp;
						</a>
					</div>	
					<div class="action_file">
						<a href="/temas/editar/<?= $controlador->funcion('normalize', $dt['titulo']).".".$dt['id_tema']; ?>#archivosVisor"><div><button class="btn_normal"><i class="material-icons">launch</i></button></div></a>
						<div><i class="material-icons i_delete delete_file">delete</i></div>
						</div>
					</div>
					<?php		
						endwhile;
						while($dr = $lista_archivos[1]->fetch_array()):
							$tfu = $controlador->funcion('returnClassExt', $dr['id_archivo']);
					?>
					
					<div class="files_div" id="<?= base64_encode($dr['id']); ?>">
					<div class="file_elem <?= $tfu; ?>" style="<?php if($tfu == 'attach_image')print '--bkimg:'.'url(/Resources/files_usr/'.$dr['id_archivo'].')';?>" title="<?= $dr['nombre_archivo']; ?>">	
						<a href="/Resources/files_usr/<?= $dr['id_archivo']; ?>" download="<?= $dr['nombre_archivo']; ?>"><?php if(strlen($dr['nombre_archivo']) > 26):print substr($dr['nombre_archivo'],0,26)."..";else:print $dr['nombre_archivo']; endif; ?>&nbsp;
						</a>
					</div>	
					<div class="action_file">
						<a href="/temas/ver/<?= $controlador->funcion('normalize', $dr['titulo']).".".$dr['id_tema']; ?>#archivosVisor"><div><button class="btn_normal"><i class="material-icons">launch</i></button></div></a>
						<div><i class="material-icons i_delete delete_file">delete</i></div>
						</div>
					</div>
					<?php
						endwhile;
					?>
				</div>
			</div>
			<?php 
				endif;
			 ?>
			<script type="text/javascript" src="/Views/template/js/editor.js"></script>
			<br><br>
		<?php
				endif;
			endif;

			if(!empty($modulos)):
		?>
			<div id="Modulos">
				<div class="headTopics" id='m'>
					<i class="material-icons">widgets</i>&nbsp;
					<span>Ver y Listar Módulos...</span>&nbsp;
					<i class="material-icons">expand_more</i>
				</div>
			<div class="bodyTopics">
		<?php
				foreach ($modulos as $mod):
		?>
			<div class="list_modulo" id="<?= $mod['id']; ?>-ltp">
				<div class="ico_modul">
					<i class="material-icons modul">widgets</i>
				</div>
				<p class="exp_topic">
					&nbsp;&nbsp;<?= $mod['nu']; ?>
					<i class="material-icons">expand_more</i>
				</p>
				<div class="bodyTopics get_topicsMod"></div>
			</div>
		<?php
				endforeach;
		?>
			</div>
			</div>
		<?php
			endif;
		?>

			<div id="Temas">
				<div class="headTopics">
					<i class="material-icons">
					<?php if($metodo == 'buscar' || $metodo == 'searchtag'):print 'find_in_page';else:print 'chrome_reader_mode'; endif; ?>
					</i>&nbsp;
					<span><?php if($metodo == 'buscar' || $metodo == 'searchtag'):print 'Resultados...';else:print 'Ver Temas Individuales...'; endif;?></span>&nbsp;
					<i class="material-icons">expand_more</i>
				</div>
		<?php
			if(!empty($callback_datos)):
			  foreach ($callback_datos as $val):
				if( isset($val['ni']) && $val['ni'] == 1):
					$ictem = "list_alt";
				else:
					$ictem = "chrome_reader_mode";
				endif;

				if(($val['iu'] == 0 && $metodo != 'searchtag') || ($val['iu'] != 0 && $metodo == 'searchtag') || $metodo == 'buscar'):

 		 			$post_tema = array('idt' => $val['id'], 'tit' => $val['ti']);
 					$post_tema = base64_encode(json_encode($post_tema));
		?>
			<div class="list_tema">
				<div class="info_list_tema">
				<?php 
					if(isset($_SESSION['userSesion']) && $member):
				?>
					<a class="underl href_action hst" href="/temas/ver/<?= $controlador->funcion('normalize', $val['ti']).'.'.$val['id']; ?>" title="<?= $val['ti']; ?>">
				<?php 
				 	endif;
				 ?>
				<div>
					<i class="material-icons"><?= $ictem; ?></i>
				</div>
				<p>
					&nbsp;<?php if(strlen($val['ti']) > 24):print substr($val['ti'], 0, 24)." ...";else:print $val['ti']; endif; ?>&nbsp;
					<span>
						&nbsp;editado el:&nbsp;<?= $val['fe']; ?>		
						<i class="material-icons">watch_later</i>
					</span>
				</p>
				<?php 
					if(isset($_SESSION['userSesion']) && $member):
				 ?>
				 	</a>
				 <?php 
				 	endif;
				  ?>
				</div>
				<div class="action_temas" id="<?= $post_tema; ?>">
				<?php  
					if (isset($_SESSION['userSesion']) && ($id_usuario == $_SESSION['userSesion']['id'])):
				?>
					<div class="delete_tema">
					<i class="material-icons del_tema">delete</i>
					</div>
					<a class="href_action" href="/temas/editar/<?= $controlador->funcion('normalize', $val['ti']).'.'.$val['id']; ?>">
					<div class="edit_tema">
					<i class="material-icons i_normal">edit</i>
					</div>
					</a>
				<?php 
					else:
				?>
					<div>
						<i class="material-icons i_normalh">launch</i>
					</div>
				<?php		
					endif;
				 ?>
				</div>
			</div>
		<?php
				endif;
			  endforeach;
			elseif(empty($callback_datos) && $metodo == 'buscar'):
		?>
			<br><br><i class="material-icons img_empty">filter_none</i>
			<p class="advice">Sin resultados!!</p>
		<?php	
			elseif(empty($callback_datos)):
		?>
				<br><br><i class="material-icons img_empty">filter_none</i>
			<p class="advice">No hay temas individuales!!</p>
		<?php
			endif;
		?>	
		<br>
		<div class="linksPaginacion">
		<?php
			if($metodo == 'listar'):
		      if(!empty($callback_datos)):		
			$pages = $controlador->paginar_temas($argumento);
		?>
			<a class="paginacion <?php if($page == 1)print 'sel'; ?> href_action" href="?page=1">1</a>
		<?php

				for($i = $page; $i <= $page + 8; $i++):
					if($i != 1 && $i <= $pages):
		?>
			<a class="paginacion <?php if($page == $i)print 'sel'; ?> href_action" href="?page=<?= $i; ?>"><?= $i; ?></a>
		<?php
					endif;
				endfor;
				if($i <= $pages):
		?>
			<a href='?page=<?= $i; ?>' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
		<?php			
				endif;
			  endif; 	
			endif;
	 	?>
		</div><br>
		</div>
		</div>
		<?php
			if(isset($_SESSION['userSesion']) && ($id_usuario == $_SESSION['userSesion']['id'])):
				if(isset($idcur)):
		?>
			<div <?= 'id="'.base64_encode(json_encode($idcur)).'"'; ?> class="float_btn addtema_ico">
				<i class="material-icons add_tema">library_add</i>
			</div>
		<?php		
				endif;
 				include_once(ROOT."Views/temas/templates/frmNuevoTema.php");
 				include_once(ROOT."Views/unidades/templates/frmAddUnidades.php");
 			endif;
 		?>
 		<script type="text/javascript" src="/Views/template/js/base64ende.js"></script>
	</article>
</div>