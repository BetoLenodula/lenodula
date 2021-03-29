	
	function get_dats_divcomment(arg, idarg){
		if(idarg === null){
			var parnt = $(arg).parents('.content_comment'); 
			var idc = $(parnt).attr('id');
		}

		if(arg === null){
			idc = idarg;
		}

 		idc = idc.split('_');
		idc = idc[1].replace(/-/g, "=");
		idc = Base64.decode(idc);
		idc = JSON.parse(idc);
		return idc;
	}

	function get_resps_comments(dats, ses, arg, type){
		var str = "";
		if(type == 'r'){
			menc = 'rmenc';
			more = 'more_res_coms';
		}
		else if(type = 'rr'){
			menc = 'rmencr';
			more = 'more_res_comsr';
		}

		if(JSON.stringify(dats) != '[]'){
			$.each(dats, function(i){
				var fot = "";

				if(dats[i].fot == 'na'){
				fot = "<div class='pic_img_resp' style='background-image:url(https://graph.facebook.com/"+ dats[i].idu +"/picture?type=small);'></div>";
				}
				else if(dats[i].fot == 'none'){
				fot = "<div class='pic_img_resp'><i class='material-icons ico_replies'>account_circle</i></div>";
				}
				else{
				fot = "<div class='pic_img_resp' style='background-image:url(/Views/template/images/pictures/"+ dats[i].fot + ");'></div>";
				}
				str = str+"<div class='content_reply' id='"+dats[i].idr+"-rc'>"
						 +"<a href='/usuarios/perfil/"+ dats[i].idu +"' class='usresco'>"+ fot +"</a>"
						 +"<div class='body_reply'><p><b>"+dats[i].nom+"</b> "+ dats[i].res +"<br>"
						 if(responder && ses != dats[i].idu){
						 str = str+"<a class='mencionar_resp'><small>Responder</small></a>"
						 }
						 str = str+"</p>"
						 if(responder && ses != dats[i].idu){
						 str = str+"<div class='patresmenc'>"
						 +"<div class='resmenc' contenteditable='true'></div><div class='"+menc+"'><i class='material-icons'>send</i></div><div class='crmenc'><i class='material-icons'>close</i></div>"
						 +"</div>"
						 }
						 str = str+"<span>"+ dats[i].fec +"</span></div>"
						 +"</div>"
			})
			if(dats.length > 4 && arg != null){
				str = str+"<a class='underl "+more+"'>VER MÁS<i class='material-icons'>expand_more</i></a>";
			}
		}
		else{

		}
		return str;
	}

	var com = $('#comentario');
	com.on('change drop keydown cut paste', function() {
  		com.height('auto');
		com.height(com.prop('scrollHeight'));
	});


	$('.cerrar_reply').click(function(){
		$(this).parents('.reply_comment').fadeOut(200);
	})

	$('.reply').click(function(){
		if($(this).closest('.content_comment').find('#frmRespuestaForo, #frmRespuestaRespuestaForo').length){
		$(this).parents('.content_comment').find('.reply_comment').fadeIn(200);
		$(this).parents('.content_comment').find('.foot_comment').css({'position':'absolute'});	
		$(this).parents('.content_comment').find('.content_replies').hide();
		}
		else{
			msgAlert('Unete al grupo para poder Responder!!');
			cerrar_alert_focus();
		}
	})



	$('#add_survey').click(function(){
		if(!$('#divSurvey').is(':visible')){
			$(this).text('close');
			$('#divSurvey').show();
			$('#opts1, #opts2, #survey').removeAttr('disabled');
			$('#comentario').attr('placeholder', 'Hacer una pregunta...');
		}
		else{
			$(this).text('bar_chart');
			$('#divSurvey').hide();
			$('#opts1, #opts2, #opts3, #opts4, #survey').attr('disabled', 'disabled');
			$('#opts3, #opts4').hide();
			$('#addoptsurv').text('add');
			$('#comentario').attr('placeholder', 'Comentario...');
		}
	})

	$('#addoptsurv').click(function(){
		if($(this).text() == "remove" && $('#opts4').is(':visible')){
			$('#opts4').hide();
			$('#opts4').attr('disabled', 'disabled');
		}
		else if($(this).text() == "remove" && !$('#opts4').is(':visible')){
			$('#opts3').hide();
			$('#opts3').attr('disabled', 'disabled');
			$(this).text('add');
		}
		else{
			if(!$('#opts3').is(':visible')){
				$('#opts3').show();
				$('#opts3').removeAttr('disabled');
			}
			else{
				$('#opts4').show();
				$('#opts4').removeAttr('disabled');
				$(this).text('remove');
			}
		}
	})

	 $('.copy').click(function(){
    	copy(null, $(this).attr('id'));
    	if($('.msg_delay').length == 0){
			msg_fade("ENLACE COPIADO");
    	}

    })

	 $('.report').click(function(){
	 	me = $(this);
	 	if($(me).find('.reprt').length){
		 	var idc = get_dats_divcomment($(me), null);
		 	var id = idc['id'];
			var pre = idc['pref'];
			var exprInt = /^\d*$/;

			if(!exprInt.test(id)){
				location.reload();
			}
			if(pre != 'pf'){
				location.reload();
			}
			
			$(me).attr('disabled', 'disabled');
			$.ajax({
				 url: '/respuestas/reportar',
				type: 'post',
				data: {idr: id, post_type: 'ajax'}
			}).done(function(info){
				if(info == "true"){
					if($('.msg_delay').length == 0){
						msg_fade("GRACIAS, SE ENVIÓ TU REPORTE!");
					}
				}
				if(info == "ses"){
					msgAlert('Inicia sesión para realizar la acción!');
					cerrar_alert_focus();
				}
				if(info == "exist"){
					msgAlert("Ya habías reportado esa respuesta!");
					cerrar_alert_focus();
				}
				$(me).removeAttr('disabled');
			})
		}

	 })


	$('.view_replies').click(function(){
		var cont = $(this).parents('.content_comment');

		if(!$(cont).find('.content_replies').is(':visible')){
			$(cont).find('.foot_comment').css({'position':'static'});
			$(cont).find('.content_replies').fadeIn(200);
			$(cont).find('.reply_comment').hide();
		}
		else{

			$(cont).find('.foot_comment').css({'position':'absolute'});
			$(cont).find('.content_replies').hide();
		}

		if($(cont).find('.content_replies').is(':empty')){
			var idc = get_dats_divcomment($(this), null);


			var id = idc['id'];
			var pre = idc['pref'];
			var exprInt = /^\d*$/;

			if(!exprInt.test(id)){
				location.reload();
			}
			if(pre != 'pf'){
				location.reload();
			}

			if($('#frmRespuestaForo').length > 0){
				responder = true;
			}
			else{
				responder = false;
			}

			ses = $('#showUser').attr('class');

			$('.spinner').show();
			$.get('/respuestascomentario/ver/todo', {get_type: 'ajax', idc: id}, function(dats){
				str = get_resps_comments(dats, ses, true, 'r');
				$(cont).find('.content_replies').html(str);
				$('.spinner').hide();	
			}, 'json')

		}
			
	})

	$('.content_replies').on('click', '.more_res_coms', function(){
		me = $(this);
		limit = 0;
		var idc = get_dats_divcomment($(this), null);
		var id = idc['id'];

		$(me).closest('.content_replies').find('.content_reply').each(function(){
			limit++;
		})

		ses = $('#showUser').attr('class');

		$('.spinner').show();
		$.get('/respuestascomentario/ver/mas', {get_type: 'ajax', lim: limit, idc: id}, function(dats){
			str = get_resps_comments(dats, ses, null, 'r');
			$(str).insertBefore(me);
			$('.spinner').hide();	
		}, 'json')

	})

	$('.content_replies').on('click', '.mencionar_resp', function(){
		txt = $(this).closest('.content_reply').find('b').text();
		res = $(this).closest('.content_reply').find('.patresmenc .resmenc');
		menc = $(this).closest('.content_reply').find('.usresco').attr('href');
		$(this).closest('.content_reply').find('.patresmenc').show();

		res.html('<a href='+menc+' class=arrob>@'+txt+'</a>&nbsp;');
	})

	sendmencion = false;
	$('.content_replies').on('click', '.rmenc', function(){
		var frm = $(this).closest('.content_comment').find('#frmRespuestaForo');
		var exprReply = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\'\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^\<\>\@]{1,500}$/;
		var exprIdUniq = /^[0-9a-z]{15,16}$/;
		var exprInt    = /^\d*$/;
		var datsFrm = $(frm).serializeArray();

		var post_reply = datsFrm[1].value;
		resp = $(this).closest('.patresmenc').find('.resmenc');
		reply = resp.html();

		pr = Base64.decode(post_reply);
		pr = JSON.parse(pr);

		var idc = pr['id'];
		var idu = pr['idu']
		var pag = pr['pag'];

		men = $(this).closest('.content_reply').find('.usresco').attr('href');
		men = men.split('/');
		men = men[3];

		if(reply == ''){
			msgAlert('Escribe una respuesta!!');
			cerrar_alert_focus($(resp));
			return false;
		}
		if(reply.length > 500){
			msgAlert('Tu respuesta es muy larga!!');
			cerrar_alert_focus($(resp));
			return false;
		}
		if(!exprReply.test(reply)){
			msgAlert('En tu respuesta NO utilices cacacteres no permitidos!!');
			cerrar_alert_focus($(resp));
			return false;
		}

		if(!exprInt.test(idc)){
			location.reload();
		}
		if(!exprIdUniq.test(idu)){
			location.reload();
		}
		if(!exprInt.test(pag)){
			location.reload();
		}

		$('.spinner').show();
		if(sendmencion == false){
			sendmencion = true;
		$.post('/respuestascomentario/nuevo', {post_type: 'ajax', idco: idc, idus: idu, resp: reply, page: pag, menc: men} ,function(info){
			if(info == 'true'){
				resp.html('');
				$(resp).parent().hide();
				var nr = parseInt($(frm).parents('.content_comment').find('.num_replies').text()) + 1;
				$(frm).parents('.content_comment').find('.num_replies').text(nr);
				sendmencion = false;
				$('.spinner').hide();
				msg_fade("RESPUESTA ENVIADA");
			}
		});

		}

	})

	$('.content_replies').on('click', '.crmenc', function(){
		$(this).closest('.patresmenc').hide();
	})


	var sendreply = false;
	$('.send_reply').click(function(){
		var frm = $(this).parents('.reply_comment').find('#frmRespuestaForo');
		var datsFrm = $(frm).serializeArray();
		var exprReply = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\'\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^]{1,500}$/;
		var exprIdUniq = /^[0-9a-z]{15,16}$/;
		var exprInt    = /^\d*$/;

		var reply = datsFrm[0].value;
		var post_reply = datsFrm[1].value;

		pr = Base64.decode(post_reply);
		pr = JSON.parse(pr);

		var idc = pr['id'];
		var idu = pr['idu']
		var pag = pr['pag'];
		
		if(reply == ''){
			msgAlert('Escribe una respuesta!!');
			cerrar_alert_focus($(frm).find('textarea'));
			return false;
		}
		if(reply.length > 500){
			msgAlert('Tu respuesta es muy largo!!');
			cerrar_alert_focus($(frm).find('textarea'));
			return false;
		}
		if(!exprReply.test(reply)){
			msgAlert('En tu respuesta NO utilices cacacteres no permitidos!!');
			cerrar_alert_focus($(frm).find('textarea'));
			return false;
		}

		if(!exprInt.test(idc)){
			location.reload();
		}
		if(!exprIdUniq.test(idu)){
			location.reload();
		}
		if(!exprInt.test(pag)){
			location.reload();
		}

		$('.spinner').show();
		if(sendreply == false){
			sendreply = true;
		$.post('/respuestascomentario/nuevo', {post_type: 'ajax', idco: idc, idus: idu, resp: reply, page: pag, menc: 'null'} ,function(info){
			if(info == 'true'){
				$(frm).find('textarea').val('');
				var nr = parseInt($(frm).parents('.content_comment').find('.num_replies').text()) + 1;
				$(frm).parents('.content_comment').find('.num_replies').text(nr);
				sendreply = false;
				$('.spinner').hide();
				msg_fade("RESPUESTA ENVIADA");
			}
		});

		}
	})

	var sendcomentario = false;
	$('#frmForo').submit(function(){
		var comentario = $('#comentario').val();
		var pd = $('#post_dats_foro').val();
		pd = Base64.decode(pd);
		pd = JSON.parse(pd);

		var id_usuario = pd['idu'];
		var nombre_grupo = pd['ng'];
		var id_grupo = pd['idg'];
		
		var exprComent = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\'\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^\<\>\🙂\😀\😃\😄\😂\😍\😘\😜\😐\😏\😔\😷\😪\😴\😎\😭\😱\😡\😈\💩\😺\😹\😼\🙀\😾\🙈\🙉\🙊\💓\💕\💔\👋\👌\👈\👉\👆\👇\👍\👎\👊\💪\👶\👦\👧\👨‍💻\🚶\🚶‍♀️\💃\💑\👨‍❤️‍👨\👩‍❤️‍💋‍👩\🐶\🐱\🐯\🐽\🐭\🐼\🐻\🐥]{1,1500}$/;
		var exprOpt = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^]{1,20}$/;
		var exprIdUniq = /^[0-9a-z]{15,16}$/;
		var exprNG	   = /^[0-9a-z\_\s]{3,80}$/;
		var exprInt    = /^\d*$/;


		if(comentario == ''){
			msgAlert('Falta tu comentario o pregunta!!');
			cerrar_alert_focus('#comentario');
			return false;
		}

		var surv = "";

		if($('#divSurvey').is(':visible')){
			for(var id = 1; id <= 4; id++){
				if(!$('#opts'+id).attr('disabled')){
					if($('#opts'+id).val() == ''){
						msgAlert('Indica la opción '+id);
						cerrar_alert_focus('#opts'+id);
						return false;
					}
					if($('#opts'+id).val().length > 20){
						msgAlert('La opción debe ser más breve!!');
						cerrar_alert_focus('#opts'+id);
						return false;
					}
					if(!exprOpt.test($('#opts'+id).val())){
						msgAlert('No incluyas caracteres extraños!!');
						cerrar_alert_focus('#opts'+id);
						return false;
					}
					surv+= "<br><meter value=0 min=0 max=1></meter> "+$('#opts'+id).val();
				}
				else{
					comentario+= surv;
					$('#survey').val('<br>'+surv);
				}	
			}
		}
		
		if(comentario.length > 1500){
			msgAlert('Tu comentario es muy largo!!');
			cerrar_alert_focus('#comentario');
			return false;
		}

		if(!exprComent.test(comentario)){
			msgAlert('Utilizaste caracteres extraños no permitidos!!');
			cerrar_alert_focus('#comentario');
			return false;
		}

		if(!exprIdUniq.test(id_usuario)){
			msgAlert('identificador inválido!!');
			return false;
		}

		if(!exprNG.test(nombre_grupo)){
			msgAlert('identificador inválido!!');
			return false;
		}

		if(!exprInt.test(id_grupo)){
			msgAlert('identificador inválido!!');
			return false;
		}
		
		$('.spinner').show();
		
		if (sendcomentario == false) {
        	sendcomentario = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}

	})


	$('.del_comment').click(function(){
		var parnt = $(this).parents('.content_comment');
		var idc = get_dats_divcomment($(this), null);
		
		var id = idc['id'];
		var idg = idc['idg'];
		var pre = idc['pref'];
		var exprInt = /^\d*$/;

		if(!exprInt.test(id)){
			location.reload();
		}
		if(!exprInt.test(idg)){
			location.reload();
		}
		if(pre != 'pf'){
			location.reload();
		}

		if(confirm('¿SEGURO(a) QUE BORRARÁS ESTE COMENTARIO?')){
			$('.spinner').show();
			$.when(
		
			$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(info){
				if(info){
					$.post('/comentarios/borrar', {post_type: 'ajax', idc: id, idgr: idg, idu: info}, function(info){
						if(info == 'true'){
							$('.spinner').hide();
							return true;
						}
					})
				}
			})

			).then(function(){
				$(parnt).fadeOut(500);
				$('#post-'+id).remove();
			})
		}
	})

	var like = false;
	$('.like_c').click(function(){
		var me = $(this);
		var idc = get_dats_divcomment($(me), null);

		var id = idc['id'];
		var idg = idc['idg'];
		var pre = idc['pref'];
		var exprInt = /^\d*$/;

		if(!exprInt.test(id)){
			location.reload();
		}
		if(!exprInt.test(idg)){
			location.reload();
		}
		if(pre != 'pf'){
			location.reload();
		}

		if(like != id){
		
		$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(info){
			if(info){
				var ids = info;
				$.post('/comentarios/like', {post_type: 'ajax', idc: id, idgr: idg, idu: ids}, function(info){
					if(info === 'true'){
						like = id;
						var us = $(me).parents('.content_comment').find('.head_comment a').attr('href');
						us = us.split('/');
						us = us[3];
						if(ids != us){
						var lk = parseInt($(me).find('span').text()) + 1;
						$(me).find('span').text(lk);				
						}
					}
				})
			}
			else{
				msgAlert('Inicia sesión para dar like! <i class="material-icons">lock_open</i>');
				cerrar_alert_focus();
			}
		})

		}

	})

	var dislike = false;
	$('.dislike_c').click(function(){
		var me = $(this);
		var idc = get_dats_divcomment($(me), null);

		var id = idc['id'];
		var idg = idc['idg'];
		var pre = idc['pref'];
		var exprInt = /^\d*$/;

		if(!exprInt.test(id)){
			location.reload();
		}
		if(!exprInt.test(idg)){
			location.reload();
		}
		if(pre != 'pf'){
			location.reload();
		}

		if(dislike != id){
		
		$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(info){
			if(info){
				var ids = info;
				$.post('/comentarios/dislike', {post_type: 'ajax', idc: id, idgr: idg, idu: ids}, function(info){
					if(info === 'true'){
						dislike = id;
						var us = $(me).parents('.content_comment').find('.head_comment a').attr('href');
						us = us.split('/');
						us = us[3];
						if(ids != us){
						var dlk = parseInt($(me).find('span').text()) + 1;
						$(me).find('span').text(dlk);				
						}
					}
				})
			}
			else{
				msgAlert('Inicia sesión para dar dislike! <i class="material-icons">lock_open</i>');
				cerrar_alert_focus();
			}
		})

		}

	})

	$('.view_replies_reply').click(function(){
		var cont = $(this).parents('.content_comment');

		if(!$(cont).find('.content_replies').is(':visible')){
			$(cont).find('.foot_comment').css({'position':'static'});
			$(cont).find('.content_replies').fadeIn(200);
			$(cont).find('.reply_comment').hide();
		}
		else{

			$(cont).find('.foot_comment').css({'position':'absolute'});
			$(cont).find('.content_replies').hide();
		}

		if($(cont).find('.content_replies').is(':empty')){
			var idr = get_dats_divcomment($(this), null);


			var id = idr['id'];
			var pre = idr['pref'];
			var exprInt = /^\d*$/;

			if(!exprInt.test(id)){
				location.reload();
			}
			if(pre != 'pf'){
				location.reload();
			}


			if($('#frmRespuestaRespuestaForo').length > 0){
				responder = true;
			}
			else{
				responder = false;
			}

			ses = $('#showUser').attr('class');

			$('.spinner').show();
			$.get('/respuestasrespuesta/ver/todo', {get_type: 'ajax', idre: id}, function(dats){
				str = get_resps_comments(dats, ses, true, 'rr');
				$(cont).find('.content_replies').html(str);
				$('.spinner').hide();	
			}, 'json')

		}
			
	})

	$('.content_replies').on('click', '.more_res_comsr', function(){
		me = $(this);
		limit = 0;
		var idr = get_dats_divcomment($(this), null);
		var id = idr['id'];

		$(me).closest('.content_replies').find('.content_reply').each(function(){
			limit++;
		})

		ses = $('#showUser').attr('class');

		$('.spinner').show();
		$.get('/respuestasrespuesta/ver/mas', {get_type: 'ajax', lim: limit, idre: id}, function(dats){
			str = get_resps_comments(dats, ses, null, 'rr');
			$(str).insertBefore(me);
			$('.spinner').hide();	
		}, 'json')

	})


	var sendreplyreply = false;
	$('.send_reply_reply').click(function(){
		var frm = $(this).parents('.reply_comment').find('#frmRespuestaRespuestaForo');
		var datsFrm = $(frm).serializeArray();
		var exprReply  = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\'\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^]{1,500}$/;
		var exprIdUniq = /^[0-9a-z]{15,16}$/;
		var exprInt    = /^\d*$/;

		var reply_r = datsFrm[0].value;
		var post_reply_r = datsFrm[1].value;

		pr = Base64.decode(post_reply_r);
		pr = JSON.parse(pr);

		var idr = pr['id'];
		var idu = pr['idu'];
		
		if(reply_r == ''){
			msgAlert('Escribe una respuesta!!');
			cerrar_alert_focus($(frm).find('textarea'));
			return false;
		}
		if(reply_r.length > 500){
			msgAlert('Tu respuesta es muy larga!!');
			cerrar_alert_focus($(frm).find('textarea'));
			return false;
		}
		if(!exprReply.test(reply_r)){
			msgAlert('En tu Respuesta, NO utilices cacacteres no permitidos!!');
			cerrar_alert_focus($(frm).find('textarea'));
			return false;
		}

		if(!exprInt.test(idr)){
			location.reload();
		}
		if(!exprIdUniq.test(idu)){
			location.reload();
		}

		$('.spinner').show();
		if(sendreplyreply == false){
			sendreplyreply = true;
		$.post('/respuestasrespuesta/nuevo', {post_type: 'ajax', idre: idr, idus: idu, respr: reply_r} ,function(info){
			if(info == 'true'){
				$(frm).find('textarea').val('');
				var nr = parseInt($(frm).parents('.content_comment').find('.num_replies').text()) + 1;
				$(frm).parents('.content_comment').find('.num_replies').text(nr);
				sendreplyreply = false;
				$('.spinner').hide();
				msg_fade("RESPUESTA ENVIADA");
			}
		});

		}
	})

	sendreplyreplymenc = false;
	$('.content_replies').on('click', '.rmencr', function(){
		var frm = $(this).closest('.content_comment').find('#frmRespuestaRespuestaForo');
		var datsFrm = $(frm).serializeArray();
		var exprReply  = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#\^\@\<\>]{1,500}$/;
		var exprIdUniq = /^[0-9a-z]{15,16}$/;
		var exprInt    = /^\d*$/;

		var post_reply_r = datsFrm[1].value;
		resp = $(this).closest('.patresmenc').find('.resmenc');
		reply_r = resp.html();

		pr = Base64.decode(post_reply_r);
		pr = JSON.parse(pr);

		var idr = pr['id'];
		var idu = pr['idu'];

		men = $(this).closest('.content_reply').find('.usresco').attr('href');
		men = men.split('/');
		men = men[3];

		if(reply_r == ''){
			msgAlert('Escribe una respuesta!!');
			cerrar_alert_focus($(resp));
			return false;
		}
		if(reply_r.length > 500){
			msgAlert('Tu respuesta es muy larga!!');
			cerrar_alert_focus($(resp));
			return false;
		}
		if(!exprReply.test(reply_r)){
			msgAlert('En tu Respuesta, NO utilices cacacteres no permitidos!!');
			cerrar_alert_focus($(resp));
			return false;
		}

		if(!exprInt.test(idr)){
			location.reload();
		}
		if(!exprIdUniq.test(idu)){
			location.reload();
		}

		$('.spinner').show();
		if(sendreplyreplymenc == false){
			sendreplyreplymenc = true;
		$.post('/respuestasrespuesta/nuevo', {post_type: 'ajax', idre: idr, idus: idu, respr: reply_r, menc: men} ,function(info){
			if(info == 'true'){
				resp.html('');
				$(resp).parent().hide();
				var nr = parseInt($(frm).parents('.content_comment').find('.num_replies').text()) + 1;
				$(frm).parents('.content_comment').find('.num_replies').text(nr);
				sendreplyreplymenc = false;
				$('.spinner').hide();
				msg_fade("RESPUESTA ENVIADA");
			}
		});

		}
		
	})

	$('.del_respuesta').click(function(){
		var me = $(this);
		var idr = get_dats_divcomment($(me), null);

		var id = idr['id'];
		var idt = idr['idt'];
		var pre = idr['pref'];
		var exprInt = /^\d*$/;

		if(!exprInt.test(id)){
			location.reload();
		}
		if(!exprInt.test(idt)){
			location.reload();
		}
		if(pre != 'pf'){
			location.reload();
		}

		if(confirm('¿REALMENTE DESEAS BORRAR ESTA RESPUESTA?')){
			$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(info){
				if(info){
					var ids = info;
					$.post('/respuestas/borrar', {post_type: 'ajax', idr: id, idte: idt, idu: ids}, function(info){
						if(info === 'true'){
							$(me).parents('.content_comment').fadeOut(400);
						}
					})
				}
				else{
					msgAlert('Inicia sesión para borrar! <i class="material-icons">lock_open</i>');
					cerrar_alert_focus();
				}
			})
		}
	})




	var grateful = false;
	$('.grateful').click(function(){
		var me = $(this);
		var idr = get_dats_divcomment($(me), null);

		var id = idr['id'];
		var idt = idr['idt'];
		var pre = idr['pref'];
		var exprInt = /^\d*$/;

		if(!exprInt.test(id)){
			location.reload();
		}
		if(!exprInt.test(idt)){
			location.reload();
		}
		if(pre != 'pf'){
			location.reload();
		}

		if(grateful != id){
		
		$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(info){
			if(info){
				var ids = info;
				$.post('/respuestas/grateful', {post_type: 'ajax', idr: id, idte: idt, idu: ids}, function(info){
					if(info === 'true'){
						grateful = id;
						var us = $(me).parents('.content_comment').find('.head_comment a').attr('href');
						us = us.split('/');
						us = us[3];
						if(ids != us){
						var grat = parseInt($(me).find('span').text()) + 1;
						$(me).find('span').text(grat);				
						}
					}
				})
			}
			else{
				msgAlert('Inicia sesión para dar gracias! <i class="material-icons">lock_open</i>');
				cerrar_alert_focus();
			}
		})

		}

	})

		var qualified = false;
	$('.qualified').click(function(){
		var me = $(this);
		var idr = get_dats_divcomment($(me), null);
		var calif = parseInt($(this).parent().find('input').val());

		var id = idr['id'];
		var idt = idr['idt'];
		var pre = idr['pref'];
		var exprInt = /^\d*$/;

		if(!exprInt.test(id)){
			location.reload();
		}
		if(!exprInt.test(idt)){
			location.reload();
		}
		if(pre != 'pf'){
			location.reload();
		}
		if(!exprInt.test(calif)){
			msgAlert('La calificación no es un número!!');
			cerrar_alert_focus();
			return false;
		}
		if(calif < 1 || calif > 10){
			msgAlert('calificación no válida!!');
			cerrar_alert_focus();
			return false;
		}


		if(qualified != id){
		
		$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(info){
			if(info){
				var ids = info;
				$.post('/respuestas/calificar', {post_type: 'ajax', idr: id, idte: idt, idu: ids, cal: calif}, function(info){
					if(info === 'true'){
						qualified = id;
						msgAlert('Calificaste una respuesta!! <i class="material-icons">thumb_up</i>');
						cerrar_alert_focus();		
					}
					else{
						msgAlert('Ya habías calificado! <i class="material-icons">close</i>');
						cerrar_alert_focus();			
					}
				})
			}
			else{
				msgAlert('Inicia sesión para calificar! <i class="material-icons">lock_open</i>');
				cerrar_alert_focus();
			}
		})

		}

	})

	$('#addpic_com').click(function(){
		reg_URL = /\b(https?|ftp|file):\/\/[\-A-Za-z0-9+&@#\/%?=~_|!:,.;]*[\-A-Za-z0-9+&@#\/%=~_|]/;
		src = prompt('ESCRIBE O PEGA LA URL DE UNA IMAGEN!');

		if(src){
			if(!reg_URL.test(src)){
                msgAlert('Url Inválida, revisa que sea una URL correcta!');
                cerrar_alert_focus();
            }
            else{
				$('#pic_comm').html('<div><img src='+src+' width=100%><i class="material-icons">close</i></div>');
				$('#pict_comment').val(src);
				$('#gif_comment').val('');
            }
		}

	})

	$('#pic_comm').on('click', 'i', function(){
		$(this).parents('#pic_comm').html('');
		$('#pict_comment').val('');
		$('#gif_comment').val('');
	})

	$("<i class='material-icons votesurvey'>radio_button_unchecked</i>").insertBefore('.body_notice meter, .content_comment meter');
	$('.body_notice, .content_comment').on('click', '.votesurvey', function(){
		chkvote = false;
		$(this).parent('blockquote, p').find('i').each(function(){
			if($(this).text() == 'check_circle'){
				chkvote = true;
			}
		})

		if(chkvote === false){
			me = $(this);
			strpst = $(me).closest('.body_notice').find('.srvpost');
	    	forpst = $(me).closest('.content_comment');
			if($(strpst).length > 0){
	    		idc = get_dats_divcomment(null, $(strpst).attr('id'));
	    	}
	    	if($(forpst).length > 0){
	    		idc = get_dats_divcomment(null, $(forpst).attr('id'));
	    	}

	    	$.ajax({
	    		url: '/comentarios/comprobar_voto',
	    		type: 'post',
	    		data: {post_type: 'ajax', idcom: idc['id']}
	    	}).done(function(info){
	    		if(info == 'true'){
					$(me).text('check_circle');
					
			    	meter = parseInt($(me).next('meter').val()) + 1;
					$(me).next('meter').val(meter)
					arr = new Array();
					votes = 0;

			    	$(me).parent('blockquote, p').find('meter').each(function(){
			    		arr.push(this.getAttribute('value'));
			    		votes+= parseInt(this.getAttribute('value'));
			    	})	
			    	max = Math.max.apply(null, arr);
			    	$(me).parent('blockquote, p').find('meter').attr('max', max);
			    	lv = $(me).parent('blockquote, p').find('.shar_comm');
			    	lvf = $(me).closest('.content_comment article').find('span:last-child');
			    	
			    	if($(lv).length > 0){
			    		$('<span class=num_votes>'+votes+' VOTOS</span>').insertBefore($(lv));
			    	}
			    	if($(lvf).length > 0){
			    		$('<span class=num_votes>'+votes+' VOTOS</span>').insertBefore($(lvf));
			    	}

			    	if($(strpst).length > 0){
			    		comm = $(me).closest('blockquote').html(); 
			    	}
			    	if($(forpst).length > 0){
			    		comm = $(me).closest('p').html(); 
			    	}
			    	    var wrapped = $("<div>" + comm + "</div>");
						wrapped.find('span').remove();
						wrapped.find('br:last-child').remove();
						wrapped.find('i').remove();
						comm = wrapped.html();
						comm = comm.trim();
						comm = comm.replace(/['"]+/g, '');
						
			    		idcom = idc['id'];
			    		idgrp = idc['idg'];

			    		$.ajax({
			    			url: '/comentarios/editar',
			    			type: 'post',
			    			data: {post_type: 'ajax', com: comm, idcome: idcom, idgroup: idgrp}
			    		}).done(function(info){
			    			console.log(info);
			    		})

	    		}
	    		else if(info == 'session'){
	    			msgAlert('Inicia sesión para votar! <i class="material-icons">lock_open</i>');
	    			cerrar_alert_focus();
	    		}
	    		else if(info == 'false'){
	    			msgAlert('Ya votaste anteriormente en esta encuesta!!');
	    			cerrar_alert_focus();
	    		}
	    	})
    	}
    	
	})

	$('#add_emoji').click(function(){
		if(!$('#emojis_cont').is(':visible')){
			$('#emojis_cont').show();
			$('#cont_gif').hide();
		}
		else{
			$('#emojis_cont').hide();
		}
	})

	$('#emojis_cont button').click(function(){
		emo = $(this).text();
		dat = $('#comentario').val();

		$('#comentario').val(dat+" "+emo);
		$('#comentario').focus().val(data+emo);
	})

	$('#add_giphies').click(function(){
		if(!$('#cont_gif').is(':visible')){
			$('#emojis_cont').hide();
			$('#cont_gif').show();
		}
		else{
			$('#cont_gif').hide();
		}
	})