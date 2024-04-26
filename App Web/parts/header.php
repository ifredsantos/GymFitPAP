<div class="space_fechar_menu" id="space_fechar_menu" style="display: none; z-index: 98"></div>
<div class="space_fechar_form" id="space_fechar_form" style="display: none"></div>
<nav id = "menu">
    <input type = "checkbox" id="btn-menu">
    <label for = "btn-menu">&#9776;</label>
    <a href = "home"><img id="logo" src = "<?= APP_URL ?>layout/logoFinal.png" alt = "GymFit"></a>
    <ul>
        <li><a href = "<?= APP_URL ?>home#sobrenos">Sobre nós</a></li>
        <li><a href = "home#modalidades">Modalidades</a>
            <ul>
                <?php
                    $buscaModalidades = $gst->exe_query("SELECT * FROM modalidades");
                    if (count($buscaModalidades) > 0) {
                        for($i = 0; $i < count($buscaModalidades); $i++) {
                            if($buscaModalidades[$i]["descricao"] != "" || $buscaModalidades[$i]["imgs"] != "")
                                echo '<li><a href = "modalidade/' . $buscaModalidades[$i]['nome_modalidade'] . '">' . $buscaModalidades[$i]['nome_modalidade'] . '</a></li>';
                            else
                                echo '<li><a href="javascript:alert(\'Sem informação adicional\')">'.$buscaModalidades[$i]['nome_modalidade'].'</a></li>';
                        }
                    }
                ?>
            </ul>
        </li>
        <li><a href = "<?= APP_URL ?>home#horario">Horário</a></li>
        <li style="cursor: pointer;">Mais        
            <ul>
                <li><a href = "<?= APP_URL ?>home#localizacao">Localização</a></li>
                <li><a href = "<?= APP_URL ?>home#contactos">Contactos</a></li>
            </ul>
        </li>
    </ul>
</nav>

<?php
    if(isset($_SESSION['cod_user'])) {
        $codUser = $_SESSION['cod_user'];

        $param = [":cod_user" => $codUser];

        $user = $gst->exe_query("SELECT U.cod_utilizador, U.username, U.foto, UT.nome_regra 
        FROM utilizadores U, utilizadores_tipo UT
        WHERE U.tipo_utilizador = UT.cod_regra AND U.cod_utilizador = :cod_user
        LIMIT 1", $param);
        
        if(count($user) > 0) {
?>

<div class="space-form-login" id="space-form-login" style="right: -250px; height: 65px; border-radius: 0;">
    <div class="space-icon-login" id="space-icon-login" style="right: 0px;">
        <?php
            if($user[0]['foto'] != "") {
        ?>
        <img class="circle-img" id="btn-login" src="posts/utilizadores/<?= $user[0]['foto'] ?>" alt="<?= $user[0]['username'] ?>" title="<?= $user[0]['username'] ?>">
        <?php
            }
            else
            {
        ?>
        <img id="btn-login" src="layout/user.svg" alt="<?= $user[0]['username'] ?>" title="<?= $user[0]['username'] ?>">
        <?php
            }
        ?>
    </div>
    
    <div class="inf-user">
        <h3><?= $user[0]['username'] ?></h3>
        <?php
            if($_SESSION['role'] == 1 && $_SESSION['auth'] == 1) {
                echo "<p class=\"text_right\" style=\"margin-right: 10px\"><a href=\"office/dashboard\">Área de Administração</a> | <a href=\"logout\">Sair</a></p>";
            } else if($_SESSION['role'] == 2 && $_SESSION['auth'] == 1) {
                echo "<p class=\"text_right\" style=\"margin-right: 10px\"><a href=\"perfil/\">Área de Treinador</a> | <a href=\"logout\">Sair</a></p>";
            } else {
                echo "<p class=\"text_right\" style=\"margin-right: 10px\"><a href=\"perfil\">Ver perfil</a> | <a href=\"logout\">Sair</a></p>";
            }
        ?>
    </div>
</div>

<?php
        }
    } else {
?>


<div class="space-form-login" id="space-form-login" style="right: -250px;">
    <div class="space-icon-login" id="space-icon-login" style="right: 0px;">
        <img id="btn-login" src="layout/user.svg" alt="Registar/Login" title="Registar/Login">
    </div>
    
    <div class="form-login">
        <form name="login" method="post" action="parts/inc_login.php">
            <label for = "cod_adesao"><p style="margin-top: 10px;">Username/Email</p></label>
            <input name = "email"
                   type = "text"
                   autocomplete="on"
                   required>
            <br>
            
            <label for = "psw"><p>Password</p></label>
            <input name = "psw"
                   type = "password"
                   autocomplete="on"
                   required
                   style="width: 170px;">

            <p style="margin: 0;"><a href="recuperar_password" style="font-size: 12px; color: #efefef;">Esqueci-me da password</a></p>
            <input type="hidden" name="back" value="<?= $_SERVER["REQUEST_URI"] ?>">
            <input class="btn-submit" type = "submit" value = "Entrar">
        </form>
        <hr style="width: 100%; border: 1px solid #262626">
        <p style="font-size: 15px; color: #efefef;">Ainda não tens uma conta?</p>
        <p><a href="registo" style="font-size: 15px; color: #efefef;">Regista-te!</a></p>
    </div>
</div>
<?php
    }
?>

<script src="<?= APP_URL ?>js/main.js"></script>