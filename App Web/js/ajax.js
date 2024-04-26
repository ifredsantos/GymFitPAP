/*
 * Função para criar um objeto XMLHTTPRequest
 */
function CriaRequest() {
    try{
        request = new XMLHttpRequest();        
    }catch (IEAtual){
         
        try{
            request = new ActiveXObject("Msxml2.XMLHTTP");       
        }catch(IEAntigo){
         
            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");          
            }catch(falha){
                request = false;
            }
        }
    }
     
    if (!request) 
        alert("O seu browser não suporta Ajax!");
    else
        return request;
}

/*
 * Função para enviar os dados
 */
function getDadosMensalidade(btnMes, btnAno, codAquisicao) {
      
    // Declaração de Variáveis
    var result = document.getElementById("result");
    var xmlreq = CriaRequest();
     
    // Exibi a imagem de progresso
    result.innerHTML = '<img style="width: 100px; display: block; margin: auto;" src="layout/loading.gif" alt="A carregar..." title="A carregar...">';
     
    // Iniciar uma requisição
    xmlreq.open("GET", "parts/perfil_info_mensalidade.php?mes=" + btnMes + "&ano=" + btnAno + "&cod_aquisicao=" + codAquisicao, true);
     
    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function() {
         
        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {
             
            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function getInfUtilizadorExtra(cod_utilizador) {
    var codUtilizador = cod_utilizador;
    var result = document.getElementById("result");
    
    var xmlreq = CriaRequest();

    xmlreq.open("GET", "parts/utilizador_info_extra.php?codigo=" + codUtilizador, true);
    xmlreq.onreadystatechange = function() {
        if (xmlreq.readyState == 4) {
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function getTexto(cod_texto) {
    var result = document.getElementById("result");
    
    var xmlreq = CriaRequest();

    xmlreq.open("GET", "parts/return_texto_info.php?codigo=" + cod_texto, true);
    xmlreq.onreadystatechange = function() {
        if (xmlreq.readyState == 4) {
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function pesquisaClientes(pesquisa) {
    var stringPesquisa = pesquisa;
    var resultAntigo = document.getElementById("resultado_anterior");
    
    var xmlreq = CriaRequest();

    xmlreq.open("GET", "parts/clientes_pesquisa.php?pesquisa=" + stringPesquisa, true);
    xmlreq.onreadystatechange = function() {
        if (xmlreq.readyState == 4) {
            if (xmlreq.status == 200) {
                resultAntigo.innerHTML = xmlreq.responseText;
            }else{
                resultAntigo.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function addExerciciosAoPlano(codPlano) {
    var cod_plano = codPlano;
    var result = document.getElementById("resultado_ajax_add_exercicios_plano");
    
    var xmlreq = CriaRequest();

    xmlreq.open("GET", "parts/return_add_exercicios_plano.php?cod=" + cod_plano, true);
    xmlreq.onreadystatechange = function() {
        if (xmlreq.readyState == 4) {
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function remExerciciosAoPlano(codPlano) {
    var cod_plano = codPlano;
    var result = document.getElementById("resultado_ajax_rem_exercicios_plano");
    
    var xmlreq = CriaRequest();

    xmlreq.open("GET", "parts/return_rem_exercicios_plano.php?cod=" + cod_plano, true);
    xmlreq.onreadystatechange = function() {
        if (xmlreq.readyState == 4) {
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function addClientesAoExercicio(codPlano) {
    var cod_plano = codPlano;
    var result = document.getElementById("resultado_ajax_add_cliente_plano");
    
    var xmlreq = CriaRequest();

    xmlreq.open("GET", "parts/return_add_clientes_plano.php?cod=" + cod_plano, true);
    xmlreq.onreadystatechange = function() {
        if (xmlreq.readyState == 4) {
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function removerClientesAoPlano(codPlano) {
    var cod_plano = codPlano;
    var result = document.getElementById("resultado_ajax_rem_cliente_plano");
    
    var xmlreq = CriaRequest();

    xmlreq.open("GET", "parts/return_rem_clientes_plano.php?cod=" + cod_plano, true);
    xmlreq.onreadystatechange = function() {
        if (xmlreq.readyState == 4) {
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}