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
		</div><br><br>
		<a href="/cursos/avances/<?= $argumento; ?>" class="href_action underl inline">
			<span>&nbsp;&nbsp;REGRESAR</span>
			<i class="material-icons">launch</i>
		</a><br>
		<style>
			@import url("https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css");
		</style>
		<?php 
			$data = null;

			if($callback_datos->num_rows > 0):
			 while($r = $callback_datos->fetch_array()):
				$perc = ceil(100 * $r['numero_temas_vistos'] / $r['numero_temas']);
				if($perc == 0):
					$perc = '00';
				endif;

				$data .= "{curso: '". $r['nombre_materia_curso']. "', value: '". $perc ."'},";	
			 endwhile;
			 $data = substr($data, 0, -1);
			else:
		?>
			<i class="material-icons img_empty">filter_none</i>
			<p class="advice">Este usuario no tiene ningún curso aún!!</p>
		<?php
			endif;
		 ?>
		 <br><div id="chart" style="height: 300px;"></div><br>
	</article>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
		new Morris.Bar({
			  element: 'chart',
			  
			  data: [<?= $data; ?>],
			  
			  xkey: 'curso',
			  
			  ykeys: ['value'],
			  
			  labels: ['% '],

			  resize: true,

			  ymax: 100,

			  barColors: ['#10ADC3']
		  
		});
</script>