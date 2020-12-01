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
			<i class="material-icons">event</i>
			<h1>Agenda</h1>
		</div><br>
		<div id="divEvents">
			<?php 
				if(isset($_SESSION['userSesion'])):
			?>	
				<div id="ag">
				<p class="quote" align="center">
				<i class="material-icons">exposure</i>&nbsp;
				<span class="advice">+agrega eventos o quita eventos...</span>&nbsp;
				</p>
				</div>
			<?php
				else:
			?>
				<div id="ag">
				<p class="quote" align="center">
				<a href="/usuarios/ingresar" class="href_action inline underl">
				<i class="material-icons">lock_open</i>&nbsp;
				<span class="advice">inicia sesión para agregar fechas...</span>&nbsp;
				</a>
				</p>
				</div>
			<?php
				endif;
			 ?>
			<div id="backForwDate">
				<a href="/agendas/ver/<?= $yb.'-'.($mb - 1) ?>#ag">
					<button class="btn btnRegular">
						&nbsp;&nbsp;&nbsp;&nbsp;
					<i class="material-icons">arrow_back_ios</i>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</button>
				</a>
				<a href="/agendas/ver/<?= $yf.'-'.($mf + 1) ?>#ag">
					<button class="btn btnRegular">
						&nbsp;&nbsp;&nbsp;&nbsp;
						<i class="material-icons">arrow_forward_ios</i>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</button>
				</a>
			</div>
		<?php 
			new Views\Calendar($m, $y, null, 'inline', null, $eventos, $alertas);		 
		?>
		</div>
		<?php 
			if (isset($_SESSION['userSesion'])):
				include_once("frmEvent.php");
				include_once(MSG."confirm.php");
			endif;
		 ?>
		<div class="space" id="lEvents"></div>
		<div id="listEvents">
			<div class="btriangulo arrowd"></div>
			<div id="head_cont_events"></div>
			<div id="contain_events_l">
				<i class="material-icons empty_font">event_busy</i>
			</div>
		</div>
		<script type="text/javascript" src="/Views/template/js/base64ende.js"></script>
		<script type="text/javascript" src="/Views/template/js/calendar.js"></script>	
	</article>
</div>