var psw = document.getElementById('password');
var conf_psw = document.getElementById('confirm_password');

var txt_psw = document.getElementById('msg_password');
var txt_confirm_psw = document.getElementById('msg_confirm_password');
var txt_geral = document.getElementById('txt_geral');

var btn_submit = document.getElementById('btn_submit');

var p_nome = document.getElementById('p_nome');
var u_nome = document.getElementById('u_nome');
var username = document.getElementById('username');
var email = document.getElementById('email');
var data_nasc = document.getElementById('data_nasc');

conf_psw.onkeyup = function()
{
    if(conf_psw.value != psw.value)
    {
        txt_confirm_psw.innerHTML = "As passwords não correspondem.";
        txt_confirm_psw.style.color = "red";
    }
    else
    {
        txt_confirm_psw.innerHTML = "As passwords correspondem.";
        txt_confirm_psw.style.color = "green";
        btn_submit.disabled = false;
    }
    
    if(conf_psw.value == "" && psw.value == "")
    {
        txt_confirm_psw.innerHTML = "";
    }
}

psw.onkeyup = function()
{   
    if(conf_psw.value != "" && psw.value != conf_psw.value)
    {
        txt_confirm_psw.innerHTML = "As passwords não correspondem.";
        txt_confirm_psw.style.color = "red";
    }
    
    if(conf_psw.value == "")
    {
        txt_psw.innerHTML = "Confirme a password no campo abaixo"
        txt_psw.style.color = "blue";
    }
    
    if(conf_psw.value == "" && psw.value == "")
    {
        txt_psw.innerHTML = "Insira uma password"
        txt_psw.style.color = "blue";
        txt_confirm_psw.innerHTML = "";
    }
    
    if(psw.value == conf_psw.value)
    {
        if(psw.value == "" || conf_psw.value == "")
        {
            txt_psw.innerHTML = "Insira uma password"
            txt_psw.style.color = "blue";
        }
        else
        {
            txt_confirm_psw.innerHTML = "As passwords correspondem.";
            txt_confirm_psw.style.color = "green";
            btn_submit.disabled = false;
        }
    }
}

conf_psw.onfocus = function()
{
    txt_psw.style.display = "none";
}

psw.onfocus = function()
{
    if(psw.value == "")
    {
        txt_psw.innerHTML = "Insira uma password"
        txt_psw.style.color = "blue";
    }
}

btn_submit.onclick = function()
{
    if(psw.value == conf_psw.value && psw.value != "" && conf_psw.value != "")
    {
        btn_submit.disabled = false;
    }
    else if(p_nome.value == "" || u_nome.value == "" || username.value == "" || email.value == "" || data_nasc.value == "")
    {
        txt_geral.innerHTML = "Os campos com * são de preenchimento obrigatório!", txt_geral.style.color = "red";
    }
    else
    {
        btn_submit.disabled = true;
    }
}