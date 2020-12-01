function last_blog(){
	$.ajax({
		url: 'https://lenodula.com/blog/ultimo_articulo?get_type=ajax',
		dataType: 'json'
	}).done(function(dat){
		$.each(dat, function(i){
			$('#head_blg_lnd').css({'background-image': 'url('+dat[i].fot+')'});
			$('#head_blg_lnd').html('<h6>'+dat[i].tit+'</h6>');
			$('#body_blg_lnd').html("<article>"+dat[i].des+"<br><br><a class='href_action inline underl' href='https://lenodula.com/blog'>LEER MÁS...</a></article>");
		})
	})
}