-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 22 juin 2023 à 23:53
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `healthy-food`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `Nom_de_categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `Nom_de_categorie`) VALUES
(1, 'Petit-déjeuner'),
(2, 'Déjeuner'),
(3, 'Collation'),
(4, 'Dîner');

-- --------------------------------------------------------

--
-- Structure de la table `commander`
--

CREATE TABLE `commander` (
  `Id_commande` int(11) NOT NULL,
  `Id_utilisateur` int(11) NOT NULL,
  `Id_nourriture` int(11) NOT NULL,
  `Date_de_commande` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(50) NOT NULL DEFAULT 'En cours de traitement',
  `Nombre_de_commande` int(11) NOT NULL,
  `Montant_de_commande` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commander`
--

INSERT INTO `commander` (`Id_commande`, `Id_utilisateur`, `Id_nourriture`, `Date_de_commande`, `Status`, `Nombre_de_commande`, `Montant_de_commande`) VALUES
(1, 1, 1, '2023-06-11 15:34:58', 'Reçu', 2, 300.00),
(6, 1, 9, '2023-06-21 11:50:17', 'Reçu', 2, 380.00),
(7, 1, 15, '2023-06-21 11:54:56', 'Reçu', 1, 300.00),
(8, 1, 31, '2023-06-21 11:56:53', 'Reçu', 5, 800.00),
(9, 1, 28, '2023-06-21 12:01:34', 'Reçu', 3, 300.00),
(10, 1, 33, '2023-06-21 12:03:18', 'Reçu', 5, 1500.00),
(11, 1, 36, '2023-06-21 12:08:15', 'Reçu', 2, 400.00),
(39, 32, 2, '2023-06-22 06:47:43', 'En cours de traitement', 1, 250.00),
(40, 32, 2, '2023-06-22 06:48:34', 'En cours de traitement', 1, 250.00),
(41, 32, 2, '2023-06-22 06:53:51', 'En cours de traitement', 1, 250.00),
(42, 32, 2, '2023-06-22 06:57:11', 'En cours de traitement', 2, 500.00),
(43, 32, 2, '2023-06-22 06:57:38', 'En cours de traitement', 3, 750.00),
(44, 32, 2, '2023-06-22 07:01:37', 'En cours de traitement', 2, 500.00),
(45, 32, 2, '2023-06-22 07:03:20', 'En cours de traitement', 1, 250.00),
(46, 32, 2, '2023-06-22 07:04:44', 'En cours de traitement', 1, 250.00),
(47, 32, 2, '2023-06-22 07:06:47', 'En cours de traitement', 2, 500.00),
(48, 32, 2, '2023-06-22 07:12:05', 'En cours de traitement', 1, 250.00),
(49, 32, 2, '2023-06-22 07:12:19', 'En cours de traitement', 1, 250.00),
(50, 51, 1, '2023-06-22 08:22:50', 'En cours de traitement', 1, 150.00),
(51, 53, 11, '2023-06-22 20:29:09', 'Reçu', 1, 160.00),
(52, 53, 33, '2023-06-22 20:29:42', 'Reçu', 1, 300.00),
(53, 53, 30, '2023-06-22 20:31:36', 'Reçu', 1, 160.00);

-- --------------------------------------------------------

--
-- Structure de la table `nourritures`
--

