<div id="some_activity">
	<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<iframe width="90%" height="200" style="margin-left:5%; border-radius:8px;" src="https://www.youtube.com/embed/xaYYESUpdoE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><br>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
	<article id="main">
		<div id="indexHeader" class="divHeader">
			<i class="material-icons">&#xE886;</i>
			<h1>Grupos</h1>
		</div>
		<br>
		<div id="wallGrupo">
			<?php
			$num_grupos = $controlador->contar_grupos();

			if($num_grupos == 0):
			?>
			<i class="material-icons img_empty">eco</i>
			<?php
				if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor'): 
			 ?>
			 <p class="advice">
				No existen grupos, crea uno!
			</p>
			<br>
			<a class="href_action" href="/grupos/nuevo">
			<div class="minDivGrupo newGrupo" id="newEmptyGrupos">
				<i class="material-icons">plus_one</i>&nbsp;
				<span>Nuevo</span>
			</div>
			</a>
			<?php
				else:
			?>
			<p class="advice">
				No se han creado grupos!
			</p>
			<?php
				endif;
			else:
			?>
			<div id="searching_dats">
				<input class="inptxt outinptxt search_input" type="text" name="search_grupos" value="" placeholder="Buscar...">
				<a class="href_action" id="button_search" href="">
					<button class="btn btnEdit"><i class="material-icons">search</i></button>
				</a>
			</div>
			<br><br>
			<?php
				if(isset($_SESSION['userSesion'])):
			?>
			<a class="href_action href_style" href="/grupos/buscar/my">VER MIS GRUPOS</a><br><br><br>
			<?php
					if($_SESSION['userSesion']['rol'] == 'Tutor'):
			?>
			<a class="href_action" href="/grupos/nuevo">
			<div class="minDivGrupo newGrupo floating">
				<i class="material-icons">plus_one</i>&nbsp;
				<span>Nuevo</span>
			</div>
			</a>
			<?php
					endif;
				endif;									

				while($dats = $callback_datos->fetch_array()):

			?>
			<div class="minDivGrupo floating minGrupo" id="<?= base64_encode($dats['id'].'-gr'); ?>">
				<?php 
					if(isset($ses) && $ses == $dats['id_usuario']):
				?>
				<div class="delete_grp"><i class="material-icons">delete_forever</i></div>
				<?php
					endif;
				 ?>
				<a class="href_action href_groups" href="/grupos/ver/<?= $controlador->funcion("normalize", $dats['nombre_grupo']); ?>.<?= $dats['id']; ?>">
				<div class="headMinGrupo" style="background-color:<?= $dats['color_theme']; ?>">
				<i class="material-icons i_min_grp"><?= $dats['theme']; ?></i>
				<i class="material-icons i_min_min_back_grp">cloud</i>
				<i class="material-icons i_min_back_grp">cloud</i>
				<p><?= $dats['nombre_grupo']; ?></p>
				</div>
				<div class="bodyMinGrupo">
					<p>
						<?= substr($dats['descripcion_grupo'], 0, 75)."..."; ?>
					</p>
					<div class="footMinGrupo">
						<i class="material-icons le">event</i>
						<span><?= $controlador->funcion("alfa_months", $dats['fecha_creacion_grupo']); ?></span>
						<i class="material-icons ri"><?php if($dats['tipo_acceso'] == 'Privado'): print "vpn_lock";else: print "public"; endif; ?></i>
					</div>
				</div>
				</a>
			</div>
			<?php
				endwhile;
			?>
			<div class="linksPaginacion">
			<?php
				if($metodo == 'pagina' || $metodo == 'index'):
					$pages = $controlador->paginar_grupos();
					if(!$argumento):
						$pg = 1;
					else:
						$pg = $argumento;
					endif;
			?>
			<a class="paginacion <?php if($pg == 1) print 'sel'; ?> href_action" href="/grupos/pagina/1">1</a>
			<?php

					for($i = $pg; $i <= $pg + 8; $i++):
						if($i != 1 && $i <= $pages):
			?>
			<a class="paginacion <?php if($argumento == $i)print 'sel'; ?> href_action" href="/grupos/pagina/<?= $i; ?>"><?= $i; ?></a>

			<?php
						endif;
					endfor;
					
					if($i <= $pages):
			?>
			<a href='/grupos/pagina/<?= $i; ?>' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
			<?php			
					endif;
				endif;
			?>
			</div>
			<?php
			endif;
			?>
			<br>
		</div>
	</article>
</div>
<script src="/Views/template/js/base64ende.js"></script>