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
			<i class="material-icons">&#xEB4F;</i>
			<h1>Ingresar</h1>
		</div>
		<div id="divSignin">
			<br><br>
			<form id="frmIngreso" action="" method="post" class="frm">
				<input class="inptxt" id="lemail" type="email" name="email" value="" placeholder="Email..." maxlength="60" required><br><br>
				<input class="inptxt" id="lpassword" type="password" name="password" value="" placeholder="Password..." maxlength="15" required><br><br><br>
				<input id="iniciar_sesion" type="submit" name="ingresar" value="INICIAR SESIÓN">
				<a class="href_action" href="/usuarios/auth_facebook">
				<div id="facebookInit">
					&nbsp;&nbsp;<span>INICIAR CON</span> &nbsp;<img src="/Views/template/images/fbwhite.png">&nbsp;&nbsp;
				</div>
				</a><br><br><br>
				<hr color="C9DEE1"><br>
				<p id="displayFrmReg"><i class="material-icons">how_to_reg</i>&nbsp;CREAR UNA CUENTA NUEVA</p>
			</form>
			<br>
			<form id="frmRegistro" action="" method="post" class="frm">
				<input class="inptxt" id="nombre_user" type="text" name="nombre_user" value="" placeholder="Nick o nombre de usuario..." maxlength="15" required><br><br>
				<input class="inptxt" id="nombres" type="text" name="nombres" value="" placeholder="Nombres..." maxlength="80" required><br><br>
				<input class="inptxt" id="apellidos" type="text" name="apellidos" value="" placeholder="Apellidos..." maxlength="80" required><br><br>
				<input class="inptxt" id="email" type="email" name="email" value="" placeholder="Email real válido..." maxlength="60" required><br><br>
				<input class="inptxt" id="remail" type="email" name="remail" value="" placeholder="Repetir Email..." maxlength="60" required><br><br>
				<input class="inptxt" id="password" type="password" name="password" value="" placeholder="Crear password..." maxlength="15" required><br><br>
				<input class="inptxt" id="rpassword" type="password" name="rpassword" value="" placeholder="Repetir password..." 
				maxlength="15" required><br><br>
				<div class="contSelect">
					<select name="rol" id="selectrol">
						<option class="selected">Rol...</option>	
						<option>Usuario</option>
						<option>Tutor</option>
					</select>
				</div><br>
				<input type="submit" name="registrar" value="CREAR CUENTA"><br><br>
				<p id="displayFrmInit"><i class="material-icons">vpn_key</i>&nbsp;&nbsp;O INICIAR SESIÓN</p>
			</form><br>
		</div>
	</article>
</div>