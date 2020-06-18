-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 18 Juin 2020 à 17:28
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `quincaillerie`
--

-- --------------------------------------------------------

--
-- Structure de la table `actioncaisse`
--

CREATE TABLE `actioncaisse` (
  `idac` int(11) NOT NULL,
  `date_ouverture` date NOT NULL,
  `heure_ouverture` time NOT NULL,
  `date_fermeture` date DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL,
  `solde_theorique` int(11) NOT NULL DEFAULT '0',
  `etat` int(11) NOT NULL DEFAULT '0',
  `commentaire` text,
  `user_id` int(11) NOT NULL,
  `caisse_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `actioncaisse`
--

INSERT INTO `actioncaisse` (`idac`, `date_ouverture`, `heure_ouverture`, `date_fermeture`, `heure_fermeture`, `solde_theorique`, `etat`, `commentaire`, `user_id`, `caisse_id`, `token`) VALUES
(1, '2020-06-09', '09:13:00', NULL, NULL, 0, 1, NULL, 1, 1, 'jigbuhfge deyvgzyho vuzigfhpoj hvc'),
(6, '2020-06-10', '14:44:38', '2020-06-10', '15:15:07', 54600, 1, '', 1, 1, 'b876414abb602793b1212aa48d37c66faa6facf7adbc1263acf4e1db223233de95a6d0b9ba3cf2c27cd3ea9ced66803506de'),
(8, '2020-06-11', '10:13:36', NULL, NULL, 0, 0, NULL, 1, 1, '5be107855e1c8585e3f6c1dd8d76778271e008014abf625e263a44caff3dd8d3491d72e4641e3685efb8e7acadf575153862'),
(9, '2020-06-12', '13:19:27', NULL, NULL, 0, 0, NULL, 1, 1, '60bb4fda6e98db6a1cdf35cfad396e5e69091a30c8ef9e3367b60b62fcc7b571c13710de40cb0d38947c45ca95e1b961abb8'),
(10, '2020-06-15', '10:19:48', NULL, NULL, 0, 0, NULL, 1, 1, 'abf54bab6dba198d2dd9c3b887b3f8d2a1862db9537453dd0a786a9c3a596b4e200a77c6e47efcaf7d6b43ea9db275a7bc0e'),
(11, '2020-06-16', '09:51:33', NULL, NULL, 0, 0, NULL, 1, 1, '108beac719caa321b2d491c01e3ef85d935615d8e479e4debf9a2e8a5f446fa6a561fcd85dabf38f0a307a57027c4e26896b'),
(12, '2020-06-17', '08:40:22', NULL, NULL, 0, 0, NULL, 1, 1, 'f03c3a73edb6d7929713540163d9719652b5234c3ee12c77cb3934d9ea7d833404f05165759d0f253e61abc03da78c579f49'),
(13, '2020-06-18', '11:59:14', NULL, NULL, 0, 0, NULL, 1, 1, '615ce8b65ae2911dd7d1f959d4dc1f911345bc41fc6f2c84242824688b8c2d855139a4d8442a12ddae074ef87d15dff983b2');

-- --------------------------------------------------------

--
-- Structure de la table `argent`
--

CREATE TABLE `argent` (
  `id_argent` int(11) NOT NULL,
  `valeur` int(11) NOT NULL,
  `type` varchar(8) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `argent`
--

INSERT INTO `argent` (`id_argent`, `valeur`, `type`, `etat`) VALUES
(1, 10000, 'Billet', 0),
(2, 5000, 'Billet', 0),
(3, 2000, 'Billet', 0),
(4, 1000, 'Billet', 0),
(6, 500, 'Billet', 0),
(7, 500, 'Pièce', 0),
(8, 250, 'Pièce', 0),
(9, 200, 'Pièce', 0),
(10, 100, 'Pièce', 0),
(11, 50, 'Pièce', 0),
(12, 25, 'Pièce', 1),
(13, 10, 'Pièce', 1),
(14, 5, 'Pièce', 1);

-- --------------------------------------------------------

--
-- Structure de la table `billetage`
--

CREATE TABLE `billetage` (
  `id_billetage` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `date_billetage` date DEFAULT NULL,
  `ac_id` int(11) NOT NULL,
  `argent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `billetage`
--

INSERT INTO `billetage` (`id_billetage`, `quantite`, `date_billetage`, `ac_id`, `argent_id`) VALUES
(11, 5, '2020-06-10', 6, 1),
(12, 2, '2020-06-10', 6, 3),
(13, 1, '2020-06-10', 6, 6),
(14, 1, '2020-06-10', 6, 10);

-- --------------------------------------------------------

--
-- Structure de la table `boncommande`
--

CREATE TABLE `boncommande` (
  `idfacture` int(11) NOT NULL,
  `numbon` varchar(55) DEFAULT NULL,
  `idfournisseur` int(11) NOT NULL,
  `datebon` date NOT NULL,
  `iduser` int(11) NOT NULL,
  `tva` varchar(15) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `echeance` date DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `annulee` int(11) DEFAULT '0',
  `motifAnnulation` text,
  `dateAnnulation` date DEFAULT NULL,
  `idUserAnnulation` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `boncommande`
--

INSERT INTO `boncommande` (`idfacture`, `numbon`, `idfournisseur`, `datebon`, `iduser`, `tva`, `etat`, `echeance`, `token`, `annulee`, `motifAnnulation`, `dateAnnulation`, `idUserAnnulation`) VALUES
(1, NULL, 1, '2020-05-13', 1, 'non', 1, NULL, '1a6e83e04b046b473c16a2b6ad89199177a7689b2ce35a2a7047cd9e52b2f59411af6d5cc9bee7a8c8caeb0edc506dd8d537', 0, NULL, NULL, NULL),
(2, NULL, 3, '2020-06-04', 1, 'non', 0, NULL, 'bea96728f153a20ac10b39efeedbe388471301bb74535cdd195fae8bad01db6603ddbe5a65870f5088b177db0482d604b42c', 1, 'Motif annulation', NULL, 1),
(3, NULL, 3, '2020-06-05', 1, 'non', 0, NULL, '038a0b715700a011e452ddbbf65031469cd33d8505a48214f2b46a4965e7dc28b61b1a77932aa66ba8fcec1c9ffc57071ea9', 0, NULL, NULL, NULL),
(4, NULL, 3, '2020-06-08', 1, 'non', 1, '2020-07-08', '80afe6e64a41af22e41041959879aac2bcac1858f8d49ac5f8d37c5ba4dc00a5daeecbad06180bff336553a585c376d35333', 0, NULL, NULL, NULL),
(5, NULL, 3, '2020-06-10', 1, 'non', 0, NULL, '3b74b0df90badf64e4b78af5a4dd2798793f84918f12285576217a40c8124dd4519f1abe0d5bb7589138cb50a379101b4f24', 0, NULL, NULL, NULL),
(6, NULL, 3, '2020-06-16', 1, 'non', 1, NULL, '2ee84e722a3679d3e68f69e63a8da10a6e681f086b808f50c20e122413d80cb595042f305d2b1c06eac337607fde06db484a', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `bonlivraison`
--

CREATE TABLE `bonlivraison` (
  `idfacture` int(11) NOT NULL,
  `numbon` varchar(55) DEFAULT NULL,
  `datebon` date NOT NULL,
  `iduser` int(11) NOT NULL,
  `idbc` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `bonlivraison`
--

INSERT INTO `bonlivraison` (`idfacture`, `numbon`, `datebon`, `iduser`, `idbc`, `token`) VALUES
(1, NULL, '2020-05-13', 1, 1, 'f5354d2cbc97cd607dbbbde4a5a965918376ade0f13c89ba1cbeb0ce0ff65d8ea3121b1e682f6b862b34b8baa911387d4fed'),
(2, NULL, '2020-06-08', 1, 4, '897a36172338d8517530bc423b04666335c76a9f80fd9382c8c2924d29be90163eadfc82a1c7bb4e6b8f6562e048337db89c'),
(3, NULL, '2020-06-08', 1, 4, 'a7c7bdafa1fa4284e67c3ca4d39171e3c5a23a08f246d6cbe2191424e5b1a48b74c9648ff6377780b0770f209c1f6c2785cc'),
(4, NULL, '2020-06-10', 1, 4, 'bec7f93c168d0a196cc4d8b6c47744392ec2768e6f2f7cf9419347f29df5d68c4b15fbab24d531bd836dec9475bfc893273c'),
(5, NULL, '2020-06-16', 1, 6, '44cfb3f9428e7ecda7b62428802d23701068a42527d1aee5c6b1ff2f467654048e3fc04ab12c21cf4d355664b38a10c811fa');

-- --------------------------------------------------------

--
-- Structure de la table `caisse`
--

CREATE TABLE `caisse` (
  `idcaisse` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `caisse`
--

INSERT INTO `caisse` (`idcaisse`, `libelle`, `etat`, `token`) VALUES
(1, 'Caisse 1', 0, 'gtscfdghoijdutds');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `idclient` int(10) UNSIGNED NOT NULL,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `type_client` int(25) NOT NULL,
  `ncc` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`idclient`, `nom`, `email`, `phone`, `adresse`, `etat`, `type_client`, `ncc`, `token`, `profession`, `observation`) VALUES
(1, 'BATIM', '', '5555555', '', 0, 1, '16101992', 'f6ae8e757e11910767d9fd71d320ddf95f7d8b0c6fe7cc8582c6522912336f9c333aed5f1e4621a081380ee31e775137d640', '', 'Observation'),
(2, 'ETS Cissé & Frères', '', '887741321', '', 0, 2, '11062020', 'fe7b7e5d822bec723c1f6e468e549ca93ac5f17f55902226351dd3065a84e4c5ad63c70427d1233916cb3285dc6ed54193df', '', 'Observations'),
(3, 'Malick Coulibaly', '', '55541325', 'Abidjan Yopougon', 0, 1, '', '21fa9e0cf883df47f4524f887e7c8d1b4ec0260fc9e86e65215dfd542408cf9086cf1e54d7887e922b5c8b62df21a5aa1523', 'Entrepreneur', 'ythondc');

-- --------------------------------------------------------

--
-- Structure de la table `commerciaux`
--

CREATE TABLE `commerciaux` (
  `idcommercial` int(10) UNSIGNED NOT NULL,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `commerciaux`
--

INSERT INTO `commerciaux` (`idcommercial`, `nom`, `phone`, `etat`, `type`, `token`) VALUES
(1, 'Commercial 1', '844542154', 0, 1, '41ef8ffc7782f3e317238b44a588862dd5342dda438b78cb2374e47e5fb1ae5b93f49391017183ea05419cf6be1b82339238'),
(2, 'Commercial 2', '4521542', 0, 2, '1f58158a551f55c76c50549315a5d905790352d1da1f5a280bab29f9a2e658f3c443058c9118a0fd043b892c6defbd7977ed'),
(3, 'Commercial 3', '68745784', 0, 3, '34f672c4d886388433dbcf0e6c798bc534297d0460016aa95eb70d39976da98bc24992490eb3cb5d9992b3094978784e93a9');

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE `depense` (
  `iddepense` int(11) NOT NULL,
  `motifdepense` text NOT NULL,
  `datedepense` date NOT NULL,
  `iduser` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `factureachat` int(11) DEFAULT NULL,
  `typedepense` varchar(15) NOT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `arretcaisse_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `depense`
--

INSERT INTO `depense` (`iddepense`, `motifdepense`, `datedepense`, `iduser`, `montant`, `token`, `factureachat`, `typedepense`, `fournisseur_id`, `arretcaisse_id`) VALUES
(10, 'Versement Banque', '2020-06-10', 1, 45000, '6d03b78b5bfc967f3a07ea8174e72bbe1f9c8acc0a8e2e6959b34563855c28f46221cdf875defbe4122447f6ae617814ccf6', NULL, 'banque', NULL, 6),
(9, 'Règlement Fournisseur', '2020-06-10', 1, 150000, 'ca51df3b273e0a238247f92a02cdb27e31fa63fa4a3d083cad8f33f87104eb49e1d9c570036c8efbfea9227ec6a25671b71d', 5, 'fa', 3, 6),
(8, ' Motif', '2020-06-10', 1, 15000, '0583aea874a3461b39888bb5018f57a592ac36cdeff9d294ae40d29a435b6cb52a2680a6b13146178adfc5f91341c6597c08', NULL, 'exp', NULL, 6),
(11, 'Règlement Fournisseur', '2020-06-16', 1, 67200, '44cfb3f9428e7ecda7b62428802d23701068a42527d1aee5c6b1ff2f467654048e3fc04ab12c21cf4d355664b38a10c811fa', 6, 'fa', 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `detailbc`
--

CREATE TABLE `detailbc` (
  `iddetail` int(11) NOT NULL,
  `idbon` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `pu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `detailbc`
--

INSERT INTO `detailbc` (`iddetail`, `idbon`, `idproduit`, `qte`, `pu`) VALUES
(1, 1, 1, 3, 10000),
(2, 1, 24, 6, 1500),
(3, 1, 25, 9, 2000),
(4, 2, 25, 10, 15000),
(5, 2, 1, 10, 2500),
(6, 2, 24, 10, 10000),
(7, 3, 1, 1, 15000),
(8, 3, 24, 2, 10000),
(9, 3, 25, 3, 5000),
(18, 4, 1, 1, 5000),
(17, 4, 24, 2, 10000),
(16, 4, 25, 3, 25000),
(19, 4, 26, 1, 74800),
(20, 5, 1, 10, 15000),
(21, 6, 26, 1, 60000),
(22, 6, 1, 9, 800);

-- --------------------------------------------------------

--
-- Structure de la table `detailbl`
--

CREATE TABLE `detailbl` (
  `iddetail` int(11) NOT NULL,
  `idbon` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `pu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `detailbl`
--

INSERT INTO `detailbl` (`iddetail`, `idbon`, `idproduit`, `qte`, `pu`) VALUES
(1, 1, 1, 3, 10000),
(2, 1, 24, 6, 1500),
(3, 1, 25, 9, 2000),
(4, 2, 1, 1, 5000),
(5, 3, 1, 1, 5000),
(6, 4, 1, 1, 5000),
(7, 4, 24, 2, 10000),
(8, 4, 25, 3, 25000),
(9, 4, 26, 1, 74800),
(10, 5, 26, 1, 60000),
(11, 5, 1, 9, 800);

-- --------------------------------------------------------

--
-- Structure de la table `detailinventaire`
--

CREATE TABLE `detailinventaire` (
  `iddetail` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `qteavant` double NOT NULL,
  `qteapres` double NOT NULL,
  `idinventaire` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `detailproforma`
--

CREATE TABLE `detailproforma` (
  `iddetailproforma` int(10) UNSIGNED NOT NULL,
  `proforma_id` int(10) UNSIGNED NOT NULL,
  `produit_id` int(10) UNSIGNED NOT NULL,
  `qte` int(11) NOT NULL,
  `pu` int(11) NOT NULL,
  `remise` int(11) NOT NULL DEFAULT '0',
  `etat` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `detailproforma`
--

INSERT INTO `detailproforma` (`iddetailproforma`, `proforma_id`, `produit_id`, `qte`, `pu`, `remise`, `etat`) VALUES
(1, 2, 26, 10, 80000, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `detailtransfert`
--

CREATE TABLE `detailtransfert` (
  `iddetailtransfert` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `transfert_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `detailtransfert`
--

INSERT INTO `detailtransfert` (`iddetailtransfert`, `idproduit`, `quantite`, `transfert_id`) VALUES
(2, 25, 10, 2),
(3, 25, 10, 3),
(4, 25, 10, 4);

-- --------------------------------------------------------

--
-- Structure de la table `detailvente`
--

CREATE TABLE `detailvente` (
  `iddetailvente` int(10) UNSIGNED NOT NULL,
  `vente_id` int(10) UNSIGNED NOT NULL,
  `produit_id` int(10) UNSIGNED NOT NULL,
  `qte` int(11) NOT NULL,
  `pu` int(11) NOT NULL,
  `remise` int(11) NOT NULL DEFAULT '0',
  `etat` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `detailvente`
--

INSERT INTO `detailvente` (`iddetailvente`, `vente_id`, `produit_id`, `qte`, `pu`, `remise`, `etat`) VALUES
(21, 12, 1, 100, 1500, 0, 0),
(22, 13, 1, 100, 1000, 0, 0),
(23, 12, 24, 1, 4500, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `entrepot`
--

CREATE TABLE `entrepot` (
  `identrepot` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `datecreation` date NOT NULL,
  `token` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `iduser` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entrepot`
--

INSERT INTO `entrepot` (`identrepot`, `designation`, `details`, `datecreation`, `token`, `etat`, `iduser`) VALUES
(1, 'Magasin 1', 'Magasin 1', '2020-03-06', 'f90fb2539243333ce002c530099abff3582cb901867cb766ab0fd29efcc05e46e3d9f1b09be91ff9214e9eeec0c897ab8da2', 0, 1),
(2, 'Magasin 2', 'Magasin 2', '2020-03-06', '3672486d5cf47e715ad3a25d0b70a49d6c000c50b070a2434830019891745c8425c2b99137fdd1d600da1697c1335ad974bc', 0, 1),
(3, 'Magasin 3', ' Magasin 3', '2020-03-06', 'b088ae64345e5d39d2520b28de23c7aa74e279b7c22572b25341cd49447bd694377a5ae53254050268afb14bb82419622f8e', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE `famille` (
  `idfamille` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `famille`
--

INSERT INTO `famille` (`idfamille`, `libelle`, `etat`, `token`) VALUES
(1, 'Famille 1', 0, '44fc8da3be1f7ec44928c2e1b59ce2a8f074c05fd5277525e09504a4b808c19d9e92364be665c244672ed6520dbca4b0a235'),
(2, 'Famille 2', 0, '4f69779e787a94396cfea2d546bfa62670e7a73055a45672ed3bc2722d3490de76c373eb216862f6ca0b1c69b79225af2eaf'),
(6, 'Famille 3', 0, '9ccf3686b67da91d38bdb1293055c790586d567a80d02f7e7b7c70eb81b1f37368a0915ebb026b333e9badf3cc25dbd61d26');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `idfournisseur` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `situation` text,
  `contact` varchar(10) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL,
  `nomRep` varchar(255) NOT NULL,
  `fonction` varchar(155) NOT NULL,
  `contactPersonnel` varchar(25) NOT NULL,
  `contactProfessionnel` varchar(25) NOT NULL,
  `observation` text NOT NULL,
  `ncc` varchar(25) DEFAULT NULL,
  `rccm` varchar(25) DEFAULT NULL,
  `ncb` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fournisseur`
--

INSERT INTO `fournisseur` (`idfournisseur`, `designation`, `situation`, `contact`, `email`, `etat`, `token`, `nomRep`, `fonction`, `contactPersonnel`, `contactProfessionnel`, `observation`, `ncc`, `rccm`, `ncb`) VALUES
(1, 'Fournisseur 1', ' Situation géographique du fournisseur', '57800439', 'email@email.com', 0, '18b376bf148d8d4ca4c090c94e7d0e01d7176158b73904571a03b106babeb006054c15c61776e07caded3318ebc9e26c7b22', 'YUHL.M', 'tgfuyuhjk', '654865', '64541652', 'Observation', '0123', '4567', '0123456789'),
(2, 'Fournisseur 2', ' Fournisseur 2', '57800439', 'azerty@fbi.us', 0, '911502bc1eb6972c94b1a3da0d4b45c65b6fc20b5b3f0e88be02b86abde78675552b4524aab0983082bd3cc3946fb52b78d7', 'Zié ', 'DG', '05451200', '84200600', 'Observation', NULL, NULL, NULL),
(3, 'SICOMEX', 'Yopougon, Siporex', '75896315', 'info@sicomex.ci', 0, '5d7b49bff6507a9c465e696202e182e763a2031ffcccce242292a016477b3e0081f69a8687e66612b93bec012c70df0e7ed5', 'Coulibaly Malick', 'Commercial', '2589123', '77892130', 'Observation', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

CREATE TABLE `inventaire` (
  `idinventaire` int(11) NOT NULL,
  `identrepot` int(11) NOT NULL,
  `dateinventaire` date NOT NULL,
  `heureinventaire` time NOT NULL,
  `iduser` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `idpaiement` int(10) UNSIGNED NOT NULL,
  `vente_id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `nompayeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `typepaiement` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numerocheque` int(11) DEFAULT NULL,
  `nombanque` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `datepaiement` date NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arretcaisse_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `paiements`
--

INSERT INTO `paiements` (`idpaiement`, `vente_id`, `userid`, `montant`, `nompayeur`, `typepaiement`, `numerocheque`, `nombanque`, `etat`, `datepaiement`, `token`, `arretcaisse_id`) VALUES
(10, 9, 1, 156000, NULL, 'espece', 0, '', 0, '2020-06-10', 'b3bca0f73bfcc3958e7fe8e5a10369642f5a6a6ac43fb66b1b78f6c5e8ea79a5124a05a421133e483190bacd4e20bbf396c2', 6),
(11, 10, 1, 93600, NULL, 'espece', 0, '', 0, '2020-06-10', '46fbce6577c9c85c63a601789c319b7f05bdd63c3bff0088dca965a4d1a196dc1336d8a57fbd08a0aa50fa8abf2c0ec8bdc7', 6);

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `idpersonnel` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `statut` varchar(25) NOT NULL,
  `magasin_id` int(11) NOT NULL,
  `fonction` varchar(100) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personnel`
--

INSERT INTO `personnel` (`idpersonnel`, `nom`, `prenom`, `contact`, `statut`, `magasin_id`, `fonction`, `etat`, `token`) VALUES
(1, 'Coulibaly', 'Malick', '57800439', 'Permanent', 1, 'Informaticien', 0, ''),
(2, 'Coulibaly', 'Yacine', '47755588', 'Permanent', 2, 'Comptable', 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

CREATE TABLE `prix` (
  `idPrix` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `tyclient_id` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `prix`
--

INSERT INTO `prix` (`idPrix`, `produit_id`, `tyclient_id`, `prix`, `etat`, `deleted`) VALUES
(1, 1, 1, 10000, 1, 1),
(2, 1, 2, 8000, 1, 1),
(3, 1, 3, 12000, 1, 1),
(4, 1, 1, 15000, 1, 1),
(5, 1, 2, 12000, 1, 1),
(6, 1, 3, 14000, 1, 1),
(7, 1, 1, 15000, 1, 1),
(8, 1, 2, 12000, 1, 1),
(9, 1, 3, 16000, 1, 1),
(10, 1, 1, 1500, 0, 0),
(11, 1, 2, 1000, 0, 0),
(12, 1, 3, 1200, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `idproduit` int(11) NOT NULL,
  `designation` varchar(155) NOT NULL,
  `information` text NOT NULL,
  `qte` int(11) NOT NULL DEFAULT '0',
  `montant` varchar(15) NOT NULL,
  `montant_revendeur` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `masse` double NOT NULL,
  `idfamille` int(11) NOT NULL,
  `seuil` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`idproduit`, `designation`, `information`, `qte`, `montant`, `montant_revendeur`, `etat`, `masse`, `idfamille`, `seuil`, `token`) VALUES
(1, 'Produit 1', ' ', 0, '1500', 1200, 0, 150.5, 1, 10, '2074efbb90a306c3a42e4be7aaf5ef0e4018f1de68fc5edc75ae39ae032d94ef2d4bee6c0c3477766d8db88825cbc83dcdba'),
(24, 'Produit 2', ' Details', 0, '4500', 4000, 0, 5.24, 1, 5, '36e469bf7f773ea74bd0089168b2783fc7e725c8df6852177c798d2cec5bab7998f3970ce2aa666f077924f76dcaaa02cced'),
(25, 'Produit 3', ' hgvh', 0, '24000', 20000, 0, 20.26, 1, 15, '5ecf526737c31241bc2faf0102a1a19141edca5162a1c1707684c0d26ee15abac1799296f101343c4d2877a66454276524fa'),
(26, 'Ciment', ' Détail', 0, '80000', 78000, 0, 1000, 1, 2, '07b8e7ae9abe2022a690b875df929017e3dc57850d742e97656a940ce00b72088e14edb462a366f6b6cbc0fbf090f7e0ce6f');

-- --------------------------------------------------------

--
-- Structure de la table `proforma`
--

CREATE TABLE `proforma` (
  `idproforma` int(11) NOT NULL,
  `dateemission` date NOT NULL,
  `service_id` int(11) NOT NULL,
  `tva_id` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `remisefacture` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `proforma`
--

INSERT INTO `proforma` (`idproforma`, `dateemission`, `service_id`, `tva_id`, `montant`, `remisefacture`, `etat`, `token`) VALUES
(2, '2020-06-18', 1, 1, 800000, 25000, 0, '366e15a5bb455e6eafbec5c23f9754d4bada01f7b2f2120c7ae272cf7abe778a5c5d430a1214c2a14017203a9c3b78ddab20');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `idservice` int(11) NOT NULL,
  `typeservice` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `delai` int(11) NOT NULL,
  `datedebut` date NOT NULL,
  `dateenregistrement` date NOT NULL,
  `detail` text,
  `client_id` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `services`
--

INSERT INTO `services` (`idservice`, `typeservice`, `adresse`, `delai`, `datedebut`, `dateenregistrement`, `detail`, `client_id`, `montant`, `etat`, `token`) VALUES
(1, 'Aménagement', 'Yopougon Annanerai Cité Batim 3', 20, '2020-06-29', '2020-06-18', 'Détail du chantier', 3, 500000, 0, '578568111cff8b4f9d541d85753bded6e4dd4104c68df7ea92cea3dabad66b49a4e131691cd9d71d1f7fbec0dbec1b0159e2');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `idstock` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `qte` double NOT NULL,
  `prixachat` int(11) NOT NULL,
  `identrepot` int(11) NOT NULL,
  `idbl` int(11) NOT NULL,
  `dateachat` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `stock`
--

INSERT INTO `stock` (`idstock`, `idproduit`, `qte`, `prixachat`, `identrepot`, `idbl`, `dateachat`) VALUES
(7, 25, 0, 17800, 3, 4, '2020-03-11'),
(8, 25, 7, 2500, 1, 5, '2020-03-18'),
(9, 1, 0, 2300, 1, 5, '2020-03-18'),
(4, 25, 0, 1250, 2, 3, '2020-03-11'),
(5, 24, 4, 985, 1, 3, '2020-03-11'),
(6, 1, 0, 880, 1, 3, '2020-03-11'),
(10, 25, 10, 2500, 1, 6, '2020-03-18'),
(11, 1, 0, 2300, 1, 6, '2020-03-18'),
(12, 25, 5, 1500, 1, 7, '2020-04-26'),
(13, 25, 3, 1500, 2, 7, '2020-04-26'),
(14, 25, 2, 1500, 3, 7, '2020-04-26'),
(15, 24, 4, 2000, 1, 7, '2020-04-26'),
(16, 24, 5, 2000, 2, 7, '2020-04-26'),
(17, 24, 0, 2000, 3, 7, '2020-04-26'),
(18, 1, 0, 10000, 1, 1, '2020-05-13'),
(19, 1, 1, 10000, 2, 1, '2020-05-13'),
(20, 1, 0, 10000, 3, 1, '2020-05-13'),
(21, 24, 2, 1500, 1, 1, '2020-05-13'),
(22, 24, 2, 1500, 2, 1, '2020-05-13'),
(23, 24, 2, 1500, 3, 1, '2020-05-13'),
(24, 25, 3, 2000, 1, 1, '2020-05-13'),
(25, 25, 3, 2000, 2, 1, '2020-05-13'),
(26, 25, 3, 2000, 3, 1, '2020-05-13'),
(27, 1, 0, 5000, 1, 4, '2020-06-08'),
(28, 24, 1, 10000, 1, 4, '2020-06-08'),
(29, 24, 1, 10000, 2, 4, '2020-06-08'),
(30, 25, 1, 25000, 1, 4, '2020-06-08'),
(31, 25, 1, 25000, 2, 4, '2020-06-08'),
(32, 25, 1, 25000, 3, 4, '2020-06-08'),
(33, 26, 1, 74800, 3, 4, '2020-06-08'),
(34, 25, 10, 17800, 2, 4, '2020-03-11'),
(35, 25, 10, 1250, 3, 3, '2020-03-11'),
(36, 25, 10, 17800, 2, 4, '2020-03-11'),
(37, 26, 1, 60000, 1, 5, '2020-06-16'),
(38, 1, 9, 800, 1, 5, '2020-06-16');

-- --------------------------------------------------------

--
-- Structure de la table `taxes`
--

CREATE TABLE `taxes` (
  `idtaxe` int(10) UNSIGNED NOT NULL,
  `pourcentage` double NOT NULL,
  `libelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `taxes`
--

INSERT INTO `taxes` (`idtaxe`, `pourcentage`, `libelle`, `etat`, `token`) VALUES
(1, 18, 'TVA', 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

CREATE TABLE `transfert` (
  `idtransfert` int(11) NOT NULL,
  `datetransfert` date NOT NULL,
  `heuretransfert` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `de` int(11) NOT NULL,
  `vers` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `transfert`
--

INSERT INTO `transfert` (`idtransfert`, `datetransfert`, `heuretransfert`, `user_id`, `de`, `vers`, `token`) VALUES
(2, '2020-06-15', '16:35:38', 1, 3, 2, '9e88a13f0322e860256ffcf1685fbb7f22dbad04b694494a6a0e2a97cf50a1652410f197b7ad029031f9890ee425a724115e'),
(3, '2020-06-15', '16:39:05', 1, 2, 3, '0439c49d34815d4f833655a99bca89be2a704ea779c3024c309622903655dae6fc9b5757411b0339593d3150c02a2bdd3f34'),
(4, '2020-06-15', '16:39:37', 1, 3, 2, '30aa0ec9b036b7954069852d008238f806f562cd6105101401e07cf64ec9279d600f34d985c8422c3d17f4cae3702501ee35');

-- --------------------------------------------------------

--
-- Structure de la table `typeclient`
--

CREATE TABLE `typeclient` (
  `idType` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typeclient`
--

INSERT INTO `typeclient` (`idType`, `designation`, `description`, `etat`, `token`) VALUES
(1, 'Ordinaire', 'Client Ordinaire', 0, '25e9a966a2ef023db2f88035698e803e0d567e82da71050b5fb8c5e4c27b59b1c7aceb8b61899064a4747f31fdf9b976af71'),
(2, 'Revendeur', 'Client Revendeur', 0, '267a476d525f0e3310bf5455f62de3d067004e17cd6a9fcabaf813b6a237c85c249db6df51f5fee5ef7203c8dc91d33d945d'),
(3, 'Concurant', 'Client Concurant', 0, '7ff57b0d61052ac5f1b96aaa51b813f92c09b9567fd0d944b355f6a87bf758bc4513a181823488b17aff2896df4ca83998dd');

-- --------------------------------------------------------

--
-- Structure de la table `typecommercial`
--

CREATE TABLE `typecommercial` (
  `idType` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `pourcentage` int(11) NOT NULL DEFAULT '0',
  `etat` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typecommercial`
--

INSERT INTO `typecommercial` (`idType`, `designation`, `pourcentage`, `etat`, `token`) VALUES
(1, 'Type commerciaux 1', 30, 0, 'cdda7d3cb4caa127e627a6d06cf294047d7503578ad2230dd5214fbf46002fc7ae4e1083b637591f18b5b56326143a47c01f'),
(2, 'Type commerciaux 2', 20, 0, '487c14bf0b45110136777de0bb6311bddf8a3b9ecda8dab86402d98c8b93265b120c0924bda9baa7d5c9e4fd589130c72ee4'),
(3, 'Type commerciaux 3', 10, 0, '2e939db16f00e0b649197ede26d612704bab9122cee121e4d165d555cc6d4f5eb394c04d438778172a7ae742d9727a09e0ab');

-- --------------------------------------------------------

--
-- Structure de la table `typedepense`
--

CREATE TABLE `typedepense` (
  `idtypedepense` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `token` varchar(255) NOT NULL,
  `abb` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typedepense`
--

INSERT INTO `typedepense` (`idtypedepense`, `libelle`, `description`, `token`, `abb`) VALUES
(1, 'Enlèvement de Fond', 'Enlèvement de Fond gtfeg ct csahsca', '8b816b455459e5623657850697ad6b7409f13c9e3da171ca940bb9ad7f6e337ce2890d1bf84873002a7934310d4cff64e738', NULL),
(2, 'Frais de route', 'Frais de route', 'bc01c7bbc5dc026a7f28083264e6ba4a763f4ddf6f913377c7e0cb512e3be677e8394b9346547fcb027537a1e5f99705d5e3', NULL),
(3, 'Frais annexe BL', 'Frais annexe BL', '7eb6f6a1f3260f0d1b56f5e924178fcf4e4560d3a7a8ed442d8102f0ff41af997c1abc920781b1883c8e9dd1880ff7231f87', NULL),
(4, 'Versement Banque', 'Versement Banque', '466ab5321268f2b3c6c84a128eba572f7ba663be5cd2585719539771ac7b95fe3c4a78045981fc28159d58dc065d4100b407', 'banque'),
(5, 'Dépense Exploitation', 'Dépense Exploitation', '0837c80f28b5d0dcba8c98f5ef2a68073fc2f13770ac4818f06a288531e949acef1840afff5e943c0f7410df0c684671aab2', 'exp'),
(6, 'Facture Achat', 'Facture Achat', '0837c80f28b5d0dcba8c98f5ef2a68073fc2f13770ac4818f06a288531e949acef1840afff98e943c0f7410df0c684671aab2', 'fa');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$AxHY2jN2/BuQfYFlVWXIHOPYAzlbk6qWFT2dYCg.bTAfmDYryGANu', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1592481524, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(3, '::1', 'malick', '$2y$10$Ai4iguJpKIGiVXjvVMG/reYYGvc/2Hj/SEnDvWP9HG91/OOxd7dQ.', 'admin@admin.come', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1583344154, NULL, 1, 'Coulibaly', 'Malick', 'Développeur', '578222512');

-- --------------------------------------------------------

--
-- Structure de la table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(8, 3, 1),
(9, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `idvente` int(10) UNSIGNED NOT NULL,
  `datevente` date NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `commercial_id` int(11) DEFAULT NULL,
  `tva_id` int(10) UNSIGNED DEFAULT NULL,
  `montant` int(11) NOT NULL,
  `avance` int(11) DEFAULT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `etatlivraison` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remisefacture` int(11) NOT NULL DEFAULT '0',
  `echeance` date DEFAULT NULL,
  `arretcaisse_id` int(11) NOT NULL,
  `datelivraison` date DEFAULT NULL,
  `entrepotlivraison` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `ventes`
--

INSERT INTO `ventes` (`idvente`, `datevente`, `client_id`, `commercial_id`, `tva_id`, `montant`, `avance`, `etat`, `etatlivraison`, `token`, `remisefacture`, `echeance`, `arretcaisse_id`, `datelivraison`, `entrepotlivraison`) VALUES
(12, '2020-06-15', 3, 2, 1, 154500, 0, 0, 1, '0821cca7dff9aafb27e1b0423e07a8c45238aca41dd6e2b45ee8c7b44e504c23dfc92c1c7d44d51be89c445a8509c7fe90b3', 0, '2020-07-12', 10, '2020-06-15', 1),
(13, '2020-06-15', 2, 3, 1, 100000, 0, 0, 0, '519556a85e5aec45df848aed4952cdb56c0529a8ea369f85a1cb70412c2441f4930a1626cd543500dbf28d891ddac83c3894', 0, '2020-07-12', 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `versements`
--

CREATE TABLE `versements` (
  `idversement` int(11) NOT NULL,
  `motifversement` text NOT NULL,
  `dateversement` date NOT NULL,
  `iduser` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `arretcaisse_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `versements`
--

INSERT INTO `versements` (`idversement`, `motifversement`, `dateversement`, `iduser`, `montant`, `token`, `arretcaisse_id`) VALUES
(2, ' Description', '2020-06-10', 1, 15000, '87b8b1b0b140fb5b9f69c2367c8c96ef333fa5d6b21065124784f60466b97a54f628716fd4a2b70347140f213a1db93827e7', 6);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `actioncaisse`
--
ALTER TABLE `actioncaisse`
  ADD PRIMARY KEY (`idac`);

--
-- Index pour la table `argent`
--
ALTER TABLE `argent`
  ADD PRIMARY KEY (`id_argent`),
  ADD KEY `WDIDX13818664400` (`type`);

--
-- Index pour la table `billetage`
--
ALTER TABLE `billetage`
  ADD PRIMARY KEY (`id_billetage`),
  ADD KEY `WDIDX138805108511` (`ac_id`),
  ADD KEY `WDIDX138805108512` (`argent_id`),
  ADD KEY `code_ac2` (`ac_id`,`argent_id`);

--
-- Index pour la table `boncommande`
--
ALTER TABLE `boncommande`
  ADD PRIMARY KEY (`idfacture`);

--
-- Index pour la table `bonlivraison`
--
ALTER TABLE `bonlivraison`
  ADD PRIMARY KEY (`idfacture`);

--
-- Index pour la table `caisse`
--
ALTER TABLE `caisse`
  ADD PRIMARY KEY (`idcaisse`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`idclient`);

--
-- Index pour la table `commerciaux`
--
ALTER TABLE `commerciaux`
  ADD PRIMARY KEY (`idcommercial`);

--
-- Index pour la table `depense`
--
ALTER TABLE `depense`
  ADD PRIMARY KEY (`iddepense`);

--
-- Index pour la table `detailbc`
--
ALTER TABLE `detailbc`
  ADD PRIMARY KEY (`iddetail`);

--
-- Index pour la table `detailbl`
--
ALTER TABLE `detailbl`
  ADD PRIMARY KEY (`iddetail`);

--
-- Index pour la table `detailinventaire`
--
ALTER TABLE `detailinventaire`
  ADD PRIMARY KEY (`iddetail`);

--
-- Index pour la table `detailproforma`
--
ALTER TABLE `detailproforma`
  ADD PRIMARY KEY (`iddetailproforma`);

--
-- Index pour la table `detailtransfert`
--
ALTER TABLE `detailtransfert`
  ADD PRIMARY KEY (`iddetailtransfert`);

--
-- Index pour la table `detailvente`
--
ALTER TABLE `detailvente`
  ADD PRIMARY KEY (`iddetailvente`);

--
-- Index pour la table `entrepot`
--
ALTER TABLE `entrepot`
  ADD PRIMARY KEY (`identrepot`);

--
-- Index pour la table `famille`
--
ALTER TABLE `famille`
  ADD PRIMARY KEY (`idfamille`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`idfournisseur`);

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD PRIMARY KEY (`idinventaire`);

--
-- Index pour la table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`idpaiement`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`idpersonnel`);

--
-- Index pour la table `prix`
--
ALTER TABLE `prix`
  ADD PRIMARY KEY (`idPrix`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`idproduit`);

--
-- Index pour la table `proforma`
--
ALTER TABLE `proforma`
  ADD PRIMARY KEY (`idproforma`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`idservice`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idstock`);

--
-- Index pour la table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`idtaxe`);

--
-- Index pour la table `transfert`
--
ALTER TABLE `transfert`
  ADD PRIMARY KEY (`idtransfert`);

--
-- Index pour la table `typeclient`
--
ALTER TABLE `typeclient`
  ADD PRIMARY KEY (`idType`);

--
-- Index pour la table `typecommercial`
--
ALTER TABLE `typecommercial`
  ADD PRIMARY KEY (`idType`);

--
-- Index pour la table `typedepense`
--
ALTER TABLE `typedepense`
  ADD PRIMARY KEY (`idtypedepense`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Index pour la table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`idvente`);

--
-- Index pour la table `versements`
--
ALTER TABLE `versements`
  ADD PRIMARY KEY (`idversement`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `actioncaisse`
--
ALTER TABLE `actioncaisse`
  MODIFY `idac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `argent`
--
ALTER TABLE `argent`
  MODIFY `id_argent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `billetage`
--
ALTER TABLE `billetage`
  MODIFY `id_billetage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `boncommande`
--
ALTER TABLE `boncommande`
  MODIFY `idfacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `bonlivraison`
--
ALTER TABLE `bonlivraison`
  MODIFY `idfacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `caisse`
--
ALTER TABLE `caisse`
  MODIFY `idcaisse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idclient` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `commerciaux`
--
ALTER TABLE `commerciaux`
  MODIFY `idcommercial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `depense`
--
ALTER TABLE `depense`
  MODIFY `iddepense` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `detailbc`
--
ALTER TABLE `detailbc`
  MODIFY `iddetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `detailbl`
--
ALTER TABLE `detailbl`
  MODIFY `iddetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `detailinventaire`
--
ALTER TABLE `detailinventaire`
  MODIFY `iddetail` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `detailproforma`
--
ALTER TABLE `detailproforma`
  MODIFY `iddetailproforma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `detailtransfert`
--
ALTER TABLE `detailtransfert`
  MODIFY `iddetailtransfert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `detailvente`
--
ALTER TABLE `detailvente`
  MODIFY `iddetailvente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `entrepot`
--
ALTER TABLE `entrepot`
  MODIFY `identrepot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `famille`
--
ALTER TABLE `famille`
  MODIFY `idfamille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `idfournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `inventaire`
--
ALTER TABLE `inventaire`
  MODIFY `idinventaire` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `idpaiement` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `idpersonnel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `prix`
--
ALTER TABLE `prix`
  MODIFY `idPrix` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `idproduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `proforma`
--
ALTER TABLE `proforma`
  MODIFY `idproforma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `idservice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `idstock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `idtaxe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `transfert`
--
ALTER TABLE `transfert`
  MODIFY `idtransfert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `typeclient`
--
ALTER TABLE `typeclient`
  MODIFY `idType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `typecommercial`
--
ALTER TABLE `typecommercial`
  MODIFY `idType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `typedepense`
--
ALTER TABLE `typedepense`
  MODIFY `idtypedepense` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `idvente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `versements`
--
ALTER TABLE `versements`
  MODIFY `idversement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
