$(function () {
    rayas();
    abecedario();
    intentos();
});


var aleatorio = Math.floor(Math.random() * palabras.length);
var palabra_escogida = palabras[aleatorio];
var pista_escogida = "Pista: " + pistas[aleatorio];
var imagen_escogida = imagenes[aleatorio];

var intent = 5;
var g = [];

function rayas() {
    for (let i = 0; i <= palabra_escogida.length - 1; i++) {
        g.push("-");
    }
    $("#letras").text(g.join(" "));
    $("#pistas").text(pista_escogida);

    if(imagen_escogida != 'na'){
        $('#imagen_pista').attr('src', imagen_escogida);
    }
}

function mostrarRayas() {
    for (let i = 0; i < g.length; i++) {
        $("#letras").text(g.join(" "));
    }
}

var abc = [
    "A",
    "B",
    "C",
    "D",
    "E",
    "F",
    "G",
    "H",
    "I",
    "J",
    "K",
    "L",
    "M",
    "N",
    "Ñ",
    "O",
    "P",
    "Q",
    "R",
    "S",
    "T",
    "U",
    "V",
    "W",
    "X",
    "Y",
    "Z",
];

function abecedario() {
    var a = "";
    var myDiv = document.createElement("ul");

    for (let i = 0; i < abc.length; i++) {
        var li = document.createElement("li");

        var a = document.createElement("a");
        a.href = "#guessing";
        a.setAttribute("onclick", 'comprobar("' + abc[i] + '")');
        var al = document.createTextNode(abc[i]);
        a.appendChild(al);
        li.appendChild(a);
        myDiv.appendChild(li);

        $(myDiv).appendTo("#abc");
    }
}

function comprobar(letra) {
    var letra_escogida = ["-"];

    for (let i = 0; i < abc.length; i++) {
        if (abc[i] === letra) {
            abc.splice(i, 1);
        }

    }
    $("#abc").html("");
    abecedario();
    letra_escogida.push(letra);

    jugar(letra);
}

function jugar(letra) {
    var p = 0;
    var c = 0;
    var no = 0;
    var f = 0;

    for (let i = 0; i < palabra_escogida.length; i++) {
        if (palabra_escogida.charAt(i).toUpperCase() == letra) {
            p = i;
            g[p] = letra;
            mostrarRayas();
            f += 1;
        }
    }
    for (let i = 0; i < g.length; i++) {
        if (g[i] != "-") {
            no++
        }
    }

    if (no == palabra_escogida.length) {
        fin();
    }

    if (f === 0) {
        intent--;
        intentos();
    }
}

function intentos() {
    if (intent == 0) {
        $("#intentos").text("Intentos: " + intent);
        gameOver();
    } else {
        $("#intentos").text("Intentos: " + intent);
    }
}

function gameOver() {
    g = [];
    $("#abc").text("");
    $(".abc").css("display", "none");
    $(".mensajes").css("display", "flex");
    $(".mensajes").css("background-color", "rgb(138,22,22)");
    $("#mensajes").text("UPS!, la palabra correcta era: " + palabra_escogida.toUpperCase());
     $('#imagen_pista').css({'filter': 'blur(0)'})
}

function fin() {
    g = [];
    $("#abc").text("");
    $(".abc").css("display", "none");
    $(".mensajes").css("display", "flex");
    $(".mensajes").css("background-color", "#268b3c");
    $("#mensajes").text("Acertaste. MUY BIEN!");
    $('#imagen_pista').css({'filter': 'blur(0)'});
}

function again() {
    location.reload();
}

$('#imgwrd').on('click', 'i', function(){
    $(this).parents('#imgwrd').html('');
})

