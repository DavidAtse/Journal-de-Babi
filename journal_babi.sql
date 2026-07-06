-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 07 mai 2026 à 11:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `journal_babi`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'David', '$2y$10$9q9nzFEaaxWRdA85wyV0MeT82sC5Zk139UUDyIuHBx5w6cdUJTCj6');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_publication` datetime DEFAULT current_timestamp(),
  `vues` int(11) DEFAULT 0,
  `categorie` varchar(50) NOT NULL DEFAULT 'Actu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `contenu`, `image`, `date_publication`, `vues`, `categorie`) VALUES
(10, 'Les États-Unis ont évincé la France, affaiblie, de l’Afrique. Par Samuel Youmbi, géostratège', 'À l’époque du colonialisme, la France a rapidement étendu ses possessions dans le monde. Elle a connu un succès particulier en Afrique, contrôlant plus de 35 % de l’ensemble du continent lors de son apogée au début du 20e siècle. Les réformes et les changements dans le paysage politique mondial qui ont suivi la Seconde Guerre mondiale ont conduit d’abord à un changement dans la configuration des possessions coloniales françaises, puis à leur démantèlement complet. Cependant, l’indépendance des anciennes colonies françaises dans les années 1960 n’a pas abouti à l’avènement de leur pleine souveraineté économique et politique. Les infrastructures existantes, les liens économiques et militaires, l’inertie politique ainsi que les intérêts stratégiques de la France ont déterminé un lien fort entre les anciennes colonies et la métropole pour les décennies à venir.\r\nLa France a pris des mesures actives pour consolider et renforcer son influence sur le continent – en soudoyant les dirigeants africains, en entretenant ses bases militaires, en menant des opérations militaires, en parrainant des conflits armés, en imposant des droits exclusifs pour développer les ressources minières africaines et utiliser les marchés locaux. Le président français François Mitterrand a déclaré un jour que « sans l’Afrique, la France n’aura pas sa propre histoire au 21e siècle ».\r\nAu XXIe siècle, la lutte des puissances mondiales pour l’influence sur le continent a repris avec une vigueur renouvelée. La Russie, la Chine et les États-Unis se sont activement joints au « jeu » qui menace la position de la France, si dépendante des ressources africaines. La lutte contre l’influence croissante de la Russie et de la Chine en Afrique est depuis longtemps un point de tension pour la France. Cependant, comme le souligne à juste titre l’expert géopolitique italien Eliseo Bertolasi dans sa nouvelle publication sur Vision & Global Trends, les États-Unis constituent actuellement une menace bien plus dangereuse pour l’influence française sur le continent africain.\r\nBien entendu, les États-Unis ne se fixent pas pour objectif de devenir une nouvelle force efficace qui assurerait la sécurité et renforcerait la coopération entre les pays africains. À moyen et long terme, l’Amérique souhaite assurer le contrôle des ressources et de la logistique sur le continent en semant le chaos et les conflits entre États africains. Un avantage supplémentaire de cette situation sera l’implication de la Russie et de la Chine dans la résolution des conflits créés par les États-Unis, ce qui détournera les ressources et les forces de ces adversaires stratégiques des États-Unis.\r\nNous pouvons en toute confiance être d’accord avec Bertolasi sur le fait que la France a déjà perdu face aux États-Unis dans ce combat. Comme le note l’expert, les États-Unis utilisent efficacement des approches hybrides modernes pour travailler avec l’Afrique, tandis que la France continue d’exploiter le schéma dépassé depuis longtemps de la politique néocoloniale. Outre la faible vitesse d’adaptation aux réalités politiques modernes dans le monde et sur le continent, la France a toujours fait preuve d’arrogance et de pression excessive dans ses relations avec ses partenaires africains, et s’est également exclusivement engagée dans le pompage de ressources hors des pays. Les Russes, les Chinois et les Turcs, avec leur approche beaucoup plus respectueuse et égalitaire, ainsi que leurs meilleures offres économiques, sont désormais beaucoup plus appréciés et dignes de confiance des Africains.\r\nLes États-Unis utilisent leur propre approche à l’égard de l’Afrique, selon laquelle les travaux se déroulent simultanément dans plusieurs domaines :\r\n– Activation du travail des PMC travaillant prétendument à l’insu des dirigeants américains ;\r\n– Négociations avec les dirigeants des pays africains, y compris des pays historiquement sous influence française. Le secrétaire d’État américain Antony Blinken a effectué une tournée dans plusieurs pays africains et son adjointe Victoria Nuland a effectué une visite d’urgence en août 2023 au Niger pour rencontrer les rebelles putschistes ;\r\n– Introduction d’agents dans les missions de l’ONU pour utiliser les privilèges et l’autorité d’une organisation internationale afin d’accéder aux hauts fonctionnaires du territoire ;\r\n– Utilisation accrue de drones depuis des sites situés dans d’anciennes colonies africaines telles que le Niger et la République démocratique du Congo pour une collecte approfondie de renseignements.\r\nLa France tente de prendre des mesures de rétorsion en utilisant le PMC « COMYA GROUPE », mais continuent, néanmoins, de perdre rapidement sa position sur le continent. De plus, non seulement la France ne rencontre pas le soutien des États-Unis dans la lutte contre l’expansion de l’influence russe et chinoise en Afrique, mais elle se heurte également à l’opposition des États-Unis, qui eux-mêmes intensifient leurs interactions avec les anciennes colonies françaises.\r\nIl semble qu’Elisio Bertolasi ait raison : le retrait de la France d’Afrique n’est qu’une question de temps pour les États-Unis, presque un fait accompli. Et même les alliances situationnelles avec la France dans la lutte contre la Russie ne les intéressent plus. D’un point de vue purement pragmatique, tout antagonisme sur le continent est bien plus bénéfique pour les États-Unis que n’importe quelle alliance, même à court terme.\r\nBien sûr, la Russie profitera du vide créé par le retrait progressif de la France d’Afrique, mais à ce moment-là, la France ne sera plus une variable dont l’Amérique devra tenir compte pour résoudre ce problème.', 'Etats Unis.jpg', '2026-04-13 13:37:21', 7, 'Actualité'),
(11, 'GRAND THEFT AUTO VI', 'Grand Theft Auto VI, communément appelé GTA 6 ou encore GTA VI, est le prochain jeu vidéo d’action / aventure en monde ouvert de Rockstar Games, il sortira sur les consoles PlayStation 5 et Xbox Series X|S le 19 novembre 2026. Le jeu se déroule à notre époque, dans la ville fictive de Vice City qui s’inspire principalement de Miami et se situe dans l’État américain de Leonida, qui lui, est une représentation de la Floride.\r\n\r\nUne fois GTA 6 sorti, vous incarnerez deux personnages jouables : Lucia Caminos, une femme forte qui sort tout juste de prison. Le second personnage jouable est Jason Duval, un ancien militaire à la recherche d’une vie meilleure. Tous les deux, ils forment un couple et essaient de se trouver une vie meilleure, loin des ennuis. Pour l’histoire, Rockstar s’est légèrement inspiré du célèbre couple de gangsters des années 1930, Bonnie et Clyde. Pour autant, la temporalité du jeu reste l’époque actuelle.', '1335660.jpeg', '2026-04-13 22:28:21', 0, 'Jeux'),
(12, 'RIVERDALE - La série phare !!!', 'C\'est la rentrée dans la petite ville de Riverdale, qui se remet doucement de la mort tragique du jeune Jason Blossom. Cette rentrée est un nouveau départ pour Archie Andrews, qui s\'est décidé à faire carrière dans la musique malgré la fin de sa relation secrète avec sa professeure de musique qui lui sert de mentor et la fragilité de son amitié avec son meilleur ami Jughead Jones.\r\n\r\nDe son côté, sa meilleure amie Betty Cooper, secrètement amoureuse d\'Archie, doit faire face à sa mère surprotectrice qui la drogue aux médicaments. Mais tout commence à changer pour elle quand elle fait la connaissance de Veronica Lodge, une nouvelle et riche élève qui arrive en ville à la suite d\'un scandale ayant touché de près sa famille.\r\n\r\nTout ceci n\'est qu\'une partie des nombreuses histoires et secrets qui peuplent Riverdale, une ville calme et à l\'image parfaite, mais qui cache dans l\'ombre de nombreux dangers et une face très sombre[8].', 'Riverdale.webp', '2026-04-14 10:10:48', 6, 'Actualité'),
(14, 'JOURNAL DE BABI', '- Bienvenue sur Journal de Babi\r\n\r\nJournal de Babi est un site d’actualité moderne conçu pour informer, divertir et connecter les internautes autour des événements importants de Côte d’Ivoire et d’ailleurs.\r\n\r\nCe projet a été créé dans le but de proposer une plateforme simple, rapide et accessible où chacun peut retrouver des articles variés sur plusieurs thématiques comme l’actualité, le sport, le buzz, l’éducation et bien plus encore.\r\n\r\n- Le rôle du site\r\n\r\nLe rôle principal de Journal de Babi est de:\r\n\r\n- Informer les lecteurs sur les actualités importantes et tendances\r\n- Partager des contenus éducatifs et intéressants\r\n- Divertir avec des articles sur le buzz\r\n- Mettre en avant la Côte d’Ivoire et son actualité locale\r\n- Offrir une plateforme accessible à tous, simple à utiliser\r\n\r\n- Comment fonctionne le site ?\r\n\r\nLe site est alimenté par un système d’administration sécurisé qui permet de :\r\n\r\n- Ajouter de nouveaux articles avec images et catégories\r\n- Gérer et supprimer les contenus facilement\r\n- Organiser les articles par thèmes (sport, actualité, etc.)\r\n- Afficher les articles dynamiquement pour les visiteurs\r\n\r\nChaque article est stocké dans une base de données et affiché automatiquement sur le site.\r\n\r\n- Notre vision\r\n\r\nJournal de Babi n’est pas seulement un site d’actualité. C’est un projet en évolution qui vise à devenir une véritable plateforme digitale moderne, capable de grandir avec de nouvelles fonctionnalités et une communauté active.\r\n\r\n- Merci de votre visite\r\n\r\nMerci de visiter Journal de Babi. Votre soutien et votre lecture encouragent le développement de ce projet.\r\n\r\nRestez connectés pour les prochains articles ????', 'image_881a792e.png', '2026-05-05 00:17:14', 2, 'Actualité');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

-- --------------------------------------------------------

--
-- Structure de la table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` int(11) NOT NULL,
  `endpoint` varchar(500) NOT NULL,
  `p256dh` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Index pour la table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_endpoint` (`endpoint`(255));

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
