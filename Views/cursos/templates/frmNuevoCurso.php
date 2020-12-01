				<form action="/cursos/nuevo/" method="post" id="frmNuevoCurso" class="frm">
 					<input type="text" id="nombre_materia_curso" name="nombre_materia_curso" value="" class="inptxt" placeholder="Nombre del Curso..." required><br><br>
 					<input type="hidden" id="post_dats" name="post_dats" value="<?= $post_cur; ?>">
 					<input type="submit" name="crear_curso" value="Crear curso">
 				</form>