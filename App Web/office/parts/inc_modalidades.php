<?php
    // Alterar os valores do php.ini
    // upload_max_filesize = 100M;
    // post_max_size = 1000M;
?>

<div class="panel panel-default panel-table">
    <div class="panel-heading">
        <div class="row">
            <div class="col col-xs-6"></div>
            <div class="col col-xs-6 text-right">
                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#adicionarFoto" style="height: 42px;">Adicionar modalidade</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="adicionarFoto" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Adicionar modalidade</h3>
                </div>
                <div class="modal-body">
                    <form action="<?= APP_URL_OFFICE ?>editor/modalidades" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="foto_index">Fotografia da página inícial:</label>
                            <input required class="form-control" type="file" name="foto_index">
                        </div>

                        <div class="form-group">
                            <label for="foto_mensalidade">Fotografia de apresentação da mensalidade:</label>
                            <input class="form-control" type="file" name="foto_mensalidade">
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome da modalidade:</label>
                            <input required class="form-control" type="text" name="nome" placeholder="Insira o nome da modalidade aqui..." maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" name="descricao" maxlength="1000" placeholder="Insira uma descrição..." rows="6"></textarea>
                        </div>

                        <div class="modal-footer clearfix">
                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Fechar</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <input type="hidden" name="acao" value="add_modalidade">
                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Adicionar modalidade</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body" id="resultado_anterior">
        <table class="table table-striped table-bordered table-list">
            <thead>
                <tr>
                    <th><em class="fa fa-cog"></em></th>
                    <th style="width: 150px">Foto da pag. inicial</th>
                    <th>Modalidade</th>
                    <th>Descrição</th>
                    <th>Imagem Principal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $buscaModalidade = $gst->exe_query("
                    SELECT * FROM modalidades");
                    if(count($buscaModalidade) > 0) {
                        for($i = 0; $i < count($buscaModalidade); $i++) {
                            $mod = $buscaModalidade[$i];

                            $fotoPrincipal = getFotoPrincipal($mod['imgs']);
                ?>
                <tr>
                    <td align="center">
                        <a class="btn btn-danger" href="<?= APP_URL_OFFICE ?>editor.php?target=modalidades&acao=remover_modalidade&id=<?= $mod['cod_modalidade'] ?>"><em class="fa fa-trash"></em></a>
                    </td>
                    <!--<td class="hidden-xs">1</td>-->
                    <td><img style="width: 100%;" src="<?= APP_URL ?>posts/modalidades/FID/<?= $mod['imgIndex'] ?>"></td>
                    <td><?= $mod['nome_modalidade'] ?></td>
                    <?php
                        if($mod['descricao'] != "") {
                    ?>
                    <td><?= encortarTexto($mod['descricao'], 200, '...') ?></td>
                    <?php
                        } else {
                    ?>
                    <td>Sem descrição...</td>
                    <?php
                        }
                    ?>
                    <?php
                        if($fotoPrincipal != "") {
                    ?>
                    <td><img style="width: 100%;" src="<?= APP_URL ?>posts/modalidades/FAP/<?= $fotoPrincipal ?>"></td>
                    <?php
                        } else
                            echo '<td>Sem imagem...</td>';
                    ?>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>