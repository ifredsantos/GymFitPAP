function format($tipoFormat) {
    var textArea = document.getElementById('texto');
    var prev = document.getElementById('pre-view');

    if($tipoFormat != "") {
        var selectedText;
        var tgInicio = tgFim = "";

        if($tipoFormat == "paragrafo") {
            tgInicio = "<p>";
            tgFim = "</p>";
        }
        else if($tipoFormat == "negrito") {
            tgInicio = "<b>";
            tgFim = "</b>";
        }
        else if($tipoFormat == "italico") {
            tgInicio = "<i>";
            tgFim = "</i>";
        }
        else if($tipoFormat == "cortado") {
            tgInicio = "<del>";
            tgFim = "</del>";
        }
        else if($tipoFormat == "sublinhado") {
            tgInicio = "<ins>";
            tgFim = "</ins>";
        }
        else if($tipoFormat == "superior") {
            tgInicio = "<sup>";
            tgFim = "</sup>";
        }
        else if($tipoFormat == "marcado") {
            tgInicio = "<mark>";
            tgFim = "</mark>";
        }
        else if($tipoFormat == "link") {
            tgInicio = '<a href="https://www.link.com" target="_blank">';
            tgFim = "</a>";
        }
        else {
            return;
        }

        if (textArea.selectionStart != undefined) {
            var posInicio = textArea.selectionStart;
            var posFim = textArea.selectionEnd;
            var textoSelecionado = textArea.value.substring(posInicio, posFim);

            var novoTexto = textArea.value.substring(0, posInicio) + 
            tgInicio + textoSelecionado + tgFim + textArea.value.substring(posFim);
                                                            
            textArea.value = novoTexto;
        }
        prev.innerHTML = textArea.value;
    }
}

function doGetCaretPosition (ctrl) {
    var CaretPos = 0;	
    if (document.selection) { 
        //IE
        ctrl.focus ();		
        var Sel = document.selection.createRange ();		
        Sel.moveStart ('character', -ctrl.value.length);		
        CaretPos = Sel.text.length;
    }
    else if (ctrl.selectionStart || ctrl.selectionStart == '0'){
        // Firefox
         CaretPos = ctrl.selectionStart;
    }
    return (CaretPos);
}

function atualizaPrev() {
    var textArea = document.getElementById('texto');
    var prev = document.getElementById('pre-view');

    prev.innerHTML = textArea.value;
}