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
	<style>
		@import url("/Views/template/css/calif.css");
	</style>
	<article id="main">
		<div class="divHeader" id="indexHeader">
			<i class="material-icons">library_add_check</i>
			<h1>Calificaciones</h1>
		</div><br><br>
		<div id="searching_dats">
			<input class="inptxt outinptxt search_calif" type="text" name="search_calif" value="" placeholder="Buscar por curso...">
			<a class="href_action" id="button_search_calif" href="">
				<button class="btn btnEdit"><i class="material-icons">search</i></button>
			</a>
		</div><br><br>
		<div id="contCalif">
			<div id="headCalif">
				<div class="divhcal"><i class="material-icons">face</i></div>
				<div class="divhcal"><i class="material-icons">assignment</i></div>
			</div>
			<div id="bodyCalif">
		<?php 
			if(!empty($dats)):
				foreach($dats as $r):
					if($r['fot'] == 'na'):
						$urlp = "https://graph.facebook.com/".$r['idu']."/picture?type=small";
					elseif($r['fot'] == 'none'):
						$urlp = "/Views/template/images/account_circle.svg";
					else:
						$urlp = "/Views/template/images/pictures/".$r['fot'];
					endif;

					if($r['cal'] < 6):
						$c = "red";
					elseif($r['cal'] > 5 && $r['cal'] < 8):
						$c = "yel";
					elseif($r['cal'] > 9):
						$c = "grn";
					endif;
		?>	<div class="dpiccalusr">
				<div class="dpicusr">
					<a href="/usuarios/perfil/<?= $r['idu']; ?>" class="href_action underl">
					<div style="background-image: url(<?= $urlp; ?>);"></div>
					<span><?= $r['nom']; ?></span>
					</a>
				</div>
				<div class="dcalusr">
					<div>
						<a href="/temas/listar/<?= $r['idc']."?like=".$r['idu']; ?>" class="href_action underl">
						<i class="material-icons">folder</i><br>
						<span><?= $r['ncr']; ?></span>
						</a>
					</div>
					<div>
						<a href="/respuestas/ver/<?= $r['idr']; ?>" class="href_action underl">
						<i class="material-icons">fact_check</i><br>
						<span>
							<b class="<?= $c; ?>">
								<?= $r['cal'];?>
							</b><?= "&nbsp;(".$r['trp'].")";  ?>
						</span>
						</a>
					</div>
					<div>
						<a href="/temas/ver/<?= $controlador->funcion('normalize', $r['tit']).".".$r['idt'];  ?>" class="href_action underl">
						<i class="material-icons">chrome_reader_mode</i><br>
						<span><?= $r['tit'];  ?></span>
						</a>
					</div>
				</div>
			</div>
		<?php
				endforeach;
			else:
		?>
		<div align="center"><i class="material-icons img_empty">assignment_late</i><p class="advice">No se encontraron resultados!</p></div>
		<?php
			endif;
		 ?>
		 	</div>
		</div><br><br>
		<div class="linksPaginacion">
	<?php
		if(!isset($_GET['b'])):
		  if(!empty(($dats))):
			$pages = $controlador->paginar_calif($argumento);
			if(!isset($_GET['page'])):
				$pg = 1;
			else:
				$pg = $_GET['page'];
			endif;
	?>
		<a class="paginacion <?php if($pg == 1)print 'sel'; ?> href_action" href="/cursos/calificaciones/<?= $argumento; ?>?page=1">1</a>
	<?php

			for($i = $pg; $i <= $pg + 8; $i++):
				if($i != 1 && $i <= $pages):
	?>
		<a class="paginacion <?php if($_GET['page'] == $i)print 'sel'; ?> href_action" href="/cursos/calificaciones/<?= $argumento.'?page='.$i; ?>"><?= $i; ?></a>
	<?php
				endif;
			endfor;
			if($i <= $pages):
	?>
		<a href='/cursos/calificaciones/<?= $argumento.'?page='. $i; ?>' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
	<?php			
			endif;
		  endif;
		endif;	
	 ?>

		</div><br><br>
	</article>
</div>