CREATE TABLE `nourritures` (
  `Id_nourriture` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Sous_nom` varchar(50) NOT NULL,
  `Description_` varchar(200) NOT NULL,
  `Prix` decimal(10,2) NOT NULL,
  `_Image` varchar(100) NOT NULL,
  `id_categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `nourritures`
--

INSERT INTO `nourritures` (`Id_nourriture`, `Nom`, `Sous_nom`, `Description_`, `Prix`, `_Image`, `id_categorie`) VALUES
(1, 'PANCAKES', 'TOUT CHOCO HEALTHY', '180g de farine de blé\r\n20g de cacao amer non sucré\r\n10g de sucre de canne non reffiné\r\n8g de levure chimique\r\n1 pincée de sel fin\r\n20g d\'huile d\'olive\r\n1 oeuf\r\n30g de chocolat noir fondu\r\n25cl de lait', 150.00, 'pancake.png', 1),
(2, 'Poêlée ', 'boeuf haché et pommes de terre', '3 cuillères à soupe d\'huile d\'olive extra vierge, divisées\n\n1 livre de bœuf haché maigre à 90 %\n\n2 cuillères à café de cumin moulu\n\n¾ cuillère à café de sel\n\n¼ cuillère à café de poivre moulu\n', 250.00, 'Poêlée de boeuf haché et pommes de terre.png', 2),
(6, 'PANCAKES BANANE', 'SANS SUCRES', '1 banane moyenne.\r\n1 oeuf.\r\n70 g de farine de blé\r\n4 g de levure chimique\r\n30 g de lait végétal ou non\r\n1 pincée de sel fin', 170.00, 'pancake1.png', 1),
(7, 'Toast de ricotta', 'au citron et aux baies', '¼ tasse de fromage ricotta au lait entier\r\n\r\n2 cuillères à café de sirop d\'érable pur\r\n\r\n½ cuillère à café de zeste de citron plus 1/4 cuillère à café, divisée\r\n\r\n2 tranches de pain de grains entiers,', 200.00, 'Toast Lemon-Berry Ricotta.png', 1),
(8, 'Berry-Mint Kefir', 'Smoothies', '1 cup low-fat plain kefir (see Tip)\r\n\r\n1 cup frozen mixed berries\r\n\r\n¼ cup orange juice\r\n\r\n1-2 tablespoons fresh mint\r\n\r\n1 tablespoon honey', 170.00, 'Flocons d\'avoine à la banane.png', 1),
(9, 'Berry Chia', 'Pudding', '1 ¾ cups blackberries, raspberries and/or diced mango (fresh or frozen), divided\r\n\r\n1 cup unsweetened almond milk or milk of choice\r\n\r\n¼ cup chia seeds\r\n\r\n1 tablespoon pure maple syrup\r\n\r\n¾ teaspoon v', 190.00, 'Mini quiches sans croûte aux oignons caramélisés et au fromage.png', 1),
(10, 'Bircher ', 'Muesli', '1 ½ cups old-fashioned rolled oats (see Tip)\r\n\r\n1 ½ cups unsweetened almond milk\r\n\r\n1 ¼ cups whole-milk plain yogurt\r\n\r\n1 medium Fuji apple, unpeeled, cored and grated (1 cup)\r\n\r\n¼ cup chia seeds\r\n\r\n4', 210.00, 'Bircher Muesli.png', 1),
(11, 'Muesli ', 'aux framboises', '⅓ tasse de muesli\r\n\r\n1 tasse de framboises\r\n\r\n¾ tasse de lait faible en gras', 160.00, 'Framboises.png', 1),
(12, 'Avoine ', 'au beurre de cacahuète', '½ tasse de lait de soja ou autre lait végétal\r\n\r\n½ tasse de flocons d\'avoine à l\'ancienne (voir Astuce)\r\n\r\n1 cuillère à soupe de sirop d\'érable pur\r\n\r\n1 cuillère à soupe de graines de chia\r\n\r\n1 cuillè', 210.00, 'Avoine au beurre de cacahuète.png', 1),
(13, 'yogourt au muesli ', 'grillé aux pacanes et aux cerises', '1 tasse de flocons d\'avoine à l\'ancienne\r\n\r\n½ tasse d\'amandes effilées\r\n\r\n½ tasse de pacanes, hachées grossièrement\r\n\r\n½ tasse de gros flocons de noix de coco non sucrés\r\n\r\n¼ tasse de germe de blé ou ', 270.00, 'Smoothies au kéfir aux baies et à la menthe.png', 1),
(14, 'Pain ', 'aux bananes classique', '2 tasses de farine tout usage\r\n\r\n¾ cuillère à café de bicarbonate de soude\r\n\r\n½ cuillère à café de sel\r\n\r\n1 tasse de sucre\r\n\r\n¼ tasse de beurre, ramolli\r\n\r\n2 gros oeufs\r\n\r\n1 ½ tasse de banane mûre écr', 180.00, 'Pain aux bananes classique.png', 1),
(15, 'Salade de pâtes', 'au poulet', '6 onces de pâtes casarecce\r\n\r\n8 onces de haricots verts (haricots verts français), coupés en 2 po. pièces\r\n\r\n⅝ cuillère à café de sel kasher, divisée\r\n\r\n¼ tasse d\'huile d\'olive extra vierge\r\n\r\n2 cuill', 300.00, 'Salade de pâtes aux crevettes.png', 2),
(16, 'Salade de noix de cajou', 'avec vinaigrette à la coriandre, à la menthe et à ', '2 onces de lentilles ou de pâtes à grains entiers, comme des fusilli ou des penne\r\n\r\n1 échalote moyenne , finement hachée\r\n\r\n1 cuillère à soupe de jus de citron\r\n\r\n1 cuillère à soupe d\'eau tiède\r\n\r\n½ ', 350.00, 'Salade de noix de cajou.png', 2),
(17, 'Quiche ', 'aux épinards et aux champignons', '2 cuillères à soupe d\'huile d\'olive extra vierge\r\n\r\n8 onces de champignons sauvages mélangés frais tranchés tels que cremini, shiitake, champignons de Paris et/ou pleurotes\r\n\r\n1 ½ tasse d\'oignon doux ', 400.00, 'Quiche aux épinards et aux champignons.png', 2),
(18, 'Sandwich', 'aux légumes et houmous', '2 tranches de pain complet\r\n\r\n3 cuillères à soupe de houmous\r\n\r\n¼ avocat, écrasé\r\n\r\n½ tasse de verdures mélangées\r\n\r\n¼ poivron rouge moyen , tranché\r\n\r\n¼ tasse de concombre tranché\r\n\r\n¼ tasse de carot', 200.00, 'Sandwich aux légumes et houmous.png', 2),
(19, 'Wrap ', 'Boursin Concombre', '1 tortilla de blé entier de 8 pouces\r\n\r\n3 cuillères à soupe de Boursin à l\'ail et aux herbes\r\n\r\n½ tasse de concombre finement haché', 200.00, 'wrap au concombre et au boursin.png', 2),
(20, 'Salade', 'crémeuse au poulet', '2 tasses de poulet rôti haché\r\n\r\n¾ tasse de céleri haché\r\n\r\n⅓ tasse d\'aïoli citron-herbes (voir note)\r\n\r\nPoivre noir concassé', 250.00, 'Bol de riz brun aux légumes rôtis et au tofu.png', 2),
(21, 'Salade', 'Cobb hachée au poulet', '2 tasses de laitue romaine hachée\r\n\r\n2 cuillères à soupe de vinaigrette au fromage bleu en bouteille, comme le fromage bleu Chunky de Bolthouse Farms, divisées\r\n\r\n¼ tasse de tomates hachées\r\n\r\n¼ tasse', 400.00, 'Salade Cobb hachée au poulet.png', 2),
(22, 'Salade', 'garnie de poulet et de quinoa', '¾ tasse de poitrine de poulet cuite effilochée (voir recettes associées)\r\n\r\n½ tasse de quinoa cuit (voir recettes associées)\r\n\r\n1 tasse de légumes racines rôtis (voir recettes associées)\r\n\r\n1-2 cuillè', 450.00, 'Salade garnie de poulet et de quinoa.png', 2),
(23, 'Boules ', 'Délice au caramel', '1 tasse de flocons d\'avoine\r\n\r\n½ tasse de beurre d\'amande non sucré et sans sel ajouté\r\n\r\n¼ tasse de sauce au caramel\r\n\r\n¼ cuillère à café de sel\r\n\r\n6 cuillères à soupe de mini pépites de chocolat mi-', 200.00, 'Boules d\'énergie aux canneberges et aux amandes.png', 3),
(24, 'Boules', 'aux canneberges et aux amandes', '¾ tasse d\'amandes entières crues\r\n\r\n½ tasse de canneberges séchées sucrées\r\n\r\n¼ tasse de dattes dénoyautées\r\n\r\n¾ tasse de flocons d\'avoine à l\'ancienne (voir Astuce)\r\n\r\n2 cuillères à soupe de tahini\r\n', 150.00, 'Boules d\'énergie Délice au caramel.png', 3),
(25, 'Boules', ' sans cuisson au maïs blanc Seneca', '1 ½ tasse d\'avoine rapide\r\n\r\n1 tasse de farine de maïs blanc grillé (voir Astuce)\r\n\r\n1 cuillère à café de cannelle moulue\r\n\r\n1 cuillère à café de sel\r\n\r\n½ tasse de beurre d\'arachide naturel\r\n\r\n¼ tasse', 250.00, 'Boules énergétiques sans cuisson au maïs blanc Seneca.png', 3),
(26, 'Barres', 'granola sans cuisson', '2 ½ tasses de flocons d\'avoine à l\'ancienne\r\n\r\n¼ tasse de graines de citrouille crues non salées (graines de citrouille)\r\n\r\n⅓ tasse de noisettes crues non salées\r\n\r\n16 dattes Medjool dénoyautées, hach', 200.00, 'barres granola.png', 3),
(27, 'Chips', 'de parmesan', '2 onces de parmesan frais rapé (environ 1/2 tasse)\r\n\r\n¼ cuillère à café de poivre noir fraîchement moulu', 170.00, 'Chips de parmesan.png', 3),
(28, 'Muffins', 'à la citrouille', '2 tasses de flocons d\'avoine sans gluten\r\n\r\n1 tasse de purée de citrouille\r\n\r\n2 œufs\r\n\r\n1 tasse de yogourt grec 2 %\r\n\r\n¼ tasse de sirop d\'érable\r\n\r\n1 ½ cuillères à café de levure chimique\r\n\r\n½ cuillèr', 100.00, 'muffins .png', 3),
(29, 'Croustilles', 'de friteuse à air', '1 pomme de terre moyenne , russet, chair et peau, crue\r\n\r\n1 cuillère à soupe d\'huile de colza\r\n\r\n¼ cuillère à café de sel de mer\r\n\r\n¼ cuillère à café de poivre noir fraîchement moulu\r\n\r\nHuile de canol', 250.00, 'Croustilles de friteuse à air.png', 3),
(30, 'Boules', 'à la tarte aux pommes', '¾ tasse de dattes Medjool, dénoyautées et hachées\r\n\r\n½ tasse de flocons d\'avoine\r\n\r\n½ tasse de pommes séchées hachées\r\n\r\n½ tasse de beurre d\'amande non sucré\r\n\r\n¼ tasse de pacanes hachées, grillées\r\n\r', 160.00, 'Boules d\'énergie.png', 3),
(31, 'Wrap d\'omelette', 'à la salade grecque', '1 cuillère à soupe d\'huile d\'olive extra vierge\r\n\r\n1 cuillère à soupe de jus de citron\r\n\r\n1 cuillère à café de vinaigre de vin rouge\r\n\r\n½ cuillère à café d\'origan séché\r\n\r\n½ cuillère à café de poivre ', 160.00, 'enveloppe d\'omelette.png', 4),
(32, 'Nouilles ', 'au sésame et aux arachides', '1 livre de filets de poulet\r\n\r\n4 onces de spaghettis de blé entier\r\n\r\n2 paquets de 10 onces de nouilles de courgettes spiralées (environ 6 tasses)\r\n\r\n½ tasse de beurre de cacahuète naturel lisse\r\n\r\n3 ', 220.00, 'nouilles aux arachides et au sésame avec poulet.png', 4),
(33, 'Poêlée', 'de bœuf haché et de pâtes', '1 cuillère à soupe d\'huile d\'olive extra vierge\r\n\r\n1 livre de bœuf haché maigre à 90 %\r\n\r\n8 onces de champignons, finement hachés ou pulsés dans un robot culinaire\r\n\r\n½ tasse d\'oignon coupé en dés\r\n\r\n', 300.00, 'Poêlée de bœuf haché et de pâtes.png', 4),
(34, 'Saumon', 'et légumes grillés', '2 courgettes moyennes, parées et coupées en deux sur la longueur\r\n\r\n1 livre d\'asperges, parées\r\n\r\n5 à 6 cuillères à soupe de vinaigrette citron-ail carbonisé , divisées\r\n\r\n1 ¼ livres de filet de saumo', 350.00, 'Tacos au saumon rôti avec salsa au maïs et aux poivrons.png', 4),
(35, 'Tacos ', 'au saumon rôti ', '2 cuillères à café de miel\r\n\r\n1 piment chipotle en conserve en adobo, haché finement\r\n\r\n1 cuillère à café de moutarde de Dijon\r\n\r\n1 cuillère à café de jus de citron vert frais plus 2 cuillères à soupe', 300.00, 'Galettes de saumon croustillantes avec salade de concombre crémeuse.png', 4),
(36, 'Galettes', 'de saumon croustillantes', '1 gros oeuf, légèrement battu\r\n\r\n¼ tasse de chapelure de blé entier\r\n\r\n2 cuillères à soupe de mayonnaise\r\n\r\n½ cuillère à café d\'assaisonnement Old Bay\r\n\r\n⅛ cuillère à café de poivre moulu\r\n\r\n2 boîtes ', 200.00, 'Saumon Old Bay avec purée de pois citronnée.png', 4),
(37, 'Saumon Old Bay ', 'avec purée de pois citronnée', '1 livre de pois , frais ou surgelés\r\n\r\n¼ tasse de crème fraîche ou de crème sure\r\n\r\n½ cuillère à café de zeste de citron\r\n\r\n3 cuillères à soupe de jus de citron\r\n\r\n¼ cuillère à café de sel\r\n\r\n¼ cuillè', 450.00, 'Rouleaux de sushi au saumon épicé.png', 4),
(38, 'Rouleaux de sushi', 'au saumon épicé', '2 boîtes (6 onces) de saumon, égoutté et émietté\r\n\r\n3 cuillères à soupe de mayonnaise\r\n\r\n3 cuillères à café de Sriracha\r\n\r\n2 cuillères à café de vinaigre de riz\r\n\r\n6 feuilles de nori\r\n\r\n2 tasses de ri', 350.00, 'Saumon et légumes grillés avec vinaigrette au citron et à l\'ail carbonisés.png', 4),
(39, 'Saumon ', 'avec orzo aux herbes citronnées', '1 tasse d\'orzo, de préférence de blé entier\r\n\r\n2 tasses de brocoli haché (environ 1/2 tête)\r\n\r\n3 cuillères à soupe d\'huile d\'olive extra vierge, divisée\r\n\r\n1 ¼ livre de filet de saumon avec peau, coup', 320.00, 'Pâtes à la ricotta déesse verte.png', 4),
(40, 'Magni ad earum repud', 'Enim in alias deleni', 'Et molestiae quis qu', 0.00, 'Boules d\'énergie Délice au caramel.png', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `Id_utilisateur` int(11) NOT NULL,
  `Nom_` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Adresse` varchar(100) NOT NULL,
  `Numero_telephone` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Mot_de_passe` varchar(255) NOT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `admin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`Id_utilisateur`, `Nom_`, `Prenom`, `Adresse`, `Numero_telephone`, `Email`, `Mot_de_passe`, `Image`, `admin`) VALUES
(1, 'el kabdani', 'soufiane', 'complexe zemmouri 4 izdihar 9', '0568456786', 'soufiane@gmail.com', '$2y$10$Y41KB8eUnubSgYuMeuJpKOpvTM72tYV6G6BTFbnhb4HbiWDEcDCLK', '6487c0c6f02d6-soufian profile pic.png', 0),
(2, 'moumou', 'outhman', 'mojamae hassani', '076786867', 'outhman@gmail.com', '$2y$10$CApwi21L08YYaBTND.k3dOOnKgH4grFkJtmAEeCn0p16mrsT352G.', NULL, 1),
(53, 'alaoui', 'ali', 'branes 1', '0678787878', 'ali@gmail.com', '$2y$10$ceUNtmyuV3k/4MjNtY06Ael1KvH1fyiWIIsbjzEAT7ykVmPdWCosi', '6494ae6e89a7b-chef outhman.jpg', 0),
(54, 'el kabdani', 'mustapha', 'complexe zemmouri 4', '0678787878', 'mustapha@gmail.com', '$2y$10$oVf.GUa7zzaaV7O45CgHeedjessEGbX7eIHylNk.pOMZXxQ34t4L.', NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commander`
--
ALTER TABLE `commander`
  ADD PRIMARY KEY (`Id_commande`);

--
-- Index pour la table `nourritures`
--
ALTER TABLE `nourritures`
  ADD PRIMARY KEY (`Id_nourriture`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`Id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commander`
--
ALTER TABLE `commander`
  MODIFY `Id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `nourritures`
--
ALTER TABLE `nourritures`
  MODIFY `Id_nourriture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `Id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `nourritures`
--
ALTER TABLE `nourritures`
  ADD CONSTRAINT `nourritures_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
