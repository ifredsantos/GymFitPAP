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
                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#adicionarFoto" style="height: 42px;">Adicionar foto</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="adicionarFoto" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Adicionar foto à galeria</h3>
                </div>
                <div class="modal-body">
                    <form action="<?= APP_URL_OFFICE ?>editor/galeria" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nome">Título</label>
                            <input class="form-control" type="text" name="titulo" maxlength="60" placeholder="Insira um título...">
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea class="form-control" name="descricao" maxlength="155" placeholder="Insira uma descrição..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Foto</label>
                            <input type="file" name="image" accept="image/*">
                        </div>

                        <div class="modal-footer clearfix">
                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" role="button">Fechar</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <input type="hidden" name="acao" value="foto_upload">
                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Adicionar à galeria</button>
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
                    <th style="width: 150px">Foto</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $buscaFoto = $gst->exe_query("
                    SELECT cod_img, titulo, descricao, nome_img, data_pub FROM galeria ORDER BY data_pub DESC");
                    if(count($buscaFoto) > 0) {
                        for($i = 0; $i < count($buscaFoto); $i++) {
                            $pub = $buscaFoto[$i];
                ?>
                <tr>
                    <td align="center">
                        <a class="btn btn-default" data-toggle="modal" data-target="#utilizadorExtraInfo" onclick="getInfUtilizadorExtra('<?= $codUtilizador ?>')"><em class="fa fa-pencil"></em></a>
                        <a class="btn btn-danger" href="<?= APP_URL_OFFICE ?>editor.php?target=galeria&acao=remover&id=<?= $pub['cod_img'] ?>"><em class="fa fa-trash"></em></a>
                    </td>
                    <!--<td class="hidden-xs">1</td>-->
                    <td><img style="width: 100%;" src="<?= CAM_GALERIA ?>_200_/<?= $pub['nome_img'] ?>"></td>
                    <td><?= $pub['titulo'] ?></td>
                    <td><?= $pub['descricao'] ?></td>
                    <td><?= $pub['data_pub'] ?></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>