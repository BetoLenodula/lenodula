		<div class="back_shadow" id="confirm_events">
		<form class="<?php if(isset($frmEv)): print 'frmEv'; else: print 'frmModal';endif; ?> box" id="frmEvent" action="/agendas/nuevoevento" method="post">
			<i class="material-icons cerrarBox">closed</i><br><br>
			<?php 
				if(isset($frmEv)):
			 ?>
			<input type="date" id="fecha_evento" name="fecha_evento" value="" class="inpdate">
			<?php 
				else:
			?>
			<label class="frmlbl date_event"></label>
			<input type="hidden" id="post_data_event" name="post_data_event" value="">
			<?php		
				endif;
			 ?>
			 <img src="/Views/template/images/calendario.svg" alt="eventos" width="40"><br><br>
			<input type="text" class="inptxt" id="descripcion_evento" name="descripcion_evento" value="<?php if(isset($nomev)): print $nomev; endif; ?>" placeholder="Nombre del Evento..."><br><br>
			<label for="hora_evento" class="frmlbl">Hora del Evento</label><br>
			<input type="time" id="hora_evento" name="hora_evento" value="" class="inptime"><br><br>
			<div class="contSelect">
				<select name="tipo_evento" id="tipo_evento">
					<option>Tipo...</option>
					<option>Tarea</option>
					<option>Leer</option>
					<option>Recordatorio</option>
					<option>Exámen</option>
					<option>Otro</option>
				</select>
			</div><br><br>
			<?php 
				if(isset($url_this)):
			?>
			<input type="hidden" id="reference" name="reference" value="<?= base64_encode($url_this); ?>">
			<?php		
				endif;
			 ?>
			<input type="submit" name="event_submit" value="Guardar Evento">		
		</form>
		</div>
		<?php 
			if(isset($frmEv)):
		?>
		<script type="text/javascript" src="/Views/template/js/calendar.js"></script>
		<?php
			endif;
		 ?>