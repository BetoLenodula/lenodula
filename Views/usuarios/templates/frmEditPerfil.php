
							<form id="frmEditPerfil" class="frm" method="post" action="">
								<label for="nombre_user">nombre usuario (Rol <?= $rol; ?>)</label><br>
								<input type="text" id="nombre_user" class="inptxtalp" name="nombre_user" value="<?= $nombre_user; ?>" maxlength="15"><br><br><br>
								<label for="nombres">nombres</label><br>
								<input type="text" id="nombres" class="inptxtalp" name="nombres" value="<?= $nombres; ?>" maxlength="60"><br><br><br>
								<label for="apellidos">apellidos</label><br>
								<input type="text" id="apellidos" class="inptxtalp" name="apellidos" value="<?= $apellidos; ?>" maxlength="60"><br><br><br>
								<label for="email">Registrado desde: <?= $controlador->funcion("alfa_months", $fecha_ing); ?></label><br>
								 
								<label for="email">Email: <?= $email; ?></label><br><br><br>
								<input type="submit" name="updatePerfil" value="GUARDAR CAMBIOS">
							</form>