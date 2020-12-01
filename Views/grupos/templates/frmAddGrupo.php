<div id="some_activity">
	<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<iframe width="90%" height="200" style="margin-left:5%; border-radius:8px;" src="https://www.youtube.com/embed/Tx1JcR5Y3q4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><br>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
	<article id="main">
		<div id="indexHeader" class="divHeader">
			<i class="material-icons">&#xE886;</i>
			<h1><?php if(isset($edit_theme) && $edit_theme == true): print 'Editar Grupo'; else: print 'Nuevo Grupo'; endif; ?></h1>
		</div>
		<div id="divAddGroup">
			<br>
			<form id="frmAddGrupo" method="post" action="/grupos/<?php if(isset($edit_theme) && $edit_theme == true):print 'editar';else: print 'nuevo'; endif; ?>" class="frm">
				<input class="inptxt" id="nombre_grupo" type="text" name="nombre_grupo" value="<?php if(isset($nomb_g)) print $nomb_g; ?>" placeholder="Nombre del Grupo..." maxlength="80" required><br><br>
				<textarea name="descripcion_grupo" id="descripcion_grupo" class="inptxt" maxlength="250" placeholder="Descripción del Grupo..." required><?php if(isset($descri)) print $descri; ?></textarea><br><br>
				<div class="contSelect">
					<select name="tipo_acceso" id="tipo_acceso">
						<option>Acceso...</option>	
						<option <?php if(isset($acceso) && $acceso == 'Cerrado') print 'selected'; ?>>Privado</option>
						<option <?php if(isset($acceso) && $acceso == 'Abierto') print 'selected'; ?>>Abierto</option>
					</select>
				</div><br><br>
				<?php 
					if(!isset($theme)):
				 ?>
				<label class="frmlbl">Elige un Icono para el Grupo</label><br><br>
				<table cellspacing="1" id="tableThemes">
					<tr>
						<td class="itheme"><i class="material-icons">&#xE84F;</i><p>school</p></td>
						<td class="itheme"><i class="material-icons">&#xE6E1;</i><p>chart</p></td>
						<td class="itheme"><i class="material-icons">&#xE30D;</i><p>Technology</p></td>
					</tr>
					<tr>
						<td class="itheme"><i class="material-icons">&#xE8E2;</i><p>Language</p></td>
						<td class="itheme"><i class="material-icons">&#xE80B;</i><p>Global</p></td>
						<td class="itheme"><i class="material-icons">&#xE80C;</i><p>Seminary</p></td>
					</tr>
					<tr>
						<td class="itheme"><i class="material-icons">&#xE1BD;</i><p>Math</p></td>
						<td class="itheme"><i class="material-icons">&#xE8DD;</i><p>Forum</p></td>
						<td class="itheme"><i class="material-icons">&#xE90E;</i><p>Legal</p></td>
					</tr>
					<tr>
						<td class="itheme"><i class="material-icons">&#xE8B8;</i><p>Engineer</p></td>
						<td class="itheme"><i class="material-icons">&#xE54B;</i><p>Read</p></td>
						<td class="itheme"><i class="material-icons">&#xE55B;</i><p>Plan</p></td>
					</tr>
					<tr>
						<td class="itheme"><i class="material-icons">&#xE560;</i><p>Blog</p></td>
						<td class="itheme"><i class="material-icons">&#xE63F;</i><p>Health</p></td>
						<td class="itheme"><i class="material-icons">&#xEB4C;</i><p>Nature</p></td>
					</tr>
					<tr>
						<td class="itheme"><i class="material-icons">&#xE40A;</i><p>Art</p></td>
						<td class="itheme"><i class="material-icons">&#xE56C;</i><p>Cook</p></td>
						<td class="itheme"><i class="material-icons">&#xE57D;</i><p>Economy</p></td>
					</tr>
					<tr>
						<td class="itheme"><i class="material-icons">&#xE1B1;</i><p>Devices</p></td>
						<td class="itheme"><i class="material-icons">&#xE91D;</i><p>Wild life</p></td>
						<td class="itheme"><i class="material-icons">&#xE407;</i><p>Harmony</p></td>
					</tr>
				</table><br><br>
				<?php 
					endif;

					if(isset($idg)):
				?>
				<input type="hidden" id="datpost" name="datpost" value="<?php if(isset($idg)) print $idg; ?>">
				<?php		
					endif;
				 ?>
				<input type="hidden" id="theme" name="theme" value="<?php if(isset($theme)) print $theme; ?>">
				<label class="frmlbl" for="color_theme">Elige un Color que identifique al Grupo</label><br><br>
				<input id="color_theme" type="color" name="color_theme" value="<?php if(isset($color)): print $color; else: print '#555555'; endif; ?>"><br><br><br>
				<?php 
					if(isset($edit_theme) && $edit_theme == true):
				?>
				<input type="submit" name="editar_grupo" value="GUARDAR CAMBIOS">
				<?php		
					else:
				?>
				<input type="submit" name="crear_grupo" value="CREAR GRUPO">
				<?php		
					endif;
				 ?>
			</form><br>
		</div>
	</article>
</div>