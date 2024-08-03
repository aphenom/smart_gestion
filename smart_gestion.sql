-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  jeu. 09 juil. 2020 à 01:04
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `smart_gestion`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200623153026', '2020-06-23 15:30:34'),
('20200623184136', '2020-06-23 18:41:43');

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_agent`
--

DROP TABLE IF EXISTS `smartgestion_agent`;
CREATE TABLE IF NOT EXISTS `smartgestion_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_add_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_piece` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_piece` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B7E8CF256CECB9A` (`user_add_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_agent`
--

INSERT INTO `smartgestion_agent` (`id`, `user_add_id`, `nom`, `prenom`, `contact`, `type_piece`, `numero_piece`, `date_add`, `date_del`, `etat_val`, `etat_del`) VALUES
(1, 1, 'Kouassi', 'Paul', '85203695', 'attestation', 'CI88546477PL', '2020-06-23 18:18:46', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_article`
--

DROP TABLE IF EXISTS `smartgestion_article`;
CREATE TABLE IF NOT EXISTS `smartgestion_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_add_id` int(11) NOT NULL,
  `user_del_id` int(11) DEFAULT NULL,
  `user_val_id` int(11) NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pu_vente` int(11) NOT NULL,
  `pu_achat` int(11) NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  `etat_proprio` tinyint(1) NOT NULL,
  `nom_proprio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seuil_approvisionnement` int(11) DEFAULT NULL,
  `image_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_dimensions` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:simple_array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FDE8C49FF9038C4` (`sku`),
  KEY `IDX_FDE8C49F56CECB9A` (`user_add_id`),
  KEY `IDX_FDE8C49FFED75B76` (`user_del_id`),
  KEY `IDX_FDE8C49F45495E26` (`user_val_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_article`
--

INSERT INTO `smartgestion_article` (`id`, `user_add_id`, `user_del_id`, `user_val_id`, `image_name`, `nom`, `pu_vente`, `pu_achat`, `sku`, `date_add`, `date_del`, `etat_val`, `etat_del`, `etat_proprio`, `nom_proprio`, `seuil_approvisionnement`, `image_original_name`, `image_mime_type`, `image_size`, `image_dimensions`) VALUES
(1, 1, NULL, 1, 'action-5ef4fa800bcee997385885.jpg', 'test', 1250, 470, '88625545', '2020-06-25 19:26:55', NULL, 1, 0, 1, NULL, 23, 'Action.jpg', 'image/jpeg', 575010, '1200,1200'),
(2, 1, NULL, 1, NULL, 'Brosse à cheveux', 700, 500, NULL, '2020-06-29 18:15:27', NULL, 1, 0, 0, 'Monsier dix pourcent', NULL, NULL, NULL, NULL, NULL),
(3, 1, NULL, 1, NULL, 'Biscuit', 500, 200, '05512182', '2020-06-29 18:20:37', NULL, 1, 0, 0, 'Tonton rigoberson', NULL, NULL, NULL, NULL, NULL),
(4, 1, NULL, 1, NULL, 'Puce', 500, 200, '03169032', '2020-06-29 18:44:41', NULL, 1, 0, 0, 'Tonio Giga', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_autre_transaction`
--

DROP TABLE IF EXISTS `smartgestion_autre_transaction`;
CREATE TABLE IF NOT EXISTS `smartgestion_autre_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_add_id` int(11) NOT NULL,
  `type_transaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` int(11) NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C8FC60156CECB9A` (`user_add_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_autre_transaction`
--

INSERT INTO `smartgestion_autre_transaction` (`id`, `user_add_id`, `type_transaction`, `montant`, `objet`, `date_add`, `date_del`, `etat_val`, `etat_del`) VALUES
(1, 1, 'entree', 45000, 'Démarrer quelque chose', '2020-07-05 02:33:19', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_commande`
--

DROP TABLE IF EXISTS `smartgestion_commande`;
CREATE TABLE IF NOT EXISTS `smartgestion_commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_add_id` int(11) NOT NULL,
  `agent_livreur_id` int(11) DEFAULT NULL,
  `user_montant_id` int(11) DEFAULT NULL,
  `type_commande` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieu_livraison` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frais_livraison` int(11) DEFAULT NULL,
  `montant_recu` int(11) DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `etat_livraison` tinyint(1) NOT NULL,
  `date_retour` datetime DEFAULT NULL,
  `etat_retour` tinyint(1) NOT NULL,
  `date_reception` datetime DEFAULT NULL,
  `etat_reception` tinyint(1) NOT NULL,
  `objet_retour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_montant` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AA743E0F56CECB9A` (`user_add_id`),
  KEY `IDX_AA743E0F8922B60E` (`agent_livreur_id`),
  KEY `IDX_AA743E0FA69F17A4` (`user_montant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_commande`
--

INSERT INTO `smartgestion_commande` (`id`, `user_add_id`, `agent_livreur_id`, `user_montant_id`, `type_commande`, `nom_client`, `numero_client`, `lieu_livraison`, `frais_livraison`, `montant_recu`, `sku`, `date_add`, `date_del`, `etat_val`, `etat_del`, `date_livraison`, `etat_livraison`, `date_retour`, `etat_retour`, `date_reception`, `etat_reception`, `objet_retour`, `date_montant`) VALUES
(1, 1, 1, 1, 'facebook', 'Kouadio Leopold', '42587896', 'Yopcityyyyy', 1500, 14500, '1593448751', '2020-06-29 16:39:11', '2020-06-29 20:07:50', 1, 0, NULL, 1, NULL, 0, '2020-07-03 19:44:09', 1, NULL, '2020-07-03 00:00:00'),
(2, 1, NULL, NULL, 'locale', 'Désiré Kouao', NULL, NULL, NULL, NULL, '1593995003', '2020-07-06 00:23:23', '2020-07-06 00:47:25', 1, 0, NULL, 0, NULL, 0, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_commande_article`
--

DROP TABLE IF EXISTS `smartgestion_commande_article`;
CREATE TABLE IF NOT EXISTS `smartgestion_commande_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `pu_vente` int(11) NOT NULL,
  `pu_achat` int(11) NOT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FD2AEB587294869C` (`article_id`),
  KEY `IDX_FD2AEB5882EA2E54` (`commande_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_commande_article`
--

INSERT INTO `smartgestion_commande_article` (`id`, `article_id`, `commande_id`, `quantite`, `pu_vente`, `pu_achat`, `date_add`, `date_del`, `etat_val`, `etat_del`) VALUES
(1, 4, 1, 11, 500, 200, '2020-06-29 18:44:41', NULL, 1, 0),
(2, 1, 1, 6, 1250, 470, '2020-06-29 18:46:10', NULL, 1, 0),
(3, 1, 1, 7, 1250, 470, '2020-06-29 19:26:30', NULL, 0, 1),
(4, 1, 2, 80, 1250, 470, '2020-07-06 00:31:04', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_credit_article`
--

DROP TABLE IF EXISTS `smartgestion_credit_article`;
CREATE TABLE IF NOT EXISTS `smartgestion_credit_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_add_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_541B01597294869C` (`article_id`),
  KEY `IDX_541B015956CECB9A` (`user_add_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_credit_article`
--

INSERT INTO `smartgestion_credit_article` (`id`, `article_id`, `user_add_id`, `quantite`, `objet`, `date_add`) VALUES
(1, 1, 1, 70, 'Quantité initiale', '2020-06-26 17:55:05'),
(2, 1, 1, 10, 'Besoin urgent', '2020-06-26 17:55:44');

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_debit_article`
--

DROP TABLE IF EXISTS `smartgestion_debit_article`;
CREATE TABLE IF NOT EXISTS `smartgestion_debit_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_add_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_article` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `etat_defectueux` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4967B2EE7294869C` (`article_id`),
  KEY `IDX_4967B2EE56CECB9A` (`user_add_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_debit_article`
--

INSERT INTO `smartgestion_debit_article` (`id`, `article_id`, `user_add_id`, `quantite`, `objet`, `ref_article`, `date_add`, `etat_defectueux`) VALUES
(1, 1, 1, 25, 'Plus besoin', NULL, '2020-06-26 18:02:05', 0),
(2, 1, 1, 1, 'bah il déconne wo', 'R12BV3', '2020-06-26 18:54:59', 1);

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_entree`
--

DROP TABLE IF EXISTS `smartgestion_entree`;
CREATE TABLE IF NOT EXISTS `smartgestion_entree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_add_id` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8423FE7F56CECB9A` (`user_add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_sortie`
--

DROP TABLE IF EXISTS `smartgestion_sortie`;
CREATE TABLE IF NOT EXISTS `smartgestion_sortie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_add_id` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `objet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E19F5A2B56CECB9A` (`user_add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `smartgestion_user`
--

DROP TABLE IF EXISTS `smartgestion_user`;
CREATE TABLE IF NOT EXISTS `smartgestion_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_add` datetime DEFAULT NULL,
  `date_del` datetime DEFAULT NULL,
  `etat_val` tinyint(1) NOT NULL,
  `etat_del` tinyint(1) NOT NULL,
  `text_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1F0BFF23F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smartgestion_user`
--

INSERT INTO `smartgestion_user` (`id`, `username`, `roles`, `password`, `nom`, `prenom`, `date_add`, `date_del`, `etat_val`, `etat_del`, `text_password`, `email`, `contact`) VALUES
(1, 'user_com', 'a:2:{i:0;s:8:\"ROLE_COM\";i:1;s:8:\"ROLE_FIN\";}', '$argon2id$v=19$m=65536,t=4,p=1$NmhFTmt6eS92UkMvT1MvQQ$fQivmsJKkzcsnMqBOz17mQGQJDtUTaDlF5s1BKji/F4', 'DELTA', 'Akissi', '2020-06-23 15:34:44', NULL, 1, 0, '12345', NULL, NULL),
(2, 'user_admin', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '$argon2id$v=19$m=65536,t=4,p=1$SkpucTZZem55T0dPL2I0Rw$feCCAM/s758fmdBJpFYOxGcS5BGcOI2S97vLHELjQ6I', 'Doyen', 'Assa', '2020-07-07 23:25:23', NULL, 1, 0, '12345', NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `smartgestion_agent`
--
ALTER TABLE `smartgestion_agent`
  ADD CONSTRAINT `FK_8B7E8CF256CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`);

--
-- Contraintes pour la table `smartgestion_article`
--
ALTER TABLE `smartgestion_article`
  ADD CONSTRAINT `FK_FDE8C49F45495E26` FOREIGN KEY (`user_val_id`) REFERENCES `smartgestion_user` (`id`),
  ADD CONSTRAINT `FK_FDE8C49F56CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`),
  ADD CONSTRAINT `FK_FDE8C49FFED75B76` FOREIGN KEY (`user_del_id`) REFERENCES `smartgestion_user` (`id`);

--
-- Contraintes pour la table `smartgestion_autre_transaction`
--
ALTER TABLE `smartgestion_autre_transaction`
  ADD CONSTRAINT `FK_4C8FC60156CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`);

--
-- Contraintes pour la table `smartgestion_commande`
--
ALTER TABLE `smartgestion_commande`
  ADD CONSTRAINT `FK_AA743E0F56CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`),
  ADD CONSTRAINT `FK_AA743E0F8922B60E` FOREIGN KEY (`agent_livreur_id`) REFERENCES `smartgestion_agent` (`id`),
  ADD CONSTRAINT `FK_AA743E0FA69F17A4` FOREIGN KEY (`user_montant_id`) REFERENCES `smartgestion_user` (`id`);

--
-- Contraintes pour la table `smartgestion_commande_article`
--
ALTER TABLE `smartgestion_commande_article`
  ADD CONSTRAINT `FK_FD2AEB587294869C` FOREIGN KEY (`article_id`) REFERENCES `smartgestion_article` (`id`),
  ADD CONSTRAINT `FK_FD2AEB5882EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `smartgestion_commande` (`id`);

--
-- Contraintes pour la table `smartgestion_credit_article`
--
ALTER TABLE `smartgestion_credit_article`
  ADD CONSTRAINT `FK_541B015956CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`),
  ADD CONSTRAINT `FK_541B01597294869C` FOREIGN KEY (`article_id`) REFERENCES `smartgestion_article` (`id`);

--
-- Contraintes pour la table `smartgestion_debit_article`
--
ALTER TABLE `smartgestion_debit_article`
  ADD CONSTRAINT `FK_4967B2EE56CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`),
  ADD CONSTRAINT `FK_4967B2EE7294869C` FOREIGN KEY (`article_id`) REFERENCES `smartgestion_article` (`id`);

--
-- Contraintes pour la table `smartgestion_entree`
--
ALTER TABLE `smartgestion_entree`
  ADD CONSTRAINT `FK_8423FE7F56CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`);

--
-- Contraintes pour la table `smartgestion_sortie`
--
ALTER TABLE `smartgestion_sortie`
  ADD CONSTRAINT `FK_E19F5A2B56CECB9A` FOREIGN KEY (`user_add_id`) REFERENCES `smartgestion_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
