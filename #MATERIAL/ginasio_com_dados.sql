DROP DATABASE ginasio;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05-Abr-2019 às 09:01
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ginasio`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conquistas`
--

CREATE TABLE `conquistas` (
  `cod_conquista` int(11) NOT NULL,
  `nome_conquista` varchar(50) NOT NULL,
  `descricao_conquista` varchar(100) DEFAULT NULL,
  `foto_conquista` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `conquistas`
--

INSERT INTO `conquistas` (`cod_conquista`, `nome_conquista`, `descricao_conquista`, `foto_conquista`) VALUES
(1, 'Família', 'Seja um membro da família GymFit', 'profile-achievement24'),
(2, 'Eu gosto disto', 'Membro à mais de 6 meses', 'profile-achievement1'),
(3, 'Fidelidade', 'Membro à mais de um ano', 'profile-achievement2'),
(4, 'Eu tenho!', 'Compre um produto no GymFit', 'profile-achievement4'),
(5, 'Eu amo-te!', 'Compre 10 produtos no GymFit', 'profile-achievement5'),
(6, 'Nunca sem ti!', 'Compre 20 produtos no GymFit', 'profile-achievement6'),
(7, 'Olá mundo', 'Convide 10 pessoas para visitar o seu perfil público', 'profile-achievement7'),
(8, 'Certinho', 'Seja regular no seu treino', 'profile-achievement9'),
(9, 'Sonhador', 'Adicione 5 produtos na sua lista de desejos', 'profile-achievement10'),
(10, 'Equipa do Facebook', 'Dê um gosto na página do GymFit no Facebook', 'profile-achievement12'),
(11, 'Eu encontrei-te', 'Adicione um amigo no GymFit', 'profile-achievement13'),
(12, 'A minha gange', 'Adicione 5 amigos ao GymFit', 'profile-achievement14'),
(13, 'Juntos somos mais fortes', 'Adicione 20 amigos ao GymFit', 'profile-achievement15'),
(14, 'Este sou eu!', 'Adicione um avatar', 'profile-achievement17'),
(15, 'Eu gosto disto puro', 'Deixe um comentário depois de comprar um produto', 'profile-achievement21'),
(16, 'Em qualquer lugar', 'Instale a aplicação para mobile do GymFit (e faça login!)', 'profile-achievement25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `cod_encomenda` int(11) NOT NULL,
  `ref_encomenda` varchar(20) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `pagamento` int(11) NOT NULL,
  `data_encomenda` datetime NOT NULL,
  `data_envio` datetime DEFAULT NULL,
  `transportadora` int(11) NOT NULL,
  `portes` decimal(5,2) NOT NULL,
  `IVA` int(2) NOT NULL,
  `status_transacao` varchar(40) DEFAULT NULL,
  `pago` char(1) NOT NULL,
  `data_pagamento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomenda_detalhes`
--

CREATE TABLE `encomenda_detalhes` (
  `cod_encomenda_detalhes` int(11) NOT NULL,
  `encomenda` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `qty` int(3) NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `sabor` varchar(30) DEFAULT NULL,
  `tamanho` varchar(10) DEFAULT NULL,
  `cor` varchar(20) DEFAULT NULL,
  `peso` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `exercicios`
--

CREATE TABLE `exercicios` (
  `cod_exercicio` int(11) NOT NULL,
  `nome_exercicio` varchar(100) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `exercicios`
--

INSERT INTO `exercicios` (`cod_exercicio`, `nome_exercicio`, `img`, `video`, `tipo`) VALUES
(1, 'Superman', 'costas_lombar_superman.jpg', 'Lombar 2 - Superman.mp4', 1),
(5, 'Hyper Extention', 'costas_lombar_no_banco.jpg', 'Lombar 1 - Lombar no banco.mp4', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `galeria`
--

CREATE TABLE `galeria` (
  `cod_img` int(11) NOT NULL,
  `titulo` varchar(60) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `nome_img` varchar(60) NOT NULL,
  `data_pub` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `galeria`
--

INSERT INTO `galeria` (`cod_img`, `titulo`, `descricao`, `nome_img`, `data_pub`) VALUES
(17, '', '', '278899_294744_632791_940667_A14.jpg', '2019-03-30'),
(18, '', '', '255150_980756_436659_400330_A14.jpg', '2019-03-30'),
(19, '', '', '911557_191927_641061_282065_A14.jpg', '2019-03-30'),
(20, '', '', '770507_214378_460794_697841_A14.jpg', '2019-03-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios`
--

CREATE TABLE `horarios` (
  `cod_horario` int(11) NOT NULL,
  `semanal_manha` varchar(14) DEFAULT NULL,
  `semanal_tarde` varchar(14) DEFAULT NULL,
  `sabado_manha` varchar(14) DEFAULT NULL,
  `sabado_tarde` varchar(14) DEFAULT NULL,
  `domingo_manha` varchar(14) DEFAULT NULL,
  `domingo_tarde` varchar(14) DEFAULT NULL,
  `data_modificacao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `horarios`
--

INSERT INTO `horarios` (`cod_horario`, `semanal_manha`, `semanal_tarde`, `sabado_manha`, `sabado_tarde`, `domingo_manha`, `domingo_tarde`, `data_modificacao`) VALUES
(0, '09:00;13:00', '15:00;21:30', '09:00;13:00', '16:00;19:00', NULL, NULL, '2019-03-30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_entidade`
--

CREATE TABLE `informacoes_entidade` (
  `cod_entidade_informacao` int(11) NOT NULL,
  `nome_entidade` varchar(30) NOT NULL,
  `nome_contacto` varchar(30) NOT NULL,
  `telefone_contacto` varchar(13) NOT NULL,
  `email_contacto` varchar(100) NOT NULL,
  `mapa` varchar(500) DEFAULT NULL,
  `pagina_facebook` varchar(200) DEFAULT NULL,
  `pagina_instagram` varchar(200) DEFAULT NULL,
  `nome_localidade` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `informacoes_entidade`
--

INSERT INTO `informacoes_entidade` (`cod_entidade_informacao`, `nome_entidade`, `nome_contacto`, `telefone_contacto`, `email_contacto`, `mapa`, `pagina_facebook`, `pagina_instagram`, `nome_localidade`) VALUES
(1, 'GymFit', 'GymFit', '964196433', 'fredinsondev@gmail.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3051.6279391701473!2d-8.491628784613512!3d40.10600757940246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22589c1063c277%3A0x21ddad272e4fac02!2sGin%C3%A1sio+GymFit!5e0!3m2!1spt-PT!2spt!4v1526729441094', 'https://www.facebook.com/GinasioGymFit/', 'https://www.instagram.com/gymfitcondeixa/', 'Rua da Lagoa, Valada, Condeixa-a-Nova');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `cod_msg` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `email_cliente` varchar(100) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  `data_envio` datetime NOT NULL,
  `vista` char(1) DEFAULT NULL,
  `respondida` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidades`
--

CREATE TABLE `mensalidades` (
  `cod_mensalidade` int(11) NOT NULL,
  `nome_mensalidade` varchar(30) NOT NULL,
  `preco` double(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensalidades`
--

INSERT INTO `mensalidades` (`cod_mensalidade`, `nome_mensalidade`, `preco`) VALUES
(1, 'Sem mensalidade', 0.00),
(2, '2x / semana', 25.00),
(3, '3x / semana', 27.50),
(4, 'Livre trânsito', 30.00),
(5, '10 aulas (Limite de 3 meses)', 40.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidades_aquisicoes`
--

CREATE TABLE `mensalidades_aquisicoes` (
  `cod_aquisicao` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `mensalidade` int(11) NOT NULL,
  `desconto` int(11) NOT NULL,
  `data_aquisicao` date NOT NULL,
  `atual` char(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensalidades_aquisicoes`
--

INSERT INTO `mensalidades_aquisicoes` (`cod_aquisicao`, `utilizador`, `mensalidade`, `desconto`, `data_aquisicao`, `atual`) VALUES
(21, 1000, 2, 1, '2019-04-03', 's');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidades_descontos`
--

CREATE TABLE `mensalidades_descontos` (
  `cod_desconto` int(11) NOT NULL,
  `nome_desconto` varchar(30) NOT NULL,
  `valor_desconto` double(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensalidades_descontos`
--

INSERT INTO `mensalidades_descontos` (`cod_desconto`, `nome_desconto`, `valor_desconto`) VALUES
(1, 'Sem desconto', 0.00),
(2, 'Estudante', 2.50);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidades_pagamentos`
--

CREATE TABLE `mensalidades_pagamentos` (
  `cod_mensalidadePagamento` int(11) NOT NULL,
  `cod_utilizador` int(11) NOT NULL,
  `aquisicao` int(11) NOT NULL,
  `valor_pago` double(4,2) DEFAULT NULL,
  `mes` int(2) NOT NULL,
  `ano` int(4) NOT NULL,
  `data_pagamento` datetime DEFAULT NULL,
  `cancelado` char(1) DEFAULT 'n',
  `fatura` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensalidades_pagamentos`
--

INSERT INTO `mensalidades_pagamentos` (`cod_mensalidadePagamento`, `cod_utilizador`, `aquisicao`, `valor_pago`, `mes`, `ano`, `data_pagamento`, `cancelado`, `fatura`) VALUES
(16, 1000, 21, NULL, 4, 2019, NULL, 'n', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `modalidades`
--

CREATE TABLE `modalidades` (
  `cod_modalidade` int(11) NOT NULL,
  `nome_modalidade` varchar(30) NOT NULL,
  `descricao` varchar(1000) DEFAULT NULL,
  `imgIndex` varchar(100) NOT NULL,
  `imgs` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `modalidades`
--

INSERT INTO `modalidades` (`cod_modalidade`, `nome_modalidade`, `descricao`, `imgIndex`, `imgs`) VALUES
(1, 'Musculação', 'O treinamento de força, conhecido popularmente como musculação é uma forma de exercício contra resistência, praticado normalmente em ginásios, para o treinamento e desenvolvimento dos musculos esqueléticos. Utiliza a força da gravidade (com barras, halteres, pilhas de peso ou o peso do próprio corpo) e a <a href = \"\">resistência</a> gerada por equipamentos, elásticos e molas para opor forças aos musculos que, por sua vez, devem gerar força oposta através de contrações musculares que podem ser concêntricas, excêntricas e isométricas.</p><p>Esta forma de treinamento físico é utilizado para fins atléticos (por meio da melhora no desempenho de atletas), estáticos (no desenvolvimento do volume muscular) e de saúde (auxiliando no tratamento de doenças musculares, Osseas, metabólicas, melhora na mobilidade, postura etc).', 'musc.jpg', 'musculacao.png;elevacao-escapula.jpg;67986-11200468.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id_pagamento` int(11) NOT NULL,
  `tipo_pagamento` varchar(10) NOT NULL,
  `permitido` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `planos`
--

CREATE TABLE `planos` (
  `cod_plano` int(11) NOT NULL,
  `nome_plano` varchar(60) NOT NULL,
  `img_plano` varchar(60) NOT NULL,
  `duracao` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `planos`
--

INSERT INTO `planos` (`cod_plano`, `nome_plano`, `img_plano`, `duracao`) VALUES
(1, 'Treino geral', 'plano_geral.jpg', '01:30:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `plano_exercicios`
--

CREATE TABLE `plano_exercicios` (
  `cod_plano_exercicio` int(11) NOT NULL,
  `plano` int(11) NOT NULL,
  `exercicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `plano_exercicios`
--

INSERT INTO `plano_exercicios` (`cod_plano_exercicio`, `plano`, `exercicio`) VALUES
(1, 1, 5),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `cod_produto` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `nome_produto` varchar(60) NOT NULL,
  `descricao_produto` varchar(500) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `cod_marca` int(11) NOT NULL,
  `cod_categoria` int(11) NOT NULL,
  `preco_fornecedor` decimal(6,2) NOT NULL,
  `PVP` decimal(6,2) NOT NULL,
  `sabor` varchar(20) DEFAULT NULL,
  `tamanho` varchar(10) DEFAULT NULL,
  `cor` varchar(100) DEFAULT NULL,
  `peso` int(6) DEFAULT NULL,
  `desconto` int(2) DEFAULT NULL,
  `fotos` varchar(255) NOT NULL,
  `visitas` int(11) DEFAULT NULL,
  `vendido` int(11) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`cod_produto`, `ref`, `nome_produto`, `descricao_produto`, `stock`, `cod_marca`, `cod_categoria`, `preco_fornecedor`, `PVP`, `sabor`, `tamanho`, `cor`, `peso`, `desconto`, `fotos`, `visitas`, `vendido`, `notas`) VALUES
(1, 'PROTMYPRT-IWP1000', 'Impact Whey Protein', 'Proteína de soro de leite de elevada qualidade com 21 g de proteína por porção, para ingerir a proteína necessária de uma fonte segura — as mesmas vacas que produzem o seu leite e queijo. Apenas é filtrada e transformada em pó para produzir alimentos nutritivos completamente naturais.', 9, 1, 1, '3.38', '5.38', 'Sem sabor', '', '', 1000, 0, '10530943-1234625356041867.jpg;10530943-9994620651516888.jpg', NULL, NULL, ''),
(2, 'PROTMYPRT-IWP1000', 'Impact Whey Protein', 'Proteína de soro de leite de elevada qualidade com 21 g de proteína por porção, para ingerir a proteína necessária de uma fonte segura — as mesmas vacas que produzem o seu leite e queijo. Apenas é filtrada e transformada em pó para produzir alimentos nutritivos completamente naturais.', 9, 1, 1, '3.38', '5.38', 'Banana', '', '', 1000, 0, '10530943-1234625356041867.jpg;10530943-9994620651516888.jpg', NULL, NULL, ''),
(3, 'PROTMYPRT-IWP1000', 'Impact Whey Protein', 'Proteína de soro de leite de elevada qualidade com 21 g de proteína por porção, para ingerir a proteína necessária de uma fonte segura — as mesmas vacas que produzem o seu leite e queijo. Apenas é filtrada e transformada em pó para produzir alimentos nutritivos completamente naturais.', 9, 1, 1, '3.38', '5.38', 'Baunilha', '', '', 1000, 0, '10530943-1234625356041867.jpg;10530943-9994620651516888.jpg', NULL, NULL, ''),
(4, 'PROTMYPRT-IWP1000', 'Impact Whey Protein', 'Proteína de soro de leite de elevada qualidade com 21 g de proteína por porção, para ingerir a proteína necessária de uma fonte segura — as mesmas vacas que produzem o seu leite e queijo. Apenas é filtrada e transformada em pó para produzir alimentos nutritivos completamente naturais.', 9, 1, 1, '3.38', '5.38', 'Chocolate', '', '', 1000, 0, '10530943-1234625356041867.jpg;10530943-9994620651516888.jpg', NULL, NULL, ''),
(5, 'PROTMYPRT-IWP1000', 'Impact Whey Protein', 'Proteína de soro de leite de elevada qualidade com 21 g de proteína por porção, para ingerir a proteína necessária de uma fonte segura — as mesmas vacas que produzem o seu leite e queijo. Apenas é filtrada e transformada em pó para produzir alimentos nutritivos completamente naturais.', 9, 1, 1, '3.38', '5.38', 'Tiramisu', '', '', 1000, 0, '10530943-1234625356041867.jpg;10530943-9994620651516888.jpg', NULL, NULL, ''),
(6, 'AMACDMYPRT-BE1080', 'BCAA Energy 6 x 440 ml', 'Bebida Zero hidratos de carbono BCAA — para refrescar após o treino', 53, 1, 2, '8.99', '14.99', 'Cherry Cola', '', '', 1080, 0, '11537724-1054620643814721.jpg;11537724-1564620643844286.jpg', NULL, NULL, ''),
(7, 'AMACDMYPRT-BE1080', 'BCAA Energy 6 x 440 ml', 'Bebida Zero hidratos de carbono BCAA — para refrescar após o treino', 53, 1, 2, '8.99', '14.99', 'Morango & Framboesa', '', '', 1080, 0, '11537724-1054620643814721.jpg;11537724-1564620643844286.jpg', NULL, NULL, ''),
(8, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XS', 'Vermelho', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(9, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XS', 'Azul', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(10, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XS', 'Cinzento', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(11, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XS', 'Branco', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(12, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XS', 'Preto', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(13, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XS', 'Verde', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(14, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'S', 'Vermelho', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(15, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'S', 'Azul', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(16, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'S', 'Cinzento', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(17, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'S', 'Branco', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(18, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'S', 'Preto', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(19, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'S', 'Verde', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(20, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 10, 2, 3, '9.99', '19.90', '', 'M', 'Vermelho', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(21, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 10, 2, 3, '9.99', '19.90', '', 'M', 'Azul', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(22, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 10, 2, 3, '9.99', '19.90', '', 'M', 'Cinzento', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(23, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 10, 2, 3, '9.99', '19.90', '', 'M', 'Branco', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(24, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 10, 2, 3, '9.99', '19.90', '', 'M', 'Preto', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(25, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 10, 2, 3, '9.99', '19.90', '', 'M', 'Verde', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(26, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 20, 2, 3, '9.99', '19.90', '', 'L', 'Vermelho', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(27, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 20, 2, 3, '9.99', '19.90', '', 'L', 'Azul', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(28, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 20, 2, 3, '9.99', '19.90', '', 'L', 'Cinzento', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(29, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 20, 2, 3, '9.99', '19.90', '', 'L', 'Branco', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(30, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 20, 2, 3, '9.99', '19.90', '', 'L', 'Preto', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(31, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 20, 2, 3, '9.99', '19.90', '', 'L', 'Verde', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(32, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'XL', 'Vermelho', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(33, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'XL', 'Azul', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(34, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'XL', 'Cinzento', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(35, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'XL', 'Branco', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(36, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'XL', 'Preto', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(37, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 5, 2, 3, '9.99', '19.90', '', 'XL', 'Verde', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(38, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XXL', 'Vermelho', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(39, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XXL', 'Azul', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(40, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XXL', 'Cinzento', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(41, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XXL', 'Branco', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(42, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XXL', 'Preto', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, ''),
(43, 'VESTGYF-CGYF', 'Camisolão GymFit', '', 0, 2, 3, '9.99', '19.90', '', 'XXL', 'Verde', 0, 10, '35644889_1834524423517022_7008613752002052096_n.jpg', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_categorias`
--

CREATE TABLE `produtos_categorias` (
  `cod_categoria` int(11) NOT NULL,
  `abreviatura_ref` varchar(10) DEFAULT NULL,
  `nome_categoria` varchar(30) NOT NULL,
  `descricao_categoria` varchar(500) DEFAULT NULL,
  `foto_categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos_categorias`
--

INSERT INTO `produtos_categorias` (`cod_categoria`, `abreviatura_ref`, `nome_categoria`, `descricao_categoria`, `foto_categoria`) VALUES
(1, 'PROT', 'Proteinas', 'As proteínas são moléculas orgânicas formadas pela união de vários aminoácidos (entre 50 a 1000 aminoácidos), diferenciando-se entre si precisamente pelo tipo e qualidade dos aminoácidos que as formam e pelo modo como estes se encontram unidos.', 'proteina.jpg'),
(2, 'AMACD', 'Aminoácidos', 'Os aminoácidos incluem os conhecidos BCAA que se formam naturalmente na proteína e constituem as pedras basilares dos novos músculos – algo que é importante qualquer que seja o teu objetivo de fitness. Poderás ter dificuldades em obtê-los apenas através da tua alimentação, além de que também são dispendiosos. A nossa gama de pós de aminoácidos, Comprimidos, BCAA e Glutamina dão-te uma ajuda.', 'aminoácidos.jpg'),
(3, 'VEST', 'Vestuário', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_marcas`
--

CREATE TABLE `produtos_marcas` (
  `cod_marca` int(11) NOT NULL,
  `abreviatura_ref` varchar(10) DEFAULT NULL,
  `nome_marca` varchar(60) NOT NULL,
  `logo_marca` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos_marcas`
--

INSERT INTO `produtos_marcas` (`cod_marca`, `abreviatura_ref`, `nome_marca`, `logo_marca`) VALUES
(1, 'MYPRT', 'MyProtein', 'myprotein.png'),
(2, 'GYF', 'GymFit', 'gymfit.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguros`
--

CREATE TABLE `seguros` (
  `cod_seguro` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `ano` int(4) NOT NULL,
  `data_pagamento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `seguros`
--

INSERT INTO `seguros` (`cod_seguro`, `utilizador`, `ano`, `data_pagamento`) VALUES
(10, 1000, 2019, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `textos`
--

CREATE TABLE `textos` (
  `cod_texto` int(11) NOT NULL,
  `titloPT` varchar(60) NOT NULL,
  `textoPT` varchar(2000) NOT NULL,
  `data_ultimoUpdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `textos`
--

INSERT INTO `textos` (`cod_texto`, `titloPT`, `textoPT`, `data_ultimoUpdate`) VALUES
(1, 'Apresentação', '\r\n<p>Somos um ginásio em Condeixa-a-Nova com tudo o que necessita para ficar em forma!</p>\r\n<p>Temos um ambiente descontraido, profissional e alegre.</p>\r\n<p>O GymFit é um ginásio onde a sua maior força se situa no convívio e saúde.</p>\r\n<p>Fornecemos bem estar não apenas com o suor, mas sim com equilíbrio, saber, convívio e com um sorriso.</p>\r\n<p><b>Venha visitar-nos, estamos a sua espera!</b></p>\r\n<p>Clique <a href=\"https://www.youtube.com\">aqui</a> para ver o nosso canal do YouTube.</p>', '2018-11-04');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_exercicios`
--

CREATE TABLE `tipos_exercicios` (
  `cod_tipo_exercicio` int(11) NOT NULL,
  `nome_tipo` varchar(60) NOT NULL,
  `img` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipos_exercicios`
--

INSERT INTO `tipos_exercicios` (`cod_tipo_exercicio`, `nome_tipo`, `img`) VALUES
(1, 'Costas', 'capa_lombar.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tranportadoras`
--

CREATE TABLE `tranportadoras` (
  `cod_transportadora` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `imagem` varchar(60) DEFAULT NULL,
  `contacto` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `treinadores`
--

CREATE TABLE `treinadores` (
  `cod_treinador` int(11) NOT NULL,
  `nome_treinador` varchar(60) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `data_nascimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `cod_utilizador` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `nome` char(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(13) DEFAULT NULL,
  `psw` varchar(32) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `genero` char(1) NOT NULL,
  `data_nascimento` date NOT NULL,
  `data_adesao` date NOT NULL,
  `data_ultimoAcesso` datetime DEFAULT NULL,
  `online` char(1) NOT NULL DEFAULT 'n',
  `ip_ultimoAcesso` varchar(20) DEFAULT NULL,
  `tipo_utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`cod_utilizador`, `username`, `nome`, `email`, `telefone`, `psw`, `foto`, `genero`, `data_nascimento`, `data_adesao`, `data_ultimoAcesso`, `online`, `ip_ultimoAcesso`, `tipo_utilizador`) VALUES
(1000, 'Fredinson', 'Frederico Santos', 'fsraen@gmail.com', '+351915539220', 'c53512d75bbbfd03bfa1337116ea8384', NULL, 'm', '2001-12-09', '2018-11-03', '2019-04-05 07:50:30', 's', '::1', 3),
(1001, 'admin', 'Administrador', 'admin@ginasiogymfit.com', '', '21232f297a57a5a743894a0e4a801fc3', NULL, 'm', '1985-02-19', '2003-01-01', '2019-04-03 13:18:09', 'n', '::1', 1),
(1002, 'AnaSS', 'Ana Sofia', 'ana.sofia@gmail.com', '+351967891234', 'c53512d75bbbfd03bfa1337116ea8384', NULL, 'f', '1999-10-02', '2018-09-12', '0000-00-00 00:00:00', 'n', '', 3),
(1004, 'Ju32', 'Juliana Ribeiro', 'gyasdg@gmail.com', '+351925196152', 'c53512d75bbbfd03bfa1337116ea8384', NULL, 'f', '1987-10-02', '2016-09-12', '0000-00-00 00:00:00', 'n', '', 3),
(1005, 'Fred', 'Frederico Augusto dos Santos', 'fredinson4mastergamer@gmail.com', NULL, 'f2cb32166f77f33e80311be40c97466e', NULL, 'm', '2001-12-09', '2019-03-24', '2019-03-25 10:33:51', 'n', '::1', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_analises`
--

CREATE TABLE `utilizadores_analises` (
  `cod_analise` int(11) NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `altura` decimal(3,2) NOT NULL,
  `perimetro_abdominal` decimal(4,2) DEFAULT NULL,
  `pressao_arterial` int(5) DEFAULT NULL,
  `utilizador` int(11) NOT NULL,
  `data_analise` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `utilizadores_analises`
--

INSERT INTO `utilizadores_analises` (`cod_analise`, `peso`, `altura`, `perimetro_abdominal`, `pressao_arterial`, `utilizador`, `data_analise`) VALUES
(1, '83.00', '1.78', '0.00', 0, 1005, '2019-03-24'),
(2, '80.00', '1.80', '0.00', 0, 1000, '2019-04-04');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_confirmacao`
--

CREATE TABLE `utilizadores_confirmacao` (
  `cod_confirmacao` int(11) NOT NULL,
  `cod_user` int(11) NOT NULL,
  `chave_confirmacao` varchar(32) NOT NULL,
  `date_pedido` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_conquistas`
--

CREATE TABLE `utilizadores_conquistas` (
  `cod_utConquista` int(11) NOT NULL,
  `cod_utilizador` int(11) NOT NULL,
  `cod_conquista` int(11) NOT NULL,
  `data_conquista` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_modalidades`
--

CREATE TABLE `utilizadores_modalidades` (
  `cod_utilizadorModalidade` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `modalidade` int(11) NOT NULL,
  `atual` char(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `utilizadores_modalidades`
--

INSERT INTO `utilizadores_modalidades` (`cod_utilizadorModalidade`, `utilizador`, `modalidade`, `atual`) VALUES
(1, 1000, 1, 's');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_objetivos`
--

CREATE TABLE `utilizadores_objetivos` (
  `id_objetivo` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `objetivo` varchar(60) NOT NULL,
  `peso_alvo` decimal(6,3) NOT NULL,
  `data_alvo` date NOT NULL,
  `atual` char(1) NOT NULL DEFAULT 'n',
  `cumprido` char(1) NOT NULL DEFAULT 'n',
  `data_registo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `utilizadores_objetivos`
--

INSERT INTO `utilizadores_objetivos` (`id_objetivo`, `utilizador`, `objetivo`, `peso_alvo`, `data_alvo`, `atual`, `cumprido`, `data_registo`) VALUES
(9, 1005, 'Peder Peso', '80.000', '2018-12-09', 'n', 's', '2019-03-25'),
(10, 1000, 'Perder Peso', '70.000', '2019-05-03', 's', 'n', '2019-04-04');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_pre_registos`
--

CREATE TABLE `utilizadores_pre_registos` (
  `cod_preReg` varchar(20) NOT NULL,
  `utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores_tipo`
--

CREATE TABLE `utilizadores_tipo` (
  `cod_regra` int(11) NOT NULL,
  `nome_regra` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `utilizadores_tipo`
--

INSERT INTO `utilizadores_tipo` (`cod_regra`, `nome_regra`) VALUES
(1, 'Administrador'),
(3, 'Cliente'),
(4, 'Não confirmado'),
(5, 'Pré-registo'),
(2, 'Treinador');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conquistas`
--
ALTER TABLE `conquistas`
  ADD PRIMARY KEY (`cod_conquista`),
  ADD UNIQUE KEY `nome_conquista` (`nome_conquista`);

--
-- Indexes for table `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`cod_encomenda`);

--
-- Indexes for table `encomenda_detalhes`
--
ALTER TABLE `encomenda_detalhes`
  ADD PRIMARY KEY (`cod_encomenda_detalhes`);

--
-- Indexes for table `exercicios`
--
ALTER TABLE `exercicios`
  ADD PRIMARY KEY (`cod_exercicio`),
  ADD UNIQUE KEY `nome_exercicio` (`nome_exercicio`),
  ADD KEY `tipo` (`tipo`);

--
-- Indexes for table `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`cod_img`);

--
-- Indexes for table `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`cod_horario`);

--
-- Indexes for table `informacoes_entidade`
--
ALTER TABLE `informacoes_entidade`
  ADD PRIMARY KEY (`cod_entidade_informacao`),
  ADD UNIQUE KEY `nome_entidade` (`nome_entidade`),
  ADD UNIQUE KEY `telefone_contacto` (`telefone_contacto`),
  ADD UNIQUE KEY `email_contacto` (`email_contacto`),
  ADD UNIQUE KEY `mapa` (`mapa`),
  ADD UNIQUE KEY `pagina_facebook` (`pagina_facebook`),
  ADD UNIQUE KEY `pagina_instagram` (`pagina_instagram`);

--
-- Indexes for table `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`cod_msg`);

--
-- Indexes for table `mensalidades`
--
ALTER TABLE `mensalidades`
  ADD PRIMARY KEY (`cod_mensalidade`),
  ADD UNIQUE KEY `nome_mensalidade` (`nome_mensalidade`);

--
-- Indexes for table `mensalidades_aquisicoes`
--
ALTER TABLE `mensalidades_aquisicoes`
  ADD PRIMARY KEY (`cod_aquisicao`),
  ADD KEY `utilizador` (`utilizador`),
  ADD KEY `mensalidade` (`mensalidade`),
  ADD KEY `desconto` (`desconto`);

--
-- Indexes for table `mensalidades_descontos`
--
ALTER TABLE `mensalidades_descontos`
  ADD PRIMARY KEY (`cod_desconto`),
  ADD UNIQUE KEY `nome_desconto` (`nome_desconto`);

--
-- Indexes for table `mensalidades_pagamentos`
--
ALTER TABLE `mensalidades_pagamentos`
  ADD PRIMARY KEY (`cod_mensalidadePagamento`),
  ADD UNIQUE KEY `fatura` (`fatura`),
  ADD KEY `cod_utilizador` (`cod_utilizador`),
  ADD KEY `aquisicao` (`aquisicao`);

--
-- Indexes for table `modalidades`
--
ALTER TABLE `modalidades`
  ADD PRIMARY KEY (`cod_modalidade`),
  ADD UNIQUE KEY `nome_modalidade` (`nome_modalidade`);

--
-- Indexes for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id_pagamento`);

--
-- Indexes for table `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`cod_plano`),
  ADD UNIQUE KEY `nome_plano` (`nome_plano`);

--
-- Indexes for table `plano_exercicios`
--
ALTER TABLE `plano_exercicios`
  ADD PRIMARY KEY (`cod_plano_exercicio`),
  ADD KEY `plano` (`plano`),
  ADD KEY `exercicio` (`exercicio`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`cod_produto`),
  ADD KEY `cod_marca` (`cod_marca`),
  ADD KEY `cod_categoria` (`cod_categoria`);

--
-- Indexes for table `produtos_categorias`
--
ALTER TABLE `produtos_categorias`
  ADD PRIMARY KEY (`cod_categoria`),
  ADD UNIQUE KEY `nome_categoria` (`nome_categoria`);

--
-- Indexes for table `produtos_marcas`
--
ALTER TABLE `produtos_marcas`
  ADD PRIMARY KEY (`cod_marca`),
  ADD UNIQUE KEY `nome_marca` (`nome_marca`),
  ADD UNIQUE KEY `logo_marca` (`logo_marca`);

--
-- Indexes for table `seguros`
--
ALTER TABLE `seguros`
  ADD PRIMARY KEY (`cod_seguro`),
  ADD KEY `fk_utilizador_seguro` (`utilizador`);

--
-- Indexes for table `textos`
--
ALTER TABLE `textos`
  ADD PRIMARY KEY (`cod_texto`);

--
-- Indexes for table `tipos_exercicios`
--
ALTER TABLE `tipos_exercicios`
  ADD PRIMARY KEY (`cod_tipo_exercicio`),
  ADD UNIQUE KEY `nome_tipo` (`nome_tipo`),
  ADD UNIQUE KEY `img` (`img`);

--
-- Indexes for table `tranportadoras`
--
ALTER TABLE `tranportadoras`
  ADD PRIMARY KEY (`cod_transportadora`);

--
-- Indexes for table `treinadores`
--
ALTER TABLE `treinadores`
  ADD PRIMARY KEY (`cod_treinador`);

--
-- Indexes for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`cod_utilizador`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `foto` (`foto`),
  ADD KEY `tipo_utilizador` (`tipo_utilizador`);

--
-- Indexes for table `utilizadores_analises`
--
ALTER TABLE `utilizadores_analises`
  ADD PRIMARY KEY (`cod_analise`),
  ADD KEY `utilizador` (`utilizador`);

--
-- Indexes for table `utilizadores_confirmacao`
--
ALTER TABLE `utilizadores_confirmacao`
  ADD PRIMARY KEY (`cod_confirmacao`),
  ADD UNIQUE KEY `chave_confirmacao` (`chave_confirmacao`),
  ADD KEY `cod_user` (`cod_user`);

--
-- Indexes for table `utilizadores_conquistas`
--
ALTER TABLE `utilizadores_conquistas`
  ADD PRIMARY KEY (`cod_utConquista`),
  ADD KEY `cod_utilizador` (`cod_utilizador`),
  ADD KEY `cod_conquista` (`cod_conquista`);

--
-- Indexes for table `utilizadores_modalidades`
--
ALTER TABLE `utilizadores_modalidades`
  ADD PRIMARY KEY (`cod_utilizadorModalidade`),
  ADD KEY `utilizador` (`utilizador`),
  ADD KEY `modalidade` (`modalidade`);

--
-- Indexes for table `utilizadores_objetivos`
--
ALTER TABLE `utilizadores_objetivos`
  ADD PRIMARY KEY (`id_objetivo`),
  ADD KEY `utilizador` (`utilizador`);

--
-- Indexes for table `utilizadores_pre_registos`
--
ALTER TABLE `utilizadores_pre_registos`
  ADD PRIMARY KEY (`cod_preReg`),
  ADD KEY `utilizador` (`utilizador`);

--
-- Indexes for table `utilizadores_tipo`
--
ALTER TABLE `utilizadores_tipo`
  ADD PRIMARY KEY (`cod_regra`),
  ADD UNIQUE KEY `nome_regra` (`nome_regra`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conquistas`
--
ALTER TABLE `conquistas`
  MODIFY `cod_conquista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `cod_encomenda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encomenda_detalhes`
--
ALTER TABLE `encomenda_detalhes`
  MODIFY `cod_encomenda_detalhes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exercicios`
--
ALTER TABLE `exercicios`
  MODIFY `cod_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `galeria`
--
ALTER TABLE `galeria`
  MODIFY `cod_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `cod_msg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mensalidades`
--
ALTER TABLE `mensalidades`
  MODIFY `cod_mensalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mensalidades_aquisicoes`
--
ALTER TABLE `mensalidades_aquisicoes`
  MODIFY `cod_aquisicao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `mensalidades_descontos`
--
ALTER TABLE `mensalidades_descontos`
  MODIFY `cod_desconto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mensalidades_pagamentos`
--
ALTER TABLE `mensalidades_pagamentos`
  MODIFY `cod_mensalidadePagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `modalidades`
--
ALTER TABLE `modalidades`
  MODIFY `cod_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `planos`
--
ALTER TABLE `planos`
  MODIFY `cod_plano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plano_exercicios`
--
ALTER TABLE `plano_exercicios`
  MODIFY `cod_plano_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `produtos_categorias`
--
ALTER TABLE `produtos_categorias`
  MODIFY `cod_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produtos_marcas`
--
ALTER TABLE `produtos_marcas`
  MODIFY `cod_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seguros`
--
ALTER TABLE `seguros`
  MODIFY `cod_seguro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `textos`
--
ALTER TABLE `textos`
  MODIFY `cod_texto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tipos_exercicios`
--
ALTER TABLE `tipos_exercicios`
  MODIFY `cod_tipo_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tranportadoras`
--
ALTER TABLE `tranportadoras`
  MODIFY `cod_transportadora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treinadores`
--
ALTER TABLE `treinadores`
  MODIFY `cod_treinador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `cod_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT for table `utilizadores_analises`
--
ALTER TABLE `utilizadores_analises`
  MODIFY `cod_analise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `utilizadores_confirmacao`
--
ALTER TABLE `utilizadores_confirmacao`
  MODIFY `cod_confirmacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilizadores_conquistas`
--
ALTER TABLE `utilizadores_conquistas`
  MODIFY `cod_utConquista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilizadores_modalidades`
--
ALTER TABLE `utilizadores_modalidades`
  MODIFY `cod_utilizadorModalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `utilizadores_objetivos`
--
ALTER TABLE `utilizadores_objetivos`
  MODIFY `id_objetivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `utilizadores_tipo`
--
ALTER TABLE `utilizadores_tipo`
  MODIFY `cod_regra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `exercicios`
--
ALTER TABLE `exercicios`
  ADD CONSTRAINT `exercicios_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipos_exercicios` (`cod_tipo_exercicio`);

--
-- Limitadores para a tabela `mensalidades_aquisicoes`
--
ALTER TABLE `mensalidades_aquisicoes`
  ADD CONSTRAINT `mensalidades_aquisicoes_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`cod_utilizador`),
  ADD CONSTRAINT `mensalidades_aquisicoes_ibfk_2` FOREIGN KEY (`mensalidade`) REFERENCES `mensalidades` (`cod_mensalidade`),
  ADD CONSTRAINT `mensalidades_aquisicoes_ibfk_3` FOREIGN KEY (`desconto`) REFERENCES `mensalidades_descontos` (`cod_desconto`);

--
-- Limitadores para a tabela `mensalidades_pagamentos`
--
ALTER TABLE `mensalidades_pagamentos`
  ADD CONSTRAINT `mensalidades_pagamentos_ibfk_1` FOREIGN KEY (`cod_utilizador`) REFERENCES `utilizadores` (`cod_utilizador`),
  ADD CONSTRAINT `mensalidades_pagamentos_ibfk_2` FOREIGN KEY (`aquisicao`) REFERENCES `mensalidades_aquisicoes` (`cod_aquisicao`);

--
-- Limitadores para a tabela `plano_exercicios`
--
ALTER TABLE `plano_exercicios`
  ADD CONSTRAINT `plano_exercicios_ibfk_1` FOREIGN KEY (`plano`) REFERENCES `planos` (`cod_plano`),
  ADD CONSTRAINT `plano_exercicios_ibfk_2` FOREIGN KEY (`exercicio`) REFERENCES `exercicios` (`cod_exercicio`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`cod_marca`) REFERENCES `produtos_marcas` (`cod_marca`),
  ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `produtos_categorias` (`cod_categoria`);

--
-- Limitadores para a tabela `seguros`
--
ALTER TABLE `seguros`
  ADD CONSTRAINT `fk_utilizador_seguro` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`cod_utilizador`);

--
-- Limitadores para a tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `utilizadores_ibfk_1` FOREIGN KEY (`tipo_utilizador`) REFERENCES `utilizadores_tipo` (`cod_regra`);

--
-- Limitadores para a tabela `utilizadores_analises`
--
ALTER TABLE `utilizadores_analises`
  ADD CONSTRAINT `utilizadores_analises_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`cod_utilizador`);

--
-- Limitadores para a tabela `utilizadores_confirmacao`
--
ALTER TABLE `utilizadores_confirmacao`
  ADD CONSTRAINT `utilizadores_confirmacao_ibfk_1` FOREIGN KEY (`cod_user`) REFERENCES `utilizadores` (`cod_utilizador`);

--
-- Limitadores para a tabela `utilizadores_conquistas`
--
ALTER TABLE `utilizadores_conquistas`
  ADD CONSTRAINT `utilizadores_conquistas_ibfk_1` FOREIGN KEY (`cod_utilizador`) REFERENCES `utilizadores` (`cod_utilizador`),
  ADD CONSTRAINT `utilizadores_conquistas_ibfk_2` FOREIGN KEY (`cod_conquista`) REFERENCES `conquistas` (`cod_conquista`);

--
-- Limitadores para a tabela `utilizadores_modalidades`
--
ALTER TABLE `utilizadores_modalidades`
  ADD CONSTRAINT `utilizadores_modalidades_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`cod_utilizador`),
  ADD CONSTRAINT `utilizadores_modalidades_ibfk_2` FOREIGN KEY (`modalidade`) REFERENCES `modalidades` (`cod_modalidade`);

--
-- Limitadores para a tabela `utilizadores_objetivos`
--
ALTER TABLE `utilizadores_objetivos`
  ADD CONSTRAINT `utilizadores_objetivos_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`cod_utilizador`);

--
-- Limitadores para a tabela `utilizadores_pre_registos`
--
ALTER TABLE `utilizadores_pre_registos`
  ADD CONSTRAINT `utilizadores_pre_registos_ibfk_1` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`cod_utilizador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
