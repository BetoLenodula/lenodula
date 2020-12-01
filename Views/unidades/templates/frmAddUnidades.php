			
 		 <form id="frmUnidad" class="frmModal box" method="post" action="/unidades/nuevo">
			 <i class="material-icons cerrarBox">closed</i><br><br>
			 <label class="frmlbl" id="lblFrmUnidad"></label><br>
			 <input type="text" name="nombre_unidad" value="" id="nombre_unidad" class="inptxt" placeholder="Título del Módulo..."><br><br>
			 <label class="frmlbl">Número de Temas</label><br>
			 <input type="number" id="numero_temas" name="numero_temas" value="1" min="1" max="40"><br><br>
			 <input type="hidden" name="post_dats_un" value="" id="post_dats_un">
			 <input type="submit" name="submit_unidad" value="Crear Módulo"><br><br>		
 		 </form>