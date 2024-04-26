var pop = document.getElementById('pop-user');
                
function abrePopUp() {
    if(pop.style.display == "none") {
        pop.style.display = "block";
    } else {
        pop.style.display = "none";
    }
}

function preparaCliente(codMensPagamentoID, nomeCliente, valorPagar, nomeMensalidade, nomeDesconto, mes, existeSeguro) {
    campoMensalidade = document.getElementById('mensalidade');
    campoDesconto = document.getElementById('desconto');
    campoValor = document.getElementById('valor');
    campoMes = document.getElementById('mes');
    campoNome = document.getElementById('nome');
    campoMensalidadePagamentoID = document.getElementById('mensalidadePagamentoID');
    campoExisteSeguro = document.getElementById('existeSeguro');
    ckb_existeSeguro = document.getElementById("ckb_existeSeguro");

    campoMensalidadePagamentoID.value = codMensPagamentoID;
    campoNome.value = nomeCliente;
    campoValor.value = valorPagar;
    campoMensalidade.value = nomeMensalidade;
    campoDesconto.value = nomeDesconto;
    campoMes.value = mes;
    campoExisteSeguro.value = existeSeguro;

    if(existeSeguro == 'n')
        ckb_existeSeguro.style.display = "block";

}

function enviaTextoEInf(titulo, texto) {
    ftitulo = document.getElementById('titulo');
    editor = document.getElementById('editTexto');
    prev = document.getElementById('pre-view');

    ftitulo.value = titulo;
    editor.value = texto;
    prev.value = texto;
}

function removeMensalidadeCliente(codCliente, mensalidadePagID) {
    cCliente = document.getElementById('clienteID');
    mPagID = document.getElementById('mensalidadeID');

    cCliente.value = codCliente;
    mPagID.value = mensalidadePagID;
}