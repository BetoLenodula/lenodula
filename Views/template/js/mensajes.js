	
	var u = location.href;
	u = u.split('/');
	var usp = u[5];
	usp = usp.split('?');
	usp = usp[0];

	function get_reciente(){
		var exprIdUniq = /^[0-9a-z]{15,16}$/;

		if(!exprIdUniq.test(usp)){
			msgAlert('Id de usuario incorrecto!!');
			cerrar_alert_focus();
			return false;	
		}

		$.ajax({
			url: '/mensajes/get_lmsg',
			type: 'get',
			dataType: 'json',
			data: {get_type: 'ajax', recept: usp}
		}).done(function(dat){
			str = "";

			$.each(dat, function(i){
				if(dat[i].idu == dat[i].ide){
					cl = "msgme";
				}
				else{
					cl = "msgot";
				}

				str = str +"<article class='"+cl+"'>"
						  +dat[i].msg
						  +"<br><span>"+dat[i].tms+"</span>"
						  +"</article>";
			})
			$('#bottomsgs').before(str);
			h = $('#body_msgs').prop('scrollHeight');
			$('#body_msgs').scrollTop(h);
		})
	}

	function get_msgs_inbox(lim, pos){
		var exprIdUniq = /^[0-9a-z]{15,16}$/;

		if(!exprIdUniq.test(usp)){
			msgAlert('Id de usuario incorrecto!!');
			cerrar_alert_focus();
			return false;	
		}

		$.ajax({
			url: '/mensajes/get_lasts',
			type: 'get',
			dataType: 'json',
			data: {get_type: 'ajax', recept: usp , limit: lim}
		}).done(function(dat){
			str = "";

			$.each(dat, function(i){
				if(dat[i].idu == dat[i].ide){
					cl = "msgme";
				}
				else{
					cl = "msgot";
				}

				str = str +"<article class='"+cl+"'>"
						  +dat[i].msg
						  +"<br><span>"+dat[i].tms+"</span>"
						  +"</article>";
			})

			if(pos == "bottom"){
				$('#bottomsgs').before(str);
				h = $('#body_msgs').prop('scrollHeight');
				$('#body_msgs').scrollTop(h);
			}
			if(pos == "top"){
				$('#body_msgs').find('#topmsgs').after(str);
				limit_msgs += 8;
			}
		})
	}


	function get_recientes(){
		get_msgs_inbox(0, 'bottom');
	}

	limit_msgs = 8
	$('#body_msgs').scroll(function(){
		if($(this).scrollTop() == 0){
			get_msgs_inbox(limit_msgs, 'top');
		}
	})

	$('#frmMsg').submit(function(){
		var exprMsg = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\#]{1,800}$/;
		var exprIdUniq = /^[0-9a-z]{15,16}$/;

		var me = $(this);

		var url = location.href;
		url = url.split('/');


		var msg = $('#mensaje').val();
		var arg = url[5];
		arg = arg.split('?');
		arg = arg[0]

		if(msg.length < 1){
			msgAlert('Escribe un mensaje!');
			cerrar_alert_focus('#mensaje');
			return false;
		}

		if(msg.length > 800){
			msgAlert('El mensaje es muy largo!');
			cerrar_alert_focus('#mensaje');
			return false;
		}

		if(!exprMsg.test(msg)){
			msgAlert('El Mensaje contiene caracteres extraños!!');
			cerrar_alert_focus('#mensaje');
			return false;
		}

		if(!exprIdUniq.test(arg)){
			msgAlert('Id de usuario incorrecto!!');
			cerrar_alert_focus();
			return false;	
		}


		dats = $(this).serializeArray();
		dats.push({'name': 'post_type', 'value': 'ajax'});
		dats.push({'name': 'recept', 'value': arg});

		$(me).find('button').attr('disabled', 'disabled');

		$.ajax({
			url: '/mensajes/nuevo',
			type: 'post',
			data: dats
		}).done(function(info){
			if(info == 'true'){
				$('#mensaje').val('');
			}
			else{
				msgAlert('Algo salió mal!');
				cerrar_alert_focus();
			}
			$(me).find('button').removeAttr('disabled');
		})
		
		return false;
	})

	urlm = window.location.href;
	urlm = urlm.split('?');
	if(urlm[1] == 'msg=true'){
		$('#main_msgs').show();
		$('#open_boxmsg').hide();
		get_recientes();
	}	

	$('#open_boxmsg').click(function(){
		$('#main_msgs').show();
		$(this).hide();
		if($('#msgs').find('article').length == 0){
			get_recientes();
		}
	})
	$('#closmsg').click(function(){
		$('#main_msgs').hide();
		$('#open_boxmsg').show();	
	})