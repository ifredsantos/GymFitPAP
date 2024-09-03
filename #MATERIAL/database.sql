DROP DATABASE ginasio;
CREATE DATABASE ginasio;
USE ginasio;

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
INSERT INTO informacoes_entidade (cod_entidade_informacao, nome_entidade, nome_contacto, telefone_contacto, email_contacto, mapa, pagina_facebook, pagina_instagram, nome_localidade) VALUES
(1, 'GymFit', 'GymFit', 964196433, 'fredinsondev@gmail.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3051.6279391701473!2d-8.491628784613512!3d40.10600757940246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22589c1063c277%3A0x21ddad272e4fac02!2sGin%C3%A1sio+GymFit!5e0!3m2!1spt-PT!2spt!4v1526729441094', 
'https://www.facebook.com/GinasioGymFit/', 'https://www.instagram.com/gymfitcondeixa/', 'Rua da Lagoa, Valada, Condeixa-a-Nova');

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

INSERT INTO utilizadores_tipo (cod_regra, nome_regra) VALUES 
(1, 'Administrador'),
(2, 'Treinador'),
(3, 'Cliente'),
(4, 'Não confirmado'),
(5, 'Pré-registo');

CREATE TABLE utilizadores (
    cod_utilizador INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) UNIQUE NOT NULL,
    nif INT(9),
    nome CHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(13),
    psw VARCHAR(32) NOT NULL,
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
INSERT INTO utilizadores (cod_utilizador, username, nome, email, telefone, psw, genero, data_nascimento, data_adesao, data_ultimoAcesso, ip_ultimoAcesso, tipo_utilizador) VALUES 
(1000, 'Fred', 'Frederico Santos', 'fsraen@gmail.com', '915539220', 'c53512d75bbbfd03bfa1337116ea8384', 'm', '2001-12-09', '2018-11-03', '', '', 3),
(1001, 'admin', 'Administrador', 'admin@ginasiogymfit.com', '', '21232f297a57a5a743894a0e4a801fc3', 'm', '1985-02-19', '2003-01-01', '', '', 1);

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
INSERT INTO conquistas (nome_conquista, descricao_conquista, foto_conquista) VALUES 
('Família', 'Seja um membro da família GymFit', 'profile-achievement24'),
('Eu gosto disto', 'Membro à mais de 6 meses', 'profile-achievement1'),
('Fidelidade', 'Membro à mais de um ano', 'profile-achievement2'),
('Eu tenho!', 'Compre um produto no GymFit', 'profile-achievement4'),
('Eu amo-te!', 'Compre 10 produtos no GymFit', 'profile-achievement5'),
('Nunca sem ti!', 'Compre 20 produtos no GymFit', 'profile-achievement6'),
('Olá mundo', 'Convide 10 pessoas para visitar o seu perfil público', 'profile-achievement7'),
('Certinho', 'Seja regular no seu treino', 'profile-achievement9'),
('Sonhador', 'Adicione 5 produtos na sua lista de desejos', 'profile-achievement10'),
('Equipa do Facebook', 'Dê um gosto na página do GymFit no Facebook', 'profile-achievement12'),
('Eu encontrei-te', 'Adicione um amigo no GymFit', 'profile-achievement13'),
('A minha gange', 'Adicione 5 amigos ao GymFit', 'profile-achievement14'),
('Juntos somos mais fortes', 'Adicione 20 amigos ao GymFit', 'profile-achievement15'),
('Este sou eu!', 'Adicione um avatar', 'profile-achievement17'),
('Eu gosto disto puro', 'Deixe um comentário depois de comprar um produto', 'profile-achievement21'),
('Em qualquer lugar', 'Instale a aplicação para mobile do GymFit (e faça login!)', 'profile-achievement25');

CREATE TABLE utilizadores_conquistas (
    cod_utConquista INT NOT NULL AUTO_INCREMENT,
    cod_utilizador INT NOT NULL,
    cod_conquista INT NOT NULL,
    FOREIGN KEY(cod_utilizador) REFERENCES utilizadores(cod_utilizador),
    FOREIGN KEY(cod_conquista) REFERENCES conquistas(cod_conquista),
    data_conquista DATE NOT NULL,
    PRIMARY KEY (cod_utConquista)
);
INSERT INTO utilizadores_conquistas () VALUES (1, 1000, 1, '2019-04-26');

