-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 02 Mai 2018 à 10:19
-- Version du serveur :  5.7.22-0ubuntu0.16.04.1
-- Version de PHP :  7.0.29-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Création de la Base de données `starwars`
--

DROP DATABASE IF EXISTS starwars;
CREATE DATABASE starwars;
USE starwars;

-- --------------------------------------------------------

--
-- Structure de la table `figure`
--

CREATE TABLE `figure` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT '/assets/images/no-picture.jpg',
  `bio` text NOT NULL,
  `id_movie` int(11) NOT NULL,
  `id_faction` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `figure`
--

INSERT INTO `figure` (`id`, `name`, `picture`, `bio`, `id_movie`, `id_faction`) VALUES
(1, "Anakin Skywalker", "/assets/images/figure/figure-5fd8fba781d7a.jpeg", "Découvert à l'âge de neuf ans par deux chevaliers Jedi, Obi-Wan Kenobi et Qui-Gon Jinn, le jeune garçon est caractérisé par deux anecdotes : son taux élevé de Midichloriens, ces organismes microscopiques qui constituent la « Force », l'énergie mystique qui donne aux Jedi leur pouvoir, et sa naissance mystérieuse d'une mère vierge. Jinn voit en lui « l'Élu », chargé de rétablir « l'équilibre de la Force », d'après une prophétie Jedi. Malgré son âge avancé, Anakin reçoit la formation de Jedi et devient l'apprenti d'Obi-Wan Kenobi. À ses 20 ans, il noue une idylle durable avec la Sénatrice Padmé Amidala, acte fondamentalement proscrit par les règles Jedi. La peur de perdre l'être aimé, couplée à un déchaînement de haine lors du massacre des responsables de la mort de sa mère, le rend vulnérable au Côté Obscur. À peine nommé Chevalier, Anakin se retrouve affublé d'une Padawan non officielle et particulièrement turbulente, Ahsoka Tano. Mais peu à peu, Palpatine, son ami proche, qui est en réalité le seigneur Sith Dark Sidious, l'entraîne vers le Côté Obscur de la Force pour faire de lui l'un des principaux architectes du maléfique empire. Mais ceci est une autre histoire.", 4, 1),
(2, "Empereur Palpatine", "/assets/images/figure/figure-5fd8fbe2e86bd.jpeg", "Le peu d'informations existant au sujet de la jeunesse de Palpatine indique qu'il serait né sur Naboo en -82. Conformément à la coutume Sith, il prit le nom de Dark Sidious, assassina son maître Dark Plagueis dès qu'il estima avoir tout appris de lui et forma un disciple qu'il baptisa Dark Maul. Il entra en politique et réunit autour de lui un cortège de fidèles, qu'ils soient praticiens du Côté Obscur de la Force, notables corrompus, ou même Jedi fourvoyés. Autant de contacts qui permirent son ascension au siège de Chancelier Suprême. C'est ainsi qu'il put orchestrer dans l'ombre la fameuse Guerre des Clones. Tombant le masque après une quinzaine d'années de manigances, Dark Sidious s'autoproclama Empereur Galactique. Il retourna les soldats clones de la République contre les chevaliers Jedi, et pervertit un de leurs représentants les plus prometteurs, Anakin Skywalker, qui allait devenir Dark Vador, instrument de terreur du futur Empire. C'est pourtant Dark Vador lui-même qui mit fin à la vie de l'Empereur après avoir trouvé la rédemption en combattant son propre fils Luke. Cependant, l'esprit désincarné de l'Empereur usa de la science mise au point pendant la Guerre des Clones pour habiter une reproduction de son ancien corps. L'Empereur ressuscité essaya sans succès de pervertir Luke Skywalker puis de s'incarner dans le corps d'Anakin Solo, petit-fils de Vador, mais fut alors entraîné dans les profondeurs de la Force.", 5, 2),
(3, "Han Solo", "/assets/images/figure/figure-5fd8fc0fc06b1.jpeg", "Le petit Han fut découvert dans un spatioport de Corellia par le contrebandier Garris Shrike, capitaine du vaisseau le Bonne Fortune sur lequel travaillait comme cuisinière la Wookiee Dewlanna qui le recueillit et auprès de laquelle il apprit le langage des Wookiees. À l'âge de 19 ans, alors que Han Solo faisait ses adieux à Dewlanna, Shrike s'attaqua à eux, provoquant la mort de la mère adoptive de Solo. Celui-ci se jura alors de sauver un jour la vie d'un Wookiee. Plus tard, Solo entra à l'Académie de Carida et sortit de sa promotion avec le grade de lieutenant. Mais lorsqu'on lui ordonna d'abattre un esclave Wookiee, Solo préféra prendre la fuite avec lui. Ce dernier, nommé Chewbacca, se considéra lié à Solo par une dette d'honneur. L'association avec Chewbacca marqua le début de la vie de contrebandier de Han Solo. Lors du tournoi de Sabacc de la Cité des Nuages qui l'opposa à son ami Lando Calrissian, Solo remporta la mise : le Faucon Millenium. Il finit par devenir un héros de la Rébellion grâce à son association avec Luke Skywalker et Obi-Wan Kenobi puis pendant l'illustre Bataille de Yavin. Sont également célèbres ses différends avec des individus tels que Dengar, Boba Fett, Jack le Rouge et surtout Jabba le Hutt, ce qui lui valut d'être cryogénisé dans un bloc de carbonite. C'est en l'an 4 après Yavin que Solo recouvra la liberté, et put participer à la bataille décisive d'Endor. Cette période est aussi celle où il rencontra la princesse Leia Organa, sa future épouse et la mère de ses trois enfants, destinés à devenir des Chevaliers Jedi.", 4, 1),
(4, "Dark Maul", "/assets/images/figure/figure-5fd8fc3a8df10.jpeg", "Né parmi les Mornemoines, géniteurs esclaves mâles des Nocturnonnes, cette faction des Sorcières de Dathomir vouée au Côté Obscur de la Force, Dark Maul devint l'apprenti de Dark Sidious dès son plus jeune âge. À 21 ans, Maul reçut sa première mission de Sidious : déstabiliser le Soleil Noir, cartel intergalactique du crime qui menaçait son pouvoir. Plus tard, en 32 avant la Bataille de Yavin, Palpatine envoya son apprenti aux trousses de la Sénatrice Padmé Amidala. Maul suivit Padmé, ainsi que ses protecteurs, les deux Jedi Obi-Wan Kenobi et Qui-Gon Jinn, jusqu'à Naboo, planète natale de la Sénatrice. Là, il mit à mort le vénérable Qui-Gon, mais fut à son tour exécuté par Obi-Wan, le Padawan de ce dernier. Plusieurs rumeurs existent concernant la survivance de Dark Maul. Selon certaines, la partie inférieure de son corps, amputée par Obi-Wan, aurait été remplacée par des jambes cybernétiques. Le monstre bionique résultant de cette odieuse opération aurait refait surface sur Tatooine, avant d'être détruit une fois encore par Obi-Wan. Une autre version évoque la mystérieuse résurrection de Maul sur la planète Kalakar VI, où Dark Vador triompha d'un double en tous points semblable au sautillant Zabrak (nos lecteurs sont invités à consulter le volume Le Côté Obscur n°5, qui détaille cette anecdote), dont la nature, clonique ou magique (due à la sorcellerie de Dathomir, peut-être ?) reste incertaine.", 1, 2),
(5, "Jar Jar Binks", "/assets/images/figure/figure-5fd8fc5ad78ab.jpeg", "Fils d'un illustre pêcheur au gros, le Gungan Jar Jar Binks est très vite expulsé du domicile familial, mais aussi de toutes les écoles où il passe, pour cause d'incompétence manifeste. Il survit en pratiquant divers métiers, dont celui de ménestrel. En 32 avant la bataille de Yavin, par un hasard extraordinaire, Jar Jar Binks se retrouve au cur des événements afférents au blocus de Naboo, et s'acoquine avec les Jedi Qui-Gon Jinn et Obi-Wan Kenobi. S'ensuit tout un enchevêtrement de péripéties, lors desquelles Jar Jar voyage de Naboo à Tatooine, puis à Coruscant, et fait connaissance avec la reine humaine de sa planète, Padmé Amidala, dont il deviendra une sorte de nonce. Une aventure aux incessants rebondissements qui le verra nommé Général des armées gunganes. Dix ans plus tard, alors qu'il remplace sa compatriote Amidala pour prendre les fonctions de sénateur, Jar Jar Binks entre dans l'Histoire comme instigateur involontaire de la Guerre des Clones, puisque, impressionné par les belles paroles du sénateur Palpatine, il propose au Sénat d'octroyer les pleins pouvoirs à celui-ci afin de mettre un terme aux exactions de la Fédération du Commerce. La dernière apparition publique connue de Jar Jar Binks a lieu lors des funérailles de son amie de toujours Padmé Amidala. Nul ne sait ce qu'il advint de lui lors de l'invasion impériale de son monde, si ce n'est qu'il enfanta un fils Abso Bar Binks qui prit le parti de l'Alliance Rebelle.", 1, 1),
(6, "Dark Vador", "/assets/images/figure/figure-5fd8fd02be1e5.jpeg", "Né Anakin Skywalker, il trahit les Jedi et aida le Chancelier, le seigneur Sith Dark Sidious, à asseoir son pouvoir impérial sur la galaxie. Rebaptisé Dark Vador par son nouveau maître, il fut mutilé lors d'un duel contre son ancien maître Obi-Wan Kenobi. Palpatine lui redonna forme quasi humaine par la greffe de membres bioniques et l'ajout d'une armure permettant à son corps brisé de survivre. Si le Jedi prometteur d'autrefois avait perdu de son agilité et de sa grâce, il était devenu plus redoutable que jamais, consumé par une haine envers l'existence tout entière et lui-même en particulier. Vador parcourut la galaxie en quête des Jedi ayant survécu à l'Ordre 66, afin de les exterminer. Pendant cette période, il forma plusieurs élèves selon les rites des Sith : Flint, Tao, Shira Brie, et surtout Galen Marek, dit « Starkiller ». Bras droit de l'Empereur, il était également chargé de punir les traîtres à l'Empire. L'histoire retient surtout aujourd'hui le long combat qui l'a opposé à son propre fils, Luke Skywalker. L'enjeu de cette lutte n'était pas seulement la victoire de l'Empire ou de la Rébellion, mais le salut de l'âme des deux Skywalker. Si Vador envisageait sérieusement de pervertir son fils pour en faire son apprenti Sith et renverser l'Empereur, ce fut finalement Luke qui parvint à atteindre le coeur de son père et à lui faire reprendre le droit chemin, quelques instants avant sa mort.", 4, 2),
(7, "C-3PO", "/assets/images/figure/figure-5fd8fd422afa2.jpeg", "C-3PO était probablement destiné à servir d'interprète ou de décodeur de données informatiques. Mais c'est sur Tatooine qu'Anakin Skywalker découvrit sa carcasse et entreprit de remettre en état la machine. Ainsi naquit le nouveau C-3PO. En dépit de sa nature casanière et craintive, il se retrouva propulsé dans une série de mésaventures pendant toute la montée en puissance de l'Empire Galactique. Lors de l'attaque du Tantive IV, C-3PO et son compagnon de toujours R2D2 se virent confier les plans de l'Étoile Noire par la Sénatrice Leia Organa, plans qui, une fois entre les mains des Rebelles, contribuèrent à la première grande victoire de l'Alliance sur l'Empire Galactique. Grâce à ses talents d'interprète et de conteur, C-3PO permit également aux Rebelles de gagner la confiance des Ewoks, qui participèrent activement à la destruction de l'Étoile de la Mort. Dans les années qui suivirent, C-3PO continua de vivre une vie d'aventures et l'on ne sait pas exactement s'il est toujours en fonction de nos jours, ou sinon, dans quelles circonstances il a été désactivé.", 4, 1),
(8, "Général Grievous", "/assets/images/figure/figure-5fd8fd815eafa.jpeg", "Qymaen Jai Sheelal, originaire de la planète Kalee, apprit à se battre contre les Huk dès son plus jeune âge. À 22 ans, le nombre de ses victimes était si élevé que les autres Kaleesh le considéraient comme une légende vivante. Sheelal forma un lien profond avec sa compagne d'armes Ronderu Lij Kummar. Hélas, Kummar fut tuée par les Huk et Sheelal, qui ne se remit jamais de sa disparition, décida de porter son deuil toute sa vie, en adoptant un nouveau nom, « Grievous » (du verbe « to grieve », « qui pleure la mort d'autrui »). À la tête de l'armée kaleesh, il fit massacrer les Yam'rii. Ces derniers demandèrent alors le soutien de la République Galactique, qui imposa à Kalee un embargo et une dette de guerre draconiens. Après la guerre, le Comte Dooku et Dark Sidious provoquèrent le crash du vaisseau de Grievous. Mutilé par l'accident, Grievous fut reconstruit sous la forme d'un redoutable cyborg doté de bras bioniques pouvant se diviser en deux. Psychiquement reprogrammé par Dooku, Grievous se lança à corps perdu dans la Guerre des Clones. Il prit ainsi l'habitude de conserver en trophée les sabres laser des Jedi qu'il tuait. Sur Utapau, alors qu'il comptait user de ses quatre bras armés de sabres laser pour triompher du Jedi Obi-Wan Kenobi dans un duel traditionnel, ce dernier fit taire sa répugnance envers les pistolasers pour abattre Grievous à l'aide de cette arme « inélégante ».", 3, 2),
(9, "Luke Skywalker", "/assets/images/figure/figure-5fd8fe8566aed.jpeg", "Avec sa soeur jumelle Leia, Luke est le fils de Padmé Amidala et d'Anakin Skywalker. Sachant que ces enfants auraient des prédispositions à maîtriser la Force, Obi-Wan Kenobi et Yoda les mirent à l'abri de l'Empereur juste après leur naissance. Luke fut confié à Owen Lars et sa femme Beru, qui exploitaient une ferme hydroponique sur la planète Tatooine. En grandissant il ne rêvait que d'une chose : rejoindre l'Académie impériale afin de devenir pilote. Entraîné dans la lutte par Obi-Wan et le droïde R2D2, il se mua rapidement en commandant de la Rébellion et premier chevalier Jedi depuis la chute de la République qui mit fin à l'Empire de Palpatine en combattant Dark Vador, son propre père. Après le triomphe de l'Alliance, Luke dut faire face à de nouveaux défis : la renaissance de l'ordre Jedi, la perte de son premier disciple potentiel, la résurrection de l'Empereur Palpatine qui faillit l'entraîner du Côté Obscur de la Force, et surtout la guerre contre les Yuuzhan Vong où il vit son épouse Mara Jade mourir et son neveu Jacen Solo devenir le Sith Dark Caedus. Luke Skywalker prit la décision de retracer les pas de son neveu déchu afin de mieux comprendre les raisons de sa chute. Son fils Ben Skywalker l'accompagna dans cette épreuve lors de laquelle ils découvrirent la tribu perdue des Sith, ainsi qu'Abeloth, l'esprit éthéré d'une ancienne praticienne du Côté Obscur de la Force qui provoquait à distance une psychose chez les disciples Sith comme Jedi.", 4, 1),
(10, "Jabba Le Hutt", "/assets/images/figure/figure-5fd8ffc246ee3.jpeg", "Jabba est le redouté chef du syndicat du crime, après avoir repris le flambeau à son père. Entouré d’une horde de malfaiteurs, il s’est installé dans le monastère B’omarr, sur Tatooine, d’où il dirige son puissant réseau intergalactique. Discret et extrêmement diplomate, son pouvoir n’est remis en question ni par l’Empire, ni par l’Alliance Rebelle. Mais c’est sa vendetta contre Han Solo qui lui coûtera la vie : lorsque Jabba parvient enfin à attraper le contrebandier pour lui faire payer sa dette envers lui, il sera secouru par ses amis de l’Alliance Rebelle, Leia Organa et Luke Skywalker. Leia, infiltrée comme chasseuse de primes puis démasquée, en est réduite à être enchaînée comme danseuse de charmes. Mais dans la confusion induite par les pouvoirs de Jedi de Skywalker, elle se servira de cette chaîne pour étrangler Jabba le Hutt.", 6, 3),
(11, "Princesse Leia", "/assets/images/figure/figure-5fd8ffed319b8.jpeg", "Élevée par le prince Bail Organa et la reine Breha d'Alderaan, Leia Organa est en fait l'enfant d'Anakin Skywalker et de Padmé Amidala. En grandissant, Leia participa avec ferveur à plusieurs missions secrètes pour l'Alliance Rebelle, notamment sur Kattada, où elle récupéra les plans secrets de l'Étoile Noire qui anéantirait plus tard sa planète d'adoption. Tombée entre les mains de Dark Vador, Leia confia les précieux plans à R2D2 autour duquel devait se former une équipe d'aventuriers qui, après avoir délivré la princesse, participèrent à la destruction de la terrible Étoile Noire. Leia se constitua une nouvelle famille dans la Rébellion où se trouvaient l'apprenti Jedi Luke Skywalker, qui se révéla être son frère, et le contrebandier Han Solo, qui ne tarda pas à gagner son coeur. Ainsi, l'ancienne Sénatrice n'hésita pas à s'aventurer au sein de la cour du terrible gangster Jabba le Hutt pour libérer son bien-aimé. Elle combattit ensuite lors de la Bataille d'Endor qui mit fin à l'Empire Galactique de Palpatine. Leia devint par la suite chef de la Nouvelle République, apprit à maîtriser la Force et épousa Han Solo. Le couple donna naissance à trois enfants, les jumeaux Jaina et Jacen, puis Anakin Solo. Si la famille Organa-Solo subit bien des épreuves, de la mort du jeune Anakin à la perversion de Jacen sous l'égide de la Sith Lumiya, Leia ne s'écarta jamais du droit chemin, restant fidèle à la mémoire de son père adoptif Bail Organa.", 4, 1)
;

