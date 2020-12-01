<?php 
	namespace Views;

	use Controllers\respuestasController as Respuestas;
	use Classes\Method as Method;

	class Foro_topic{

		private $ids;
		private $idt;
		private $idu;
		private $titulo_tema;
		private $name;
		private $foto;
		private $user;
		private $page;
		private $admin;
		private $fec_lim;
		private $hor_lim;

		private $res;
		private $fun;

		public function funcion($funcion, $arg){
			$this->fun = new Method();
			$return = $this->fun->$funcion($arg);
			return $return;
		}

		public function __construct($idt, $perm_archivo, $titulo_tema, $lista_archivos, $page, $id_admin, $fec_limite, $hor_limite){
		$this->res = new Respuestas();

		if(isset($_SESSION['userSesion'])){
			$this->ids     = $_SESSION['userSesion']['id_session'];
			$this->idu     = $_SESSION['userSesion']['id'];
			$this->name    = $_SESSION['userSesion']['nombre_user'];
			$this->foto    = $_SESSION['userSesion']['foto'];
		}

			$this->titulo_tema  = $titulo_tema;
			$this->idt          = $idt;
			$this->page         = $page;
			$this->admin        = $id_admin;
			$this->fec_lim      = $fec_limite;
			$this->hor_lim      = $hor_limite;

			if($perm_archivo == 1){
				$this->user = 'allowf';
			}
			else{
				$this->user = null;
			}
?>
	<div class="contentForo">
<?php
		if(($this->idu) && isset($_SESSION['userSesion']) && ((date('Y-m-dH:i:s') <= $this->fec_lim.$this->hor_lim) || $this->fec_lim == NULL)):

 		$post_respuestas = array('idu' => $this->idu, 'idt' => $this->idt, 'ti' => $this->titulo_tema);
 		$post_respuestas = base64_encode(json_encode($post_respuestas));
?>
		<div class="comment_user">
		<div class="divFrmRespuestas">
		<form method="post" action="/respuestas/nuevo" id="frmForoR">
			<input type="text" id="titulo_respuesta" name="titulo_respuesta" class="inptxt" placeholder="Título de la respuesta..."><br><br>
			<input type="hidden" id="post_dats_respuestas" name="post_dats_respuestas" value="<?= $post_respuestas; ?>">
		</form>
		<?php 
			new Editor($this->user, null, $lista_archivos, 'responder', 'files_usr');
		 ?>
		</div>
		</div>
<?php
		else:
?>
		<span class="advice"><i class="material-icons">schedule</i>&nbsp;Terminó el tiempo para responder este tema</span>
<?php			
		endif;
?>
		<div id="foro">
<?php		
		
		$datos = $this->res->ver_todos($this->idt, $this->page);
		while($r = $datos->fetch_array()):
			$stars = $this->res->funcion('stars_points', $r['total_puntos']);
			$id = array('id' => $r['id'], 'idt' => $this->idt, 'pref' => 'pf');
			$id = base64_encode(json_encode($id));
			$id = str_replace("=", "-", $id);
?>		<div class="ancl"></div>
		<div class="content_comment" id="pf_<?= $id; ?>">
			<div class="head_comment">
				<div class="pictComment" style="<?php if($r['ids'] == 'FB')print "background-image: url(https://graph.facebook.com/$r[id_usuario]/picture?type=small);";?>">
				<?php 
					if($r['foto'] == 'none'):
				?>
					<i class="material-icons account-ico">account_circle</i>
				<?php 
					endif;
					if($r['foto'] != 'none' && $r['ids'] != 'FB'):
				?>
					<img src="/Views/template/images/pictures/<?= $r['foto'];?>" alt="<?= $r['nombre_user']; ?>_usuario">
				<?php
					endif;
				?>
				<div class="star_div"><i class="material-icons star_small">star</i><small>x&nbsp;<?= $stars; ?></small></div>
				</div>
				<a href="/usuarios/perfil/<?= $r['id_usuario'] ?>"><span><?= $r['nombre_user']; ?></span></a>
				<?php
					if($this->idu ==  $r['id_usuario']):
				?>
				<span class="del_respuesta"><i class="material-icons">delete</i></span>
				<?php
					elseif($this->idu == $this->admin):
				?>
				<div class="qualify">
				<input type="range" name="calif" value="<?= $r['calificacion']; ?>" min="0" max="10" class="range">
				<button class="btn btnPublish qualified"><small><?= $r['calificacion']; ?></small>&nbsp;pt.&nbsp;<i class="material-icons ico ico_btn">send</i></button>
				</div>
				<?php		
					endif;
				?>
			</div>
			<article>
				<h1 align="center"><?= $r['titulo_respuesta']; ?></h1>
				<div><?= html_entity_decode($r['respuesta']); ?></div><br><br>
				<span><i class="material-icons">watch_later</i>&nbsp;<?= $r['timestamp_respuesta']; ?></span>
			</article>
			<div class="foot_comment">
				<div class="foot_comment_votes">
					<div class="grateful"><i class="material-icons">favorite_border</i>&nbsp;<span><?= $r['gratificaciones']; ?></span></div>
					<div class="reply"><i class="material-icons">comment</i>&nbsp;<span class="hide_span">RESPONDE</span></div>
				</div>
				<div class="foot_comment_actions">
					<div class="view_replies_reply"><span><b>Ver&nbsp;<span class="num_replies"><?= $r['numero_respuestas']; ?></span>&nbsp;Resp.</b></span></div>
					<?php 
						if($this->idu == $this->admin && $r['id_usuario'] != $this->admin):
					?>
					<div class="del_respuesta"><i class="material-icons">delete</i>&nbsp;<span class="hide_span">Eliminar</span></div>
					<?php
						else:
					?>
					<div class="report"><i class="material-icons <?php if($this->idu != $r['id_usuario']) print'reprt'; ?>">flag</i>&nbsp;<span class="hide_span">Reportar</span></div>
					<?php
						endif;
					 ?>
				</div>
			</div>
			<?php
				if($this->idu):
					$post_reply_reply = array('id' => $r['id'], 'idu' => $this->idu);
					$post_reply_reply = base64_encode(json_encode($post_reply_reply));
			?>
			<div class="reply_comment">
				<div class="pict_reply" style="<?php if($this->ids == 'FB')print "background-image: url(https://graph.facebook.com/$this->idu/picture?type=small);";?>">
					<?php 
					if($this->foto == 'none'):
					?>
					<i class="material-icons account-ico">account_circle</i>
					<?php 
					endif;
					if($this->foto != 'none' && $this->ids != 'FB'):
					?>
					<img src="/Views/template/images/pictures/<?= $this->foto;?>" alt="<?= $this->name; ?>_usuario">
					<?php
					endif;
					?>
				
				</div>
				<div class="divfrm_reply">
					<form method="post" action="" id="frmRespuestaRespuestaForo">
						<textarea class="inptxt" id="respuesta_respuesta" name="respuesta_respuesta" placeholder="Respuesta..." required></textarea>
						<input type="hidden" id="post_reply_reply" name="post_reply_reply" value="<?= $post_reply_reply; ?>">
					</form>
				</div>
				<div class="div_buttons_reply">
					<div class="send_reply_reply"><span><i class="material-icons">send</i></span></div>
					<div class="cancel_reply cerrar_reply"><span><i class="material-icons">close</i></span></div>
				</div>
			</div>
			<?php
				endif;
			?>
			<div class="content_replies"></div>
		</div>

<?php
		endwhile;
?>	
		</div><br>
		<div class="linksPaginacion">
<?php
   if($datos->num_rows > 0):
	$pages = $this->res->paginar_respuestas($this->idt);
?>
		<a class="paginacion <?php if($this->page == 1)print 'sel'; ?> href_action" href="?page=1#foro">1</a>
<?php

	for ($i = $page; $i <= $page + 8; $i++):
		if($i != 1 && $i <= $pages):
?>
		<a class="paginacion href_action <?php if($this->page == $i)print 'sel'; ?>" href="?page=<?= $i; ?>#foro"><?= $i; ?></a>
<?php
		endif;
	endfor;
		if($i <= $pages):
?>
		<a href='?page=<?= $i; ?>#foro' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
<?php			
		endif;
   endif;		
?>
		</div><br>
	</div>
<?php

		}

	}


 ?>