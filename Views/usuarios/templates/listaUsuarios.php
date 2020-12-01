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
	<i class="material-icons">&#xE87C;</i>
	<h1>Usuarios</h1>
</div>
<div id="listUsers">
	<div id="searching_dats">
		<input class="inptxt outinptxt search_input" type="text" name="search_user" value="" placeholder="Buscar...">
		<a class="href_action" id="button_search" href=""><button class="btn btnEdit"><i class="material-icons">search</i></button></a>
	</div><br><br>
	<?php
		if($metodo != 'buscar' && !empty($callback_datos)):
	?>
	<a class="underl inline href_action" href="<?= URL.$_GET['url']; ?>?order=max"><i class="material-icons">sort</i>&nbsp;<span>ORDENAR</span></a>
	<?php 
		endif;

		$max_puntos = $controlador->contar_puntos();
		
		if(!empty(($callback_datos))):
		  foreach($callback_datos as $datos):
	?>
	<div class="divListUser">
		<div class="pictListUser">
			<div style="<?php if($datos['ids'] == 'FB')print "background-image: url(https://graph.facebook.com/$datos[identificador_unico]/picture?type=large)"; ?>">	
	<?php 
			if($datos['foto'] == 'none'):
	?>
			<img src="/Views/template/images/account_circle.svg" alt="<?= $datos['nombre_user']; ?>_default">
	<?php 
			endif;
			if($datos['foto'] != 'none' && $datos['ids'] != 'FB'):
			
	?>
			<img src="/Views/template/images/pictures/<?= $datos['foto'];?>" alt="<?= $datos['nombre_user']; ?>_imagen">
	<?php
			endif;
	?>
			</div>
		</div>
		<div class="divInfoUser">
			<p>
				<span><?= $datos['nombre_user']; ?></span><br>
				(<?= $datos['rol']; ?>)<br>
				<?= $datos['nombres']." ".$datos['apellidos']; ?><br><br>
				<meter class="meter_puntos_user" min="0" max="<?php if($max_puntos == 0):print 1;else:print $max_puntos;endif; ?>" value="<?= $datos['total_puntos']; ?>" title="<?= $datos['total_puntos']; ?> Puntos"></meter>
			</p>
		</div>
		<?php 
			
		 ?>
		<div class="divActionUser">
			<a class="href_action" href="/usuarios/perfil/<?= $datos['identificador_unico']; ?>">
				<button class="btn btnEdit"><i class="material-icons ico_btn">account_circle</i> Ver Perfil</button><br>
			</a>
			<?php 
				if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor' &&
					$datos['identificador_unico'] != $_SESSION['userSesion']['id']):
				?>
				<button class="btn btnAction btnAdd_mem"><i class="material-icons ico_btn">add_box</i> Agregar..</button>
			<?php		
				endif;
			?>
		</div>
	</div>
	<?php
		  endforeach;
		else:
	?>
	<i class="material-icons img_empty">contacts</i>
	<p class="advice">No hay usuarios registrados!!</p>
	<?php
		endif;
	?>
	<br>
	<div class="linksPaginacion">
	<?php

		if($metodo == 'pagina' || $metodo == 'index'):
		  if(!empty(($callback_datos))):
			$pages = $controlador->paginar_usuarios();
			if(!$argumento):
				$pg = 1;
			else:
				$pg = $argumento;
			endif;
	?>
		<a class="paginacion <?php if($pg == 1)print 'sel'; ?> href_action" href="/usuarios/pagina/1">1</a>
	<?php

			for($i = $pg; $i <= $pg + 8; $i++):
				if($i != 1 && $i <= $pages):
	?>
		<a class="paginacion <?php if($argumento == $i)print 'sel'; ?> href_action" href="/usuarios/pagina/<?= $i; ?>"><?= $i; ?></a>
	<?php
				endif;
			endfor;
			if($i <= $pages):
	?>
		<a href='/usuarios/pagina/<?= $i; ?>' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
	<?php			
			endif;
		  endif;	
		endif;
	 ?>
	</div>
</div>
<?php 
	if(isset($_SESSION['userSesion']) && $_SESSION['userSesion']['rol'] == 'Tutor'):
		include_once(ROOT."Views/grupos/templates/frmAddMember.php");
	endif;
 ?>
	</article>
</div>