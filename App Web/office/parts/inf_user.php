<div class = "pop-user" id = "pop-user" style="display: none;">
    <?php
        if(isset($_SESSION['cod_user']) && !empty($_SESSION['cod_user']))
        {
            $param = [
                ":utilizador" => $_SESSION['cod_user']
            ];
            $buscaInfUser = $gst->exe_query("
            SELECT u.username, u.tipo_utilizador, tU.nome_regra 
            FROM utilizadores u
                INNER JOIN utilizadores_tipo tU ON u.tipo_utilizador = tU.cod_regra
            WHERE u.cod_utilizador = :utilizador
            ", $param);
                        
            if(count($buscaInfUser) > 0)
            {
                $infUser = $buscaInfUser[0];
                echo "<p>".$infUser['username']." | ".$infUser['nome_regra']."</p>";
            }
        }
    ?>
    <p><a href = "logout.php">Logout</a></p>
</div>