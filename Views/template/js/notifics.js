	var	dGrupos = false;
	var	dForos = false;
	var	dGlobales = false;

	 $('body').click(function(evt){ 
	 	var elem = $(evt.target).parents('nav').attr('id');
	 	
	 	if(elem != 'navigation_bar'){
	 		manipule_menues(null, null);
	 		parse_var_bool(null);
		} 
	 }); 

	 function ajaxNotifComentsContent(dats){
	 	str = "";
	 	$.each(dats, function(i){
				var fot = "";
				var ngr = normalize(dats[i].ngr);
				ngr = ngr.toLowerCase();
				ngr = ngr.replace(/\s/g, "_");

				if(dats[i].men != 'null'){
					msj = "Te @ mencionó ";
				}
				else{
					msj = "Respondió tu comentario ";	
				}

				if(dats[i].fot == 'na'){
				fot = "<div class='pic_img_not' style='background-image:url(https://graph.facebook.com/"+ dats[i].ide +"/picture?type=small);'></div>";
		
				}
				else if(dats[i].fot == 'none'){
				fot = "<div class='pic_img_not'><i class='material-icons ico_notif_user'>person</i></div>";
				}
				else{
				fot = "<div class='pic_img_not' style='background-image:url(/Views/template/images/pictures/"+ dats[i].fot + ");'></div>";
				}

				str = str+"<div class='min_not' id='"+dats[i].idn+"."+dats[i].ide+"."+dats[i].idg+"'>"
							+"<div class='pic_not'>"
								+fot
							+"</div>"								
							+"<div class='con_not'>"
								+"<p>"
								+"<a href='/usuarios/perfil/"+ dats[i].ide +"'>"
								+dats[i].nom
								+"</a> "+msj+": "
								+"<a href='/grupos/ver/"+ ngr +"."+ dats[i].idg +"?c="+ dats[i].idp +"#post-"+ dats[i].idp +"'>Ver comentario y respuestas</a>"
								+"<br><span><i class='material-icons'>watch_later</i> "+ dats[i].fec +"</span>"
								+"</p>"
							+"</div>"
							+"<div class='act_not'>"
							+"<button class='btn btnCancel delete_n_for'><i class='material-icons ico_btn_s'>close</i></button>"
							+"</div>"
						 +"</div>";
			})
	 		return str;
	 }

	 function ajaxNotifGruposContent(dats){
	 	str = "";

	 	$.each(dats, function(i){
				var fot = "";
				var p = "";
				var btn = "";
				var ngr = normalize(dats[i].ngr);
				ngr = ngr.toLowerCase();
				ngr = ngr.replace(/\s/g, "_");

				if(dats[i].ngr.length > 23){
					var p = "...";
				}

				if(dats[i].fot == 'na'){
				fot = "<div class='pic_img_not' style='background-image:url(https://graph.facebook.com/"+ dats[i].ide +"/picture?type=small);'></div>";
		
				}
				else if(dats[i].fot == 'none'){
				fot = "<div class='pic_img_not'><i class='material-icons ico_notif_user'>person</i></div>";
				}
				else{
				fot = "<div class='pic_img_not' style='background-image:url(/Views/template/images/pictures/"+ dats[i].fot + ");'></div>";
				}

				if(dats[i].not == 'quiere unirse a tu grupo'){
					btn = "<button class='btn btnEdit accept_mem'><i class='material-icons ico_btn_s'>done</i></button>";
				}

				str = str+"<div class='min_not' id='"+dats[i].idg+"."+dats[i].ide+"."+dats[i].idn+"'>"
							+"<div class='pic_not'>"
								+fot
							+"</div>"								
							+"<div class='con_not'>"
								+"<p>"
								+"<a href='/usuarios/perfil/"+ dats[i].ide +"'>"
								+dats[i].nom
								+"</a> "+ dats[i].not +": "
								+"<a href='/grupos/ver/"+ ngr +"."+ dats[i].idg +"'>"+ dats[i].ngr.substring(0, 20) + p +"</a>"
								+"<br><span><i class='material-icons'>watch_later</i> "+ dats[i].fec +"</span>"
								+"</p>"
							+"</div>"
							+"<div class='act_not'>"
							+btn
							+"<button class='btn btnCancel delete_n_mem'><i class='material-icons ico_btn_s'>close</i></button>"
							+"</div>"
						 +"</div>";
			})

	 		return str;
	 }

	 function ajaxNotifRespContent(dats){
	 	str = "";

	 	$.each(dats, function(i){
				var ico = "";
				var ver ="<a href='/respuestas/ver/"+dats[i].ire+"#foro'>Ver Respuesta</a>";
				var tte = normalize(dats[i].tte);
				tte = tte.toLowerCase();
				tte = tte.replace(/\s/g, "_");

				if(dats[i].tip == 'GR'){
				ico = "<i class='material-icons ico_notif_ico notif_red'>favorite_border</i>";
				}
				else if(dats[i].tip == 'RR'){
				ico = "<i class='material-icons ico_notif_ico notif_blue'>forum</i>";
				}
				else if(dats[i].tip == 'RE'){
				ico = "<i class='material-icons ico_notif_ico notif_grey'>chat_bubble_outline</i>";
				}
				else if(dats[i].tip == 'CA'){
				ico = "<i class='material-icons ico_notif_ico notif_grey'>playlist_add_check</i>";
				}
				else if(dats[i].tip == 'ME'){
				ico = "<i class='material-icons ico_notif_ico notif_grey'>record_voice_over</i>";
				}

				str = str+"<div class='min_not' id='"+dats[i].idn+"."+dats[i].idr+"."+dats[i].ire+"'>"
							+"<div class='pic_not'>"
								+"<div class='pic_img_not'>"+ico+"</div>"
							+"</div>"								
							+"<div class='con_not'>"
								+"<p>"
								+"<a href='/usuarios/perfil/"+ dats[i].ide +"'>"
								+dats[i].nom
								+"</a> "+dats[i].not+" "
								+ver
								+"<br><span><i class='material-icons'>watch_later</i> "+ dats[i].fec +"</span>"
								+"</p>"
							+"</div>"
							+"<div class='act_not'>"
							+"<button class='btn btnCancel delete_n_res'><i class='material-icons ico_btn_s'>close</i></button>"
							+"</div>"
						 +"</div>";
			})

	 	return str;
	 }
	
	$('#nav_notify_grupos span').click(function(){
		var parent = $(this).parents('.notificon');
		if(dGrupos == false){
			manipule_menues($(parent).attr('id'), 'show');
			parse_var_bool('dgrupos');
		}
		else{
			manipule_menues($(parent).attr('id'), 'hide');
			parse_var_bool(false);
		}

		if($(parent).find('.div_content_notify').is(':empty')){
		$(parent).find('.div_content_notify').html("<img src='/Views/template/images/loading.gif'>");
		$.ajax({
			url: '/notificaciones/notificaciones_grupo/',
			type: 'get',
			dataType: 'json',
			data: {get_type: 'ajax', limit: 0}
		}).done(function(dats){
			var str = "";
			if(JSON.stringify(dats) != '[]'){

				str = str + ajaxNotifGruposContent(dats);
			}
			else{
				str = str+"<div class='min_not'><span>SIN NOTIFICACIONES!</span></div>";
			}

			$(parent).find('.div_content_notify').html(str);
		})
		}
	})

	limitnotgrupo = 9;
	$('#div_notify_grupos .content_notify').scroll(function(){
		me = $(this);
		if($(this).scrollTop() == ($(me).find('.div_content_notify').height()) - $(this).height()){
			$.ajax({
				url: '/notificaciones/notificaciones_grupo/',
				type: 'get',
				dataType: 'json',
				data: {get_type: 'ajax', limit: limitnotgrupo}
			}).done(function(dats){
				var str = "";
				str = str + ajaxNotifGruposContent(dats);

				$(me).find('.div_content_notify').append(str);
				limitnotgrupo += 9;
			})
		}
	})


	
	$('#nav_notify_foros span').click(function(){
		var parent = $(this).parents('.notificon');
		if(dForos == false){
			manipule_menues($(parent).attr('id'), 'show');
			parse_var_bool('dforos');
		}
		else{
			manipule_menues($(parent).attr('id'), 'hide');
			parse_var_bool(false);
		}

		var str = "";

		if($(parent).find('.div_content_notify').is(':empty')){
		$(parent).find('.div_content_notify').html("<img src='/Views/template/images/loading.gif'>");

		$.when(

		$.ajax({
			url: '/notificaciones/notificar_mensajes/',
			type: 'get',
			data: {get_type: 'ajax'}
		}).done(function(info){
			if(info == '1'){
				str = str+"<div class='min_not more_act_not'>"
						 +"<div class='pic_not'><div class='pic_img_not'><i class='material-icons ico_notif_ico notif_red'>drafts</i></div></div>"
						 +"<div class='con_not'><p>Tienes <b>MENSAJES NUEVOS</b> aún sin responder: <a href='/mensajes/ver'>Ver bandeja de Mensajes...</a></p></div>"
						 +"</div>";
			}
		}),

		$.ajax({
			url: '/notificaciones/notificaciones_comentarios/',
			type: 'get',
			dataType: 'json',
			data: {get_type: 'ajax', limit: 0}
		}).done(function(dats){
			if(JSON.stringify(dats) != '[]'){
				str = str + ajaxNotifComentsContent(dats);
			}
		})

		).then(function(){
			if(str == ''){
				str = str+"<div class='min_not'><span>SIN NOTIFICACIONES!</span></div>";
			}
			$(parent).find('.div_content_notify').html(str);
		})

		}		
	})

	limitnotforo = 9;
	$('#div_notify_foros .content_notify').scroll(function(){
		me = $(this);

		if($(this).scrollTop() == ($(me).find('.div_content_notify').height()) - $(this).height()){
			$.ajax({
				url: '/notificaciones/notificaciones_comentarios/',
				type: 'get',
				dataType: 'json',
				data: {get_type: 'ajax', limit: limitnotforo}
			}).done(function(dats){
				var str = "";
				str = str + ajaxNotifComentsContent(dats);

				$(me).find('.div_content_notify').append(str);
				limitnotforo += 9;
			})
		}
	})

	$('#nav_notify_globales span').click(function(){
		var parent = $(this).parents('.notificon');
		if(dGlobales == false){
			manipule_menues($(parent).attr('id'), 'show');
			parse_var_bool('dglobales');
		}
		else{
			manipule_menues($(parent).attr('id'), 'hide');
			parse_var_bool(false);
		}

		if($(parent).find('.div_content_notify').is(':empty')){
		$(parent).find('.div_content_notify').html("<img src='/Views/template/images/loading.gif'>");
		var str = "";

		$.when(

		$.ajax({
			url: '/notificaciones/notificaciones_temas/',
			type: 'get',
			dataType: 'json',
			data: {get_type: 'ajax'}
		}).done(function(dats){
			if(JSON.stringify(dats) != '[]'){
				str = str + "<div class='min_not more_act_not'>"
							+"<i class='material-icons not_ract'>notification_important</i>"
							+"<div class='pic_not'></div>"
							+"<div class='con_not'><p>Hay actividad <u>reciente</u> de tus Cursos.<br><b>CLICK PARA MOSTRAR MÁS</b><i class='material-icons m_act_not'>keyboard_arrow_down</i></p></div>"
							+"</div>" 
						+ "<section id='warp_not_tem'>";
				$.each(dats, function(i){
					var tte = normalize(dats[i].tit);
					tte = tte.toLowerCase();
					tte = tte.replace(/\s/g, "_");

					if(dats[i].nit == 1){
						icot = "fact_check";
						tyt = "examen de";
					}
					else{
						icot = "chrome_reader_mode";
						tyt = "tema";
					}

					var ver = "<a href='/temas/ver/"+tte+"."+dats[i].idt+"'>"+dats[i].tit.substring(0,20)+"...</a>";

					str = str+"<div class='min_not'>"
								+"<div class='pic_not'>"
									+"<div class='pic_img_not'><i class='material-icons ico_notif_ico notif_aqua'>"+icot+"</i></div>"
								+"</div>"								
								+"<div class='con_not'>"
									+"<p>"
									+"<a href='/usuarios/perfil/"+ dats[i].ide +"'>"
									+dats[i].nom
									+"</a> publicó o editó el "+tyt+": "
									+ver
									+"<br><span><i class='material-icons'>watch_later</i> "+ dats[i].fep +"</span>"
									+"</p>"
								+"</div>"
								+"<div class='act_not'>"
								+"</div>"
							 +"</div>";
				})
				str = str + "</section>";
			}
			
		}),

		$.ajax({
			url: '/notificaciones/notificaciones_respuestas/',
			type: 'get',
			dataType: 'json',
			data: {get_type: 'ajax', limit: 0}
		}).done(function(dats){
			if(JSON.stringify(dats) != '[]'){
				str = str + ajaxNotifRespContent(dats);			
			}
			else{
				str = str+"<div class='min_not'><span><i class='material-icons'>tag_faces</i></span></div>";
			}
		})

		).then(function(){
			$(parent).find('.div_content_notify').html(str);
		})

		}		

	})


	sectacttem = false;
	$('#nav_notify_globales').on('click', '.more_act_not', function(){
		if(sectacttem == false){
			$('#warp_not_tem').fadeIn(700);
			$('.more_act_not b').text('OCULTAR');
			$('.m_act_not').text('keyboard_arrow_up');
			sectacttem = true;
		}
		else{
			$('#warp_not_tem').fadeOut(700);
			$('.more_act_not b').text('CLICK PARA MOSTRAR MÁS');
			$('.m_act_not').text('keyboard_arrow_down');
			sectacttem = false;	
		}
	})

	limitnotresps = 9;
	$('#div_notify_globales .content_notify').scroll(function(){
		me = $(this)
		
		if($(this).scrollTop() == ($(me).find('.div_content_notify').height()) - $(this).height()){

			$.ajax({
				url: '/notificaciones/notificaciones_respuestas/',
				type: 'get',
				dataType: 'json',
				data: {get_type: 'ajax', limit: limitnotresps}
			}).done(function(dats){
				var str = "";
				str = str + ajaxNotifRespContent(dats);

				$(me).find('.div_content_notify').append(str);
				limitnotresps += 9;
			})
		}
	})

	$('.content_notify').on('click', '.accept_mem', function(){
		var me = $(this).parents('.min_not');
		var dats = $(me).attr('id');
		var str_d = dats.split('.');

		var exprIdUniq = /^[0-9a-z]{16}$/;
		var exprInt = /^\d*$/;
		
		var idg = str_d[0];
		var ide = str_d[1];
		var idn = str_d[2];

		if(!exprInt.test(idg)){
			location.reload();
		}
		if(!exprIdUniq.test(ide)){
			location.reload();
		}
		if(!exprInt.test(idn)){
			location.reload();
		}

		$.when(

		$.post('/notificaciones/borra_notif_grupo', {post_type: 'ajax', idgr: idg, idem: ide, idno: idn}, function(info){
			if(info != 'true'){ return false; }
		}),

		$.post('/grupos/aceptar_miembro', {post_type: 'ajax', idgr: idg, idem: ide}, function(info){
			if(info != 'true'){ return false; }
		}),

		$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(info){
			if(info){
				$.post('/notificaciones/aceptar', {post_type: 'ajax', idgr: idg, idem: info, idre: ide}, function (info){
					if(info == "true"){
						return true;
					}
				})
			}
		})

		).then(function(){
			$(me).fadeOut(550);
			var ng = parseInt($('#notific_groups span').text());
			ng = ng - 1;
			$('#notific_groups span').html(ng);
		})

	})

	$('.content_notify').on('click', '.delete_n_mem', function(){
		var me = $(this).parents('.min_not');
		var dats = $(me).attr('id');
		var str_d = dats.split('.');

		var exprIdUniq = /^[0-9a-z]{16}$/;
		var exprInt = /^\d*$/;
		
		var idg = str_d[0];
		var ide = str_d[1];
		var idn = str_d[2];

		if(!exprInt.test(idg)){
			location.reload();
		}
		if(!exprIdUniq.test(ide)){
			location.reload();
		}
		if(!exprInt.test(idn)){
			location.reload();
		}

		$.post('/notificaciones/borra_notif_grupo', {post_type: 'ajax', idgr: idg, idem: ide, idno: idn}, function(info){
			if(info == 'true'){
				$(me).fadeOut(550);
				var ng = parseInt($('#notific_groups span').text());
				ng = ng - 1;
				$('#notific_groups span').html(ng);
			}
		})

	})


	$('.content_notify').on('click', '.delete_n_res', function(){
		var me = $(this).parents('.min_not');
		var dats = $(me).attr('id');
		var str_d = dats.split('.');

		var exprIdUniq = /^[0-9a-z]{15,16}$/;
		var exprInt = /^\d*$/;
		
		var idn = str_d[0];
		var idr = str_d[1];
		var ire = str_d[2];

		if(!exprInt.test(idn)){
			location.reload();
		}
		if(!exprIdUniq.test(idr)){
			location.reload();
		}
		if(!exprInt.test(ire)){
			location.reload();
		}

		$.post('/notificaciones/borrar_notificacion_respuestas', {post_type: 'ajax', idno: idn, idre: idr, ires: ire}, function(info){
			if(info == 'true'){
				$(me).fadeOut(550);
				var ng = parseInt($('#notific_globals span').text());
				ng = ng - 1;
				$('#notific_globals span').html(ng);
			}
		})

	})


	$('.content_notify').on('click', '.delete_n_for', function(){
		var me = $(this).parents('.min_not');
		var dats = $(me).attr('id');
		var str_d = dats.split('.');

		var exprIdUniq = /^[0-9a-z]{15,16}$/;
		var exprInt = /^\d*$/;
		
		var idn = str_d[0];
		var ide = str_d[1];
		var idg = str_d[2];

		if(!exprInt.test(idn)){
			location.reload();
		}
		if(!exprIdUniq.test(ide)){
			location.reload();
		}
		if(!exprInt.test(idg)){
			location.reload();
		}

		$.post('/notificaciones/borrar_notificacion_comentario', {post_type: 'ajax', idno: idn, idem: ide, idgr: idg}, function(info){
			if(info == 'true'){
				$(me).fadeOut(550);
				var ng = parseInt($('#notific_forums span').text());
				ng = ng - 1;
				$('#notific_forums span').html(ng);
			}
		})

	})

	