-- --------------------------------------------------------

--
-- Structure de la table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT "/assets/images/no-picture.jpg"
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `movie`
--

INSERT INTO `movie` (`id`, `title`, `picture`) VALUES
(1, "Episode 1 : La Menace Fantôme", "/assets/images/movie/movie-5fd901f55244c.jpeg"),
(2, "Episode 2 : L'Attaque des Clones", "/assets/images/movie/movie-5fd90206b68d0.jpeg"),
(3, "Episode 3 : La Revanche Des Siths", "/assets/images/movie/movie-5fd902166d682.jpeg"),
(4, "Episode 4 : Un Nouvel Espoir", "/assets/images/movie/movie-5fd90228a1715.jpeg"),
(5, "Episode 5 : L'Empire Contre-Attaque", "/assets/images/movie/movie-5fd9023948046.jpeg"),
(6, "Episode 6 : Le Retour Du Jedi", "/assets/images/movie/movie-5fd90248deb84.jpeg"),
(7, "Episode 7 : Le Réveil De La Force", "/assets/images/movie/movie-5fd902b58a603.jpeg"),
(8, "Episode 8 : Les Derniers Jedis", "/assets/images/movie/movie-5fd902c5d2386.jpeg"),
(9, "Episode 9 : L'Ascension de Skywalker", "/assets/images/movie/movie-5fd902d766dc2.jpeg")
;

