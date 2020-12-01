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
		<i class="material-icons">search</i>
		<h1>Busquedas...</h1>
	</div><br>
<?php
if($callback_datos->num_rows > 0):			
	while($r = $callback_datos->fetch_array()):
?>
	<div class="divBusCr">
		<div>
			<p>
				<a href="/temas/listar/<?= $r['id'];  ?>" class=" href_action underl inline">
					<i class="material-icons">folder_open</i>
					<span><?= strtoupper($r['nombre_materia_curso']);  ?></span>
				</a>
			</p>
		</div>
		<div title="<?= $r['nombre_grupo']; ?>">
			<div style="--bk_ming:<?= $r['color_theme'];  ?>">
				<i class="material-icons"><?= $r['theme'];  ?></i>
			</div>
		</div>
	</div>
<?php
	endwhile;
else:
?>
	<i class="material-icons img_empty">filter_none</i>
	<p class="advice">
		No hay resultados para esa busqueda!!
	</p>
<?php
endif;
?>
	</article><br>
</div>