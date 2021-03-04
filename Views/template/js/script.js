
	var dMenu = false;
	var getC = false;

	var id_session = false;
	var id_grupo_curso = false;
	var id_prop_curso = false;
	var status_member = false;

	var normalize = (function() {
  		var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
      		to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      	 mapping = {};
 
  		for(var i = 0, j = from.length; i < j; i++)
      		mapping[from.charAt(i)] = to.charAt(i);
 
  			return function(str){
      			var ret = [];
      			for(var i = 0, j = str.length; i < j; i++){
          			var c = str.charAt(i);
          			if(mapping.hasOwnProperty(str.charAt(i)))
              			ret.push(mapping[c]);
          			else
              			ret.push(c);
      			}      
      		return ret.join('');
  		}
 
	})();

	function copy(opt, id_elemento) {
	  var aux = document.createElement("input");

	  if(opt != null){
		 var url = ""+window.location;
		 url = url.split('#');
		 root = url[0];
	  }
	  else{
	  	root = document.domain + "/";
	  }

	  aux.setAttribute("value", root + id_elemento.substring(1));
	  document.body.appendChild(aux);
	  aux.select();
	  document.execCommand("copy");
	  document.body.removeChild(aux);
	}

   function isMobile() {
    try{ 
        document.createEvent("TouchEvent"); 
        return true; 
	    }
	    catch(e){ 
	        return false;
	    }
   }


	function extractVideoID(url){
	    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
	    var match = url.match(regExp);
	    if(match && match[7].length == 11 ){
	        return match[7];
	    }else{
	        alert("No se logró extraer ID del video.");
	    }
	}

	function findReplaceUrl(text){
    	var urlRegex = /(https?:\/\/[^\s]+)/g;
    		return text.replace(urlRegex, function(url){
        	return '[' + url + ']';
    		})
    		// or alternatively
    		// return text.replace(urlRegex, '<a href="$1">$1</a>')
	}

	function inArray(needle, haystack){
    	var length = haystack.length;
    	for(var i = 0; i < length; i++) {
        	if(haystack[i] == needle) return true;
    	}
    	return false;
	}

	function removeItemFromArr( arr, item ){
	    var i = arr.indexOf( item );
	 
	    if ( i !== -1 ) {
	        arr.splice( i, 1 );
	    }
	}

	function navegador(){
		var agent = navigator.userAgent;
		var navegadores = ['Chrome', 'Firefox', 'Safari', 'Opera', 'Edge'];
		
		for (var i in navegadores) {
			if (agent.indexOf(navegadores[i]) != -1){
				return navegadores[i];
			}
		}
	}


	function show_frmcurso(){
		if($('#divfrm_curso').is(':visible')){
			$('#divfrm_curso').fadeOut(300);
			$('#nvo_curso i').text('playlist_add');
		}
		else{
			$('#divfrm_curso').fadeIn(300);
			$('#nombre_materia_curso').focus();
			$('#nvo_curso i').text('close');
		}
	}

	function msgAlert(msg){
		$('.alert_back').find('p').html(msg);
		$('.alert_back').show();
	}

	function cerrar_alert_focus(element){
		$('.cerrar_shadow').click(function(){
			$(this).parent().parent().hide();
			if(element){
				$(element).focus();
			}
		})
	}

	function manipule_menues(arg, cond){
		if(arg){
			var elem = arg.split("_");
			elem = elem[1] + "_" + elem[2];
				elem = "#div_" + elem;

			arg = "#" + arg;
		}
			
		$('#div_notify_grupos').hide();
		$('#div_notify_foros').hide();
		$('#div_notify_globales').hide();
		$('#div_bars_menu').hide();
		$('#nav_bars_menu span').find('i').html('menu');
		$('.notificon').find('img').hide()

		if(cond == 'show'){
			$(elem).show();
			$(arg).find('img').show();

			if(elem == '#div_bars_menu'){
				$('#nav_bars_menu span').find('i').html('close');
			}
		}
		else if(cond == 'hide'){
			$(elem).hide();
			$(arg).find('img').hide();
		}

	}


	function parse_var_bool(arg){
		dMenu = false;
		dGrupos = false;
		dForos = false;
		dGlobales = false;
		if(arg == 'dmenu'){
			dMenu = true;
		}
		if(arg == 'dgrupos'){
			dGrupos = true;
		}
		if(arg == 'dforos'){
			dForos = true;
		}
		if(arg == 'dglobales'){
			dGlobales = true;
		}
	}


	function catch_tags(arg){
		var url = ""+window.location;
		var id = url.split('.');
		id = id[id.length - 1];
		id = id.split('#');
		id = id[0];
		var tag = url.split('#');

		if(tag[1] && id){
			
			if(!(/^\d*$/).test(id)){
				id = id.split('?');
				id = id[0];
			}
			tag = tag[1].split('-');
			tag = tag[1];
			var tag_full = {'id': tag, 'idg': id, 'pref': 'pf'};
			tag_full = Base64.encode(JSON.stringify(tag_full));
			tag_full = tag_full.replace("=", "-");
			$("#"+arg+"_"+tag_full).css({'background-color':'#FAFAFA', 'border': '1px solid #45A9EC', 'margin-top': '30px'});
		}
	}

	function get_cont_meth(){
		var url = ""+window.location;
		var controller = url.split('/');

		if(controller.length  > 4){
			controller = controller[3];
			method = url.split('/');
			method = method[4];

			if(controller == 'grupos' && method == 'ver'){
				catch_tags('pf');
			}
		}
	}

	function msg_fade(msg){
		elem = document.createElement('div');
			elem.setAttribute('class', 'msg_delay');
			elem.innerHTML = "<p>"+msg+"</p>";
	    	document.body.appendChild(elem);
	    	$('.msg_delay').fadeIn(1200);
	    	window.setTimeout(function(){
	    		$(elem).remove();
	    	}, 5000)
	}

	function marcarTemaLeído(arg){
		var me = $(arg);
		var dat = $(me).attr('id');
		var exprNomTem = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/;
		var exprInt    = /^\d*$/;

		var dt = Base64.decode(dat);
		dt = $.parseJSON(dt);

		var idt = dt['id'];
		var tit = dt['ti'];
		var pre = dt['pre'];

		if(!exprNomTem.test(tit)){
			location.reload();
		}
		if(!exprInt.test(idt)){
			location.reload();
		}
		if(pre != 'idt'){
			location.reload();
		}

		$(me).attr('disabled', 'disabled');

		$.ajax({
			url: '/temas/addver_tema',
			type: 'post',
			data: {post_type: 'ajax', dats: dat}
		}).done(function(info){
			if(info == 'true'){
				$(me).find('span').text('Leído');
			}
			$(me).removeAttr('disabled');
		})
	}


