    var url = ""+window.location;
    var metodo = url.split('/');
        argume = metodo[5];

        if(argume.indexOf('?') != '-1'){
            argume = argume.substring(0, argume.indexOf('?'));
        }
        if(argume.indexOf('#') != '-1'){
            argume = argume.substring(0, argume.indexOf('#'));
        }

        metodo = metodo[4];

if(metodo != 'listar'){
    colcanv = "#000000";
    sizcanv = 3;

    var canvas = document.querySelector("canvas");
    if(canvas != null){
        var ctx = canvas.getContext("2d");
        var xOffset = 100;
        var yOffset = 100;
        var cw = (canvas.width = (canvas.clientWidth * xOffset) / 100), cx = cw / 2;
        var ch = (canvas.height = (canvas.clientHeight * yOffset) / 100), cy = ch / 2;
        
        ctx.lineJoin = "round";
        ctx.fillStyle = "#FFFFFF";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        function setting_stroke(color_canv, size_canv, ctx){
            ctx.strokeStyle = color_canv;
            ctx.lineWidth = size_canv;   
        }
        setting_stroke(colcanv, sizcanv, ctx);

        var dibujando = false;
        var m = { x: 0, y: 0 };

        var eventsRy = [{event:"mousedown",func:"onStart"}, 
                        {event:"touchstart",func:"onStart"},
                        {event:"mousemove",func:"onMove"},
                        {event:"touchmove",func:"onMove"},
                        {event:"mouseup",func:"onEnd"},
                        {event:"touchend",func:"onEnd"},
                        {event:"mouseout",func:"onEnd"}
                       ];

        function onStart(evt) {
          $('#color_pen').hide();
          $('#size_pen').hide();
          colr_pen = false;
          siz_pen = false;
          m = oMousePos(canvas, evt);
          ctx.beginPath();
          dibujando = true;
        }

        function onMove(evt) {
          if (dibujando) {
            ctx.moveTo(m.x, m.y);
            m = oMousePos(canvas, evt);
            ctx.lineTo(m.x, m.y);
            ctx.stroke();
          }
        }

        function onEnd(evt) {
          dibujando = false;
        }

        function oMousePos(canvas, evt) {
          var ClientRect = canvas.getBoundingClientRect();
          var e = evt.touches ? evt.touches[0] : evt;

            return {
              x: Math.round(e.clientX - ClientRect.left),
              y: Math.round(e.clientY - ClientRect.top)
            };
        }

        for (var i = 0; i < eventsRy.length; i++) {
          (function(i) {
              var e = eventsRy[i].event;
              var f = eventsRy[i].func;console.log(f);
              canvas.addEventListener(e, function(evt) {
                    evt.preventDefault();
                    window[f](evt);
                    return;
                },false);
          })(i);
        }

        clear.addEventListener(
          "click",
          function() {
            ctx.clearRect(0, 0, cw, ch);
            ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
          },
          false
        );

        $('#add_pcanv').change(function(e){
            var TmpPath = URL.createObjectURL(e.target.files[0]);
            var img = new Image();
            img.src = TmpPath;
            img.onload = function(){
                escalar(this);          
            }
        })

        function escalar(img){
            if(canvas.width > canvas.height)
            var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            if(canvas.width < canvas.height)
            var scale = Math.max(canvas.width / img.width, canvas.height / img.height);
            var x = (canvas.width / 2) - (img.width / 2) * scale;
            var y = (canvas.height / 2) - (img.height / 2) * scale;
            ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
        }


        $('#save_canvas').click(function(){
                var url = ""+window.location;
                var url = url.split('/');
                    metodo = url[4];
                    argumento = url[5];
                    
                    if(metodo == 'ver'){
                        resource = 'respuesta';
                    }
                    if(metodo == 'editar'){
                        resource = 'tema';
                    }

                    rsrce = Base64.encode(resource);
                    argumento = Base64.encode(argumento);

                    
                if(isMobile()){
                    data = canvas.toDataURL('image/jpeg', 0.8);
                }
                else{
                    data = canvas.toDataURL('image/jpeg', 0.4);
                }    
                $(this).attr('disabled', 'disabled');

            if(confirm('¿CONFIRMAS GUARDAR LA CAPTURA ACTUAL?')){
                $('.spinner').show();
                $.post('/temas/saveCanvas', {img : data, rsrc: rsrce, arg: argumento, post_type: 'ajax'}, function(data){ 
                    if(data == "true"){
                        location.reload();
                    }
                })
            }
            else{
                $(this).removeAttr('disabled');            
            }
        })
    }
}

