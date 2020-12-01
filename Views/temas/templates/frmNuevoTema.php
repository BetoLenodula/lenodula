		
 		 <form id="frmTema" class="frmModal box" method="post" action="/temas/nuevo/">
 		 	<i class="material-icons cerrarBox">closed</i><br><br>
 		 	<label class="frmlbl" id="lblFrmCurso"></label><br>
 		 	<input type="text" id="titulo" name="titulo" value="" class="inptxt" placeholder="Título del tema..." required><br><br>
 		 	<label for="fecha_limite_respuesta" class="frmlbl">Fecha límite para admitir respuestas (*opcional)</label><br>
 		 	<input type="date" id="fecha_limite_respuesta" name="fecha_limite_respuesta" value="" class="inpdate">
 		 	<br><label class="frmlbl" for="hora_limite_respuesta" id="hrlresp">Hora límite</label><br>
				<input type="time" class="inptime" id="hora_limite_respuesta" name="hora_limite_respuesta" value="" disabled="disabled"><br><br>
 		 	<div class="contSelect">
 		 	<select name="permiso_archivo" id="permiso_archivo">
 		 		<option>¿Permitir archivos?...</option>
 		 		<option>Sí</option>
 		 		<option>No</option>
 		 	</select>
 		 	</div>
 		 	<br><br>
 		 	<input type="hidden" name="post_dats_t" value="" id="post_dats_t">
 		 	<input type="submit" name="submit_tema" value="Crear tema individual"><br><br>
 		 	<p class="href_style" id="add_unidad"><b>O CREA UN MÓDULO DE TEMAS <i class="material-icons">widgets</i></b></p><br>
 		 </form>