$(document).ready(function(){
	get_cont_meth();

	$('#descripcion_grupo, textarea.txtareainsert').on('change drop keydown cut paste', function(){
		desc = $(this);
		desc.height('auto');
		desc.height(desc.prop('scrollHeight'));
	})

	$('#body_article').on('click', '.checkbtn', function(){
		if($(this).is(':checked') ){
	        $(this).parent().attr('class', '1');
	        $(this).attr('checked', '');
	    } else {
	        $(this).parent().removeAttr('class');
	        $(this).removeAttr('checked');
	    }
	})


    $('#body_article').on('change', 'select', function(){
        opt = this.options[this.selectedIndex];
        
       	$(this).find('option').removeAttr('class');
       	$(this).find('option').removeAttr('selected');
        $(opt).attr('class', '1');
        $(opt).attr('selected', '');
    })

	$( '#body_article textarea.txtareainsert' ).on('input', function() {
	    v = $(this).val();
	    $(this).html(v);
	});

	$('#displayFrmReg').click(function(){
		$('#frmRegistro').show();
		$(this).parent().fadeOut(250);
	})

	$('#ver_avance').click(function(){
		if($('#chart_curso').is(':visible')){
			$('#chart_curso').fadeOut(600);	
			$(this).find('i:nth-child(2)').text('expand_more');
		}
		else{
			$('#chart_curso').fadeIn(400);
			$(this).find('i:nth-child(2)').text('expand_less');
		}
	})

	$('#search_grl').click(function(){
		$('#searcher_crs').show();
		$('#searcher_crs').animate({'top': '60px'}, 400);
	})


	$('#displayFrmInit').click(function(){
		$('#frmIngreso').show();
		$(this).parent().fadeOut(250);
	})

	$('.cerrarError, .cerrarBox').click(function(){
		$(this).parent().hide();
		$('.frmFile').css({'top':'50px'});
		$('.frmModal').css({'top': '50px'});
		$('.frmEv').css({'top':'50px'});
		$('#post_dats_t').val('');
		$('#post_dats_un').val('');
		$('#arggrp').val('');
		$('#lblFrmCurso').html('');
		$('.back_shadow').hide();
		$('.confirm_back').hide();
		$('#div_canvas').css({'visibility': 'hidden'});
	})


	$('.range').on('input', function(){
		var me = $(this).parent();
		var rng = $(this).val();

		$(me).find('button small').text(rng);
	})

	$('.btnAdd_mem').click(function(){
		var idus = $(this).siblings('a').attr('href');
		idus = idus.split('/');
		idus = idus[idus.length -1];
		idus = Base64.encode(idus);
		$('#post_dats_usid').val(idus);

		var name = $(this).parent().siblings('.divInfoUser').find('span').text();
		$('#info_member_frm label').html('&nbsp;Agregar a <b>'+name+'</b> a un grupo');

		$('.frmModal').hide();
		$('.frmModal').fadeIn(350);
		var pic = $(this).parent().siblings('.pictListUser').find('div');
		if($(pic).attr('style')){
			$('#info_member_frm div').html('');
			$('#info_member_frm div').attr('style', $(pic).attr('style'));
		}
		else{
			$('#info_member_frm div').attr('style', $(pic).removeAttr('style'));
			$('#info_member_frm div').html($(pic).html());
		}
	})

	$('.open_file_box, .btnAdd_mem, #conf_new_event, .delete_grp').click(function(){
		if($(this).attr('class') != 'btn btnEdit open_file_box' && $(this).attr('class') != 'material-icons open_file_box'  && $(this).attr('class') != 'open_file_box ed'){
			$('.confirm_back, .confirm_back div').hide();
			$('.back_shadow').show();
			$('.frmModal').show();
			$('.frmModal').animate({'top':'20%'},300);
		}
		$('.frmFile').show();
		$('.frmFile').animate({'top':'20%'},300);
	})

	$('#int_liCur, .addtema_ico').on('click', '.add_tema', function(){
		 var val = $(this).parent().attr('id');
		 $('#post_dats_t').val(val);

		 var nc = Base64.decode(val);
		 nc = $.parseJSON(nc);
		$('#frmTema').hide();
		$('#frmTema').fadeIn(350);
		$('#lblFrmCurso').html("Publicar un <b>[Tema Individual]</b> en el curso: (<b> <i class='icon-logo'></i> "+nc['nc']+"</b>)");
		$('#frmTema').animate({'top':'13%'},300);
	})

	$('#add_unidad').click(function(){
		 val = $('#post_dats_t').val();
		 $('#post_dats_un').val(val);

		 var nc = Base64.decode(val);
		 nc = $.parseJSON(nc);
		 
		 $('#frmTema').hide();
		 $('#frmUnidad').show();
		 $('#lblFrmUnidad').html("Crear un [Módulo de Temas] en el curso: (<b> <i class='icon-logo'></i> "+nc['nc']+"</b>)");
		 $('#frmUnidad').animate({'top':'13%'},300);
	})

	$('.href_action').click(function(){
		$('.spinner').show();
	})
	$(document).on('click', '.href_action', function(){
		$('.spinner').show();
	})

	$('#nav_bars_menu span').click(function(){
		if(dMenu == false){
			manipule_menues($(this).parents('.menuicon').attr('id'), 'show');
			parse_var_bool('dmenu');
		}
		else{
			manipule_menues($(this).parents('.menuicon').attr('id'), 'hide');
			parse_var_bool(false);
		}
	})


	$('.search_input').on('input', function(){
		var url = ""+window.location;
			
		if(url.indexOf('?') > -1){
			url = url.substring(0, url.indexOf('?'));
		}

		var controller = url.split('/');
		controller = controller[3];

		var argu = $(this).val();

		argu = argu.toLowerCase();

		argu = normalize(argu);
		argu = argu.replace(/\s/g, "_");

		if(controller != 'temas'){
			$('#button_search').attr('href', "/" + controller +"/buscar/"+ argu);
		}
		if(controller == 'temas'){
			if(getC == false){
				getC = parseInt($('#button_search').attr('href'));
			}

			$('#button_search').attr('href', "/" + controller +"/buscar/"+ argu + "?c=" +getC);	
		}
	});

	$('.search_courses').on('input', function(){
		var argu = $(this).val();

		argu = argu.toLowerCase();

		argu = normalize(argu);
		argu = argu.replace(/\s/g, "_");

		$('#button_src_crs').attr('href', "/buscar/resultado/"+ argu);
	});

	$('.search_calif').on('input', function(){
		var argu = $(this).val();

		argu = argu.toLowerCase();

		argu = normalize(argu);
		argu = argu.replace(/\s/g, "_");

		$('#button_search_calif').attr('href', "?b="+ argu);
	});

	$('.itheme').click(function(){
		$('.itheme').css({'background-color':'#4BB1BF'});
		$(this).css({'background-color':'#0AA3B8'});

		var theme = $(this).find('i').text();
		$('#theme').val(theme);
	})

	var sendpicture = false;
	$('#frmPicture').submit(function(){

		var image = $('#foto').val();
		var extimage = image.substring(image.lastIndexOf("."));
		var type = document.getElementById('foto').files[0].type

		if(type != 'image/jpeg'){
			msgAlert('El formato de la "Foto" debe de ser del tipo JPG o JPEG o No has elegido una imagen aún!!');
			cerrar_alert_focus();
			return false;
		}
			var imgid = document.getElementById('foto');
			var imgindex = imgid.files[0];
			var size = parseInt(imgindex.size);

		if(size > 3670016){
			msgAlert('El tamaño de la "Foto", No debe exceder los 3.5 MB!!');
			cerrar_alert_focus();
			return false;
		}

		$('.spinner').show();
		
		if (sendpicture == false) {
        	sendpicture = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}
	})

	$('#foto').change(function(e){
		var image = $('#foto').val();
		var ext = image.substring(image.lastIndexOf("."));
		var TmpPath = URL.createObjectURL(e.target.files[0]);

		var nf = document.getElementById('foto').files[0].name;
		
		if(nf.length > 30){
			nf = nf.substring(0, 30)+"... ("+ext+")";
		}

		$('#prev_pict').attr('src', TmpPath);

		$('#pselectfoto').html(nf);
	})


	var sendupdateusuario = false;
	$('#frmEditPerfil').submit(function(){
		$('.spinner').show();
		
		if (sendupdateusuario == false) {
        	sendupdateusuario = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}

	})

	$('#frmEditPerfil div.contSelect').change(function(){
		msgAlert('¡MOMENTO!<br>Ten en cuenta esto si eres Tutor, y cambias a Rol de Usuario: algunas acciones como Admin. ya NO se ejecutarán!!');
		cerrar_alert_focus();
	})

	$('#slide_cursos').click(function(){
		$(this).siblings().removeAttr('class');
		$(this).attr('class', 'actual_slide');
		$('#liMiembros').animate({'left':'200%'},200);
		$('#liCursos').animate({'left':'0%'},200);
		$('#dMetrica').animate({'left':'400%'}, 200);
	})

	$('#slide_usuarios_grupo').click(function(){
		$(this).siblings().removeAttr('class');
		$(this).attr('class', 'actual_slide');
		$('#liCursos').animate({'left':'100%'},200);
		$('#liMiembros').animate({'left':'0%'},200);
		$('#dMetrica').animate({'left':'200%'}, 200);
	})

	$('#slide_metrica').click(function(){
		$(this).siblings().removeAttr('class');
		$(this).attr('class', 'actual_slide');
		$('#liCursos').animate({'left':'100%'},200);
		$('#liMiembros').animate({'left':'200%'},200);
		$('#dMetrica').animate({'left':'0%'}, 200);
	})

	$('#int_liMiemb ul').on('click', '.ban_memb', function(){
		idu = $(this).parents('li').attr('id');
		var exprIdUniq = /^[0-9a-z]{15,16}$/;

		idu = idu.split('_');
		idg = idu[0];
		idus = Base64.decode(idu[1]);

		if(!exprIdUniq.test(idus)){
			msgAlert('Id Invalido');
			cerrar_alert_focus();
			return false;
		}

		if(confirm('¿CONFIRMAS BLOQUEAR A ESTE USUARIO?')){
			$.ajax({
				url: '/grupos/banear',
				type: 'post',
				data: {post_type: 'ajax', idgr: idg, use: idus}
			}).done(function(info){
				if(info == 'true'){
					msgAlert('Bloqueaste a un usuario!!');
					cerrar_alert_focus();
				}
			})
		}
	})

	$('#int_liMiemb ul').on('click', '.del_memb', function(){
		me = $(this).parents('li');
		idu = $(me).attr('id');
		var exprIdUniq = /^[0-9a-z]{15,16}$/;

		idu = idu.split('_');
		idg = idu[0];
		idus = Base64.decode(idu[1]);

		if(!exprIdUniq.test(idus)){
			msgAlert('Id Invalido');
			cerrar_alert_focus();
			return false;
		}

		if(confirm('¿CONFIRMAS QUE VAS ELIMINAR A ESTE USUARIO DEL GRUPO?')){
			$.ajax({
				url: '/grupos/borrar_miembro',
				type: 'post',
				data: {post_type: 'ajax', idgr: idg, use: idus}
			}).done(function(info){
				if(info == 'true'){
					msgAlert('Eliminaste del grupo a un usuario!!');
					cerrar_alert_focus();
					$(me).fadeOut(600);
				}
			})
		}
	})

	var limemb = 8;
    $('#liMiembros').scroll(function() {
         if($(this).scrollTop() == ($('#int_liMiemb').height() + 20) - $(this).height()){
         	var url = ""+window.location;
         	var idg = url.split('.');
			idg = parseInt(idg[idg.length - 1]);
           	
           	$('#loadslidegrp').show();
			$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(use){
					$.get('/grupos/get_creador_grupo/'+idg, {get_type: 'ajax'}, function(cre){
						$.ajax({
							url: '/grupos/ver_miembros/'+idg,
							type:'get',
							dataType: 'json',
							data: {get_type: 'ajax', limit: limemb}
						}).done(function(dat){
							str = "";
							$.each(dat, function(i){
								if(dat[i].ids == 'FB'){
									back = "background-image: url(https://graph.facebook.com/"+dat[i].idu+"/picture?type=small);"
								}
								else{
									back = "";
								}
								if(dat[i].fot == 'none'){
									back2 = "<i class='material-icons'>account_circle</i>";
								}
								if(dat[i].fot != 'none' && dat[i].ids != 'FB'){
									back2 = "<img src='/Views/template/images/pictures/"+dat[i].fot+"' alt='"+dat[i].nom+"_usuario'>";
								}
								if(dat[i].enl == 1){
									ol = "online";
								}
								else{
									ol = "outline";
								}
								if(dat[i].sta == 1){
									bl = " banned";
								}
								else{
									bl = "";
								}

								str = str +"<li id='"+idg+"_"+Base64.encode(dat[i].idu)+"'>"
		 						+"<a href='/usuarios/perfil/"+dat[i].idu+"' class='underl href_action'>"
		 							+"<div class='pict_slide_group"+bl+"' style='"+back+"' title='"+dat[i].nom+"'>"
										+back2
									+"</div>&nbsp;"
		 							+"<span>"+dat[i].nom+"</span>"
		 						+"</a>"
		 						+"<div class='online_radio'>";
	 							if(use  || use == cre){
	 								str = str +"<i class='material-icons circle "+ol+"'>lens</i>";
	        					}

	        					if(use != '' && use == cre){
	 								str = str +"&nbsp;<i class='material-icons more'>more_vert</i>"
	 								+"<div class='del_ban_user'>"
	 									+"<p class='ban_memb'>Bloquear</p>"
	 									+"<p class='del_memb'>Eliminar</p>"
	 									+"<img src='/Views/template/images/shift.png'>"
	 								+"</div>";
	 							}
	 							str = str +"</div>"
	 							+"</li>";
								
							})
							limemb += 8;
							$('#int_liMiemb ul').append(str);
							$('#loadslidegrp').hide();
						})
					})
			})
        }
    });

    $('.delete_grp').click(function(){
    	idg = $(this).parent().attr('id');
    	$('#frmDelGrp').find('#arggrp').val(idg);

    	tit = $(this).parent().find('.headMinGrupo p').text();
    	$('#frmDelGrp').find('span').text(tit);
    })

    $('#frmDelGrp').submit(function(){
    	var exprPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&_.]{8,15}$/;

    	pass = $('#passw').val();
    	idg = $('#arggrp').val();
    	idar= Base64.decode(idg).split('-');

    	dats = $(this).serializeArray();
    	dats.push({'name': 'post_type', 'value': 'ajax'});

    	if(pass == ""){
    		msgAlert('Falta el password!!');
    		cerrar_alert_focus('#passw');
    		return false;
    	}

    	if(pass.length < 8){
    		msgAlert('El password debe tener al menos 8 caracteres!!');
    		cerrar_alert_focus('#passw');
    		return false;
    	}

    	if(pass.length > 15){
    		msgAlert('El password es muy largo!!');
    		cerrar_alert_focus('#passw');
    		return false;
    	}

    	if(!exprPass.test(pass)){
    		msgAlert('El password NO debe tener "acentos, eñes, o algunos caracteres raros", Y debe tener al menos una Letra y un Número!!');
			cerrar_alert_focus('#passw');
			return false;
    	}

    	$.ajax({
    		url: '/grupos/confirmar_pass_borrar',
    		type: 'post',
    		data: dats
    	}).done(function(info){
    		if(info == "true"){
    			if(confirm('¡ATENCIÓN! ¿CONFIRMAS QUE BORRARÁS EL GRUPO \n Y TODOS LOS CURSOS, DATOS Y TEMAS QUE CONTIENE?')){
			    	$.ajax({
			    		url : '/grupos/borrar',
			    		type: 'post',
			    		data: {post_type: 'ajax', idgr: idar[0]}
			    	}).done(function(info){
			    		if(info == "true"){
			    			location.reload();
			    		}
			    		if(info == "false"){
			    			msgAlert('Algo falló al borrar el grupo!!');
    						cerrar_alert_focus();
			    		}
			    		if(info == "ses"){
			    			msgAlert('Debes abrir sesión!!');
    						cerrar_alert_focus();
			    		}
			    	})
		    	}
    		}
    		if(info == "false"){
    			msgAlert('El password no coindice con tu Usuario!!');
    			cerrar_alert_focus();
    		}
    		if(info == "ses"){
    			msgAlert('Tienes que abrir tu sesión!!');
    			cerrar_alert_focus();
    		}
    	})

    	return false;
    })

    
    var datbans = false;
    $('#baneos').click(function(){
    	var url = ""+window.location;
        var idg = url.split('.');
		idg = parseInt(idg[idg.length - 1]);

		if($('#div_bans').is(':visible')){
			$('#div_bans').fadeOut(300);
			$(this).find('i:nth-child(3)').text('expand_more');
		}
		else{
			$(this).find('i:nth-child(3)').text('expand_less');
			$('#div_bans').fadeIn(900);
		}

		if(datbans == false){
			$('.spinner').show();
			$.ajax({
				url: '/grupos/ver_baneos/'+idg,
				type: 'get',
				dataType: 'json',
				data: {get_type: 'ajax'}
			}).done(function(dat){
				str = "";
						
				if(JSON.stringify(dat) != '[]'){
					$.each(dat, function(i){
						back2 = '';
						if(dat[i].ids == 'FB'){
							back = "background-image: url(https://graph.facebook.com/"+dat[i].idu+"/picture?type=small);"
						}
						else{
							back = "";
						}
						if(dat[i].fot == 'none'){
							back2 = "<i class='material-icons'>account_circle</i>";
						}
						if(dat[i].fot != 'none' && dat[i].ids != 'FB'){
							back2 = "<img src='/Views/template/images/pictures/"+dat[i].fot+"' alt='"+dat[i].nom+"_usuario'>";
						}

						str = str +"<li id='ban_"+Base64.encode(dat[i].idu)+"'>"
				 					+"<a href='/usuarios/perfil/"+dat[i].idu+"' class='underl'>"
				 					+"<div class='pict_slide_group' style='"+back+"' title='"+dat[i].nom+"'>"
									+back2
									+"</div>&nbsp;"
				 					+"<span>"+dat[i].nom+"</span>"
				 					+"</a>"
				 					+"<button class='btn btnEdit unlockban'>&nbsp;&nbsp;<i class='material-icons'>lock_open</i>&nbsp;&nbsp;</button>"
				 					+"</li>";
					})
					
					$('#div_bans ul').html(str);
					datbans = true;
				}
			})
		}
		$('.spinner').hide();
    })

    $('#div_bans ul').on('click', '.unlockban', function(){
    	var url = ""+window.location;
        var idg = url.split('.');
		idg = parseInt(idg[idg.length - 1]);

		me = $(this).parents('li');
		idu = $(me).attr('id');
		var exprIdUniq = /^[0-9a-z]{15,16}$/;

		idu = idu.split('_');
		idus = Base64.decode(idu[1]);

		if(!exprIdUniq.test(idus)){
			msgAlert('Id Invalido');
			cerrar_alert_focus();
			return false;
		}

		$.ajax({
			url: '/grupos/desbloquear',
			type: 'post',
			data: {post_type: 'ajax', idgr: idg, idu: idus}
		}).done(function(info){
			if(info == 'true'){
				$(me).fadeOut(500);
			}
		})
    })

    var licurs = 8;
    $('#liCursos').scroll(function() {
         if($(this).scrollTop() == ($('#int_liCur').height() + 20) - $(this).height()){
         	var url = ""+window.location;
         	var idg = url.split('.');
			idg = parseInt(idg[idg.length - 1]);

           $('#loadslidegrp').show();
			$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(use){
				$.get('/grupos/get_creador_grupo/'+idg, {get_type: 'ajax'}, function(cre){
					$.ajax({
						url: '/cursos/listar/'+idg,
						type: 'get',
						dataType: 'json',
						data: {get_type: 'ajax', limit: licurs}
					}).done(function(dat){
						str = "";

						$.each(dat, function(i){
							idcur = {'id': dat[i].id, 'nc': dat[i].nc};
							idcr = Base64.encode(JSON.stringify(idcur));

							if(use != '' && use == cre){
								idli = "id='"+idcr+"'";
								act = "<button class='btn btnEdit add_tema'><i class='material-icons ico_btn_shd ico_btn'>plus_one</i>&nbsp;Tema...</button>"
 									  +"&nbsp;<i class='material-icons less_cur i_delete'>delete_forever</i>";
							}
							else{
								idli ="";
								act = "";
							}
 							str = str +"<li "+idli+" class='li_cur_dash'>"
 									+"<a href='/temas/listar/"+dat[i].id+"' class='underl href_action' title='"+dat[i].nc+"'>"
 									+"<i class='material-icons lst_icon_grp'>folder_open</i>"
 									+"&nbsp;<span>"+dat[i].nc+"</span>"
 									+"</a>"
 									+act
 									+"</li>";
						})


						licurs+= 8;
						$('#int_liCur ul').append(str);
						$('#loadslidegrp').hide();
					})	
				})
			})
        }
    });

    $('#int_liCur ul').on('click', '.less_cur', function(){
    	me = $(this).parents('li');
    	idc = $(me).attr('id');
    	idc = Base64.decode(idc);
    	dats = $.parseJSON(idc);

    	idcu = dats['id'];
    	nomc = dats['nc'];
    	
    	if(confirm('¡ALERTA! ¿SEGURO QUE DESEAS BORRAR ESTE CURSO?\n    SE PERDERÁ TODA LA INFORMACIÓN Y TEMAS!!')){
    		$.ajax({
    			url: '/cursos/borrar',
    			type: 'post',
    			data: {post_type: 'ajax', idcr: idcu, nocr: nomc}
    		}).done(function(info){
    			if(info == 'true'){
    				msgAlert('Borraste un Curso y todo el Contenido!!');
    				cerrar_alert_focus();
    				$(me).fadeOut(500);
    			}
    		})
    	}
    })


	$('#int_liMiemb').on('click','.more',function(){
		$('.del_ban_user').hide();
		$(this).siblings('div').show();
	})
	$('.get_topicsMod').on('click', '.more_op_topics', function(){
		$('.topic_option').hide();
		$(this).siblings('div').show();
	})

	 $('body').click(function(evt){ 
	 	var elem = $(evt.target).parents('div').attr('class');
	 	if(elem != 'online_radio' && elem != 'del_ban_user' && elem != 'topic_mod_el' && elem != 'topic_option'){
	 		$('.del_ban_user').hide();
	 		$('.topic_option').hide();
		} 
		bts = $(evt.target).attr('class');
		if(bts != 'btn btnPublish sh' && bts != 'material-icons ico sh' && bts != 'lnks_share'){
			$('.lnks_share').hide();
		}
	 });

	var sendingreso = false;
	$('#frmIngreso').submit(function(){
		var email    = $('#lemail').val();
		var password = $('#lpassword').val();

		var exprMail = /^\w+([\.\+\-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
		var exprPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&_.]{8,15}$/;	

		if(email == ''){
			msgAlert('Proporciona el email para ingresar!!');
			cerrar_alert_focus('#lemail');
			return false;
		}

		if(email.length > 60){
			msgAlert('El email es demasiado largo!!');
			cerrar_alert_focus('#lemail');
			return false;	
		}

		if(!exprMail.test(email)){
			msgAlert('El formato del email es Incorrecto, verifícalo!!');
			cerrar_alert_focus('#lemail');
			return false;			
		}

		if(password == ''){
			msgAlert('Falta el password para ingresar!!');
			cerrar_alert_focus('#lpassword');
			return false;
		}

		if(password.length < 8){
			msgAlert('El password parece muy corto, NO debe ser menor a 8 caracteres!!');
			cerrar_alert_focus('#lpassword');
			return false;	
		}

		if(!exprPass.test(password)){
			msgAlert('El password NO debe tener "acentos, eñes, o algunos caracteres raros", Y debe tener al menos una Letra y un Número!!');
			cerrar_alert_focus('#lpassword');
			return false;
		}

		$('.spinner').show();
		
		if (sendingreso == false) {
        	sendingreso = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}
	})

	var sendregistro = false;
	$('#frmRegistro').submit(function(){
		var nombre_user = $('#nombre_user').val();
		var nombres     = $('#nombres').val();
		var apellidos   = $('#apellidos').val();
		var email       = $('#email').val();
		var remail      = $('#remail').val();
		var password    = $('#password').val();
		var rpassword   = $('#rpassword').val();
		var rol 		= $('#selectrol').val();

		var exprNomU = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]{5,15}$/;
		var exprNA	 = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,60}$/;
		var exprMail = /^\w+([\.\+\-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
		var exprPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&_.]{8,15}$/;

		if(nombre_user == ''){
			msgAlert('Falta el Nombre de Usuario!!');
			cerrar_alert_focus('#nombre_user');
			return false;
		}

		if(nombre_user.length < 5){
			msgAlert('El Nombre de Usuario debe tener mínimo 5 caracteres');
			cerrar_alert_focus('#nombre_user');
			return false;
		}

		if(!exprNomU.test(nombre_user)){
			msgAlert('Nombre de usuario, NO debe tener caracteres especiales ni espacios o acentos!! Solo letras o números');
			cerrar_alert_focus('#nombre_user');
			return false;
		}

		if(nombres == ''){
			msgAlert('Faltan los Nombres!!');
			cerrar_alert_focus('#nombres');
			return false;					
		}

		if(nombres.length > 80){
			msgAlert('Nombre muy largo!!');
			cerrar_alert_focus('#nombres');
			return false;					
		}

		if(!exprNA.test(nombres)){
			msgAlert('Los Nombre NO deben contener números o caracteres extraños!!');
			cerrar_alert_focus('#nombres');
			return false;		
		}

		if(apellidos == ''){
			msgAlert('Faltan los Apellidos!!');
			cerrar_alert_focus('#apellidos');
			return false;
		}

		if(apellidos.length > 80){
			msgAlert('Apellidos muy largos!!');
			cerrar_alert_focus('#apellidos');
			return false;
		}

		if(!exprNA.test(apellidos)){
			msgAlert('Los Apellidos NO debe contener números o caracteres extraños!!');
			cerrar_alert_focus('#apellidos');
			return false;		
		}

		if(!exprMail.test(email)){
			msgAlert('Falta "El email", o el formato es Incorrecto!!');
			cerrar_alert_focus('#email');
			return false;			
		}

		if(!exprMail.test(email)){
			msgAlert('Faltan "Repetir el email", o el formato es Incorrecto!!');
			cerrar_alert_focus('#remail');
			return false;			
		}

		if(remail != email){
			msgAlert('No conciden las direcciones de email proporcionadas, repitela!!');
			cerrar_alert_focus('#remail');
			return false;				
		}

		if(password == ''){
			msgAlert('Falta el password!!');
			cerrar_alert_focus('#password');
			return false;					
		}

		if(password.length < 8){
			msgAlert('El password debe tener al menos 8 caracteres!!');
			cerrar_alert_focus('#password');
			return false;					
		}

		if(!exprPass.test(password)){
			msgAlert('El password NO debe tener "acentos, eñes, o algunos caracteres raros", Y debe tener al menos una Letra y un Número!!');
			cerrar_alert_focus('#password');
			return false;					
		}


		if(rpassword == ''){
			msgAlert('Falta repetir el password!!');
			cerrar_alert_focus('#rpassword');
			return false;					
		}

		if(rpassword.length < 8){
			msgAlert('El password debe tener al menos 8 caracteres!!');
			cerrar_alert_focus('#rpassword');
			return false;					
		}

		if(!exprPass.test(rpassword)){
			msgAlert('El password NO debe tener "acentos, eñes, o algunos caracteres", Y debe tener al menos una Letra y un Número!!');
			cerrar_alert_focus('#rpassword');
			return false;					
		}

		if(rpassword != password){
			msgAlert('No conciden los password proporcionadas, repítelo!!');
			cerrar_alert_focus('#rpassword');
			return false;					
		}

		if((rol != 'Tutor') && (rol != 'Usuario')){
			msgAlert('Selecciona un rol en el sistema!!');
			cerrar_alert_focus('#selectrol');
			return false;						
		}

		
		$('.spinner').show();
		
		if (sendregistro == false) {
        	sendregistro = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}

	})

	var sendgrupo = false;
	$('#frmAddGrupo').submit(function(){
		var nombre_grupo = $('#nombre_grupo').val();
		var descripcion_grupo = $('#descripcion_grupo').val();
		var tipo_acceso = $('#tipo_acceso').val();
		var theme 		 = $('#theme').val();
		var color_theme  = $('#color_theme').val();

		var exprNG	 = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,80}$/;
		var exprDG   = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{3,250}$/;
		var exprHEX  = /^\#[0-9a-f]{6}$/;

		if(nombre_grupo == ''){
			msgAlert('Proporciona un Nombre al Grupo!!');
			cerrar_alert_focus('#nombre_grupo');
			return false;
		}
		if(nombre_grupo.length < 3){
			msgAlert('El Nombre del Grupo debe tener al menos 3 caracteres!!');
			cerrar_alert_focus('#nombre_grupo');
			return false;
		}

		if(nombre_grupo.length > 80){
			msgAlert('El Nombre del Grupo es muy largo!!');
			cerrar_alert_focus('#nombre_grupo');
			return false;
		}

		if(!exprNG.test(nombre_grupo)){
			msgAlert('El Nombre del Grupo NO debe contener caracteres extraños!!');
			cerrar_alert_focus('#nombre_grupo');
			return false;
		}

		if(descripcion_grupo == ''){
			msgAlert('Proporciona una breve descripción del grupo y su contenido.!!');
			cerrar_alert_focus('#descripcion_grupo');
			return false;
		}

		if(descripcion_grupo.length > 250){
			msgAlert('La descripción del grupo es muy larga!!');
			cerrar_alert_focus('#descripcion_grupo');
			return false;
		}

		if(!exprDG.test(descripcion_grupo)){
			msgAlert('Algunos caracteres no son soportados en la descripción del grupo!!');
			cerrar_alert_focus('#descripcion_grupo');
			return false;
		}

		if((tipo_acceso != 'Privado') && (tipo_acceso != 'Abierto')){
			msgAlert('Elige un tipo de Acceso al Grupo!');
			cerrar_alert_focus('#acceso_grupo');
			return false;
		}

		if(!theme){
			msgAlert('Elige un tema visual que identifique al Grupo!');
			cerrar_alert_focus();
			return false;
		}

		if(!exprHEX.test(color_theme) || (color_theme == '#555555')){
			msgAlert('Elige un color válido para el tema!');
			cerrar_alert_focus('#color_theme');
			return false;
		}

		$('.spinner').show();
		
		if (sendgrupo == false) {
        	sendgrupo = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}

	})

	$('#share').click(function(){
		if(! $(this).find('div').is(':visible')){
			$(this).find('div').show();
		}
		else{
			$(this).find('div').hide();	
		}
	})

	var sendcurso = false;
	$('#frmNuevoCurso').submit(function(){
		var nombre_curso = $('#nombre_materia_curso').val();
		var pd = $('#post_dats').val();
		pd = Base64.decode(pd);
		pd = $.parseJSON(pd);

		var id_usuario = pd['id'];
		var nombre_grupo = pd['ng'];
		var id_grupo = pd['idg'];

		var exprNomCur = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,100}$/;
		var exprIdUniq = /^[0-9a-z]{16}$/;
		var exprNG	   = /^[0-9a-z\_\s]{3,80}$/;
		var exprInt    = /^\d*$/;

		if(nombre_curso == ''){
			msgAlert('Indica el nombre del Curso o Materia!!');
			cerrar_alert_focus('#nombre_materia_curso');
			return false;
		}

		if(nombre_curso.length > 100){
			msgAlert('El nombre del Curso es muy largo!!');
			cerrar_alert_focus('#nombre_materia_curso');
			return false;
		}

		if(!exprNomCur.test(nombre_curso)){
			msgAlert('No se permiten algunos caracteres para el nombre del Curso!!');
			cerrar_alert_focus('#nombre_materia_curso');
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
		
		if (sendcurso == false) {
        	sendcurso = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}		
	})

	$('.read_tema').click(function(){
		marcarTemaLeído($(this));
	})


	var sendtema = false;
	$('#frmTema').submit(function(){
		var dats = $('#post_dats_t').val();
		var ntem = $('#titulo').val();
		var fecl = $('#fecha_limite_respuesta').val();
		var perm = $('#permiso_archivo').val();

		var dt = Base64.decode(dats);
		dt = $.parseJSON(dt);

		var idt = dt['id'];
		var nco = dt['nc'];

		var exprNomCur = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,100}$/;
		var exprNomTem = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/;
		var exprDate = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
		var exprInt    = /^\d*$/;

		if(ntem == ''){
			msgAlert('Indica un Título para el Tema!!');
			cerrar_alert_focus('#titulo');
			return false;
		}

		if(ntem.length > 100){
			msgAlert('El título es muy largo!!');
			cerrar_alert_focus('#titulo');
			return false;
		}

		if(!exprNomTem.test(ntem)){
			msgAlert('No se permiten caracteres extraños para el título, solamente alfanuméricos!!');
			cerrar_alert_focus('#titulo');
			return false;						
		}

		if((fecl != '') && !exprDate.test(fecl)){
			msgAlert('Indica un formato de Fecha correcto, por favor!!');
			cerrar_alert_focus('#fecha_limite_respuesta');
			return false;	
		}

		if((perm != 'Sí') && (perm != 'No')){
			msgAlert('Indica un tipo de permiso de archivos!!');
			cerrar_alert_focus('#permiso_archivo');
			return false;						
		}

		if(!exprInt.test(idt)){
			msgAlert('identificador inválido!!');
			return false;
		}

		if(!exprNomCur.test(nco)){
			msgAlert('identificador inválido!!');
			return false;
		}

		$('.spinner').show();
		
		if (sendtema == false) {
        	sendtema = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}

	})

	var sendunidad = false;
	$('#frmUnidad').submit(function(){
		var dats    = $('#post_dats_un').val();
		var nom_uni = $('#nombre_unidad').val();
		var num_tem = $('#numero_temas').val();
		
		var exprNomU = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,80}$/;
		var exprNomCur = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,100}$/;
		var exprInt    = /^\d*$/;


		var dt = Base64.decode(dats);
		dt = $.parseJSON(dt);

		var idt = dt['id'];
		var nco = dt['nc'];

		if(nom_uni == ''){
			msgAlert("Proporciona un nombre al módulo!!");
			cerrar_alert_focus('#nombre_unidad');
			return false;
		}
		if(nom_uni.length > 80){
			msgAlert("El nombre es muy largo!!");
			cerrar_alert_focus('#nombre_unidad');
			return false;
		}

		if(!exprNomU.test(nom_uni)){
			msgAlert("El nombre del módulo no debe contener caracteres extraños!!");
			cerrar_alert_focus('#nombre_unidad');
			return false;
		}

		if(!exprInt.test(num_tem)){
			if(parseInt(num_tem) < 0 || parseInt(num_tem) > 40){
				msgAlert("El número de temas no está en el rango");
				cerrar_alert_focus('#numero_temas');
				return false;
			}
			else{
				msgAlert('El campo "Número de temas" no es un número válido!!');
				cerrar_alert_focus('#numero_temas');
				return false;
			}
		}

		if(!exprInt.test(idt)){
			msgAlert('identificador inválido!!');
			return false;
		}

		if(!exprNomCur.test(nco)){
			msgAlert('identificador inválido!!');
			return false;
		}


		$('.spinner').show();
		
		if (sendunidad == false) {
        	sendunidad = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}

	})

	$('#frmAddMember').submit(function(){
		me = $(this);
		var idg = false;
		var pos = false;
		var rec = false;
		var sel = $('#n_grupo').val();
		var pdu = $('#post_dats_usid').val();

		if(sel != 'Grupos...'){
			$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(iu){
				if(iu){	
					var exprIdUniq = /^[0-9a-z]{15,16}$/;
					var exprInt    = /^\d*$/;

					var dt = Base64.decode(sel);
					dt = $.parseJSON(dt);

					var idg = dt['id'];
					var pos = dt['pos'];
					pos = pos.split('_');
					pos = pos[pos.length -1];


					rec = Base64.decode(pdu);
					

					if(idg != pos){
						msgAlert('Identificador inválido!!');
						cerrar_alert_focus(null);
					}
					if(!exprIdUniq.test(rec)){
						msgAlert('Identificador de usuario inválido!!');
						cerrar_alert_focus(null);
					}

					var dats = $(me).serializeArray();
					dats.push({'name': 'idse', 'value': iu});
					dats.push({'name': 'post_type', 'value': 'ajax'});
					
					$('.spinner').show();
					$.ajax({
						url: '/grupos/add_member/',
						type: 'post',
						data: dats
					}).done(function(info){
						if(info == 'true'){
							msgAlert('Agregaste correctamente un Usuario a un Grupo<br><i class="material-icons">thumb_up</i>'
                        +'&nbsp;<i class="material-icons">thumb_up</i>!!');
							cerrar_alert_focus(null);
						}
						else{
							msgAlert('El usuario ya pertenece a ese Grupo, elige otro Grupo!!');
							cerrar_alert_focus(null);
						}
						$('.spinner').hide();
					})
				}
			})
		}
		else{
			msgAlert('Elige un Grupo!!');
			cerrar_alert_focus('#n_grupo');
		}
		
		return false;

	})



    $('#insert_tags #tags').change(function(){
    	txt = this.value;
    	var exprTags = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,15}$/;

    	if(txt.length > 15){
    		msgAlert('Es muy larga la palabra!');
    		cerrar_alert_focus('#tags');
    	}
    	if(!exprTags.test(txt)){
    		msgAlert('No se permiten caracteres extraños ni COMAS!');
    		cerrar_alert_focus('#tags');
    	}
    	else{    		
	    	$('<span>'+txt+'<span class="del_tag"><b>x</b></span></span>').insertBefore(this);
	    	this.value = "";
	    	document.getElementById('tags_hidden').value += txt+',';	
    	}
    })

    $('#insert_tags, #insert_words').on('click', '.del_tag',function(){
    	inp = $('#tags_hidden').val();
    	txt = $(this).parent('span').text();
    	txt = txt.substring(0, txt.length - 1);
    	arr = inp.split(',');

    	if(inArray(txt, arr)){
    		removeItemFromArr(arr, txt);
    		document.getElementById('tags_hidden').value = arr;
    		$(this).parent().remove();
    	}
    })

    $('#insert_tags, #insert_words').click(function(){
    	$('#tags').focus();
    	$('#words').focus();
    })

    $('.body_notice blockquote span').click(function(){
    	copy(null, $(this).attr('id'));
    	if($('.msg_delay').length == 0){
			msg_fade("ENLACE COPIADO");
    	}

    })

    $('#fecha_limite_respuesta').change(function(){
    		if($(this).val() == ''){
    			$('#hora_limite_respuesta').attr('disabled', 'disabled');
    			$('#hrlresp, #hora_limite_respuesta').hide();	
    		}
    		else{
    			$('#hrlresp, #hora_limite_respuesta').show();
    			$('#hora_limite_respuesta').removeAttr('disabled');
    			$('#hora_limite_respuesta').focus();
    		}
    		
    })

    sendlove = false;
    $('#love_tem').click(function(){
    	var url = ""+window.location;
    	idg = url.split('.');
    	idg = parseInt(idg[idg.length - 1]);

    	if(sendlove == false){
    		sendlove = true;
	    	$.ajax({
	    		url: '/temas/votar_tema',
	    		type: 'post',
	    		data: {post_type: 'ajax', idgr: idg}
	    	}).done(function(info){
	    		if(info == 'ok'){
	    			cnt = parseInt($('#love_tem').find('b').text()) + 1;
	    			$('#love_tem').find('b').text(cnt);
	    		}
	    		else if(info == 'exist'){
	    			msgAlert('Ya habías calificado esta publicación!!');
	    			cerrar_alert_focus();
	    		}
	    		else if(info == 'sesion'){
	    			msgAlert('Inicia sesión para dar like!!');
	    			cerrar_alert_focus();
	    		}
	    		sendlove = false;
	    	})
    	}
    })


});