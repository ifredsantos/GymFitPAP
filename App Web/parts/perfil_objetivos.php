<?php
    // Verifica se existe uma 1ª análise
    $param = [":utilizador" => $_SESSION['cod_user']];
    $verificaExiste1analise = $gst->exe_query("
    SELECT data_analise FROM utilizadores_analises WHERE utilizador = :utilizador", $param);

    if(count($verificaExiste1analise) == 0)
        exit(header('Location: '.APP_URL.'perfil/primeira_avaliacao'));
    else {
        // Busca objetivos
        $param = [":utilizador" => $_SESSION['cod_user']];
        $buscaObjetivos = $gst->exe_query("
        SELECT id_objetivo, objetivo, peso_alvo, data_alvo, atual, cumprido, data_registo FROM utilizadores_objetivos 
        WHERE utilizador = :utilizador 
        ORDER BY data_alvo DESC", $param);
?>
<h3 style="color: #fff; margin-bottom: 15px;">Objetivos</h3>
<div style="width: 100%; float: left;">
    <div style="width: 70%; float: left;">
        <p style="margin-bottom: 10px">Quem procura um ginásio tem sempre algum objetivo, perder peso, ganhar, manter, etc...</p>
        <p style="margin-bottom: 10px">Definir objetivos pode ajudar bastante. Alem de o motivar para os alcançar permite que ao longo do seu percuros acompanhe a sua evolução!</p>
        <p style="margin-bottom: 10px">Defina o(s) seu(s) objetivo(s)!</p>
    </div>
    <div style="width:25%; float: right;">
        <img style="width: 100%;" src="layout/objetivos.png" alt="Objetivos">
    </div>
</div>

<div style="width: calc(100% - 30px); float: left; background-color: #262626; padding: 15px; border-radius: 10px;">
    <table class="tabela_objetivos">
        <tr>
            <th></th>
            <th>Objetivo</th> 
            <th>Peso alvo</th>
            <th>Data alvo</th>
            <th>Atual</th>
            <th>Cumprido</th>
        </tr>
        <?php
            if(count($buscaObjetivos) > 0) {
                for($i = 0; $i < count($buscaObjetivos); $i++) {
                    $dadoObjetivo = $buscaObjetivos[$i];
                    $id_obj = $dadoObjetivo['id_objetivo'];

                    if($dadoObjetivo['atual'] == 's') {
                        $atual = "Sim";
                    } else {
                        $atual = "Não";
                    }

                    if($dadoObjetivo['cumprido'] == 's') {
                        $cumprido = "Sim";
                    } else {
                        $cumprido = "Não";
                    }
        ?>
        <div class="msg-space-modal" id="msg-space-modal-canelarObjetivo_<?= $i ?>" style="display: none">
            <div class="msg-content-modal">
                <h2 class="text_center">Tem a certeza de deseja excluir este objetivo?</h2>
                <p class="text_center"><u>Atenção a este procedimento!</u> Ao excluir este objetivo o processo será irreversivel.</p>
                <div class="space-buttons">
                    <button type="button" style="float: left; background-color: #efefef;">
                        <a onclick="document.getElementById('msg-space-modal-canelarObjetivo_<?= $i ?>').style.display='none';" style="color: black;">Fechar</a>
                    </button>
                    <button type="button" style="float: right; background-color: darkred;">
                        <a style="color: #efefef;" href="<?= APP_URL ?>perfil.php?target=objetivos&acao=cancelar&id=<?= $dadoObjetivo['id_objetivo'] ?>">Excluir objetivo</a>
                    </button>
                </div>
            </div>
        </div>

        <form action="<?= APP_URL ?>perfil/objetivos" method="post">
            <tr>
                <td style="padding: 12px;">
                    <a id="edit_old_obj_<?= $id_obj ?>" onclick="mudaTabelaEdicao('<?= $id_obj ?>')"><img style="cursor: pointer; width: 20px;" src="layout/edit.svg" alt="Adicionar"></a>
                    <button type="submit" id="btn_old_obj_save_<?= $id_obj ?>" style="float: left; padding-left: 20px; border: none; cursor: pointer; background-color: transparent; display: none;"><img style="width: 20px;" src="layout/check-mark.svg"></button>
                    <a onclick="document.getElementById('msg-space-modal-canelarObjetivo_<?= $i ?>').style.display = 'block'">
                        <img style="margin-left: 10px; width: 20px; cursor: pointer;" src="layout/delete.svg" alt="Remover">
                    </a>
                </td>
                <td><?= $dadoObjetivo['objetivo'] ?></td> 
                <td><?= str_replace('.', ',',$dadoObjetivo['peso_alvo']) ?> Kg</td>
                <td><?= ptdate($dadoObjetivo['data_alvo']) ?></td>
                <td>
                    <div id="old_obj_atual_<?= $id_obj ?>">
                        <?= $atual ?>
                    </div>

                    <div id="novo_obj_atual_<?= $id_obj ?>" style="display: none">
                        <select name="atual">
                            <option value="n">Não</option>
                            <option value="s">Sim</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div id="old_cumprido_<?= $id_obj ?>">
                        <?= $cumprido ?>
                    </div>
                    
                    <div id="novo_cumprido_<?= $id_obj ?>" style="display: none">
                        <select name="cumprido">
                            <option value="s">Sim</option>
                            <option value="n">Não</option>
                        </select>
                    </div>
                </td>
            </tr>
            <input type="hidden" name="acao" value="atualizar_objetivo">
        </form>
        <?php
                }
            }
        ?>
        <tr>
            <td>
                <a onclick="enviaDadosParaFrmPreObj()"><img style="width: 20px; cursor: pointer;" src="layout/add.svg" alt="Adicionar"></a>
            </td>
            <td>
                <select id="inp_objetivo">
                    <option value="Peder Peso">Perder Peso</option>
                    <option value="Ganhar Peso">Ganhar Peso</option>
                    <option value="Manter Peso">Manter Peso</option>
                </select>
            </td> 
            <td>
                <input type="number" id="inp_peso_alvo" style="width: 70px" name="" id="">
            </td>
            <td>
                <input type="date" id="inp_data_alvo" name="" id="">
            </td>
            <td>
                <select id="inp_atual">
                    <option value="s">Sim</option>
                    <option value="n">Não</option>
                </select>
            </td>
            <td>
                <select id="inp_cumprido">
                    <option value="n">Não</option>
                    <option value="s">Sim</option>
                </select>
            </td>
        </tr>
    </table>

    <form action="<?= APP_URL?>perfil/objetivos" method="post" style="display: none" id="frm_adicionar_objetivos">
        <input type="hidden" name="objetivo" id="objetivo" required>
        <input type="hidden" name="peso_alvo" id="peso_alvo" required>
        <input type="hidden" name="data_alvo" id="data_alvo" required>
        <input type="hidden" name="atual" id="atual" required>
        <input type="hidden" name="cumprido" id="cumprido" required>
        <input type="hidden" name="acao" value="adicionar_objetivo">
    </form>
</div>
<?php
    }
?>

<script>
    function mudaTabelaEdicao(id) {
        var old_obj_atual = document.getElementById('old_obj_atual_'+id);
        var old_cumprido = document.getElementById('old_cumprido_'+id);
        var novo_obj_atual = document.getElementById('novo_obj_atual_'+id);
        var novo_cumprido = document.getElementById('novo_cumprido_'+id);
        var btn_submit_old_obj = document.getElementById('btn_old_obj_save_'+id);
        var old_btn_edit = document.getElementById('edit_old_obj_'+id);

        if(novo_obj_atual.style.display == "none" && novo_cumprido.style.display == "none") {
            old_obj_atual.style.display = "none";
            old_cumprido.style.display = "none";

            novo_obj_atual.style.display = "block";
            novo_cumprido.style.display = "block";

            old_btn_edit.style.display = "none";
            btn_submit_old_obj.style.display = "block";
        }
    }
    function enviaDadosParaFrmPreObj() {
        var inp_objetivo = document.getElementById('inp_objetivo');
        var inp_peso_alvo = document.getElementById('inp_peso_alvo');
        var inp_data_alvo = document.getElementById('inp_data_alvo');
        var inp_atual = document.getElementById('inp_atual');
        var inp_cumprido = document.getElementById('inp_cumprido');

        var frm_objetivo = document.getElementById('objetivo');
        var frm_peso_alvo = document.getElementById('peso_alvo');
        var frm_data_alvo = document.getElementById('data_alvo');
        var frm_atual = document.getElementById('atual');
        var frm_cumprido = document.getElementById('cumprido');

        var frm = document.getElementById('frm_adicionar_objetivos');

        frm_objetivo.value=inp_objetivo.value;
        frm_peso_alvo.value=inp_peso_alvo.value;
        frm_data_alvo.value=inp_data_alvo.value;
        frm_atual.value=inp_atual.value;
        frm_cumprido.value=inp_cumprido.value;

        frm.submit();
    }
</script>