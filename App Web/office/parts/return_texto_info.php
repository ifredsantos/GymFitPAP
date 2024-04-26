<?php
    require "../../config.php";

    if(isset($_GET['codigo']) && !empty($_GET['codigo'])) {
        $codigoTexto = $_GET['codigo'];

        $param = [
            ":codigo" => $codigoTexto
        ];
        $buscaTextos = $gst->exe_query("SELECT * FROM textos WHERE cod_texto = :codigo", $param);
        if(count($buscaTextos) > 0) {
            $infTexto = $buscaTextos[0];
?>

                                    <form action="editor" method="post">
                                        <div class="form-group">
                                            <label for="titulo">Titulo</label>
                                            <input name="titulo" 
                                                   type="text" 
                                                   class="form-control" 
                                                   value="<?= $infTexto['titloPT'] ?>"
                                                   readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="texto" style="width: 100px; float: left;">Texto</label>
                                            <ul style="float: right; margin: 0;" class="submenu-editor">
                                                <li><a onclick="format('paragrafo')">Parágrafo</a></li>
                                                <li><a onclick="format('negrito')">Negrito</a></li>
                                                <li><a onclick="format('italico')">Itálico</a></li>
                                                <li><a onclick="format('cortado')">Cortar</a></li>
                                                <li><a onclick="format('sublinhado')">Sublinhar</a></li>
                                                <li><a onclick="format('superior')">Superior</a></li>
                                                <li><a onclick="format('marcado')">Marcar</a></li>
                                                <li><a onclick="format('link')">Link</a></li>
                                            </ul>
                                            <textarea onkeyup="atualizaPrev()" rows="8" cols="50" name="texto" class="form-control" id="texto"><?= $infTexto['textoPT'] ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="pre-view">Preview</label>
                                            <div id="pre-view"><?= $infTexto['textoPT'] ?></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="acao" value="editText">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
<?php
        }
    }
?>