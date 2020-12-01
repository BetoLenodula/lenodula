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
			<h1>Sopa de letras</h1>
		</div><br>
		<style>
			@import url('/Views/template/css/wordfind.css');
		</style>
		<div id="contentWordfind">
			<img src="/Views/template/images/wordfind.svg" alt="words" width="50"><br>
			<form action="" id="frmWordFind" method="post">
				<label for="nombre" class="frmlbl">Nombre</label>
				<input type="text" name="nombre" id="nombre" class="inptxt" maxlength="100" placeholder="nombre de la sopa de letras..." required><br><br><br>
				<label for="tags" class="frmlbl">Inserta palabras una a una.</label>
				<div id="insert_words"><input type="text" id="words" autocomplete="off" placeholder="+ palabra..."></div><br><br>
				<input type="hidden" name="tags_hidden" id="tags_hidden">
			</form>
			<button class="btn btnPublish" id="send_cwrfnd"><i class="material-icons ico">category</i>&nbsp;GUARDAR TODO</button><br><br><br>
		</div>
		<script type="text/javascript" src="/Views/template/js/wordfind.js"></script> 
	</article>
</div>