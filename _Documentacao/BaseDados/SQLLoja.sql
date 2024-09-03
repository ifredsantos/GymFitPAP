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