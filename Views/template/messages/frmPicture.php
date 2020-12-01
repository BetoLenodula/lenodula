				
					<form method="post" action="" enctype="multipart/form-data" class="frmFile box" id="frmPicture">
						<i class="material-icons cerrarBox">closed</i><br><br>
						<label for="foto" class="file-picker"><i class="material-icons">photo_camera</i> <span>Subir foto...</span></label><br><br>
						<img width="90" id="prev_pict"><br>
						<p class="namefile" id="pselectfoto">Selecciona una foto...</p><br>
						<input type="file" name="foto" value="" accept="image/*" id="foto">
						<input type="hidden" name="hidefoto" value="<?php print $foto; ?>">
						<input type="submit" name="guardar_foto" value="GUARDAR"><br><br>
					</form>