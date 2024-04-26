                <h3 style="text-align: center; color: #fff;">O teu perfil</h3>
                <br>
                
                <div class="perfil-inf-form form-registo form-disabled" id="registoApresentacao">
                    <h3 style="float: left;">Informações pessoais</h3>
                    <img class="action-img" id="action-img-edit" src = "layout/edit.svg" alt="Editar perfil" title="Editar perfil">
                    <div class="form-registo-ld-left" style="width: 100%; border: none;">
                        <br>
                        <div>
                            <label for="nome">Nome</label>
                            <br>
                            <input
                                   id="aPnome"
                                   type="text"
                                   placeholder="Nome"
                                   value="<?= $nome ?>"
                                   readonly="on"
                                   disabled="on">
                        </div>
                        <br>

                        <div>
                            <label for="email">Email</label>
                            <br>
                            <input
                                   id="aPemail"
                                   type="email"
                                   placeholder="Email"
                                   value="<?= $email ?>"
                                   readonly="on"
                                   disabled="on">
                        </div>
                        <br>

                        <div>
                            <label for="telefone">Telefone</label>
                            <br>
                            <input
                                   id="aPtelefone"
                                   type="text"
                                   placeholder="Telefone"
                                   value="<?= $telefone ?>"
                                   readonly="on"
                                   disabled="on">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <form style="display: none" class="perfil-inf-form form-registo" id="registo" name="registo" method="post" action="perfil" enctype="multipart/form-data">
                    <h3 style="float: left;">Informações pessoais</h3>
                    <img class="action-img" id="action-img-mark" src = "layout/check-mark.svg" alt="Editar perfil" title="Editar perfil">
                    <div class="form-registo-ld-left" style="width: 100%; border: none;">
                        <br>
                        <p style="color: green; text-align: center;">Modo de edição ativo</p>
                        <br>
                        <div>
                            <label for="nome">Nome</label>
                            <br>
                            <input
                                   name="nome"
                                   id="nome"
                                   type="text"
                                   placeholder="<?= $nome ?>">
                        </div>
                        <br>

                        <div>
                            <label for="email">Novo email</label>
                            <br>
                            <input
                                   name="email"
                                   id="email"
                                   type="email"
                                   placeholder="<?= $email ?>">
                        </div>

                        <div id="campo-conf-email" style="display: none;">
                            <label for="conf_email">Confirmar novo email</label>
                            <br>
                            <input
                                   name="conf_email"
                                   id="conf_email"
                                   type="email"
                                   placeholder="Confirme o seu novo email">
                        </div>
                        <p id="inf-email"></p>

                        <br>
                        <div>
                            <label for="telefone">Telefone</label>
                            <br>
                            <input
                                   name="telefone"
                                   id="telefone"
                                   type="text"
                                   placeholder="<?= $telefone ?>">
                        </div>
                        <br>

                        <div>
                            <label for="psw">Nova password</label>
                            <br>
                            <input
                                   name="psw"
                                   type="password"
                                   id="psw"
                                   placeholder="Password">
                        </div>

                        <div id="campo-conf-psw" style="display: none;">
                            <label for="conf_psw">Confirmar nova password</label>
                            <br>
                            <input
                                   name="conf_psw"
                                   type="password"
                                   id="conf_psw"
                                   placeholder="Confirme a sua nova password">
                        </div>
                        <p id="msg_password" style="text-align: center;"></p>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <p id = "txt_geral"></p>
                    <input type="hidden" name="acao" value="atualizar_perfil">
                    <input class="from-registo-btn-submit" id="btn_submit" type="submit" value="Atualizar">
                </form>
                
                <div class="space-conquista">
                    <?php
                        // Vai buscar todas as conquistas
                        $buscaConsquistas = $gst->exe_query("SELECT * FROM conquistas ORDER BY cod_conquista ASC");

                        if(count($buscaConsquistas) > 0) {
                            for($i = 0; $i < count($buscaConsquistas); $i++) {
                                $codigo = $buscaConsquistas[$i]['cod_conquista'];
                                $nome = $buscaConsquistas[$i]['nome_conquista'];
                                $descricao = $buscaConsquistas[$i]['descricao_conquista'];
                                $foto = $buscaConsquistas[$i]['foto_conquista'];

                                // Verifica se o utilizador tem esta conquista
                                $param = [
                                    ":cod_utilizador" => $_SESSION['cod_user'],
                                    ":cod_conquista" => $codigo
                                ];
                                $verificaConquistaUtilizador = $gst->exe_query("
                                SELECT data_conquista FROM utilizadores_conquistas WHERE cod_utilizador = :cod_utilizador AND cod_conquista = :cod_conquista", $param);

                                if(count($verificaConquistaUtilizador) > 0) {
                                    $status = "";
                                } else {
                                    $status = "profile-achievement-unactive";
                                }
                                echo '<a class="profile-achievement '. $foto .' '.$status. '" title="'. $nome .' - '. $descricao .'"></a>';
                            }
                        }
                    ?>
                </div>
