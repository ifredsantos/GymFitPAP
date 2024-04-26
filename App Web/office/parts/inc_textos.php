                    <div class="modal fade" id="editText" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Editar texto</h3>
                                </div>
                                <div class="modal-body" id="result">

                                    <script src="js/text_format.js"></script>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabela -->
                    <div class="panel-body" id="resultado_anterior">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th><em class="fa fa-cog"></em></th>
                                    <th>Titulo</th>
                                    <th>Texto</th>
                                    <th>Data ultima edição</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $quantidade = 10;
                                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                $inicio = ($quantidade * $pagina) - $quantidade;

                                // Busca os clientes
                                $sqlBuscaTextos = "
                                SELECT cod_texto, titloPT, textoPT, data_ultimoUpdate FROM textos ";
                                if(isset($_POST['action']) && $_POST['action'] == "pesquisar" || isset($_GET['pesquisa']) && $_GET['pesquisa'] != "")
                                {
                                    if(isset($_POST['action']))
                                        $pesquisa = $_POST['pesquisa'];
                                    else if(isset($_GET['pesquisa']))
                                        $pesquisa = $_GET['pesquisa'];
                                    
                                    if($pesquisa == "Masculino" || $pesquisa == "masculino")
                                        $pesquisa = "m";
                                    if($pesquisa == "Feminino" || $pesquisa == "feminino")
                                        $pesquisa = "f";
                                    
                                    $pesq = $pesquisa.'%';

                                    $sqlPesquisa .= "WHERE titloPT LIKE :pesquisa OR textoPT LIKE :pesquisa";
                                    $sqlBuscaTextos .= $sqlPesquisa;

                                    $param = [
                                        ":pesquisa" => $pesq
                                    ];
                                } else {
                                    $param = [];
                                    $sqlPesquisa = "";
                                }
                                $sqlBuscaTextos .= "ORDER BY data_ultimoUpdate DESC 
                                LIMIT $inicio, $quantidade";
                                
                                $buscaTextos = $gst->exe_query($sqlBuscaTextos, $param);
                                
                                $sqlTotal = "SELECT COUNT(titloPT) AS NUMTEXTOS FROM textos ";
                                $sqlTotal .= $sqlPesquisa;

                                $qrTotal = $gst->exe_query($sqlTotal);
                                $numTotal = $qrTotal[0]["NUMTEXTOS"];
                                
                                $totalPagina= ceil($numTotal/$quantidade);
                                
                                $exibir = 10;
                                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                                
                                if(count($buscaTextos) > 0) {
                                    for($i = 0; $i < count($buscaTextos); $i++) {
                                        $infTexto = $buscaTextos[$i];

                                        $codTexto = $infTexto['cod_texto'];
                                        $titulo = $infTexto['titloPT'];
                                        $texto = $infTexto['textoPT'];
                                        $dataUltimoUpdate = ptdate($infTexto['data_ultimoUpdate']);
                            ?>
                                <tr>
                                    <td align="center">
                                        <a class="btn btn-default" data-toggle="modal" 
                                            data-target="#editText" 
                                            onclick="getTexto('<?= $codTexto ?>')"><em class="fa fa-pencil"></em></a>
                                        <a class="btn btn-danger" disabled><em class="fa fa-trash"></em></a>
                                    </td>
                                    <!--<td class="hidden-xs">1</td>-->
                                    <td align="center"><?= $titulo ?></td>
                                    <td align="center"><?= encortarTexto(removerTextoFromat($texto), 100, "...") ?></td>
                                    <td align="center"><?= $dataUltimoUpdate ?></td>
                                </tr>
                            <?php
                                    }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Rodapé da tabela -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-3">Página <?= $pagina ?> de <?= $totalPagina ?>
                            </div>
                            
                            <div class="col col-xs-3">
                                <?php
                                    if(isset($_POST['action']) && $_POST['action'] == "pesquisar" && $_POST['pesquisa'] != "")
                                    {
                                ?>
                                <p>Pesquisa por: <b><?= $_POST['pesquisa'] ?></b></p>
                                <?php
                                    }
                                    else if(isset($_GET['pesquisa']) && $_GET['pesquisa'] != "")
                                    {
                                ?>
                                <p>Pesquisa por: <b><?= $_GET['pesquisa'] ?></b></p>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                <p>Número de resultados: <?= $numTotal ?></p>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="col col-xs-6">
                                <ul class="pagination hidden-xs pull-right">
                                    <?php
                                        if(isset($_POST['action']))
                                            $pesquisa = $_POST['pesquisa'];
                                        else if(isset($_GET['pesquisa']))
                                            $pesquisa = $_GET['pesquisa'];
                                        else
                                            $pesquisa = "";
                                    
                                        echo "<li><a href=\"clientes/1/$pesquisa\">&laquo;</a></li>";
                                        echo "<li><a href=\"clientes/$anterior/$pesquisa\">&lsaquo;</a></li>";
                                    
                                        for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                                            if($i > 0)
                                                echo "<li><a href=\"clientes/$i/$pesquisa\">$i</a></li>";
                                        }

                                        echo "<li><a href=\"clientes/$pagina/$pesquisa\"><strong>$pagina</strong></a></li>";

                                        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                                            if($i <= $totalPagina)
                                                echo "<li><a href=\"clientes/$i/$pesquisa\">$i</a></li>";
                                        }
                                        echo "<li><a href=\"clientes/$posterior/$pesquisa\">&rsaquo;</a></li>";
                                        echo "<li><a href=\"clientes/$totalPagina/$pesquisa\">&raquo;</a></li>";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                                }
                    ?>