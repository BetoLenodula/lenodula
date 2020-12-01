	function month_name(arg){
		if(arg == 1) name = "Enero";
		if(arg == 2) name = "Febrero";
		if(arg == 3) name = "Marzo";
		if(arg == 4) name = "Abril";
		if(arg == 5) name = "Mayo";
		if(arg == 6) name = "Junio";
		if(arg == 7) name = "Julio";
		if(arg == 8) name = "Agosto";
		if(arg == 9) name = "Septiembre";
		if(arg == 10) name = "Octubre";
		if(arg == 11) name = "Noviembre";
		if(arg == 12) name = "Diciembre";

		return name;
	}

	$('.calendar table.inline tbody td').click(function(){
		if($(this).attr('class') != 'nonetd'){
			$('.confirm_back, .confirm_back div').show();
			date = $(this).attr('class');
			datedec = Base64.decode(date);

			arrd = datedec.split('-');

			d = {
				dat : datedec,
				sub : 'sudate'
			}
			d = Base64.encode(JSON.stringify(d));

			if($(this).find('i.ntdt').length != 0){
				not = "<i class='material-icons'>notifications_active</i>";
			}
			else{
				not = "";
			}

			$('.date_event').html("&nbsp;<b>"+ month_name(arrd[1]) + " - " + arrd[2] + " - " + arrd[0] + "</b> " + not);
			$('#post_data_event').val(d);
		}

	})

	$('#new_event_group, #new_event_tema').click(function(){
			$('.back_shadow').show();
			$('.frmEv').show();
			$('.frmEv').animate({'top':'20%'},300);	
	})

	$('#list_view_events').click(function(){
		pd = $('#post_data_event').val();

		pdat = Base64.decode(pd);
		d = $.parseJSON(pdat);
		fec = d['dat'];
		suf = d['sub'];

		devent = ($('span.date_event b').text()).toUpperCase();
		$('#head_cont_events').html('<p>'+devent+'</p>');

		sd = fec.split('-');
		anio = sd[0];
		month = sd[1];
		day = sd[2];

		$('.spinner').show();
		
		$.ajax({
			url: '/agendas/listar/',
			type: 'post',
			dataType: 'json',
			data: {an: anio, mo: month, da: day, post_type: 'ajax'}
		}).done(function(dats){
			str = "";

			if(dats != ''){
				$.each(dats, function(i){
					idev = Base64.encode(dats[i].ide+"-"+dats[i].idu);

					if(dats[i].url != 'none'){
						ancl = "<a href='/"+dats[i].url+"'><i class='material-icons'>launch</i> seguir enlace</a>";
					}
					else{
						ancl = "";
					}

					if(dats[i].tip == 'Tarea'){
						ico = "work";
					}
					if(dats[i].tip == 'Leer'){
						ico = "local_library";
					}
					if(dats[i].tip == 'Recordatorio'){
						ico = "announcement";
					}
					if(dats[i].tip == 'Exámen'){
						ico = "list_alt";
					}
					if(dats[i].tip == 'Otro'){
						ico = "calendar_today";
					}
					str = str+"<div class='divevnt' id='"+idev+"-"+dats[i].ide+"'>"
							 	+"<div class='desevnt'>"
							 		+"<div>"
							 			+"<p><i class='material-icons icoevnt'>"+ico+"</i>&nbsp;"+dats[i].des+". "+ancl+"<br>"
							 			+"<span><i class='material-icons'>watch_later</i> Agendado para las:&nbsp;"+dats[i].hor+"</span>"
							 			+"</p>"
							 		+"</div>"
							 	+"</div>"
							 	+"<div class='actevnt'>"
							 	+"<p><i class='material-icons i_delete del_event'>delete</i></p>"
							 	+"</div>"
							 +"</div>"; 
				})
			
			}
			else{
				str = str+"<i class='material-icons empty_font'>event_busy</i>";
			}

			$('.confirm_back, .confirm_back div').hide();
			$('#contain_events_l').html(str);
			location.href = "#lEvents";
			$('.spinner').hide();
		})
	})

	$('#contain_events_l').on('click', '.del_event', function(){
		var exprInt  = /^\d*$/;
		var exprIdUniq = /^[0-9a-z]{15,16}$/;

		var me = $(this).parents('.divevnt');

		ide = $(me).attr('id');
		idd = ide.split('-');

		ideu = Base64.decode(idd[0]).split('-');
		evm = idd[1];

		ev = ideu[0];
		us = ideu[1];

		if(!exprInt.test(ev)){
			location.reload();
		}
		if(!exprInt.test(evm)){
			location.reload();
		}
		if(!exprIdUniq.test(us)){
			location.reload();
		}
		if(ev != evm){
			location.reload();
		}

		if(confirm('¿REALMENTE DESEAS BORRAR ESTE EVENTO?')){
			$('.spinner').show();

			$.ajax({
				url: '/agendas/borrar_evento',
				type: 'post',
				data: {post_type: 'ajax', idevb64: idd[0], idattach: evm}
			}).done(function(info){
				if(info == 'true'){
					$(me).fadeOut(300);
					$('.spinner').hide();
				}
				else{
					msgAlert('Algo falló al borrar el evento!!');
					cerrar_alert_focus(null);
				}
			})
		}

	})

	var sendevent = false;
	$('#frmEvent').submit(function(){

		var exprNomEv = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,150}$/;
		var exprDate = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
		var exprNG = /^[0-9a-z\_]{3,80}$/;
		var exprNT = /^[0-9a-z\_]{1,100}$/;
		var exprTime = /^[0-9]{2}:[0-9]{2}$/;
		var exprInt    = /^\d*$/;

		deve = $('#descripcion_evento').val();
		hora = $('#hora_evento').val();
		tipo = $('#tipo_evento').val();

		if($('#post_data_event').length > 0){

			pd = $('#post_data_event').val();

			pdat = Base64.decode(pd);
			d = $.parseJSON(pdat);
			fec = d['dat'];
			suf = d['sub'];
		}

		if($('#reference').length > 0 && $('#fecha_evento').length > 0){
			fec = $('#fecha_evento').val();
			suf = 'sudate';
			r_fec = true;

			url = $('#reference').val();
			url = Base64.decode(url);
			url = url.split('/');
			controll = url[0];

			url = url[url.length - 1];
			url = url.split('.')

			if(controll == 'grupos'){

				if(!exprNG.test(url[0])){
					msgAlert('Ref inválido!!');
					cerrar_alert_focus(null);
					return false;	
				}
			}
			if(controll == 'temas'){
				if(!exprNT.test(url[0])){
					msgAlert('Ref inválido!!');
					cerrar_alert_focus(null);
					return false;	
				}
			}

			if(!exprInt.test(parseInt(url[1]))){
				msgAlert('Ref inválido!!');
				cerrar_alert_focus(null);
				return false;
			}
		}


		if(!exprDate.test(fec) || suf != 'sudate'){
			if(r_fec == true){
				msgAlert('Indica una "Fecha" válida para el Evento!!');
				cerrar_alert_focus('#fecha_evento');
				return false;
			}
			else{		
				msgAlert('Id inválido!!');
				cerrar_alert_focus(null);
				return false;	
			}
		}

		if(!exprNomEv.test(deve)){
			msgAlert('Indica un nombre para el Evento, asegurate que no haya caracteres raros!!');
			cerrar_alert_focus('#descripcion_evento');
			return false;
		}
		if(!exprTime.test(hora)){
			msgAlert('Indica una "Hora" válida para el Evento!!');
			cerrar_alert_focus('#hora_evento');
			return false;
		}

		if(tipo != 'Tarea' && tipo != 'Leer' && tipo != 'Recordatorio' && tipo != 'Exámen' && tipo != 'Otro'){
			msgAlert('Elige un tipo de Evento que sea válido!!');
			cerrar_alert_focus('#tipo_evento');
			return false;	
		}


		$('.spinner').show();
		
		if (sendevent == false) {
        	sendevent = true;
        	return true;
    	} else {
        	$(this).find('input[type=submit]').val('ENVIANDO...');
        	return false;
    	}
	})