var avatar = document.getElementById('avatar');
var sobreAva = document.getElementById('sobreAvatar');

avatar.onmouseover = function() {
    sobreAva.style.display = "block";
}
sobreAva.onmouseleave = function() {
    sobreAva.style.display = "none";
}


var frmApresentacao = document.getElementById('registoApresentacao');
var frmEdicao = document.getElementById('registo');
var btnEdit = document.getElementById('action-img-edit');
var btnSave = document.getElementById('action-img-mark');

var campoPsw = document.getElementById('psw');
var campoConfPsw = document.getElementById('campo-conf-psw');
var campoEmail = document.getElementById('email');
var campoConfEmail = document.getElementById('campo-conf-email');

var msg_email = document.getElementById('inf-email');

btnEdit.onclick = function() {
    frmApresentacao.style.display = "none";
    frmEdicao.style.display = "block";
}
btnSave.onclick = function() {
    frmApresentacao.style.display = "block";
    frmEdicao.style.display = "none";
}

campoPsw.onclick = function() {
    campoConfPsw.style.display = "block";
}

campoEmail.onclick = function() {
    campoConfEmail.style.display = "block";
}

campoEmail.onkeyup = function() {
    msg_email.innerHTML = "Será enviado um email de validação de conta para o seu novo email";
    msg_email.style.color = "orange";
}


function confirmarModal() {
    
}