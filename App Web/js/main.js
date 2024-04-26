/* 
 * Todos os direitos reservados de DKSoft
 */

var bkg = document.getElementById('space_fechar_form');
var btn_login = document.getElementById('btn-login');
var space_login = document.getElementById('space-form-login');
var space_icon_login = document.getElementById('space-icon-login');
    
    btn_login.onclick = function() {
        if(space_login.style.right == '-250px') {
            if(btnMenu.checked) {
                bkg_menu.style.display="none";
                btnMenu.checked=false;
            }

            space_login.style.right = '0px';
            space_icon_login.style.right = '250px';
            bkg.style.display="block";
        }
        else {
            space_login.style.right = '-250px';
            space_icon_login.style.right = '0px';
            bkg.style.display = "none";

        }
    }

    bkg.onclick = function() {
        space_login.style.right = '-250px';
        space_icon_login.style.right = '0px';
        bkg.style.display = "none";
    }
    
    
var bkg_menu = document.getElementById('space_fechar_menu');
var btnMenu = document.getElementById('btn-menu');
var btnLoginFrm = document.getElementById('space-icon-login');

    btnMenu.onchange = function() {
        if(space_login.style.right = '0px') {
            space_login.style.right = '-250px';
            space_icon_login.style.right = '0px';
            bkg.style.display = "none";
        }
        if(btnMenu.checked) {
            bkg_menu.style.display="block";
        }
        else
            bkg_menu.style.display="none";
    }
    
    bkg_menu.onclick = function() {
        bkg_menu.style.display="none";
        btnMenu.checked=false;
    }
    
function mask(e, id, mask){
    mascara(id, mask);
}
function mascara(id, mask){
    var i = id.value.length;
    var carac = mask.substring(i, i+1);
    var prox_char = mask.substring(i+1, i+2);
    if(i == 0 && carac != '#'){
        insereCaracter(id, carac);
        if(prox_char != '#')insereCaracter(id, prox_char);
    }
    else if(carac != '#'){
        insereCaracter(id, carac);
        if(prox_char != '#')insereCaracter(id, prox_char);
    }
    function insereCaracter(id, char){
        id.value += char;
    }
}