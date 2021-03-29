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
	<div class="all" id="guessing">
      <section class="intentos">
        <div class="container">
          <div class="row">
            <div class="col" id="intentos">
              <p class="text-center">Intentos: 5</p>
            </div>
          </div>
        </div>
      </section>
      <section class="letras">
        <img src="" width="125" id="imagen_pista">
        <div class="container">
          <div class="row">
            <div class="col" id="letras">
              <p>-----</p>
            </div>
          </div>
        </div>
      </section>
      <section class="pistas">
        <div class="container">
          <div class="row">
            <div id="pistas" class="col">
              <p></p>
            </div>
          </div>
        </div>
      </section>
      <section class="abc">
        <div class="container">
          <div class="row">
            <div class="col" id="abc"></div>
          </div>
        </div>
      </section>
      <section class="mensajes">
        <div class="container">
          <div class="row">
            <div id="mensajes" class="col"></div>
          </div>
        </div>
      </section>
    </div>
    <button id="again" onclick="again()">OTRA</button><br><br><br><br>
    <script>
    	var palabras = [<?= $words; ?>];

		  var pistas = [<?= $clues; ?>];

		  var imagenes = [<?= $images; ?>];
    </script>
    <script src="/Views/template/js/guessword.js"></script>
	</article>
</div>