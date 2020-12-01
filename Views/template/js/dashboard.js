	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	    results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function get_data_user(){
		var url = location.href;
		u = window.location.hash;
		url = url.split('/');

		if(url[3] == 'temas' && (url[4] == 'listar')){
			arg = parseInt(url[url.length - 1]);

			$.get('/usuarios/getsession/', {get_type: 'ajax'}, function(ius){
				if(ius){
					id_session = ius;
					$.get('/cursos/id_grupo_curso/'+arg, {get_type: 'ajax'}, function(idg){
						id_grupo_curso = idg;
						$.get('/temas/validar_miembro/'+ius, {get_type: 'ajax', idgr: idg}, function(mem){	
							status_member = mem;
							$.get('/cursos/id_propietario_curso/'+arg, {get_type: 'ajax'}, function(idp){
								id_prop_curso = idp;
								disp_temas_hash(u);
							})
						})	
					})	
				}
					
			})
			
		}
	}
	get_data_user();

	function disp_temas_hash(u){
		exHash = /^\#[0-9]{1,10}\-ltp$/;

		if(exHash.test(u)){
				var idm = u.split('#');
				idm = parseInt(idm[1]);
				if(idm < 0) idm = idm * (-1);
				$("#"+idm+"-ltp").find('p i').text('expand_less');
				var elem = $("#"+idm+"-ltp").children('.get_topicsMod');
				get_temas(idm, elem);
		}
	}


	function expModTopics(){
		u = window.location.hash;

		if(u != '' && u != '#t'){
			$('#Modulos').css({'height': 'auto'});
			$('#Temas').css({'height': '43px'});
		}
		if(u == '#t'){
			$('#Temas').css({'height': 'auto'});
			$('#Modulos').css({'height': '43px'});
		}
	}
	expModTopics();


	$('.li_gr i, .li_gr span').click(function(){
		var idg = $(this).parent().attr('id');
		idg = parseInt(idg);
		if(idg < 0) idg = idg * (-1);

		var elem = $(this).parent().children('ul.cr');
		
		
		if($(elem).is(':empty')){
			$('.load').show();
			
			$.ajax({
				url: '/cursos/listar/'+idg+'/',
				type: 'get',
				dataType: 'json',
				cache: true,
				data: {get_type: 'ajax'}
			}).done(function(dats){
				var str = "";

				$.each(dats, function(i){
					str = str+"<li class='li_cr' id='"+dats[i].id+"_cr'>"
							   +"<i class='material-icons'>folder_open</i>"
							   +" <span>"+dats[i].nc+"</span>"
							   +"<ul class='ul_block te'></ul>"
							 +"</li>";
				})

				$(elem).html(str);
				$('.load').hide();
			})
		}
		else{
			$(elem).html('');
		}
	})

	$('ul.cr').on('click', '.li_cr i, .li_cr span', function(){
		var idc = $(this).parent().attr('id');
		idc = parseInt(idc);
		if(idc < 0) idc = idc * (-1);

		var elem = $(this).parent().children('ul.te');
		var str = "";
		
		
		if($(elem).is(':empty')){
			$('.load').show();

			$.ajax({
				url: '/unidades/listar_dashboard/'+idc+'/',
				type: 'get',
				dataType: 'json',
				cache: true,
				data: {get_type: 'ajax'}
			}).done(function(dats){
				$.each(dats, function(i){
					str = str+"<a href=/temas/listar/"+idc+"#Modulos><li class='li_te'>"
							   +"<i class='material-icons'>widgets</i>"
							   +" <span>"+dats[i].nu+"</span>"
							 +"</li></a>";
				})
			})
			
			$.ajax({
				url: '/temas/listar/'+idc+'/',
				type: 'get',
				dataType: 'json',
				cache: true,
				data: {get_type: 'ajax'}
			}).done(function(dats){
				$.each(dats, function(i){
					str = str+"<a href=/temas/listar/"+idc+"><li class='li_te'>"
							   +"<i class='material-icons'>chrome_reader_mode</i>"
							   +" <span>"+dats[i].ti+"</span>"
							 +"</li></a>";
				})

				$(elem).html(str);
				$('.load').hide();
			})
		}
		else{
			$(elem).html('');
		}
	})

	function get_temas(idm, elm){
		var edit = false;
		var memb = false;
		exprId = /^[0-9a-z]{15,16}$/;

		if(getParameterByName('like') != '' && exprId.test(getParameterByName('like')) && (id_session != id_prop_curso)){
			id_session = getParameterByName('like');
		}
		else if(getParameterByName('like') != '' && exprId.test(getParameterByName('like')) && (id_session == id_prop_curso)){
			id_session = getParameterByName('like');
			edit = true;	
		}

		if(id_session && (id_session == id_prop_curso)){
			edit = true;
		}
		if(id_session && status_member == 1){
			memb = true;
		}

		var idcur = false;

		$.ajax({
				url: '/temas/listar/'+null,
				type: 'get',
				dataType: 'json',
				data: {get_type: 'ajax', idmod: idm, idses: id_session}
		}).done(function(dats){
				var str = "";
				$.each(dats, function(i){
				  if(dats[i].id == dats[i].it){
				  	done = "&nbsp;<i class = 'material-icons done'>check_circle</i>";
				  }		
				  else{
				  	done = "";
				  }

				  while(idcur == false){
				  	idcur = dats[i].ic;
				  }

				  idtem = {'idt': dats[i].id, 'tit': dats[i].ti};
				  idtem = Base64.encode(JSON.stringify(idtem));

				  href = dats[i].ti.toLowerCase();	
				  href = normalize(href);
				  href = href.replace(/\s/g, "_")+"."+dats[i].id;

				  if(dats[i].ti.length > 30){
				  	tit = dats[i].ti.substring(0,30)+"...";
				  }
				  else{
				  	tit = dats[i].ti;
				  }

				  if(dats[i].ni == 1){
				  	ico = "fact_check";
				  }
				  else{
				  	ico = "chrome_reader_mode";
				  }

		          str = str+ "<div class='topic_mod_el'>";
		          			  if(memb || edit){			
		          			  str = str+"<a class='underl href_action hsm' href='/temas/ver/"+href+"'>";
		          			  }
					          str = str+"<i class='material-icons ico_topics'>"+ico+"</i>"
					          +"<p title='"+dats[i].ti+"'>"+tit+"</p>";
					          if(memb || edit){
					          str = str+"</a>";
					      	  }
					      	  str = str+done;
					      	  if(edit){
					 		  str = str+"<i class='material-icons more_op_topics more'>more_vert</i>"
					          +"<div class='topic_option' id='"+idtem+"'>"
						        +"<a class='hsm href_action' href='/temas/editar/"+href+"'><span>Editar</span></a>"
						        +"<span class='delete_tema'>Eliminar</span>"
						        +"<img src='/Views/template/images/shift.png'>"
					          +"</div>";
					      	  }
				   str = str+"</div>";

		})

				if(edit){

					idcur = {'idc': idcur, 'pr': 'dat_cur'};
					idcr = Base64.encode(JSON.stringify(idcur));
					str = str+"<div class='topic_mod_el add_tem_mod'>"
							 +"<i class='material-icons ico_topics'>add_circle_outlined</i>"
							 +"<form class='frmAddTemMod' method='post' action=''>"
							 +"<input type='text' name='titulo' value='' class='inptxtshort titulo' placeholder='Título...'>"
							 +"<input class='pd' type='hidden' name='pd' value='"+idcr+"'>"
							 +"<button class='btn btnPublish' type='submit'>Agregar</button>"
							 +"</form>"
							 +"</div>";
				}

				$(elm).html(str);
				$('.spinner').hide();
		})
	}


	$('.list_modulo .ico_modul, .list_modulo .exp_topic').click(function(){
		var idm = $(this).parent().attr('id');
		idm = parseInt(idm);
		if(idm < 0) idm = idm * (-1);

		var elem = $(this).parent().children('.get_topicsMod');

		if($(elem).is(':empty')){
			window.location.hash = idm + "-ltp";
			$('.spinner').show();
			get_temas(idm, elem);	
			$(this).parent().find('p i').text('expand_less');
		}
		else{
			$(elem).html('');
			$(this).parent().find('p i').text('expand_more');
		}

	})


	$('#Modulos').on('click', '.add_tem_mod i', function(){
		frm = $(this).parent().find('form');

		if($(frm).is(':visible')){
			$(frm).hide();
			$(this).text('add_circle_outlined');
		}
		else{
			$(this).text('close');
			$(frm).fadeIn(300);
		}
	})

	$('.bodyTopics').on('submit', '.frmAddTemMod', function(){
		var exprNomTem = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/;
		var exprInt    = /^\d*$/;

		me = $(this);
		idu = $(me).parents('.list_modulo').attr('id');
		idun = parseInt(idu);

		tit = $(me).find('.titulo').val();
		pd = $(me).find('.pd').val();
		
		var dc = Base64.decode(pd);
		dc = $.parseJSON(dc);

		var idc = dc['idc'];
		var pre = dc['pr'];

		if(tit == ''){
			msgAlert('Indica un Título para el Tema!!');
			cerrar_alert_focus('.titulo');
			return false;
		}
		if(tit.length > 100){
			msgAlert('El título del tema es muy largo!!');
			cerrar_alert_focus('.titulo');
			return false;
		}

		if(!exprNomTem.test(tit)){
			msgAlert('No se permiten caracteres extraños solamente alfanuméricos!!');
			cerrar_alert_focus('.titulo');
			return false;						
		}

		if(!exprInt.test(idun)){
			msgAlert('identificador inválido!!');
			return false;
		}
		if(!exprInt.test(idc)){
			msgAlert('identificador inválido!!');
			return false;
		}

		if(pre != 'dat_cur'){
			msgAlert('identificador inválido!!');
			return false;
		}

		$(me).find('button').attr('disabled', 'disabled');

		
		dats = $(this).serializeArray();
		dats.push({'name': 'idu', 'value': idu});
		dats.push({'name': 'post_type', 'value': 'ajax'});
		
		$('.spinner').show();
		$.ajax({
			url: '/temas/add_tema',
			type: 'post',
			data: dats
		}).done(function(info){
			if(info != 'exist' || info != 'error'){
				act = $(me).parents('.add_tem_mod');

				idtema = info.split('.');
				
				idtem = {'idt': parseInt(idtema[1]), 'tit': tit};
				idtem = Base64.encode(JSON.stringify(idtem));
				
		   		html = "<div class='topic_mod_el'>"
		          		+"<a class='underl href_action hsm' href='/temas/ver/"+info+"'>"
						+"<i class='material-icons ico_topics'>chrome_reader_mode</i>"
						+"<p title='"+tit+"'>"+tit+"</p>"
						+"</a>"
						+"<i class='material-icons more_op_topics more'>more_vert</i>"
					   	+"<div class='topic_option' id='"+idtem+"'>"
					   	+"<a class='hsm href_action' href='/temas/editar/"+info+"'><span>Editar</span></a>"
					   	+"<span class='delete_tema'>Eliminar</span>"
					   	+"<img src='/Views/template/images/shift.png'>"
					   	+"</div>"
					  +"</div>";
				$(html).insertBefore(act);
				$(me).find('button').removeAttr('disabled');
				$(me).find('.titulo').val('');
			}
			else{
				msgAlert('Ya existe un tema con ese Nombre, elige otro!!');
				cerrar_alert_focus();
			}
			$('.spinner').hide();
		})

		return false;
	})

	$('.action_temas, .get_topicsMod').on('click', '.delete_tema', function(){
		me = $(this);
		pd = $(this).parent('div').attr('id');
		dats = Base64.decode(pd);
		dats = $.parseJSON(dats);

		var exprNomTem = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/;
		var exprInt    = /^\d*$/;

		idt = dats['idt'];
		tit = dats['tit'];

		if(!exprNomTem.test(tit)){
			msgAlert('identificador inválido!!');
            return false; 
		}
		if(!exprInt.test(idt)){
			msgAlert('identificador inválido!!');
            return false; 
		}

		if(confirm('¿REALMENTE BORRARÁS EL TEMA: "'+tit+'"?')){
			$.ajax({
				url: '/temas/borrar',
				type:'post',
				data: {post_type: 'ajax', idte: idt, tite: tit}
			}).done(function(info){
				if(info == 'true'){
					$(me).parents('.list_tema').fadeOut(700);
					$(me).parents('.topic_mod_el').fadeOut(700);
				}
			})
		}
		
	})



	$(document).on('click', '.hst' ,function(e){
		window.location.hash = "t";
	})

	$('.headTopics').click(function(){
		elem = $(this).parent().attr('id');
		//history.replaceState({}, null, ' ');
		$(this).parent().css({'height': 'auto'});

		if(elem == 'Modulos'){
			$('#Temas').css({'height': '43px'});
		}
		if(elem == 'Temas'){
			$('#Modulos').css({'height': '43px'});
		}
	})