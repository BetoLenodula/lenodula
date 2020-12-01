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
			<h1>Busca palabras</h1>
		</div><br>
		<div style="width: 100%; text-align: center;">
			<style>
				@import url('/Views/template/css/wordfind.css');
			</style>
			<h2><?= strtoupper($nom); ?></h2><br>
			<div id='puzzle'></div>
		    <div id='words'></div>
		    <script type="text/javascript" src="/Views/template/js/wordfind.js"></script> 
    		<script type="text/javascript" src="/Views/template/js/wordfindgame.js"></script> 
		    &nbsp;&nbsp;&nbsp;&nbsp;
		    <div align="center"><br><button id='solve' class="btn btnAction"><i class="material-icons ico">check_circle</i>&nbsp;Resolver el juego</button></div><br>
		    <script>
		    var words = [<?= $words; ?>];
		    var gamePuzzle = wordfindgame.create(words, '#puzzle', '#words'); 
		        
		    var puzzle = wordfind.newPuzzle(words,{height: 18, width:18, fillBlanks: false});
		    wordfind.print(puzzle);   
		        
		    $('#solve').click( function() {wordfindgame.solve(gamePuzzle, words);});
		        
		    </script>
		</div>
	</article>
</div>