CREATE TABLE mensalidades (
    cod_mensalidade INT NOT NULL AUTO_INCREMENT,
    nome_mensalidade VARCHAR(30) UNIQUE NOT NULL,
    preco DOUBLE(4,2) NOT NULL,
    PRIMARY KEY(cod_mensalidade)
);
INSERT INTO mensalidades (cod_mensalidade, nome_mensalidade, preco)
    VALUES
    (1, 'Sem mensalidade', 0.00),
    (2, '2x / semana', 25.00),
    (3, '3x / semana', 27.50),
    (4, 'Livre trânsito', 30.00);
    
    
CREATE TABLE mensalidades_descontos (
    cod_desconto INT NOT NULL AUTO_INCREMENT,
    nome_desconto VARCHAR(30) NOT NULL UNIQUE,
    valor_desconto DOUBLE(4,2) NOT NULL,
    PRIMARY KEY(cod_desconto)
);
INSERT INTO mensalidades_descontos (cod_desconto, nome_desconto, valor_desconto)
    VALUES
    (1, 'Sem desconto', 0.00),
    (2, 'Estudante', 2.50);


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


CREATE TABLE treinadores (
    cod_treinador INT NOT NULL AUTO_INCREMENT,
    nome_treinador VARCHAR(60) NOT NULL,
    cargo VARCHAR(30) NOT NULL,
    descricao VARCHAR(500),
    foto VARCHAR(100) NOT NULL,
    data_nascimento DATE,
    PRIMARY KEY(cod_treinador)
);


