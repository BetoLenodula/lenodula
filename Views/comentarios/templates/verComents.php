<div id="some_activity">
	<div id="head_main_activity"><i class="material-icons">dashboard</i></div>
	<a href="https://lenodula.com" class="underl href_action">
		<p align="center"><i class="material-icons">language</i> https://lenodula.com</p>
	</a><br>
	<iframe width="90%" height="200" style="margin-left:5%; border-radius:8px;" src="https://www.youtube.com/embed/xaYYESUpdoE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><br>
	<p align="center">Desarrollado y distribuido por Lenodula. Lenodula <?= date('Y'); ?></p><br>
</div>
<div id="centralSection">
	<article id="main">
	<div class="divHeader" id="indexHeader">
		<i class="material-icons">loyalty</i>
		<h1>Menciones #</h1>
	</div><br>
	<div id="headHTAG">
		<p>&nbsp;<?= "#".$arg; ?></p>
	</div>
	<div class="contentForo">
	<div id="foro">	
<?php		
		
		
		while($r = $datos->fetch_array()):
			$id = array('id' => $r['id'], 'idg' => $r['id_grupo'], 'pref' => 'pf');
			$id = base64_encode(json_encode($id));
			$id = str_replace("=", "-", $id);
?>		
		<br><hr color="F8F8F8">
		<a href="/grupos/ver/<?= $controlador->funcion('normalize', $r['nombre_grupo']).'.'.$r['id_grupo'].'#warp_foro'; ?>" class="underl inline href_action">
			&nbsp;<i class="material-icons">launch</i>&nbsp;
			<span>IR AL FORO</span>
		</a>
		<div class="ancl" id="post-<?= $r['id'];?>"></div>
		<div class="content_comment" id="pf_<?= $id; ?>">
			<div class="head_comment">
				<div class="pictComment" style="<?php if($r['ids'] == 'FB'): print "background-image: url(https://graph.facebook.com/$r[id_usuario]/picture?type=small);"; endif; ?>">
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
					if(isset($_SESSION['userSesion']) && ($_SESSION['userSesion']['id'] ==  $r['id_usuario'])):
				?>
				<span class="del_comment"><i class="material-icons">delete</i></span>
				<?php
					endif;
				?>
			</div>
			<article>
				<p><?= $r['comentario']; ?></p><br><br>
				<span><i class="material-icons">watch_later</i>&nbsp;<?= $controlador->funcion("alfa_months", $r['fecha_comentario']); ?></span>
			</article>
			<div class="foot_comment">
				<div class="foot_comment_votes">
					<div class="like_c"><i class="material-icons">thumb_up</i>&nbsp;<span><?= $r['likes']; ?></span></div>
					<div class="dislike_c"><i class="material-icons">thumb_down</i>&nbsp;<span><?= $r['dislikes']; ?></span></div>
				</div>
				<div class="foot_comment_actions">
					<div class="view_replies"><span><b>Ver&nbsp;<span class="num_replies"><?= $r['numero_respuestas_comentario']; ?></span>&nbsp;Resp.</b></span></div>
					<div class="copy" id="/grupos/ver/<?= $controlador->funcion('normalize', $r['nombre_grupo']).'.'.$r['id_grupo'].'?c='.$r['id'].'#post-'.$r['id'];?>"><i class="material-icons">reply</i>&nbsp;<span class="hide_span">COPIAR</span></div>
				</div>
			</div>
			<div class="content_replies"></div>
		</div>

<?php
		endwhile;
?>	
	</div>
	</div>

		<div class="linksPaginacion">
<?php
	if($callback_datos->num_rows > 0):
	$pages = $controlador->paginar_destacados($arg);
?>
		<a class="paginacion <?php if($page == 1) print 'sel'; ?> href_action" href="?page=1">1</a>
<?php
	
	for ($i = $page; $i <= $page + 8; $i++):
		if($i != 1 && $i <= $pages):
?>
		<a class="paginacion href_action <?php if($page == $i) print 'sel'; ?>" href="?page=<?= $i; ?>"><?= $i; ?></a>
<?php
		endif;
	endfor;

		if($i <= $pages):
?>
		<a href='?page=<?= $i; ?>' class='more_pags'><i class='material-icons'>keyboard_arrow_right</i>...</a>
<?php
		endif;
	endif;	
?>
		</div><br>
	<script type="text/javascript" src="/Views/template/js/base64ende.js"></script>
	</article>
</div>