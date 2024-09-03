DROP DATABASE ginasio_gymfit;
CREATE DATABASE ginasio_gymfit;
USE ginasio_gymfit;

CREATE TABLE informacoes_entidade (
    cod_entidade_informacao INT PRIMARY KEY,
    nome_entidade VARCHAR(30) NOT NULL UNIQUE,
    nome_contacto VARCHAR(30) NOT NULL,
    telefone_contacto VARCHAR(13) NOT NULL UNIQUE,
    email_contacto VARCHAR(100) NOT NULL UNIQUE,
    mapa VARCHAR(500) UNIQUE,
    pagina_facebook VARCHAR(200) UNIQUE,
    pagina_instagram VARCHAR(200) UNIQUE,
    nome_localidade VARCHAR(200)
);

CREATE TABLE mensagens (
    cod_msg INT NOT NULL AUTO_INCREMENT,
    nome_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    mensagem VARCHAR(500) NOT NULL,
    data_envio DATETIME NOT NULL,
    vista CHAR(1),
    respondida CHAR(1),
    resposta VARCHAR(500),
    PRIMARY KEY (cod_msg)
);

CREATE TABLE utilizadores_tipo (
    cod_regra INT NOT NULL AUTO_INCREMENT,
    nome_regra VARCHAR(20) UNIQUE NOT NULL,
    PRIMARY KEY(cod_regra)
);

CREATE TABLE utilizadores (
    cod_utilizador INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) UNIQUE NULL,
    nif INT(9) UNIQUE NULL,
    nome CHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NULL,
    telefone VARCHAR(13) NULL,
    psw VARCHAR(32) NULL,
    foto VARCHAR(50) UNIQUE,
    genero CHAR(1) NOT NULL,
    data_nascimento date NOT NULL,
    data_adesao date NOT NULL,
    data_ultimoAcesso DATETIME,
    online CHAR(1) DEFAULT 'n' NOT NULL,
    ip_ultimoAcesso VARCHAR(20),
    tipo_utilizador INT NOT NULL,
    FOREIGN KEY(tipo_utilizador) REFERENCES utilizadores_tipo(cod_regra),
    PRIMARY KEY(cod_utilizador)
);

CREATE TABLE utilizadores_objetivos (
    id_objetivo INT NOT NULL AUTO_INCREMENT,
    utilizador INT NOT NULL,
    FOREIGN KEY(utilizador) REFERENCES utilizadores(cod_utilizador),
    objetivo VARCHAR(60) NOT NULL,
    peso_alvo DECIMAL(6,3) NOT NULL,
    data_alvo DATE NOT NULL,
    atual CHAR(1) NOT NULL DEFAULT 'n',
    cumprido CHAR(1) NOT NULL DEFAULT 'n',
    data_registo DATE NOT NULL,
    PRIMARY KEY (id_objetivo)
);

CREATE TABLE utilizadores_analises (
    cod_analise INT NOT NULL AUTO_INCREMENT,
    peso DECIMAL(5,2) NOT NULL,
    altura DECIMAL(3,2) NOT NULL,
    perimetro_abdominal DECIMAL(4,2),
    pressao_arterial INT(5),
    utilizador INT NOT NULL,
    FOREIGN KEY(utilizador) REFERENCES utilizadores(cod_utilizador),
    data_analise date NOT NULL,
    PRIMARY KEY(cod_analise)
);

CREATE TABLE utilizadores_confirmacao (
    cod_confirmacao INT NOT NULL AUTO_INCREMENT,
    cod_user INT NOT NULL,
    FOREIGN KEY(cod_user) REFERENCES utilizadores(cod_utilizador),
    chave_confirmacao VARCHAR(32) NOT NULL UNIQUE,
    date_pedido DATETIME NOT NULL,
    PRIMARY KEY (cod_confirmacao)
);

CREATE TABLE utilizadores_pre_registos (
    cod_preReg VARCHAR(20) PRIMARY KEY,
    utilizador INT NOT NULL,
    FOREIGN KEY(utilizador) REFERENCES utilizadores(cod_utilizador)
);

CREATE TABLE conquistas (
    cod_conquista INT NOT NULL AUTO_INCREMENT,
    nome_conquista VARCHAR(50) NOT NULL UNIQUE,
    descricao_conquista VARCHAR(100),
    foto_conquista VARCHAR(100),
    PRIMARY KEY (cod_conquista)
);

CREATE TABLE utilizadores_conquistas (
    cod_utConquista INT NOT NULL AUTO_INCREMENT,
    cod_utilizador INT NOT NULL,
    cod_conquista INT NOT NULL,
    FOREIGN KEY(cod_utilizador) REFERENCES utilizadores(cod_utilizador),
    FOREIGN KEY(cod_conquista) REFERENCES conquistas(cod_conquista),
    data_conquista DATE NOT NULL,
    PRIMARY KEY (cod_utConquista)
);

CREATE TABLE mensalidades (
    cod_mensalidade INT NOT NULL AUTO_INCREMENT,
    nome_mensalidade VARCHAR(30) UNIQUE NOT NULL,
    preco DOUBLE(4,2) NOT NULL,
    PRIMARY KEY(cod_mensalidade)
);    
    
CREATE TABLE mensalidades_descontos (
    cod_desconto INT NOT NULL AUTO_INCREMENT,
    nome_desconto VARCHAR(30) NOT NULL UNIQUE,
    valor_desconto DOUBLE(4,2) NOT NULL,
    PRIMARY KEY(cod_desconto)
);

