<?php 
	namespace Views;

	use Classes\Method as Method;


	class Editor{
		private $function;

		public function funcion($funcion, $arg){
			$this->funcion = new Method();
			$return = $this->funcion->$funcion($arg);
			return $return;
		}

		public function __construct($user, $html, $list_files, $act_submit, $rsrc){
?>
		<br>
		<div id="editor">
			<div id="tools">
				<button id="link" title="Insertar Link"><i class="material-icons">link</i></button>
				<button id="unlink" title="Quitar Link"><i class="material-icons">link_off</i></button>
<?php
	if($user == 'root' || $user == 'allowf'){
?>				<button id="canvas_pen"><i class="material-icons" title="Tablero" style="color:#000;">gesture</i></button>
				
				<div id="div_canvas">
					<div id="cont_canvas">
					<i class="material-icons cerrarBox">close</i>
					<canvas></canvas>
					<div id="color_pen"><span>color</span>&nbsp;<input type="color" id="color_canv_pen" value="#000000"></div>
					<div id="size_pen"><i class="material-icons s1" id="1s">radio_button_unchecked</i>&nbsp;<i class="material-icons s3" id="3s">radio_button_unchecked</i>&nbsp;<i class="material-icons s6" id="6s">radio_button_unchecked</i>&nbsp;<i class="material-icons s10" id="10s">radio_button_unchecked</i>&nbsp;<i class="material-icons s12" id="12s">radio_button_unchecked</i></div>
					<div id="tool_canvas">
						<button id="btn_color_pen" title="Color"><i class="material-icons">format_color_fill</i></button>
						<button id="btn_size_pen" title="Tamaño del pincel"><i class="material-icons">brush</i></button>
						<button id="del_canvas" title="Goma"><i class="material-icons">crop_portrait</i></button>
						<button id="clear" title="Borrar todo"><i class="material-icons">tab_unselected</i></button>
						<label id="add_pic" title="Cargar una imagen" for="add_pcanv"><i class="material-icons">add_photo_alternate</i></label>
						<input type="file" id="add_pcanv" accept="image/png, image/jpeg">
						<button id="save_canvas" title="Guardar"><i class="material-icons">save</i></button>
					</div>
					</div>
				</div>
				<button class="open_file_box ed" title="Subir Archivo"><i class="material-icons">attach_file</i></button>
				<form id="frmAttach" action="" method="post" enctype="multipart/form-data" class="frmFile box">
					<i class="material-icons cerrarBox">closed</i><br><br>
					<label for="archivo" class="file-picker"><i class="material-icons">file_upload</i> <span>Cargar archivo...</span></label>&nbsp;&nbsp;&nbsp;
					<label id="btnComenzarGrabacion" class="file-picker"><i class="material-icons">mic</i></label>
        			<label id="btnDetenerGrabacion" class="file-picker"><i class="material-icons">stop</i></label><br><br>
        			<select name="listaDeDispositivos" id="listaDeDispositivos"></select>&nbsp;&nbsp;<label id="duracion"></label><br><br>
					<p class="" id="pselectfile">Selecciona un archivo...</p><br>
					<input type="file" name="archivo" value="" id="archivo">
					<input type="submit" name="guardar_archivo" value="ADJUNTAR"><br><br>
				</form>
				<script src="/Views/template/js/record.js"></script>
<?php				
	}
?>
				<button id="insertimage" title="Insertar Imágen"><i class="material-icons">insert_photo</i></button>
				<button id="video" title="Insertar Video de Youtube"><i class="material-icons">videocam</i></button>
				<button id="table" title="Insertar Tabla"><i class="material-icons">border_all</i><div id="tbldin"></div></button>
<?php 
	if($user == 'root'){
 ?>
				<button id="check" title="Insertar un check box"><i class="material-icons">ballot</i></button>
				<button id="txtareainsert" title="Insertar un campo de texto"><i class="material-icons">crop_7_5</i></button>
				<button id="seloptions" title="Insertar un selector"><i class="material-icons">menu_open</i></button>
				<button id="quest" title="Insertar un bloque de pregunta para examen"><i class="material-icons">live_help</i></button>
<?php 
	}
 ?>
				<button id="select" title="Seleccionar Todo"><i class="material-icons">select_all</i></button>
				<button id="undo" title="Deshacer"><i class="material-icons">undo</i></button>
				<button id="redo" title="Rehacer"><i class="material-icons">redo</i></button>
				<button id="delete" title="Quitar formato a Texto Seleccionado"><i class="material-icons">wb_iridescent</i></button>
				<button id="bold" title="Negrita"><i class="material-icons">format_bold</i></button>
				<button id="italic" title="Cursiva"><i class="material-icons">format_italic</i></button>
				<button id="underline" title="Subrayado"><i class="material-icons">format_underlined</i></button>
				<button id="forecolor" title="Color de Texto"><i class="material-icons" style="color:#D46D6A;">format_color_text</i></button>
				<button id="hilitecolor" title="Marcador"><i class="material-icons">border_color</i></button>
				<div id="color_text">
					<i class="material-icons">format_color_text</i>&nbsp;<span>color</span>
					<input type="color" name="color" value="#000000">
				</div>
				<button id="title" title="Poner Como Título"><i class="material-icons">title</i></button>
				<button id="quote" title="Citar"><i class="material-icons">format_quote</i></button>
				<button id="alignfull" title="Justificar"><i class="material-icons">format_align_justify</i></button>
				<button id="alignleft" title="Alinear Izquierda"><i class="material-icons">format_align_left</i></button>
				<button id="aligncenter" title="Centrar"><i class="material-icons">format_align_center</i></button>
				<button id="alignright" title="Alinear Derecha"><i class="material-icons">format_align_right</i></button>
				<button id="orderl" title="Lista Numerada"><i class="material-icons">format_list_numbered</i></button>
				<button id="unorderl" title="Lista en Viñetas"><i class="material-icons">format_list_bulleted</i></button>
<?php 
	if($user == 'root'){
 ?>
				<button id="actdinam" title="Actividades extra plugins"><i class="material-icons" style ="color:#10ADC3;">category</i>
					<div>
						<a href="" id="urlwrfind" class="href_action underl inline"><span><img src="/Views/template/images/wordfind.svg" alt="wordfind" width="17">Sopa de letras</span></a><br>
						<a href="" id="urlguessw" class="href_action underl inline"><span><img src="/Views/template/images/guessword.svg" alt="guessword" width="16">Juego del ahorcado</span></a><br>
						<a href="" id="urltline" class="href_action underl inline"><span><img src="/Views/template/images/timeline.svg" alt="timeline" width="16">Línea de tiempo</span></a>
					</div>
				</button>
<?php 
	}
 ?>
				<div id="divselect" title="Tipo de fuente">
					<select id="fontselect">
						<option>Fuente..</option>
						<option>Arial</option>
						<option>Open Sans</option>
						<option>Work Sans</option>
						<option>Verdana</option>
						<option>Trebuchet</option>
						<option>Helvetica</option>
						<option>Tahoma</option>
						<option>Times</option>
						<option>Roboto</option>
						<option>Lato</option>
						<option>Oswald</option>
					</select>
				</div>
			</div>
			<div id="txthtml" contenteditable="true"><?php if($html)print html_entity_decode($html);?></div>
			<button class="btn btnPublish" id="<?= $act_submit; ?>">
				<i class="material-icons ico">publish</i>&nbsp;<i><?php if($act_submit == 'comentar'){ print 'Guardar Cambios';}if($act_submit == 'responder'){ print 'Publicar';} ?></i>
			</button>
			<button id="newline" title="Insertar nueva línea" class="tool"><i class="material-icons">wrap_text</i></button>
		</div>
		<?php  if($user == 'root' || $user == 'allowf'){ ?>
		<div id="archivosVisor">
			<div id="headArchivosVisor"> 
			<button class="btn btnEdit open_file_box"><i class="material-icons ico">attach_file</i>&nbsp;<span>Carga archivos..</span></button>
			<p class="ad_harch"><span class="advice"><i class="material-icons rota">touch_app</i><i class="material-icons">content_paste</i>&nbsp;pegar</span></p>
			</div>
			<div id="bodyArchivosVisor">
			<?php
				 while ($d = $list_files->fetch_array()):
				 	$typfile = $this->funcion('returnClassExt', $d['id_archivo']);
			?>
			<div class="files_div" id="<?= base64_encode($d['id']); ?>">
				<div class="file_elem <?= $typfile; ?>" style="<?php if($typfile == 'attach_image')print '--bkimg:'.'url(/Resources/'.$rsrc.'/'.$d['id_archivo'].')';?>" title="<?= $d['nombre_archivo']; ?>">	
					<a href="/Resources/<?= $rsrc; ?>/<?= $d['id_archivo']; ?>" download="<?= $d['nombre_archivo']; ?>"><?php if(strlen($d['nombre_archivo']) > 26):print substr($d['nombre_archivo'],0,26).".."; else:print $d['nombre_archivo']; endif; ?>&nbsp;
					</a>
				</div>	
				<div class="action_file">
					<div><button class="insert_file btn"><i class="material-icons">content_paste</i></button></div>
					<div><i class="material-icons i_delete delete_file">delete</i></div>
				</div>
			</div>
			<?php
				 endwhile;
			 ?>
			</div>
		</div>
		<?php  } ?>
		<script type="text/javascript" src="/Views/template/js/editor.js"></script>
		<?php  
		if($user == "root"){
		?>
		<div id="unload"></div>
		<?php 
		}
		 ?>
<?php
		}

	}



 ?>