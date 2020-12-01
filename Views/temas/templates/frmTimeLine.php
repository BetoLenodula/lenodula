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
			<i class="material-icons">category</i>
			<h1>Línea del tiempo</h1>
		</div><br>
		<style>
			@import url('/Views/template/css/timeline.css');
		</style>
		<div id="contentTimeL">
			<img src="/Views/template/images/timeline.svg" alt="timeline" width="50"><br>
			<form action="" id="frmTimeLine" method="post">
				<div id="imgtl"></div><br>
				<label class="frmlbl">poner una imagen (opcional)*</label><br>	
				<button id="add_p_img_tml" class="btn btnRegular"><i class="material-icons ico">add_photo_alternate</i>&nbsp;Imagen</button><br><br>
				<input type="text" class="inptxt" id="nombre" name="nombre" placeholder="Título de la línea del tiempo..." maxlength="100" required><br><br>
				<label class="frmlbl">Fecha de evento</label><br>
				<input type="date" class="inpdate" id="fecha" placeholder="Fecha de evento..." required><br><br>
				<textarea class="inptxt" id="dato" placeholder="Datos del evento..." required></textarea><br><br>
				<input type="hidden" id="pic_timel" name="pic_timel" value="">
				<input type="hidden" id="fechas" name="fechas" value="">
				<input type="hidden" id="datos" name="datos"  value="">	
				<button class="btn btnRegular"><i class="material-icons ico">add</i>&nbsp;Guardar evento</button><br><br>
				<hr color="F0F0F0"><br><br>
				<div id="life_lida">
					<div class="hfeda"><h6>Fecha</h6></div>
					<div class="hfeda"><h6>Dato</h6></div>
				</div>
			</form><br><br><br>
			<button class="btn btnPublish" id="send_ctimel"><i class="material-icons ico">category</i>&nbsp;GUARDAR TODO</button><br><br><br>
		</div>
	</article>
</div>
<script src="/Views/template/js/timeline.js"></script>