CREATE TABLE mensalidades_aquisicoes (
    cod_aquisicao INT NOT NULL AUTO_INCREMENT,
    utilizador INT NOT NULL,
    FOREIGN KEY(utilizador) REFERENCES utilizadores(cod_utilizador),
    mensalidade INT NOT NULL,
    FOREIGN KEY(mensalidade) REFERENCES mensalidades(cod_mensalidade),
    desconto INT NOT NULL,
    FOREIGN KEY(desconto) REFERENCES mensalidades_descontos(cod_desconto),
    data_aquisicao DATE NOT NULL,
    atual CHAR(1) DEFAULT 'n' NOT NULL,
    PRIMARY KEY(cod_aquisicao)
);

CREATE TABLE mensalidades_pagamentos (
    cod_mensalidadePagamento INT NOT NULL AUTO_INCREMENT,
    cod_utilizador INT NOT NULL,
    aquisicao INT NOT NULL,
    FOREIGN KEY(cod_utilizador) REFERENCES utilizadores(cod_utilizador),
    FOREIGN KEY(aquisicao) REFERENCES mensalidades_aquisicoes(cod_aquisicao),
    valor_pago DOUBLE(4,2),
    mes INT(2) NOT NULL,
    ano INT(4) NOT NULL,
    data_pagamento DATETIME,
    cancelado CHAR(1) DEFAULT 'n',
    fatura VARCHAR(60) UNIQUE,
    PRIMARY KEY(cod_mensalidadePagamento)
);

CREATE TABLE seguros (
    cod_seguro INT NOT NULL AUTO_INCREMENT,
    utilizador INT NOT NULL,
    CONSTRAINT fk_utilizador_seguro FOREIGN KEY(utilizador) REFERENCES utilizadores(cod_utilizador),
    ano INT(4) NOT NULL,
    data_pagamento DATE,
    PRIMARY KEY(cod_seguro)
);

CREATE TABLE modalidades (
    cod_modalidade INT NOT NULL AUTO_INCREMENT,
    nome_modalidade VARCHAR(30) UNIQUE NOT NULL,
    descricao VARCHAR(1000),
    imgIndex VARCHAR(100) NOT NULL,
    imgs VARCHAR(300),
    PRIMARY KEY(cod_modalidade)
);

CREATE TABLE galeria (
    cod_img INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(60) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    nome_img VARCHAR(60) NOT NULL,
    data_pub DATETIME NOT NULL,
    PRIMARY KEY(cod_img)
);

CREATE TABLE textos (
    cod_texto INT NOT NULL AUTO_INCREMENT,
    titloPT VARCHAR(60) NOT NULL,
    textoPT VARCHAR(2000) NOT NULL,
    data_ultimoUpdate DATE NOT NULL,
    PRIMARY KEY(cod_texto)
);

CREATE TABLE horarios (
    cod_horario INT PRIMARY KEY,
    semanal_manha VARCHAR(14),
    semanal_tarde VARCHAR(14),
    sabado_manha VARCHAR(14),
    sabado_tarde VARCHAR(14),
    domingo_manha VARCHAR(14),
    domingo_tarde VARCHAR(14),
    data_modificacao DATE
);

CREATE TABLE tipos_exercicios (
    cod_tipo_exercicio INT NOT NULL AUTO_INCREMENT,
    nome_tipo VARCHAR(60) NOT NULL UNIQUE,
    img VARCHAR(60) NOT NULL UNIQUE,
    PRIMARY KEY(cod_tipo_exercicio)
);

CREATE TABLE exercicios (
    cod_exercicio INT NOT NULL AUTO_INCREMENT,
    nome_exercicio VARCHAR(100) NOT NULL UNIQUE,
    img VARCHAR(100),
    video VARCHAR(100),
    tipo INT NOT NULL,
    FOREIGN KEY(tipo) REFERENCES tipos_exercicios(cod_tipo_exercicio),
    PRIMARY KEY(cod_exercicio)
);

CREATE TABLE planos (
    cod_plano INT NOT NULL AUTO_INCREMENT,
    nome_plano VARCHAR(60) NOT NULL UNIQUE,
    img_plano VARCHAR(60) NOT NULL,
    duracao TIME,
    tipo INT NOT NULL,
    PRIMARY KEY(cod_plano)
);

CREATE TABLE plano_exercicios (
    cod_plano_exercicio INT NOT NULL AUTO_INCREMENT,
    plano INT NOT NULL,
    FOREIGN KEY(plano) REFERENCES planos(cod_plano),
    exercicio INT NOT NULL,
    FOREIGN KEY(exercicio) REFERENCES exercicios(cod_exercicio),
    num_reps INT,
    num_series INT,
    duracao TIME,
    PRIMARY KEY(cod_plano_exercicio)
);

CREATE TABLE planos_clientes (
    cod_plano_cliente INT NOT NULL AUTO_INCREMENT,
    plano INT NOT NULL,
    FOREIGN KEY(plano) REFERENCES planos(cod_plano),
    cliente INT NOT NULL,
    FOREIGN KEY(cliente) REFERENCES utilizadores(cod_utilizador),
    PRIMARY KEY(cod_plano_cliente)
);

CREATE TABLE utilizadores_login_tentativas(
    cod_tentativa INT NOT NULL AUTO_INCREMENT,
    utilizador INT NOT NULL,
    FOREIGN KEY(utilizador) REFERENCES utilizadores(cod_utilizador),
    data_log DATETIME NOT NULL,
    PRIMARY KEY(cod_tentativa)
);

-- CREATE TABLE treinadores (
--     cod_treinador INT NOT NULL AUTO_INCREMENT,
--     nome_treinador VARCHAR(60) NOT NULL,
--     cargo VARCHAR(30) NOT NULL,
--     descricao VARCHAR(500),
--     foto VARCHAR(100) NOT NULL,
--     data_nascimento DATE,
--     PRIMARY KEY(cod_treinador)
-- );