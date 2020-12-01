<?php 
	namespace Views;

	use Controllers\comentariosController as Comentarios;
	use Classes\Method as Method;

	class Foro{

		private $ids;
		private $idg;
		private $idu;
		private $name;
		private $foto;
		private $nombre_grupo;
		private $prop_grupo;
		private $miembro;
		private $page;

		private $com;
		private $fun;

		public function funcion($funcion, $arg){
			$this->fun = new Method();
			$return = $this->fun->$funcion($arg);
			return $return;
		}

		public function __construct($idg, $miembro, $nombre_grupo, $prop_grupo, $page){
		$this->com = new Comentarios();

		if(isset($_SESSION['userSesion'])){
			$this->ids     = $_SESSION['userSesion']['id_session'];
			$this->idu     = $_SESSION['userSesion']['id'];
			$this->name    = $_SESSION['userSesion']['nombre_user'];
			$this->foto    = $_SESSION['userSesion']['foto'];
		}

			$this->idg          = $idg;
			$this->miembro      = $miembro;
			$this->nombre_grupo = $nombre_grupo;
			$this->prop_grupo   = $prop_grupo;
			$this->page         = $page;
?>
	<div class="contentForo" id="warp_foro">
<?php
		if(($this->miembro == 1 || $this->prop_grupo == $this->idu) && isset($_SESSION['userSesion'])):

 		$post_foro = array('idu' => $this->idu, 'idg' => $this->idg, 'ng' => $this->nombre_grupo);
 		$post_foro = base64_encode(json_encode($post_foro));
?>
		<div class="comment_user">
		<div class="pictForo" style="<?php if($this->ids == 'FB')print "background-image: url(https://graph.facebook.com/$this->idu/picture?type=small);";?>" title="<?= $this->name; ?>">
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
		<div class="divFrmForo">
		<form method="post" action="/comentarios/nuevo" id="frmForo">
			<textarea id="comentario" name="comentario" class="inptxt" maxlength="1500" placeholder="Comentario..." required></textarea>
			<label class="frmlbl">*utiliza # hashtag para destacar menciones</label><br>
			<div id="pic_comm"></div>
			<div id="divSurvey">
				<input type="text" class="inptxt" maxlength="20" placeholder="Opción 1" id="opts1"	name="opts1" disabled="disabled"><br>
				<input type="text" class="inptxt" maxlength="20" placeholder="Opción 2" id="opts2"	name="opts2" disabled="disabled"><br><br><i class="material-icons" id="addoptsurv">add</i><br>
				<input type="text" class="inptxt" maxlength="20" placeholder="Opción 3" id="opts3"	name="opts3" disabled="disabled"><br>
				<input type="text" class="inptxt" maxlength="20" placeholder="Opción 4" id="opts4"	name="opts4" disabled="disabled"><br><br>
				<input type="hidden" name="survey" id="survey" disabled="disabled">
			</div>
			<input type="hidden" id="post_dats_foro" name="post_dats_foro" value="<?= $post_foro; ?>">
			<input type="hidden" id="pict_comment" name="pict_comment" value="">
			<input type="hidden" id="gif_comment" name="gif_comment" value="">
			<i class="material-icons" id="addpic_com">add_photo_alternate</i>&nbsp;&nbsp;&nbsp;<i class="material-icons" id="add_emoji">insert_emoticon</i>&nbsp;&nbsp;&nbsp;<i class="material-icons" id="add_giphies">gif</i>&nbsp;&nbsp;&nbsp;<i class="material-icons" id="add_survey">bar_chart</i>
			<input type="submit" name="guardar_coment" value="Publicar">
		</form>
			<div id="emojis_cont">
				<i class="material-icons cerrarBox">close</i><br>
				<button>🙂</button>
				<button>😀</button>
				<button>😃</button>
				<button>😄</button>
				<button>😂</button>
				<button>😍</button>
				<button>😘</button>
				<button>😜</button>
				<button>😐</button>
				<button>😏</button>
				<button>😔</button>
				<button>😷</button>
				<button>😪</button>
				<button>😴</button>
				<button>😎</button>
				<button>😭</button>
				<button>😱</button>
				<button>😡</button>
				<button>😈</button>
				<button>💩</button>
				<button>😺</button>
				<button>😹</button>
				<button>😼</button>
				<button>🙀</button>
				<button>😾</button>
				<button>🙈</button>
				<button>🙉</button>
				<button>🙊</button>
				<button>💓</button>
				<button>💕</button>
				<button>💔</button>
				<button>👋</button>
				<button>👌</button>
				<button>👈</button>
				<button>👉</button>
				<button>👆</button>
				<button>👇</button>
				<button>👍</button>
				<button>👎</button>
				<button>👊</button>
				<button>💪</button>
				<button>👶</button>
				<button>👦</button>
				<button>👧</button>
				<button>👨‍💻</button>
				<button>🚶</button>
				<button>🚶‍♀️</button>
				<button>💃</button>
				<button>💑</button>
				<button>👨‍❤️‍👨</button>
				<button>👩‍❤️‍💋‍👩</button>
				<button>🐶</button>
				<button>🐱</button>
				<button>🐯</button>
				<button>🐽</button>
				<button>🐭</button>
				<button>🐼</button>
				<button>🐻</button>
				<button>🐥</button>
			</div>
			<div id="cont_gif">
				<i class="material-icons cerrarBox">close</i><br><br>
				<div id="searching_dats">
					<input type="search" class="inptxt search_input" id="search_gif" placeholder="Buscar gif...">
					<button class="btn btnEdit" id="btn_search_gif"><i class="material-icons">search</i></button>
				</div>
				<video id="gif" autoplay="true" loop="true"></video>
				<i class="material-icons" id="add_gif_comm">check_circle</i>
				<img src="/Views/template/images/giphy_img.png" alt="giphy_logo">
			</div>
			<script type="text/javascript" src="/Views/template/js/giphy.js"></script>
			<script>
				document.getElementById('btn_search_gif').addEventListener('click', function(){
					var keyword = document.getElementById('search_gif').value;

					Giphy.getUrlAsync(keyword, function(gifURL){
						document.getElementById('gif').src = gifURL;
					});
				});

				document.getElementById('add_gif_comm').addEventListener('click', function(){
					var src = document.getElementById('gif').src;

					if(src != ''){
						document.getElementById('pic_comm').innerHTML = '<div><video src='+src+' width=100% autoplay=true loop=true></video><i class="material-icons">close</i></div>';
						document.getElementById('gif').src = "";
						document.getElementById('gif').removeAttribute('src');
						document.getElementById('pict_comment').value = "";
						document.getElementById('gif_comment').value = src;
					}
					else{
						msgAlert('Busca un GIF!!');
						cerrar_alert_focus('#search_gif');
					}
				});
			</script>
		</div>
		</div>
<?php
		endif;
?>
		<div id="foro">
<?php		
		
		$datos = $this->com->ver_todos($this->idg, $this->page);
		while($r = $datos->fetch_array()):
			$id = array('id' => $r['id'], 'idg' => $this->idg, 'pref' => 'pf');
			$id = base64_encode(json_encode($id));
			$id = str_replace("=", "-", $id);
?>		<div class="ancl" id="post-<?= $r['id'];?>"></div>
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
				</div>
				<a href="/usuarios/perfil/<?= $r['id_usuario'] ?>"><span><?= $r['nombre_user']; ?></span></a>
				<?php
					if($this->idu ==  $r['id_usuario']):
				?>
				<span class="del_comment"><i class="material-icons">delete</i></span>
				<?php
					endif;
				?>
			</div>
			<article>
				<p><?= $r['comentario']; ?></p><br><br>
				<span><i class="material-icons">watch_later</i>&nbsp;<?= $this->funcion("alfa_months", $r['fecha_comentario']); ?></span>
			</article>
			<div class="foot_comment">
				<div class="foot_comment_votes">
					<div class="like_c"><i class="material-icons">thumb_up</i>&nbsp;<span><?= $r['likes']; ?></span></div>
					<div class="dislike_c"><i class="material-icons">thumb_down</i>&nbsp;<span><?= $r['dislikes']; ?></span></div>
					<div class="reply"><i class="material-icons">comment</i>&nbsp;<span class="hide_span">RESPONDE</span></div>
				</div>
				<div class="foot_comment_actions">
					<div class="view_replies"><span><b>Ver&nbsp;<span class="num_replies"><?= $r['numero_respuestas_comentario']; ?></span>&nbsp;Resp.</b></span></div>
					<div class="copy" id="/grupos/ver/<?= $this->nombre_grupo.'.'.$this->idg;  ?>?c=<?= $r['id'].'#post-'.$r['id'];  ?>"><i class="material-icons">reply</i>&nbsp;<span class="hide_span">COPIAR</span></div>
				</div>
			</div>
			<?php
				if(($this->miembro == 1 || $this->prop_grupo == $this->idu) && $this->idu):
					$post_reply = array('id' => $r['id'], 'idu' => $this->idu, 'pag' => $this->page);
					$post_reply = base64_encode(json_encode($post_reply));
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
					<form method="post" action="" id="frmRespuestaForo">
						<textarea class="inptxt" id="respuesta_comentario" name="respuesta_comentario" placeholder="Respuesta..." required></textarea>
						<input type="hidden" id="post_reply" name="post_reply" value="<?= $post_reply; ?>">
					</form>
				</div>
				<div class="div_buttons_reply">
					<div class="send_reply"><span><i class="material-icons">send</i></span></div>
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
		$pages = $this->com->paginar_comentarios($this->idg);
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