CREATE TABLE textos (
    cod_texto INT NOT NULL AUTO_INCREMENT,
    titloPT VARCHAR(60) NOT NULL,
    textoPT VARCHAR(2000) NOT NULL,
    data_ultimoUpdate DATE NOT NULL,
    PRIMARY KEY(cod_texto)
);
INSERT INTO textos (titloPT, textoPT, data_ultimoUpdate) VALUES 
('Apresentação', '
<p>Somos um ginásio em Condeixa-a-Nova com tudo o que necessita para ficar em forma!</p>
<p>Temos um ambiente descontraido, profissional e alegre.</p>
<p>O GymFit é um ginásio onde a sua maior força se situa no convívio e saúde.</p>
<p>Fornecemos bem estar não apenas com o suor, mas sim com equilíbrio, saber, convívio e com um sorriso.</p>
<p><b>Venha visitar-nos, estamos a sua espera!</b></p>
<p>Clique <a href="https://www.youtube.com">aqui</a> para ver o nosso canal do YouTube.</p>', '2018-11-04');

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

CREATE TABLE produtos_marcas (
    cod_prod_marca INT NOT NULL AUTO_INCREMENT,
    marca_nome VARCHAR(60) NOT NULL UNIQUE,
    marca_img VARCHAR(150),
    PRIMARY KEY(cod_prod_marca)
);

CREATE TABLE produtos_categorias (
    cod_prod_catg INT NOT NULL AUTO_INCREMENT,
    catg_nome VARCHAR(150) NOT NULL,
    catg_desc VARCHAR(2000),
    catg_img VARCHAR(100),
    PRIMARY KEY(cod_prod_catg)
);

CREATE TABLE produtos_sub_categorias (
    cod_prod_subCatg INT NOT NULL AUTO_INCREMENT,
    catg_pai INT NOT NULL,
    subCatg_nome VARCHAR(150) NOT NULL,
    subCatg_desc VARCHAR(2000),
    subCatg_img VARCHAR(100),
    FOREIGN KEY(catg_pai) REFERENCES produtos_categorias(cod_prod_catg),
    PRIMARY KEY(cod_prod_subCatg)
);

CREATE TABLE produtos (
    cod_produto INT NOT NULL AUTO_INCREMENT,
    prod_ref VARCHAR(60) NOT NULL UNIQUE,
    prod_nome VARCHAR(150) NOT NULL,
    prod_descricao VARCHAR(2000),
    prod_img VARCHAR(150),
    preco_fornecedor FLOAT(6,2),
    prod_pvp FLOAT(6,2) NOT NULL,
    prod_desconto INT(3) DEFAULT 0,
    prod_prop_tamanho VARCHAR(15),
    prod_prop_peso VARCHAR(15),
    prod_prop_cor VARCHAR(30),
    prod_prop_sabor VARCHAR(30),
    prod_stock INT NOT NULL,
    prod_visivel TINYINT(1) NOT NULL DEFAULT 1,
    prod_data_add DATETIME DEFAULT NOW(),
    prod_marca INT,
    prod_catg INT NOT NULL,
    prod_subCatg INT NOT NULL,
    FOREIGN KEY(prod_catg) REFERENCES produtos_categorias(cod_prod_catg),
    FOREIGN KEY(prod_subCatg) REFERENCES produtos_sub_categorias(cod_prod_subCatg),
    FOREIGN KEY(prod_marca) REFERENCES produtos_marcas(cod_prod_marca),
    PRIMARY KEY(cod_produto)
);

CREATE TABLE encomendas_metodos_pagamento (
    cod_met_pagamento INT NOT NULL AUTO_INCREMENT,
    nome_met_pagamento VARCHAR(60) NOT NULL UNIQUE,
    disponivel TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY(cod_met_pagamento)
);
INSERT INTO encomendas_metodos_pagamento() VALUES 
(1, "PayPal", 1),
(2, "Pagamento no establecimento", 1),
(3, "PaysafeCard", 0);

CREATE TABLE encomendas_status (
    cod_enc_status INT NOT NULL,
    nome_enc_status VARCHAR(60) NOT NULL UNIQUE,
    PRIMARY KEY(cod_enc_status)
);
INSERT INTO encomendas_status() VALUES 
(1, "Aguardar pagamento"),
(2, "Pagamento recebido"),
(3, "Encomenda expedida"),
(4, "Entregue"),
(5, "Cancelada");

CREATE TABLE encomendas_met_envio (
    cod_met_envio INT NOT NULL AUTO_INCREMENT,
    nome_met_envio VARCHAR(60) NOT NULL UNIQUE,
    disponivel TINYINT(1) DEFAULT 0,
    PRIMARY KEY(cod_met_envio)
);
INSERT INTO encomendas_met_envio() VALUES 
(1, "Levantamento no establecimento", 1),
(2, "Envio CTT", 1),
(3, "Levantamento num ponto pickup da Chronopost", 0);

CREATE TABLE encomendas (
    cod_encomenda INT NOT NULL AUTO_INCREMENT,
    utilizador INT NOT NULL,
    metodo_pagamento INT NOT NULL,
    localidade VARCHAR(50) NOT NULL,
    codigo_postal VARCHAR(10) NOT NULL,
    morada VARCHAR(500) NOT NULL,
    status INT NOT NULL,
    avaliacao DECIMAL(3,2),
    comentario VARCHAR(500),
    metodo_envio INT NOT NULL,
    FOREIGN KEY(metodo_envio) REFERENCES encomendas_met_envio(cod_met_envio),
    data_encomenda DATETIME NOT NULL DEFAULT NOW(),
    FOREIGN KEY(utilizador) REFERENCES utilizadores(cod_utilizador),
    FOREIGN KEY(metodo_pagamento) REFERENCES encomendas_metodos_pagamento(cod_met_pagamento),
    FOREIGN KEY(status) REFERENCES encomendas_status(cod_enc_status),
    PRIMARY KEY(cod_encomenda)
);

CREATE TABLE encomendas_detalhes (
    cod_detalhe_enc INT NOT NULL AUTO_INCREMENT,
    encomenda INT NOT NULL,
    produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_venda DECIMAL(6,2) NOT NULL,
    desconto INT(3) DEFAULT 0,
    FOREIGN KEY(encomenda) REFERENCES encomendas(cod_encomenda),
    FOREIGN KEY(produto) REFERENCES produtos(cod_produto),
    PRIMARY KEY(cod_detalhe_enc)
);

-- INSERT INTO easypay_references 
-- (ep_cin, ep_status, ep_message, ep_entity, ep_reference, t_key, o_obs, o_mobile, o_email, ep_value)

CREATE TABLE esyp_ref (
    cod_ref_tansacao INT NOT NULL AUTO_INCREMENT,
    ep_cin 
)