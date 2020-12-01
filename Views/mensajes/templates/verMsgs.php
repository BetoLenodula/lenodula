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
			<i class="material-icons">mail</i>
			<h1>Mensajes</h1>
		</div><br>
		<div id="divViewMsgs">
			<?php 
				if(!empty($callback_datos)):
				  foreach($callback_datos as $datos):
			?>
			<a href="/usuarios/perfil/<?= $datos['ide']; ?>?msg=true" class="href_action">
			<div class="div_b_msgs">
				<div class="pic_b_msgs">
					<div style="<?php if($datos['ids'] == 'FB')print "background-image: url(https://graph.facebook.com/$datos[ide]/picture?type=large)";?>">
						<?php 
						if($datos['fot'] == 'none'){
						?>
						<img src="/Views/template/images/account_circle.svg" alt="<?= $datos['nom']; ?>_default">
						<?php 
						}
						if($datos['fot'] != 'none' && $datos['ids'] != 'FB'){
			
						?>
						<img src="/Views/template/images/pictures/<?= $datos['fot'];?>" alt="<?= $datos['nom']; ?>_imagen">
						<?php
						}
						?>
					</div>
				</div>
				<div class="cont_b_msgs">
					<span>&nbsp;<?= $datos['nom']; ?></span>
				</div>
				<div class="info_b_msgs">
					<div class="envel_div">
					<i class="material-icons envel">mail</i>
					<div class="notround"></div>
					</div>
				</div>
			</div>
			</a>
			<?php
				  endforeach;
				else:
			?>

			<i class="material-icons img_empty">mail_outline</i>
			<p class="advice">No tienes mensajes!!</p>
			<?php		
				endif;
			 ?>
		</div>
	</article>
</div>