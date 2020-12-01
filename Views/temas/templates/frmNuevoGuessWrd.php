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
			<h1>Adivina palabras</h1>
		</div><br>
		<style>
			@import url('/Views/template/css/guessword.css');
		</style>
		<div id="contentGuessWrd">
			<img src="/Views/template/images/guessword.svg" alt="words" width="50"><br>
			<form action="" id="frmGuessWord" method="post">
				<div id="imgwrd"></div><br>
				<button id="add_p_img_wrd" class="btn btnRegular"><i class="material-icons ico">add_photo_alternate</i>&nbsp;Imagen</button><br><label class="frmlbl">poner una imagen de pista (opcional)* se mostrará desenfocada para adivinar la palabra</label><br><br>
				<input type="text" class="inptxt" id="nombre" name="nombre" placeholder="Título del juego..." maxlength="100" required><br><br><br>
				<input type="text" class="inptxtin" id="palabra" placeholder="Ingresa una palabra..." maxlength="20" required>
				<textarea class="inptxtin" id="pista" placeholder="Ingresa una pista para adivinarla..." required></textarea><br><br>
				<input type="hidden" id="pic_guess" name="pic_guess" value="">
				<input type="hidden" id="words" name="words" value="">
				<input type="hidden" id="clues" name="clues"  value="">	
				<button class="btn btnRegular"><i class="material-icons ico">add</i>&nbsp;Guardar palabra</button><br><br>
				<hr color="F0F0F0"><br><br>
				<div id="liwr_licl">
					<div class="hwrcl"><h6>Palabra</h6></div>
					<div class="hwrcl"><h6>Pista</h6></div>
				</div>
			</form><br><br><br>
			<button class="btn btnPublish" id="send_cgsswrd"><i class="material-icons ico">category</i>&nbsp;GUARDAR TODO</button><br><br><br>
		</div>
	</article>
</div>
<script>
	var palabras = ['no'];

	var pistas = ['no'];

	var imagenes = ['no'];
</script>
<script src="/Views/template/js/guessword.js"></script>