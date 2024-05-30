<html>
    <head></head>
    <body>
        <form action="" method="post" id="passwordTest">
            <div><input type="password" id="password1" /></div>
            <div><input type="password" id="password2" /></div>
            <div id="pass-info"></div>
        </form>
    </body>
    <script type="text/javascript">
$(document).ready(function() {
    var password1       = $('#password1');
    var password2       = $('#password2');
    var passwordsInfo   = $('#pass-info');

    passwordStrengthCheck(password1,password2,passwordsInfo);

});

function passwordStrengthCheck(password1, password2, passwordsInfo){
    var WeakPass = /(?=.{5,}).*/; 
    var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/; 
    var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/; 
    var VryStrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{5,}$/; 

    $(password1).on('keyup', function(e) {
        if(VryStrongPass.test(password1.val())){
            passwordsInfo.removeClass().addClass('vrystrongpass').html("Muito Forte! (Impressionante, por favor não se esqueça da password!)");
        }   
        else if(StrongPass.test(password1.val())){
            passwordsInfo.removeClass().addClass('strongpass').html("Forte! (Insira caracteres especiais para tornar ainda mais forte");
        }   
        else if(MediumPass.test(password1.val())){
            passwordsInfo.removeClass().addClass('goodpass').html("Bom! (Ponha letras maiúsculas)");
        }
        else if(WeakPass.test(password1.val())){
            passwordsInfo.removeClass().addClass('stillweakpass').html("Algo fraco! (Digitos aumentar a força da password)");
        }
        else{
            passwordsInfo.removeClass().addClass('weakpass').html("Muito fraca! (Deve ter 5 ou mais caracteres)");
        }
    });

    $(password2).on('keyup', function(e) {
        if(password1.val() !== password2.val()){
            passwordsInfo.removeClass().addClass('weakpass').html("As passwords não são iguais!");   
        }else{
            passwordsInfo.removeClass().addClass('goodpass').html("Passwords iguais!");  
        }
    });
}
</script>
</html>