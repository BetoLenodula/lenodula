    idavat = $('#showUser').attr('class');
	var pushCh = new Pusher('dddb561a0b4e2067e172');
    var canal  = pushCh.subscribe('port_msg');

    canal.bind('mensaje', function(res){
        if(res.resp == 'ok'){
            if(typeof(usp) != "undefined"){
            	get_reciente();
	            if(res.emit == usp){
	            	document.getElementById('tone_msg').play();   
	            }
        	}
        	if(typeof(idavat) != "undefined"){
        		if(res.recp == idavat){
	            	$('#flt_msg').show();
	            	$('#flt_msg').animate({'left': '3%'}, 300);
	            	$('#flt_msg').animate({'left': '2%'}, 300);   
	            }
        	}
        }
    });