-- --------------------------------------------------------

CREATE TABLE `beast` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT '/assets/images/no-picture.jpg',
  `size` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `id_planet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `beast`
--

INSERT INTO `beast` (`id`, `name`, `picture`, `size`, `area`, `id_movie`, `id_planet`) VALUES
(1, "Orray", "/assets/images/beast/beast-5fd90378956d3.jpeg", 2, "Desert", 2, 6),
(2, "Massiff", "/assets/images/beast/beast-5fd9040eb6eb4.jpeg", 1, "Desert", 2, 6),
(3, "Wampa", "/assets/images/beast/beast-5fd904284b2c8.jpeg", 3, "Caverne", 5, 7),
(4, "Tauntaun", "/assets/images/beast/beast-5fd90458d42b5.jpeg", 2, "Desert de Glace", 5, 7),
(5, "Happabore", "/assets/images/beast/beast-5fd9047c41016.jpeg", 4, "Desert", 7, 8),
(6, "Luggabeast", "/assets/images/beast/beast-5fd9048f5c2e7.jpeg", 2, "Desert", 7, 8),
(7, "Wookie", "/assets/images/beast/beast-5fd904dd6ee7d.jpeg", 2, "Foret", 3, 9),
(8, "Mandalorien", "/assets/images/beast/beast-5fd904f513e22.jpeg", 2, "Ville", 2, 3),
(9, "Kaadu", "/assets/images/beast/beast-5fd9050933ea8.jpeg", 2, "Plaine", 1, 10),
(10, "Sando", "/assets/images/beast/beast-5fd90520f391e.jpeg", 200, "Eau", 1, 10),
(11, "Bantha", "/assets/images/beast/beast-5fd9053c47a9d.jpeg", 3, "Desert", 4, 11),
(12, "Dewback", "/assets/images/beast/beast-5fd9059a75771.jpeg", 2, "Desert", 4, 11),
(13, "Varactyl", "/assets/images/beast/beast-5fd905af08d2f.jpeg", 4, "Caverne", 3, 12),
(14, "Ewok", "/assets/images/beast/beast-5fd905c5f360c.jpeg", 1, "Foret", 6, 13),
(15, "Porg", "/assets/images/beast/beast-5fd905da7730d.jpeg", 1, "Falaises", 8, 14);

-- --------------------------------------------------------

--
-- Structure de la table `planet`
--

CREATE TABLE `planet` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT '/assets/images/no-picture.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `planet`
--

INSERT INTO `planet` (`id`, `name`, `picture`) VALUES
(1, "Nar Kreeta", ""),
(2, "Moraband", ""),
(3, "Mandalore", ""),
(4, "Coruscant", ""),
(5, "Dagobah", ""),
(6, "Geonosis", ""),
(7, "Hoth", ""),
(8, "Jakku", ""),
(9, "Kashyyyk", ""),
(10, "Naboo", ""),
(11, "Tatooine", ""),
(12, "Utapau", ""),
(13, "Endor", ""),
(14, "Ahch-To", "");


-- --------------------------------------------------------

--
-- Structure de la table `faction`
--

CREATE TABLE `faction` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT '/assets/images/no-picture.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `faction`
--

INSERT INTO `faction` (`id`, `name`, `picture`) VALUES
(1, "Alliance Rebelle", ""),
(2, "Empire", ""),
(3, "Aucune", "")
;

-- --------------------------------------------------------

--
-- Index pour les tables exportées
--

--
-- Index pour la table `figure`
--
ALTER TABLE `figure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_movie` (`id_movie`),
  ADD KEY `id_faction` (`id_faction`);

--
-- Index pour la table `beast`
--
ALTER TABLE `beast`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_movie` (`id_movie`),
  ADD KEY `id_planet` (`id_planet`);

--
-- Index pour la table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `faction`
--
ALTER TABLE `faction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `figure`
--
ALTER TABLE `figure`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `beast`
--
ALTER TABLE `beast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `faction`
--
ALTER TABLE `faction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `planet`
--
ALTER TABLE `planet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

-- --------------------------------------------------------

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `figure`
--
ALTER TABLE `figure`
  ADD CONSTRAINT `figure_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id`),
  ADD CONSTRAINT `figure_ibfk_2` FOREIGN KEY (`id_faction`) REFERENCES `faction` (`id`);

--
-- Contraintes pour la table `beast`
--
ALTER TABLE `beast`
  ADD CONSTRAINT `beast_ibfk_1` FOREIGN KEY (`id_planet`) REFERENCES `planet` (`id`),
  ADD CONSTRAINT `beast_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id`);