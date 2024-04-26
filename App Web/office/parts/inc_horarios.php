<?php
    $buscaHorario = $gst->exe_query("
    SELECT * FROM horarios");
    if(count($buscaHorario) > 0) {
        $horario = $buscaHorario[0];
        
        $semanal_manha = explode(";", $horario['semanal_manha']);
        $semanal_manha_inicio = $semanal_manha[0];
        $semanal_manha_fim = $semanal_manha[1];

        $semanal_tarde = explode(";", $horario['semanal_tarde']);
        $semanal_tarde_inicio = $semanal_tarde[0];
        $semanal_tarde_fim = $semanal_tarde[1];

        $sabado_manha = explode(";", $horario['sabado_manha']);
        $sabado_manha_inicio = $sabado_manha[0];
        $sabado_manha_fim = $sabado_manha[1];

        $sabado_tarde = explode(";", $horario['sabado_tarde']);
        $sabado_tarde_inicio = $sabado_tarde[0];
        $sabado_tarde_fim = $sabado_tarde[1];

        if($horario['domingo_manha'] != "") {
            $domingo_manha = explode(";", $horario['domingo_manha']);
            $domingo_manha_inicio = $domingo_manha[0];
            $domingo_manha_fim = $domingo_manha[1];
        } else {
            $domingo_manha_inicio = $domingo_manha_fim = "";
        }

        if($horario['domingo_tarde'] != "") {
            $domingo_tarde = explode(";", $horario['domingo_tarde']);
            $domingo_tarde_inicio = $domingo_tarde[0];
            $domingo_tarde_fim = $domingo_tarde[1];
        } else {
            $domingo_tarde_inicio = $domingo_tarde_fim = "";
        }

    } else {
        $semanal_manha_inicio = $semanal_manha_fim = $semanal_tarde_inicio = $semanal_tarde_fim = $sabado_manha_inicio = $sabado_manha_fim = $sabado_tarde_inicio = $sabado_tarde_fim = "";
        $domingo_manha_inicio = $domingo_manha_fim = $domingo_tarde_inicio = $domingo_tarde_fim = "";
    }
?>

<h3 class="text-center">Horários</h3>
<div class="col-md-8 offset-md-2">
    <form action="editor/horarios" method="post">
        <h4>Semanal</h4>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="semanal_manha_inicio">Manhã Início</label>
                <input name="semanal_manha_inicio" type="time" class="form-control" value="<?= $semanal_manha_inicio ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="semanal_manha_fim">Manhã Fim</label>
                <input name="semanal_manha_fim" type="time" class="form-control" value="<?= $semanal_manha_fim ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="semanal_tarde_inicio">Tarde Início</label>
                <input name="semanal_tarde_inicio" type="time" class="form-control" value="<?= $semanal_tarde_inicio ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="semanal_tarde_fim">Tarde Fim</label>
                <input name="semanal_tarde_fim" type="time" class="form-control" value="<?= $semanal_tarde_fim ?>">
            </div>
        </div>

        <h4>Sábado</h4>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="sabado_manha_inicio">Manhã Início</label>
                <input name="sabado_manha_inicio" type="time" class="form-control" value="<?= $sabado_manha_inicio ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="sabado_manha_fim">Manhã Fim</label>
                <input name="sabado_manha_fim" type="time" class="form-control" value="<?= $sabado_manha_fim ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="sabado_tarde_inicio">Tarde Início</label>
                <input name="sabado_tarde_inicio" type="time" class="form-control" value="<?= $sabado_tarde_inicio ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="sabado_tarde_fim">Tarde Fim</label>
                <input name="sabado_tarde_fim" type="time" class="form-control" value="<?= $sabado_tarde_fim ?>">
            </div>
        </div>

        <h4>Domingo</h4>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="domingo_manha_inicio">Manhã Início</label>
                <input name="domingo_manha_inicio" type="time" class="form-control" value="<?= $domingo_manha_inicio ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="domingo_manha_fim">Manhã Fim</label>
                <input name="domingo_manha_fim" type="time" class="form-control" value="<?= $domingo_manha_fim ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="domingo_tarde_inicio">Tarde Início</label>
                <input name="domingo_tarde_inicio" type="time" class="form-control" value="<?= $domingo_tarde_inicio ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="domingo_tarde_fim">Tarde Fim</label>
                <input name="domingo_tarde_fim" type="time" class="form-control" value="<?= $domingo_tarde_fim ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn-group" role="group">
                    <button type="reset" class="btn btn-default btn-hover-green" role="button">Apagar</button>
                </div>
                <div class="btn-group" role="group">
                    <input type="hidden" name="acao" value="alterarHorario">
                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="clearfix"></div>