$('#add_p_img_wrd').click(function(){
    reg_URL = /\b(https?|ftp|file):\/\/[\-A-Za-z0-9+&@#\/%?=~_|!:,.;]*[\-A-Za-z0-9+&@#\/%=~_|]/;
    src = prompt('ESCRIBE O PEGA LA URL DE UNA IMAGEN!');
    if(src){
        if(!reg_URL.test(src)){
            msgAlert('Url Inválida, revisa que sea una URL correcta!');
            cerrar_alert_focus();
        }
        else{
           $('#imgwrd').html("<div><img src='"+src+"' id='prev_img_wrd'><i class='material-icons'>close</i></div>");
        }
    }
})

$('#frmGuessWord').submit(function(){
    nom = $('#nombre').val();
    pal = $('#palabra').val();
    pis = $('#pista').val();

    wrs = $('#words').val();
    cls = $('#clues').val();

    var exprNomGWP = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{1,100}$/;
    var exprPalabra = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,20}$/;

    if(nom == ''){
        msgAlert('Ingresa un título para esta actividad!');
        cerrar_alert_focus('#nombre');
        return false;
    }
    if(nom.length > 100){
        msgAlert('El título es muy largo!');
        cerrar_alert_focus('#nombre');
        return false;
    }
    if(!exprNomGWP.test(nom)){
        msgAlert('No incluyas caracteres extraños en el título!');
        cerrar_alert_focus('#nombre');
        return false;
    }

    if(pal == ''){
        msgAlert('Ingresa una palabra!');
        cerrar_alert_focus('#palabra');
        return false;
    }
    if(pal.length > 20){
        msgAlert('Esa palabra es muy larga!');
        cerrar_alert_focus('#palabra');
        return false;
    }
    if(!exprPalabra.test(pal)){
        msgAlert('No incluyas caracteres extraños ni ESPACIOS ni COMAS en la PALABRA!');
        cerrar_alert_focus('#palabra');
        return false;
    }

    if(pis == ''){
        msgAlert('Ingresa una pista para adivinar la palabra!');
        cerrar_alert_focus('#pista');
        return false;
    }
    if(pis.length > 100){
        msgAlert('Se más breve en la pista!');
        cerrar_alert_focus('#pista');
        return false;
    }
    if(!exprNomGWP.test(pis)){
        msgAlert('No incluyas caracteres extraños, o COMAS en la PISTA!');
        cerrar_alert_focus('#pista');
        return false;
    }
    if($('#prev_img_wrd').length){
        pic = $('#imgwrd').find('#prev_img_wrd').attr('src');
        pg = $('#pic_guess').val() + pic+',';
        $('#pic_guess').val(pg);
    }
    else{
        pg = $('#pic_guess').val();
        $('#pic_guess').val(pg +'na,');
    }

    wv = $('#words').val() + pal+',';
    cv = $('#clues').val() + pis+',';

    $('#words').val(wv);
    $('#clues').val(cv);

    $('#palabra').val('');
    $('#pista').val('');
    $('#imgwrd').html('');

    $('#liwr_licl').append("<div class='dlwlc'><div class='lwcl'><p>"+pal+"</p></div><div class='lwcl'><p>"+pis+"</p></div></div>");

    return false;
})

$('#send_cgsswrd').click(function(){
    me = $(this);
    var url = ""+window.location;
    var url = url.split('/');
    argumento = url[5];

    words = $('#words').val();
    clues = $('#clues').val();

    var exprWords = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,]{1,400}$/;
    var exprClues = /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\,\s\(\)\:\"\+\-\*\/\;\.\_\¿\?\¡\!\&\-\$\=\%\']{1,}$/;

    if(words == ''){
        msgAlert('Introduce palabras!!');
        cerrar_alert_focus('#palabra');
        return false;
    }
    if(words.length > 400){
        msgAlert('Son muchas palabras!');
        cerrar_alert_focus();
        return false;
    }
    if(!exprWords.test(words)){
        msgAlert('No se permiten caracteres extraños ni ESPACIOS en las PALABRAS!');
        cerrar_alert_focus();
        return false;
    }

    if(clues == ''){
        msgAlert('Introduce pistas para adivinar!!');
        cerrar_alert_focus('#pista');  
        return false; 
    }
    if(!exprClues.test(clues)){
        msgAlert('No se permiten caracteres extraños en ni COMAS en la PISTA!');
        cerrar_alert_focus();
        return false;
    }

    dat = $('#frmGuessWord').serializeArray();
    dat.push({'name': 'post_type', 'value': 'ajax'});

    $('.spinner').show();
    $(me).attr('disabled', 'disabled');

    $.ajax({
      url: '/temas/crearguesswrd/'+argumento,
      type: 'post',
      data: dat
    }).done(function(info){
      if(info == false){
        msgAlert("Ese módulo ya existe con ese nombre, usa otro!!");
        cerrar_alert_focus();
      }
      else if(info == 'error'){
        msgAlert("Ocurrió un error en la inserción!!");
        cerrar_alert_focus();
      }
      else{
        location.replace('/temas/guessword/'+info);
      }
       $('.spinner').hide();
       $(me).removeAttr('disabled');
    })
})