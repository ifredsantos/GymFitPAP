<?php
    include '../../config.php';

    if(isset($_GET['codigo']) && !empty($_GET['codigo'])) {
        $codUtilizador = $_GET['codigo'];

        $param = [":cod_utilizador" => $codUtilizador];
        $buscaInfoUtilizador = $gst->exe_query("
        SELECT cod_utilizador, nome, cod_mensalidade, cod_desconto, nome_mensalidade, nome_desconto FROM utilizadores 
            INNER JOIN mensalidades_aquisicoes ON mensalidades_aquisicoes.utilizador = utilizadores.cod_utilizador 
            INNER JOIN mensalidades ON mensalidades_aquisicoes.mensalidade = mensalidades.cod_mensalidade 
            INNER JOIN mensalidades_descontos ON mensalidades_aquisicoes.desconto = mensalidades_descontos.cod_desconto 
        WHERE utilizador = :cod_utilizador AND atual LIKE 's'", $param);

        $buscaSerial = $gst->exe_query("
        SELECT * FROM utilizadores_pre_registos WHERE utilizador = :cod_utilizador", $param);
        if(count($buscaSerial) > 0)
            $serial = $buscaSerial[0]["cod_preReg"];
        else $serial = "";

        if(count($buscaInfoUtilizador) > 0) {
            $dados = $buscaInfoUtilizador[0];
?>

                                    <form action="clientes" method="post">
                                        <?php
                                            if($serial != "") {
                                        ?>
                                        <div class="form-group">
                                            <label for="serial">Serial</label>
                                            <input name="serial" 
                                                   type="text" 
                                                   class="form-control" 
                                                   value="<?= $serial ?>" 
                                                   readonly>
                                        </div>
                                        <?php
                                            }
                                        ?>

                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input name="nome" 
                                                   type="text" 
                                                   class="form-control" 
                                                   placeholder="Insira o nome do cliente"
                                                   value="<?= $dados['nome'] ?>" 
                                                   readonly>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="email">Mensalidade</label>
                                                <select class="form-control" name="mensalidade">
                                                    <option value="<?= $dados['cod_mensalidade'] ?>"><?= $dados['nome_mensalidade'] ?> (atual)</option>
                                                    <?php
                                                        $param = [":cod_mensalidade" => $dados['cod_mensalidade']];
                                                        $buscaMensalidadeExcepAtual = $gst->exe_query("
                                                        SELECT * FROM mensalidades WHERE cod_mensalidade <> :cod_mensalidade AND cod_mensalidade <> 5", $param);
                                                        if(count($buscaMensalidadeExcepAtual) > 0) {
                                                            for($z=0; $z < count($buscaMensalidadeExcepAtual); $z++)
                                                                echo '<option value="'.$buscaMensalidadeExcepAtual[$z]["cod_mensalidade"].'">'.$buscaMensalidadeExcepAtual[$z]["nome_mensalidade"].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="telefone">Desconto</label>
                                                <select class="form-control" name="desconto">
                                                    <option value="<?= $dados['cod_desconto'] ?>"><?= $dados['nome_desconto'] ?> (atual)</option>
                                                    <?php
                                                        $param = [":cod_desconto" => $dados['cod_desconto']];
                                                        $buscaDescontoExcepAtual = $gst->exe_query("
                                                        SELECT * FROM mensalidades_descontos WHERE cod_desconto <> :cod_desconto", $param);
                                                        if(count($buscaDescontoExcepAtual) > 0) {
                                                            for($z=0; $z < count($buscaDescontoExcepAtual); $z++)
                                                                echo '<option value="'.$buscaDescontoExcepAtual[$z]["cod_desconto"].'">'.$buscaDescontoExcepAtual[$z]["nome_desconto"].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="cod_utilizador" value="<?= $dados['cod_utilizador'] ?>">
                                                    <input type="hidden" name="acao" value="alterarMensalidadeEdesconto">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Alterar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
<?php
        } else {
            $param = [":cod_utilizador" => $codUtilizador];
            $buscaInf = $gst->exe_query("
            SELECT nome FROM utilizadores WHERE cod_utilizador = :cod_utilizador", $param);
            if(count($buscaInf) > 0) {
                $dados = $buscaInf[0];
            } else {
                $dados = "";
            }
?>
                                    <form action="clientes" method="post">
                                        <?php
                                            if($serial != "") {
                                        ?>
                                        <div class="form-group">
                                            <label for="serial">Serial</label>
                                            <input name="serial" 
                                                   type="text" 
                                                   class="form-control" 
                                                   value="<?= $serial ?>" 
                                                   readonly>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input name="nome" 
                                                   type="text" 
                                                   class="form-control" 
                                                   placeholder="Insira o nome do cliente"
                                                   value="<?= $dados['nome'] ?>" 
                                                   readonly>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="email">Mensalidade</label>
                                                <select class="form-control" name="mensalidade">
                                                    <?php
                                                        $buscaMensalidadeExcepAtual = $gst->exe_query("
                                                        SELECT * FROM mensalidades WHERE cod_mensalidade <> 5");
                                                        if(count($buscaMensalidadeExcepAtual) > 0) {
                                                            for($z=0; $z < count($buscaMensalidadeExcepAtual); $z++)
                                                                echo '<option value="'.$buscaMensalidadeExcepAtual[$z]["cod_mensalidade"].'">'.$buscaMensalidadeExcepAtual[$z]["nome_mensalidade"].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="telefone">Desconto</label>
                                                <select class="form-control" name="desconto">
                                                    <?php
                                                        $buscaDescontoExcepAtual = $gst->exe_query("
                                                        SELECT * FROM mensalidades_descontos");
                                                        if(count($buscaDescontoExcepAtual) > 0) {
                                                            for($z=0; $z < count($buscaDescontoExcepAtual); $z++)
                                                                echo '<option value="'.$buscaDescontoExcepAtual[$z]["cod_desconto"].'">'.$buscaDescontoExcepAtual[$z]["nome_desconto"].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="cod_utilizador" value="<?= $codUtilizador ?>">
                                                    <input type="hidden" name="acao" value="alterarMensalidadeEdesconto">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Alterar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
<?php
        }
    }
?>