function del_game(arg, met){
    me = $(arg);
    i = $(me).parents('.div_game').find('.elm_game a').attr('href');
    idg = i.split('=');
    idg = parseInt(idg[1]);

    if(confirm('¿CONFIRMAS BORRAR ESE ELEMENTO?')){

        $.ajax({
            url: '/temas/'+met,
            type:'post',
            data: {idgm: idg, post_type: 'ajax'}
        }).done(function(info){
            if(info == "true"){
                $(me).parents('.div_game').fadeOut(500);
            }
            if(info == "false"){
                msgAlert('Algo falló al eliminar elemento!');
                cerrar_alert_focus();
            }
            if(info == "ses"){
                msgAlert("Inicia sesión para borrar el elemento!");
                cerrar_alert_focus();
            }
        })
    }
}

$(document).ready(function(){
    
     $('div[contenteditable]').keydown(function(e) { // trap the return key being pressed 
         if(e.keyCode === 13) {
             
            elem = window.getSelection().focusNode.parentNode;
            curr = window.getSelection().focusNode;
        
            if(elem == "[object HTMLQuoteElement]" || elem == "[object HTMLLabelElement]"){   
                e.preventDefault();
                $('<br><br>').insertAfter(curr);
            }
         } 
      });

        function setCursorToEnd(ele){ 
             var range, selection; 
             if(document.createRange){ 
                 range = document.createRange();
                 range.selectNodeContents(ele);
                 range.collapse(false);
                 selection = window.getSelection();
                 selection.removeAllRanges();
                 selection.addRange(range);
             }else if(document.selection){ 
                 range = document.body.createTextRange();
                 range.moveToElementText(ele);
                 range.collapse(false);
                 range.select();
             }   
         }



        function returnClassExt(ext){
            ext = ext.toLowerCase();

            if(ext == '.doc' || ext == '.docx'){
                return  'attach_word';
            }
            else if(ext == '.xls' || ext == '.xlsx'){
                return  'attach_excel';
            }
            else if(ext == '.ppt' || ext == '.pptx'){
                return  'attach_ppoint';
            }
            else if(ext == '.pdf'){
                return  'attach_pdf';
            }
            else if(ext == '.txt' || ext == '.rtf'){
                return  'attach_txt';
            }
            else if(ext == '.jpg' || ext == '.jpeg' || ext == '.png' || ext == '.gif'){
                return  'attach_image';
            }
            else if(ext == '.html' || ext == '.cpp' || ext == '.c' || ext == '.css' || ext == '.js' || ext == '.sql' || ext =='.java'){
                return  'attach_code';
            }
            else if(ext == '.zip' || ext == '.rar'){
                return  'attach_cab';
            }
            else if(ext == '.mp3' || ext == '.ogg' || ext == '.m4a'){
                return  'attach_audio';
            }
            else if(ext == '.mp4'){
                return 'attach_video';
            }
            else{
                return 'attach_file';
            }
            
        }  
         
	    function formato(f){
            document.execCommand(f, false, null);
        }

        function cambiaFuente(f){
            document.execCommand("fontName",false,f);
        }

        function ponerTitulo(){
            document.execCommand("formatBlock",false,"<h1>");
        }

        function ponerCita(){
            document.execCommand("formatBlock",false,"<blockquote>");    
        }

        function insertQuestion(){
            var parent = window.getSelection().focusNode;

            if(parent != "[object HTMLQuoteElement]" && parent.parentNode != "[object HTMLQuoteElement]"){
                document.execCommand("formatBlock",false,"<blockquote>");   
                var elem = window.getSelection().focusNode;
                if(elem == "[object HTMLQuoteElement]"){
                    $(elem).addClass("question");
                }
                else{
                    $(elem).parent('blockquote').addClass("question");   
                }
                
            }
            else{
                msgAlert("Es mejor crear los bloques de preguntas independientes uno de otro!!");
                cerrar_alert_focus();
            }
        }

        function insertarHtml(h){
            document.execCommand("insertHTML", false, h)
        }

        function insertarEnlace(){
            reg_URL = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
            var u;
            u = prompt('PEGA UNA URL O EL ENLACE AQUÍ:');
            if(u){
                if(!reg_URL.test(u)){
                    msgAlert('Url Inválida, revisa que sea una URL correcta!');
                    cerrar_alert_focus();
                }
                else{
                    document.execCommand("CreateLink",false,u);
                }
            }
        }

        function insertarImagen(){
            reg_URL = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
            var u;
            u = prompt('ESCRIBE O PEGA AQUÍ LA URL DE LA IMAGEN:');
            if(u){
                if(!reg_URL.test(u)){
                    msgAlert('Url Inválida, revisa que sea una URL correcta!');
                    cerrar_alert_focus();
                }
                else{
                    document.execCommand("InsertImage",false, u);
                }
            }
        }

        function color(c){
            document.execCommand("forecolor",false,c);
        }

        function hiliteColor(c){
            document.execCommand("hiliteColor",false,c);   
        }

        $('#bold').click(function(){
            formato('bold');
        })
        $('#italic').click(function(){
            formato('italic');
        })

        $('#underline').click(function(){
            formato('underline');
        })

        $('#link').click(function(){
            insertarEnlace();
        })

        $('#unlink').click(function(){
            formato('unLink');
        })

        $('#alignfull').click(function(){
            formato('justifyFull');
        })

        $('#alignleft').click(function(){
            formato('justifyLeft');
        })

        $('#aligncenter').click(function(){
            formato('justifyCenter');
        })

        $('#alignright').click(function(){
            formato('justifyRight');
        })

        $('#insertimage').click(function(){
        	insertarImagen();
        })

        $('#newline').click(function(){
            var editor = document.getElementById('txthtml');
            $('#txthtml').append('<br><br>');
            setCursorToEnd(editor);
            h = $('#txthtml').prop('scrollHeight');
            $('#txthtml').scrollTop(h);
        })

        $('#check').click(function(){
            insertarHtml('<fieldset contenteditable="false"><span><b><i class="material-icons" style="font-size:15px">backspace</i></b></span>&nbsp;<input class="checkbtn" type="checkbox" value=".1"></fieldset><label>[Texto...]</label>');
        })

        $('#txtareainsert').click(function(){
            insertarHtml('<fieldset class="txtareainsert"><textarea class="txtareainsert"></textarea></fieldset>');
        })

        $('#txthtml').on('click','fieldset span', function(){
            $(this).parent().remove();
        })

        $('#seloptions').click(function(){
            n = prompt("¿Cuantas OPCIONES tendrá el SELECTOR?");
            if(!isNaN(n)){
                op = "<option value='.1'>...</option>";
                for(var i = 1; i <= n; i++){
                    o = prompt("¿OPCIÓN "+i+"?");
                    op = op+"<option value='.1'>"+o+"</option>"; 
                }

                insertarHtml('<label>Texto1...(</label><fieldset contenteditable="false" class="select"><span><b><i class="material-icons" style="font-size: 15px">backspace</i></b></span>&nbsp;<select>'+op+'</select></fieldset>&nbsp;<label>) Texto2...</label>');
            }
            else{
                msgAlert('El dato que introduciste NO es un Número!!');
                cerrar_alert_focus();
            }
        })


        $('#quote').click(function(){
            ponerCita();
        })

        $('#quest').click(function(){
            insertQuestion();
        })


        $('#video').click(function(){
            var regExpYT = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
            var p = prompt('INSERTA AQUÍ LA URL DE UN VIDEO DE YouTube:');
            if(p){
                if(regExpYT.test(p)){
                    idvideo = extractVideoID(p);
                    var html = "<figure class='video'>"
                               +"<iframe width='100%' src='https://www.youtube.com/embed/"+idvideo+"' frameborder='0' allowfullscreen>"
                               +"</iframe>"
                             +"</figure><br>";
                    insertarHtml(html);  
                }
                else{
                    msgAlert('No es una dirección válida de Youtube.');
                    cerrar_alert_focus();
                }   
            }
        })

        $('#undo').click(function(){
            formato('undo');
        })

        $('#redo').click(function(){
            formato('redo');
        })

        $('#orderl').click(function(){
            formato('insertOrderedList');
        })

        $('#unorderl').click(function(){
            formato('insertUnorderedList');
        })

        $('#select').click(function(){
            formato('selectAll');
        })

        $('#fontselect').change(function(){
            var f = $(this).val();
            cambiaFuente(f);
        })

        $('#title').click(function(){
            ponerTitulo();
        })

        $('#forecolor').click(function(){
            if(!$('#color_text').is(':visible')){
                $('#color_text').show();
            }
            else{
                $('#color_text').hide();
            }
        })

        $('#color_text').change(function(){
           var col = $(this).find('input').val();
           color(col);
           $('#color_text').hide();
        })

        $('#delete').click(function(){
            formato('removeFormat');
        })

        $('#hilitecolor').click(function(){
            hiliteColor('#FFFB7A');
        })

        $('#canvas_pen').click(function(){
            location.hash = 'archivosVisor';
            $('#div_canvas').css({'visibility': 'visible'});
            $('#cont_canvas').show();
        })

        delcanv = false;
        $('#del_canvas').click(function(){
            if(delcanv == false){
                $(this).find('i').css({'color': '#3498DB'});
                $('canvas').css({'cursor': 'grab'});
                setting_stroke("#FFFFFF", sizcanv, ctx);
                delcanv = true;
            }
            else{
                $(this).find('i').css({'color': '#555'});
                $('canvas').css({'cursor': 'pointer'});
                setting_stroke(colcanv, sizcanv, ctx);
                delcanv = false;
            }
        })

        $('#color_canv_pen').change(function(){
            col = $(this).val();
            colcanv = col;
            $('canvas').css({'cursor': 'pointer'});
            setting_stroke(colcanv, sizcanv, ctx);
        })

        $('#size_pen i').click(function(){
            siz = $(this).attr('id');
            sizcanv = parseInt(siz);
            $('canvas').css({'cursor': 'pointer'});
            setting_stroke(colcanv, sizcanv, ctx);
            $('#size_pen i').css({'color':'black'});
            $(this).css({'color': '#3498DB'});
            $('#del_canvas').find('i').css({'color': '#555'});
            delcanv = false;
        })

        colr_pen = false;
        siz_pen = false;
        $('#btn_color_pen').click(function(){
            if(colr_pen == false){
                $('#color_pen').show();
                $('#size_pen').hide();
                colr_pen = true;
                siz_pen = false;
            }
            else{
                $('#color_pen').hide();
                $('#size_pen').hide();
                colr_pen = false;
                siz_pen = false;   
            }
        })
        $('#btn_size_pen').click(function(){
            if(siz_pen == false){
                $('#color_pen').hide();
                $('#size_pen').show();
                colr_pen = false;
                siz_pen = true;
            }
            else{
                $('#color_pen').hide();
                $('#size_pen').hide();
                colr_pen = false;
                siz_pen = false;   
            }
        })

        $('.insert_file').click(function(){
            var celem = $(this).parents('.files_div').find('.file_elem').attr('class');
            var elem  = $(this).parents('.files_div').find('.file_elem').html();
            
            var href = $(elem).attr('href');
            var source = href;
                href = href.split("/");
            var file = href[href.length -1];
            var ext  = file.split(".");
                ext = ext[ext.length - 1];

            var nav = navegador();

            var root = ""+window.location;
            root = root.split('/');

            if(nav == 'Chrome' || nav == 'Opera' || nav == 'Safari'){
                if(ext == 'mp3' || ext == 'ogg' || ext == 'm4a'){
                    elem = "<br><audio src='"+source+"' controls=''></audio><br>"; 
                }
                else if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif'){
                    elem = "<img src='"+source+"'>";
                }
                else if(ext == 'mp4'){
                    elem = "<div align='center'><video src='"+source+"' controls='' width='90%'></video></div>"; 
                }
                else{
                    elem = "<br><div class='"+ celem +"' contenteditable='false'>"+ elem +"<a class='prevdoc' href='https://docs.google.com/viewer?url="+root[0]+"//"+root[2]+source+"'><span class='previewdoc'><i class='material-icons'>visibility</i></span></a>&nbsp;&nbsp;&nbsp;<i class='material-icons dlfl' style='font-size:16px'>close</i>&nbsp;</div><br>";
                }   
            }
            else{
                if(ext == 'mp3' || ext == 'ogg'){
                    elem = "<br><audio src='"+source+"' controls=''></audio><br>"; 
                }
                else if(ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif'){
                    elem = "<img src='"+source+"'>";
                }
                else if(ext == 'mp4'){
                    elem = "<div align='center'><video src='"+source+"' controls='' width='90%'></video></div>"; 
                }
                else{
                    elem = "<br><div class='"+ celem +"' contenteditable='false'>"+ elem +"<a class='prevdoc' href='https://docs.google.com/viewer?url="+root[0]+"//"+root[2]+source+"'><span class='previewdoc'><i class='material-icons'>visibility</i></span></a>&nbsp;&nbsp;&nbsp;<i class='material-icons dlfl' style='font-size:16x'>close</i>&nbsp;</div><br>";
                }
            }
            insertarHtml(elem);
        })

        $('#editor').on('click', '.dlfl', function(){
            $(this).parents('.file_elem').remove();
        })

        
        $('#table').click(function(){
            $('#tbldin').show();
            if($('#tbldin').is(':empty')){
                for (var x = 1; x <= 7; x++) {
                    for(y = 1; y <= 7; y++){
                        celd = document.createElement('div');
                        celd.setAttribute('class', 'celd');
                        celd.setAttribute('id', x.toString() + y.toString());
                        $('#tbldin').append(celd);
                    }
                }
            }
        })

        $('#tbldin').on('click', '.celd', function(){
             var idtable = '';

            for(i = 0; i <= 4; i++){
                v = Math.floor(Math.random() * 10);
                idtable = idtable + v.toString();
            }

            fc = $(this).attr('id');
            f = fc.toString().substr(0,1);
            c = fc.toString().substr(1,1);
          
            var tabla = "<div align='center'><table class='table' id='tb"+ idtable +"'>";
            if(parseInt(c) > 0){
                if(parseInt(c) < 8){
                    if(parseInt(f) > 0){
                        if(parseInt(f) < 8){
                            for(i = 1; i <= parseInt(f); i++){
                                tabla = tabla + "<tr>";
                                for(y = 1; y <= parseInt(c); y++){
                                    tabla = tabla + "<td width='80' height='30'></td>";
                                }
                                tabla = tabla + "</tr>";
                            }

                            tabla = tabla + "</table></div>"
                                          + "<div align='center' class='del_table' id='dtb"+ idtable +"' contenteditable='false'><i class='material-icons'>close</i></div><br>"; 
                            insertarHtml(tabla);
                           
                        }else{
                            alert('El número de filas es mayor a 7');
                        }
                    }   
                }
                else{
                    alert('El número de columnas es mayor a 7');
                }
            }
            $('#tbldin').hide();
        })

         $('#tbldin').on('mouseover', '.celd', function(){
            lim = $(this).attr('id');

            for (var x = 11; x <= parseInt(lim); x++) {
                if(parseInt(x.toString().substr(1,1)) <= parseInt(lim.toString().substr(1,1)) ){
                    $('#' + x.toString()).css({'background-color': '#C9EFF2'});          
                }
            }
        })
        
        $('#tbldin').on('mouseout', '.celd', function(){
           $('.celd').css({'background-color': 'white'});
        })


        $('body').click(function(evt){ 
            var elem = $(evt.target).parents('div').attr('id');
            if(elem != 'editor' && elem != 'tools'){
                $('#tbldin').hide();
                $('#color_text').hide();
                $('#actdinam div').hide();
            } 
        })

        $('#responder').click(function(){
            var me = $(this);
            var tre = $('#titulo_respuesta').val();
            var post_resp = $('#post_dats_respuestas').val();

            var exprNT   = /^[0-9a-z\_\s]{1,100}$/;
            var exprIdUniq = /^[0-9a-z]{15,16}$/;
            var exprTitR = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,150}$/;
            var exprInt  = /^\d*$/;

            var dr = Base64.decode(post_resp);
            dr = JSON.parse(dr);

            var idu = dr['idu'];
            var idt = dr['idt'];
            var tit = dr['ti'];

            if(tre == ''){
                msgAlert('Indica un título a tu respuesta!!');
                cerrar_alert_focus('#titulo_respuesta');
                return false;   
            }
            if(tre.length > 150){
                msgAlert('El título de la respuesta al tema es muy larga!!');
                cerrar_alert_focus('#titulo_respuesta');
                return false;
            }
            if(!exprTitR.test(tre)){
                msgAlert('La respuesta NO debe contener caracteres extraños!!');
                cerrar_alert_focus('#titulo_respuesta');
                return false;
            }

            if(!exprIdUniq.test(idu)){
                msgAlert('identificador inválido!!');
                return false;
            }

            if(!exprNT.test(tit)){
                msgAlert('identificador inválido!!');
                return false;
            }

            if(!exprInt.test(idt)){
                msgAlert('identificador inválido!!');
                return false;   
            }


            $('.spinner').show();
            $(me).attr('disabled', 'disabled');


            var cresp = $('#txthtml').html();
            var dats = $('#frmForoR').serializeArray();
            dats.push({'name': 'content_resp', 'value': cresp});
            dats.push({'name': 'post_type', 'value': 'ajax'});

            $.ajax({
                url: '/respuestas/nuevo/',
                type: 'post',
                data: dats
            }).done(function(info){
                if(info == 'true'){
                    location.hash = "foro";
                    location.reload();
                }
                else if(info == 'caduc'){
                    msgAlert('El tiempo límite para responder este Tema concluyó!!<br><i class="material-icons">hourglass_empty</i>');
                    cerrar_alert_focus(false);
                    $('.spinner').hide();
                }
                else{
                    $('.spinner').hide();   
                }
                $(me).removeAttr('disabled');
            })


        })

        $('.send_exam').click(function(){
            var exprNT   = /^[0-9a-z\_\s]{1,100}$/;
            var exprIdUniq = /^[0-9a-z]{15,16}$/;
            var exprTitR = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\,\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%]{1,150}$/;
            var exprInt  = /^\d*$/;

            var me = $(this);
            var post_resp = $(me).attr('id');
            var cresp = $('#theme_article_section').html();

            var dr = Base64.decode(post_resp);
            dr = JSON.parse(dr);

            var idu = dr['idu'];
            var idt = dr['idt'];
            var tit = dr['ti'];


            if(!exprIdUniq.test(idu)){
                msgAlert('identificador inválido!!');
                return false;
            }

            if(!exprNT.test(tit)){
                msgAlert('identificador inválido!!');
                return false;
            }

            if(!exprInt.test(idt)){
                msgAlert('identificador inválido!!');
                return false;   
            }

            tit = tit.replace(/_/g, ' ');

            $('.spinner').show();
            $(me).attr('disabled', 'disabled');

            var arrRes = new Array();
            var inp = "";
            $('#theme_article_section').find('.question').each(function(i){
                $(this).find('fieldset').each(function(){
                    if($(this).attr('class') == 'select'){
                        $(this).find('option').each(function(){
                            inp += ($(this).attr('class') == '1') ? '1' : '0';
                        })
                    }
                    else if($(this).attr('class') == 'txtareainsert'){
                        if($(this).find('textarea').val() != ""){
                            inp += '1';
                        }
                        else{
                            inp += '0';
                        }
                    }
                    else{
                        inp += ($(this).attr('class') == '1') ? '1' : '0';
                    }
                })
                arrRes[i] = inp;
                inp = "";
            })

            var arrQue = new Array();
            $('#theme_article_section').find('.question').each(function(i){
                $(this).find('input, select, textarea').each(function(){
                    if(this == '[object HTMLSelectElement]'){
                        $(this).find('option').each(function(){
                            inp += ($(this).val() == '1') ? '1' : '0';
                        })
                    }
                    else if(this == '[object HTMLTextAreaElement]'){
                        inp += '1';
                    }
                    else{
                        inp += ($(this).val() == '1') ? '1' : '0';
                    }
                })
                arrQue[i] = inp;
                inp = "";
            })

            qualify = 0;
            for(var i = 0; i <= arrQue.length - 1; i++){
                if(arrRes[i] == arrQue[i]){
                    qualify++;
                }
            }
            qualify = parseInt((qualify / arrQue.length) * 10);
 
            var dats = new Array();

            dats.push({'name': 'titulo_respuesta', 'value': 'Examen: '+tit});
            dats.push({'name': 'post_dats_respuestas', 'value': post_resp})
            dats.push({'name': 'content_resp', 'value': cresp});
            dats.push({'name': 'exam', 'value': 1});
            dats.push({'name': 'calif', 'value': qualify});
            dats.push({'name': 'post_type', 'value': 'ajax'});
            
            
            $.ajax({
                url: '/respuestas/nuevo/',
                type: 'post',
                data: dats
            }).done(function(info){
                if(info == 'true'){
                    marcarTemaLeído($('.read_tema'));
                    msgAlert('Se envió correctamente tu Prueba contestada<br><i class="material-icons">thumb_up</i>'
                        +'&nbsp;<i class="material-icons">thumb_up</i>!!<br>TU CALIFICACIÓN FUE DE: <b style="color: #111;">'+qualify+'</b>');
                    cerrar_alert_focus(false);
                }
                if(info == 'caduc'){
                    msgAlert('El tiempo límite para responder este Examen concluyó!!<br><i class="material-icons">hourglass_empty</i>');
                    cerrar_alert_focus(false);
                }
                if(info == 'exist'){
                    msgAlert('Ya habías contestado este Examen anteriormente!!');
                    cerrar_alert_focus(false);   
                }
                $('.spinner').hide();
                $(me).removeAttr('disabled');
            })
        })

        
        $('#comentar, #notif_games').click(function(){
            var me = $(this);
            var tte = $('#titulo').val();
            var tag = $('#tags_hidden').val();
            var fec = $('#fecha_limite_respuesta').val();
            var per = $('#permiso_archivo').val();
            var post_tema = $('#post_dats_tema').val();

            var exprNT   = /^[0-9a-z\_\s]{1,100}$/;
            var exprNomTem = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,100}$/;
            var exprTags = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,\s]{1,300}$/;
            var exprDate = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
            var exprInt  = /^\d*$/;


            var dt = Base64.decode(post_tema);
            dt = JSON.parse(dt);

            var idt = dt['id'];
            var tit = dt['ti'];
            var pte = dt['pt'];

            if(tte == ''){
                msgAlert('Indica un nombre para el Tema!!');
                cerrar_alert_focus('#titulo');
                return false;   
            }
            if(tte.length > 100){
                msgAlert('El nombre del Tema es muy largo!!');
                cerrar_alert_focus('#titulo');
                return false;   
            }
            if(!exprNomTem.test(tte)){
                msgAlert('El nombre del Tema NO debe tener caracteres extraños!!');
                cerrar_alert_focus('#titulo');
                return false;   
            }

            if(tag != ''){
                if(tag.length > 300){
                    msgAlert('Son demasiadas palabras Clave!!');
                    cerrar_alert_focus('#tags');
                    return false;
                }
                if(!exprTags.test(tag)){
                    msgAlert('No utilices caracteres extraños para las palabras clave, solamente!');
                    cerrar_alert_focus('#tags');
                    return false;
                }
            }

            if((fec != '') && !exprDate.test(fec)){
                msgAlert('Indica un formato de Fecha correcto, por favor!!');
                cerrar_alert_focus('#fecha_limite_respuesta');
                return false;   
            }

            if((per != 'Sí') && (per != 'No')){
                msgAlert('Indica un tipo de permiso de archivos!!');
                cerrar_alert_focus('#permiso_archivo');
                return false;                       
            }

            if(!exprInt.test(idt)){
                msgAlert('identificador inválido!!');
                return false;
            }

            if(!exprNT.test(tit)){
                msgAlert('identificador inválido!!');
                return false;
            }

            if(pte != 'pt'){
                msgAlert('identificador inválido!!');
                return false;   
            }

            $('.spinner').show();
            $(me).attr('disabled', 'disabled');

            var ctema = $('#txthtml').html();
            var dats = $('#frmPubTema').serializeArray();
            dats.push({'name': 'content_tema', 'value': ctema});
            dats.push({'name': 'post_type', 'value': 'ajax'});

            tte = tte.toLowerCase();
            tte = normalize(tte);
            tte = tte.replace(/\s/g, "_");
            $('#unload').html('');

            $.ajax({
                url: '/temas/editar/'+tit+'.'+idt,
                type: 'post',
                data: dats
            }).done(function(info){
                if(info == 'true'){
                    $('.spinner').hide();
                    msgAlert('Se Guardaron Los Cambios Correctamente<br><i class="material-icons">thumb_up</i>'
                        +'&nbsp;<i class="material-icons">thumb_up</i>!!');
                    cerrar_alert_focus(false);

                    if(tte != tit){
                        setTimeout(function(){
                            location.replace("/temas/editar/"+tte+"."+idt);
                        }, 2000);
                    }
                }
                else{
                    $('.spinner').hide();   
                }
                $(me).removeAttr('disabled');
            })
            
        })


     $('#txthtml').on('click', '.del_table', function(){
        t = $(this).attr('id').substring(1);
        $('#txthtml').find('#' + t).remove();
        $(this).remove();
     })

     $('#txthtml').on('change drop keydown cut paste keypress', function(){
        $('#color_text').hide();
        $('#unload').html('<script>window.onbeforeunload = function(e){ e.returnValue = "true"; };</script>');
     })


    $('#archivo').change(function(e){
        var file = $('#archivo').val();
        var ext = file.substring(file.lastIndexOf("."));
        var clext = returnClassExt(ext);

        var nf = document.getElementById('archivo').files[0].name;
        
        if(nf.length > 30){
            nf = nf.substring(0, 30)+"... ("+ext+")";
        }
        $('#pselectfile').attr('class', clext);
        $('#pselectfile').html(nf+"&nbsp;&nbsp;");
    })

    var send_file_attach = false;
    $('#frmAttach').submit(function(){
        var file = $('#archivo').val();

        if(file == ''){
            msgAlert('No has elegido un archivo aún!!');
            cerrar_alert_focus();
            return false;
        }

        var size = document.getElementById('archivo').files[0].size;
        if(size >= 5242880){
            msgAlert('El tamaño del "Archivo" excede los 5 MB!!');
            cerrar_alert_focus();
            return false;
        }

        var type = document.getElementById('archivo').files[0].type;

        var mime = new Array("text/plain","text/rtf","text/html","text/css","text/x-c++src","text/x-csrc","application/dxf","application/dwg","application/pdf","application/sql","application/x-javascript","application/x-php","application/zip","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                         "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.presentationml.presentation",
                         "application/vnd.ms-powerpoint","application/vnd.ms-publisher","application/java","application/x-rar","application/rar","audio/mpeg","audio/ogg","audio/x-m4a", "image/jpeg", "image/png", "image/gif", "video/mp4");

        if(inArray(type, mime)){
            $('.spinner').show();
        
            if (send_file_attach == false) {
                send_file_attach = true;
                return true;
            } else {
                $(this).find('input[type=submit]').val('ENVIANDO...');
                return false;
            }
        }
        else{
           msgAlert('Tipo de archivo ('+ type +'), No es soportado!!');
           cerrar_alert_focus();
           return false; 
        }

    })

    $('.delete_file').click(function(){
        me = $(this);
        id = Base64.decode($(me).parents('.files_div').attr('id'));
        hre = $(me).parents('.files_div').find('a').attr('href');
        h = hre.split('/');

        dir = h[2];
        ida = h[3];

        if(dir === 'files_tut'){
            ur = '/archivos/borrar_at';
        }
        if(dir === 'files_usr'){
            ur = '/archivos/borrar_ar';
        }

        if(confirm('¿REALMENTE VAS A BORRAR ESTE ARCHIVO?')){
            $.ajax({
                url: ur,
                type: 'post',
                data: {post_type: 'ajax', ida: id, idar: ida, di: dir}
            }).done(function(info){
                if(info == 'true'){
                    $(me).parents('.files_div').fadeOut(500);
                }
            })
        }
        
    })

    $('#ver_archs_curs').click(function(){
        if($('.archs_curso').is(':visible')){
            $('.archs_curso').hide();
            $(this).find('i:nth-child(2)').text('expand_more');
        }
        else{
            $('.archs_curso').show();
            $(this).find('i:nth-child(2)').text('expand_less');
        }
    })

    $('#txthtml').find('.question').each(function(){
        $(this).find('input').each(function(){
            if($(this).val() == '1'){
                $(this).attr('checked', '');
            }
        })
        $(this).find('select').each(function(){
            $(this).find('option').each(function(){
                if($(this).val() == '1'){
                    $(this).attr('selected', '');
                }
            })
        })
    })
    $( '#txthtml' ).on( 'click', '.checkbtn', function() {
        if($(this).is(':checked') ){
            $(this).attr('value', '1');
        } else {
            $(this).attr('value', '.1');
        }
    })


    $('#txthtml').on('change', 'select', function(){
        opt = this.options[this.selectedIndex];
        
        if(opt.value == '.1'){
            $(this).find('option').val('.1');
            this.options.item(opt.index).value = '1';
        }
    })

    
    $('#urlwrfind').attr('href', '/temas/crearwordfind/' + argume);
    $('#urlguessw').attr('href', '/temas/crearguesswrd/' + argume);
    $('#urltline').attr('href', '/temas/creartimeline/' + argume);

    $('#divLstGm').on('click', '.del_wrfnd i', function(){
        del_game($(this), 'del_wordfind'); 
    })

    $('#divLstGm').on('click', '.del_guessw i', function(){
        del_game($(this), 'del_guessword'); 
    })

     $('#divLstGm').on('click', '.del_timel i', function(){
        del_game($(this), 'del_timeline'); 
    })

    $('#actdinam').click(function(){
        if($(this).find('div').is(':visible')){
            $(this).find('div').hide();
        }
        else{
            $(this).find('div').show();
        }
    })

    limgames = 5;
    $('#bodyLstGm').scroll(function(){
        me = $(this);
        
        if($(this).scrollTop() == ($(me).find('#divLstGm').height()) - $(this).height()){
           $.ajax({
                url: '/temas/list_games/'+argume,
                type: 'get',
                dataType: 'json',
                data: {get_type: 'ajax', limit: limgames}
            }).done(function(dats){
                var str = "";
                $.each(dats, function(i){
                    if(dats[i].tip == 1){
                        ref = "/temas/wordfind/"+argume+"?wrf="+dats[i].id;
                        ico_g = "wordfind.svg";
                        del = "del_wrfnd";
                    }
                    else if(dats[i].tip == 2){
                        ref = "/temas/guessword/"+argume+"?gwr="+dats[i].id;
                        ico_g = "guessword.svg";
                        del = "del_guessw";
                    }
                    else if(dats[i].tip == 3){
                        ref = "/temas/timeline/"+argume+"?tml="+dats[i].id;
                        ico_g = "timeline.svg";
                        del = "del_timel";
                    }

                    str = str+"<div class='div_game'>"
                                    +"<div class='elm_game'>"
                                    +"<a href='"+ref+"' class='underl href_action inline'>"
                                        +"<img src='/Views/template/images/"+ico_g+"' alt='ico_game' width='20' class='imggame'>"
                                        +"<span>&nbsp;"+dats[i].nom+"</span>"
                                    +"</a>"
                                    +"</div>";
                                    if(metodo == 'editar'){
                           str = str+"<div class='"+del+"'>"
                                        +"<i class='material-icons i_delete'>delete</i>"
                                    +"</div>";
                                    }
                    str = str+"</div>";
                })

                $(me).find('#divLstGm').append(str);
                limgames += 5;
            }) 
        }
    })

});