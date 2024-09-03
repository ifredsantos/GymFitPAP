<?php
    define("APP_MODE", "teste");
    // ==================================================
    // Configuração do servidor
    // ==================================================
    date_default_timezone_set('Europe/Lisbon');
    setlocale(LC_ALL, 'pt_PT');

    if(APP_MODE == "producao") { // Se o modo da aplicação estiver como produção oculta eventuais erros
        ini_set('display_errors',0);
        ini_set('display_startup_errors',0);
        error_reporting(0);
    } else { // Se o modo da aplicação estiver como teste mostra todos os eventuais erros
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
    }
    
    // ==================================================
    // Busca das informações da entidade
    // ==================================================
    require 'parts/cl_gestor.php'; // Inclusão da classe de gestão da BD
    $gst = new BDGestor("localhost", "root", "", "ginasio_gymfit"); // Criação do objeto da classe

    $data = $gst->exe_query("SELECT * FROM informacoes_entidade WHERE cod_entidade_informacao = 1");
    if(count($data) > 0) {
        $data = $data[0];
        // Informações que são alteraveis provenientes da base de dados
        define("APP_NAME", $data['nome_entidade']);
        define("APP_LOCALIDADE", $data['nome_localidade']);
        define("APP_MAP", $data['mapa']);
        define("OWNER_EMAIL", $data['email_contacto']);
        define("OWNER_TELEFONE", $data['telefone_contacto']);
        define("PAGINA_FACEBOOK", $data['pagina_facebook']);
        define("PAGINA_INSTAGRAM", $data['pagina_instagram']);
    }
    else
    {
        define("APP_NAME", "GymFit");
        define("APP_LOCALIDADE", "");
        define("APP_MAP", "");
        define("OWNER_EMAIL", "");
        define("OWNER_TELEFONE", "");
        define("PAGINA_FACEBOOK", "");
        define("PAGINA_INSTAGRAM", "");
    }
    
    // Informações estáticas
    define("APP_URL", "http://localhost/app_web/");
    define("APP_URL_OFFICE", APP_URL."office/");
    define("APP_URL_LOJA", APP_URL."loja/");
    define("CAM_FATURAS", "../posts/faturas/");
    define("CAM_GALERIA", "../posts/galeria/");
    define("DIAPAGAMENTO", "10");
    define("SEGURO", "10.00");
    define("IP_ESTABLECIMENTO", array("::1"));
    define("MAX_LOGIN_TENTATIVAS", "5");
    define("MAX_LOGIN_TEMPO", "1"); // em horas
    define("TEMPO_INATIVIDADE", 5);
    
    // ==============================================
    define("PROGRAMER_NAME", "Frederico Santos");
    define("PROGRAMER_EMAIL", "dsoftvvare@gmail.com");
    
    // Inclusão das partes necessárias para o sistema
    include("func.php"); // Arquivo onde contem todas as funções necessárias para o sistema

    // Inicia sessão segura
    sec_session_start();
    
    // ==================================================
    // Gestão dos utilizadores online (estística)
    // ==================================================
    if(isset($_SESSION['cod_user']) && !empty($_SESSION['cod_user'])) { // Se existir sessão inclui o ficheiro
        /* Este ficheiro atualiza os estado dos utilizadores que estejam inativos 
            por mais de 5 minutos para offline e altera o estado do utilizador atual */
        include 'parts/inc_verifica_utilizadores_online.php';
    }
?>