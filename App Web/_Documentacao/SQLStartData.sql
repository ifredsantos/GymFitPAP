USE ginasio_gymfit;

INSERT INTO informacoes_entidade (cod_entidade_informacao, nome_entidade, nome_contacto, telefone_contacto, email_contacto, mapa, pagina_facebook, pagina_instagram, nome_localidade) VALUES
(1, 'GymFit', 'GymFit', 964196433, 'fredinsondev@gmail.com', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3051.6279391701473!2d-8.491628784613512!3d40.10600757940246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22589c1063c277%3A0x21ddad272e4fac02!2sGin%C3%A1sio+GymFit!5e0!3m2!1spt-PT!2spt!4v1526729441094', 
'https://www.facebook.com/GinasioGymFit/', 'https://www.instagram.com/gymfitcondeixa/', 'Rua da Lagoa, Valada, Condeixa-a-Nova');

INSERT INTO utilizadores_tipo (cod_regra, nome_regra) VALUES 
(1, 'Administrador'),
(2, 'Treinador'),
(3, 'Cliente'),
(4, 'Não confirmado'),
(5, 'Pré-registo');

INSERT INTO utilizadores (cod_utilizador, username, nome, email, telefone, psw, genero, data_nascimento, data_adesao, data_ultimoAcesso, ip_ultimoAcesso, tipo_utilizador) VALUES 
(1000, 'admin', 'Administrador', 'admin@ginasiogymfit.com', '', '21232f297a57a5a743894a0e4a801fc3', 'm', '1985-02-19', '2003-01-01', '', '', 1);

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

INSERT INTO utilizadores_conquistas () VALUES (1, 1000, 1, '2019-04-26');

INSERT INTO mensalidades (cod_mensalidade, nome_mensalidade, preco) VALUES
(1, 'Sem mensalidade', 0.00),
(2, '2x / semana', 25.00),
(3, '3x / semana', 27.50),
(4, 'Livre trânsito', 30.00);

INSERT INTO mensalidades_descontos (cod_desconto, nome_desconto, valor_desconto) VALUES
(1, 'Sem desconto', 0.00),
(2, 'Estudante', 2.50);

INSERT INTO textos (titloPT, textoPT, data_ultimoUpdate) VALUES 
('Apresentação', '
<p>Somos um ginásio em Condeixa-a-Nova com tudo o que necessita para ficar em forma!</p>
<p>Temos um ambiente descontraido, profissional e alegre.</p>
<p>O GymFit é um ginásio onde a sua maior força se situa no convívio e saúde.</p>
<p>Fornecemos bem estar não apenas com o suor, mas sim com equilíbrio, saber, convívio e com um sorriso.</p>
<p><b>Venha visitar-nos, estamos a sua espera!</b></p>
<p>Clique <a href="https://www.youtube.com">aqui</a> para ver o nosso canal do YouTube.</p>', '2018-11-04');