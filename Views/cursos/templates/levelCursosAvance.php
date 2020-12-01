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
			<i class="material-icons">score</i>
			<h1>Avances</h1>
		</div>
		<div id="divAvances">
			<a href="/usuarios/perfil/<?= $argumento; ?>" class="href_action underl inline">
			<span>VER PERFIL</span>
			<i class="material-icons">launch</i>
			</a>
			<a href="/cursos/grafica/<?= $argumento; ?>" class="href_action underl inline" style="float:right;">
				<span>VER GRÁFICA</span>
				<i class="material-icons">assessment</i>
			</a><br><br>
			<hr color="F9F9F9">
		<?php 
			if($callback_datos->num_rows > 0):
			 while($r = $callback_datos->fetch_array()):
				$perc = ceil(100 * $r['numero_temas_vistos'] / $r['numero_temas']);
				if($perc == 0):
					$perc = '00';
				endif;
		?>
		<div class="div_avance">
			<div class="div_inf_avance">
				<a href="/temas/listar/<?= $r['id_curso']; ?><?php if($argumento != 'my') print "?like=".$argumento; ?>" class="underl href_action inline">
					<i class="material-icons">folder</i>
					<p>&nbsp;<?= $r['nombre_materia_curso']; ?></p>
				</a>
			</div>
			<div class="div_chart_avance">
				<meter class="meter_courses" min="0" max="<?= $r['numero_temas']; ?>" value="<?= $r['numero_temas_vistos']; ?>" ></meter>
				<span><?= $perc."%"; ?></span>
			</div>
		</div>
		<?php		
			 endwhile;
			else:
		?>
			<i class="material-icons img_empty">filter_none</i>
			<p class="advice">Este usuario no tiene ningún curso aún!!</p>
		<?php
			endif;
		 ?>
		</div>
	</article>
</div>