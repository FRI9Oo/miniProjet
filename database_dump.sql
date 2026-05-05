-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: emplois_du_temps
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `emploi_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_emploi_id_foreign` (`emploi_id`),
  CONSTRAINT `activity_logs_emploi_id_foreign` FOREIGN KEY (`emploi_id`) REFERENCES `emplois_du_temps` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creneaux`
--

DROP TABLE IF EXISTS `creneaux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `creneaux` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jour` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi') NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `creneaux_jour_heure_debut_heure_fin_unique` (`jour`,`heure_debut`,`heure_fin`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creneaux`
--

LOCK TABLES `creneaux` WRITE;
/*!40000 ALTER TABLE `creneaux` DISABLE KEYS */;
INSERT INTO `creneaux` VALUES (1,'Lundi','08:30:00','10:30:00','Créneau 1 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(2,'Lundi','10:45:00','12:45:00','Créneau 2 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(3,'Lundi','14:00:00','16:00:00','Créneau 3 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(4,'Lundi','16:15:00','18:15:00','Créneau 4 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(5,'Mardi','08:30:00','10:30:00','Créneau 1 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(6,'Mardi','10:45:00','12:45:00','Créneau 2 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(7,'Mardi','14:00:00','16:00:00','Créneau 3 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(8,'Mardi','16:15:00','18:15:00','Créneau 4 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(9,'Mercredi','08:30:00','10:30:00','Créneau 1 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(10,'Mercredi','10:45:00','12:45:00','Créneau 2 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(11,'Mercredi','14:00:00','16:00:00','Créneau 3 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(12,'Mercredi','16:15:00','18:15:00','Créneau 4 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(13,'Jeudi','08:30:00','10:30:00','Créneau 1 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(14,'Jeudi','10:45:00','12:45:00','Créneau 2 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(15,'Jeudi','14:00:00','16:00:00','Créneau 3 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(16,'Jeudi','16:15:00','18:15:00','Créneau 4 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(17,'Vendredi','08:30:00','10:30:00','Créneau 1 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(18,'Vendredi','10:45:00','12:45:00','Créneau 2 - Matin','2026-05-05 13:53:34','2026-05-05 13:53:34'),(19,'Vendredi','14:00:00','16:00:00','Créneau 3 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34'),(20,'Vendredi','16:15:00','18:15:00','Créneau 4 - Après-midi','2026-05-05 13:53:34','2026-05-05 13:53:34');
/*!40000 ALTER TABLE `creneaux` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emplois_du_temps`
--

DROP TABLE IF EXISTS `emplois_du_temps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emplois_du_temps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filiere_id` bigint(20) unsigned NOT NULL,
  `enseignant_id` bigint(20) unsigned NOT NULL,
  `salle_id` bigint(20) unsigned NOT NULL,
  `matiere_id` bigint(20) unsigned NOT NULL,
  `creneau_id` bigint(20) unsigned NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_enseignant_creneau` (`enseignant_id`,`creneau_id`),
  UNIQUE KEY `unique_salle_creneau` (`salle_id`,`creneau_id`),
  UNIQUE KEY `unique_filiere_creneau` (`filiere_id`,`creneau_id`),
  KEY `emplois_du_temps_matiere_id_foreign` (`matiere_id`),
  KEY `emplois_du_temps_creneau_id_foreign` (`creneau_id`),
  CONSTRAINT `emplois_du_temps_creneau_id_foreign` FOREIGN KEY (`creneau_id`) REFERENCES `creneaux` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emplois_du_temps_enseignant_id_foreign` FOREIGN KEY (`enseignant_id`) REFERENCES `enseignants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emplois_du_temps_filiere_id_foreign` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emplois_du_temps_matiere_id_foreign` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emplois_du_temps_salle_id_foreign` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emplois_du_temps`
--

LOCK TABLES `emplois_du_temps` WRITE;
/*!40000 ALTER TABLE `emplois_du_temps` DISABLE KEYS */;
INSERT INTO `emplois_du_temps` VALUES (1,1,1,1,1,1,NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(2,2,3,2,3,1,NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(3,1,2,1,2,2,NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(4,2,5,3,4,5,NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(5,3,4,4,5,6,NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34');
/*!40000 ALTER TABLE `emplois_du_temps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enseignants`
--

DROP TABLE IF EXISTS `enseignants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enseignants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `specialite` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enseignants_email_unique` (`email`),
  KEY `enseignants_user_id_foreign` (`user_id`),
  CONSTRAINT `enseignants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enseignants`
--

LOCK TABLES `enseignants` WRITE;
/*!40000 ALTER TABLE `enseignants` DISABLE KEYS */;
INSERT INTO `enseignants` VALUES (1,NULL,'Laassem','Brahim','b.laassem@ensiasd.ma','0612000001','Développement Web','2026-05-05 13:53:34','2026-05-05 13:53:34'),(2,NULL,'Alaoui','Fatima','f.alaoui@ensiasd.ma','0612000002','Base de Données','2026-05-05 13:53:34','2026-05-05 13:53:34'),(3,NULL,'Bennani','Youssef','y.bennani@ensiasd.ma','0612000003','Algorithmique','2026-05-05 13:53:34','2026-05-05 13:53:34'),(4,NULL,'Chakir','Sara','s.chakir@ensiasd.ma','0612000004','Mathématiques','2026-05-05 13:53:34','2026-05-05 13:53:34'),(5,NULL,'El Idrissi','Hamza','h.elidrissi@ensiasd.ma','0612000005','Réseaux & Systèmes','2026-05-05 13:53:34','2026-05-05 13:53:34');
/*!40000 ALTER TABLE `enseignants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filiere_matiere`
--

DROP TABLE IF EXISTS `filiere_matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filiere_matiere` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filiere_id` bigint(20) unsigned NOT NULL,
  `matiere_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filiere_matiere_filiere_id_matiere_id_unique` (`filiere_id`,`matiere_id`),
  KEY `filiere_matiere_matiere_id_foreign` (`matiere_id`),
  CONSTRAINT `filiere_matiere_filiere_id_foreign` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `filiere_matiere_matiere_id_foreign` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filiere_matiere`
--

LOCK TABLES `filiere_matiere` WRITE;
/*!40000 ALTER TABLE `filiere_matiere` DISABLE KEYS */;
/*!40000 ALTER TABLE `filiere_matiere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filieres`
--

DROP TABLE IF EXISTS `filieres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filieres` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `semestre` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filieres_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filieres`
--

LOCK TABLES `filieres` WRITE;
/*!40000 ALTER TABLE `filieres` DISABLE KEYS */;
INSERT INTO `filieres` VALUES (1,'MGSI','MGSI-S6',6,'Management et Génie des Systèmes Informatiques','2026-05-05 13:53:34','2026-05-05 13:53:34'),(2,'Informatique','INFO-S6',6,'Génie Informatique','2026-05-05 13:53:34','2026-05-05 13:53:34'),(3,'Mathématiques','MATH-S6',6,'Mathématiques Appliquées','2026-05-05 13:53:34','2026-05-05 13:53:34');
/*!40000 ALTER TABLE `filieres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matieres` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `volume_horaire` double NOT NULL DEFAULT 0,
  `type` enum('cours','td','tp') NOT NULL DEFAULT 'cours',
  `filiere_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matieres_code_unique` (`code`),
  KEY `matieres_filiere_id_foreign` (`filiere_id`),
  CONSTRAINT `matieres_filiere_id_foreign` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matieres`
--

LOCK TABLES `matieres` WRITE;
/*!40000 ALTER TABLE `matieres` DISABLE KEYS */;
INSERT INTO `matieres` VALUES (1,'Développement Web','DW101',45,'cours',1,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(2,'Base de Données','BD101',40,'cours',1,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(3,'Algorithmique','ALG101',35,'cours',2,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(4,'Réseaux','RES101',30,'cours',2,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(5,'Analyse Mathématique','ANA101',50,'cours',3,'2026-05-05 13:53:34','2026-05-05 13:53:34');
/*!40000 ALTER TABLE `matieres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_02_224042_create_enseignants_table',1),(5,'2026_05_02_224118_create_filieres_table',1),(6,'2026_05_02_224125_create_salles_table',1),(7,'2026_05_02_224131_create_matieres_table',1),(8,'2026_05_02_224136_create_creneaux_table',1),(9,'2026_05_02_224154_create_emplois_du_temps_table',1),(10,'2026_05_02_224159_add_role_to_users_table',1),(11,'2026_05_05_002037_create_filiere_matiere_table',1),(12,'2026_05_05_013541_add_user_id_to_enseignants',1),(13,'2026_05_05_134753_create_activity_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salles`
--

DROP TABLE IF EXISTS `salles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `capacite` int(11) NOT NULL DEFAULT 30,
  `type` enum('cours','td','tp','amphi') NOT NULL DEFAULT 'cours',
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `salles_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salles`
--

LOCK TABLES `salles` WRITE;
/*!40000 ALTER TABLE `salles` DISABLE KEYS */;
INSERT INTO `salles` VALUES (1,'Salle A1','A1',35,'cours',1,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(2,'Salle A2','A2',35,'cours',1,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(3,'Labo Info','LAB1',25,'tp',1,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(4,'Amphithéâtre','AMPHI',120,'amphi',1,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(5,'Salle TD1','TD1',20,'td',1,'2026-05-05 13:53:34','2026-05-05 13:53:34');
/*!40000 ALTER TABLE `salles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('JQ17Axi2XFW67JnvUdoQxlvi9anU8TfjvtcUQGDD',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieEF3OG5JcFJtVVBjcFUwRlhoOVZZZnpxYTF3YkhZbVpPUGRkV21kWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1777994295);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','enseignant','etudiant') NOT NULL DEFAULT 'etudiant',
  `enseignant_id` bigint(20) unsigned DEFAULT NULL,
  `filiere_id` bigint(20) unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_enseignant_id_foreign` (`enseignant_id`),
  KEY `users_filiere_id_foreign` (`filiere_id`),
  CONSTRAINT `users_enseignant_id_foreign` FOREIGN KEY (`enseignant_id`) REFERENCES `enseignants` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_filiere_id_foreign` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrateur','admin@ensiasd.ma','admin',NULL,NULL,NULL,'$2y$12$0SiivDPzrT8zK8hIBg2aWucbIuVM3gbcCGYaKD/payUpF0CveZZUy',NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(2,'Laassem Brahim','b.laassem@ensiasd.ma','enseignant',1,NULL,NULL,'$2y$12$1bd4QfKJqAeLes6e.UcQUOR2VFEqj5NFDIYfezS/uF5TTGklEDB3.',NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34'),(3,'Rokia Lemouda','r.lemouda@ensiasd.ma','etudiant',NULL,1,NULL,'$2y$12$A1YS4ulDyVxyli/Fd13Qiuaqh/8s8ph.Sx6VxrXv5xpK2O3pLJ.cK',NULL,'2026-05-05 13:53:34','2026-05-05 13:53:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-05 18:49:20
