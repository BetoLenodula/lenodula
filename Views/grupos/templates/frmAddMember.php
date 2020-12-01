				<div class="back_shadow">
				<form action="" method="post" id="frmAddMember" class="frmModal box">
					<i class="material-icons cerrarBox">closed</i><br><br>
					<div id="info_member_frm">
						<div></div><label class="frmlbl"></label>
					</div><br>
					<label for="n_grupo" class="frmlbl">Selecciona un grupo</label><br>
					<div class="contSelect">
					<select name="n_grupo" id="n_grupo">
 		 				<option>Grupos...</option>
 		 				<?php 
 		 					while($r = $grupos->fetch_array()):

 							$id_grp = array('id' => $r['id'], 'pos' => 'postfix_'.$r['id']);
 							$id_grp = base64_encode(json_encode($id_grp));
 		 				?>
 		 				<option value="<?= $id_grp; ?>"><?= $r['nombre_grupo']; ?></option>	
 		 				<?php		
 		 					endwhile;
 		 				 ?>
 		 			</select>
 		 			</div><br><br>
 		 			<input type="hidden" name="post_dats_usid" value="" id="post_dats_usid">
 					<input type="submit" name="add_miembro" value="Agregar"><br><br>
 				</form>
 				</div>
 				<script type="text/javascript" src="/Views/template/js/base64ende.js"></script>