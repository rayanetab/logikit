-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: logikit
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asset`
--

DROP TABLE IF EXISTS `asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset`
--

LOCK TABLES `asset` WRITE;
/*!40000 ALTER TABLE `asset` DISABLE KEYS */;
INSERT INTO `asset` VALUES (1,'LP-2024-001','Dell','Latitude 5420','retired','2026-02-02 01:02:00'),(2,'HP-2024-002','HP','EliteBook 840','maintenance','2026-04-27 09:28:00'),(3,'MBP-2024-003','Apple','MacBook Pro 14','assigned','2026-04-27 12:44:00'),(4,'LN-2024-004','Lenovo','ThinkPad X1','available','2026-04-27 12:34:00');
/*!40000 ALTER TABLE `asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignment`
--

DROP TABLE IF EXISTS `assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assigned_at` datetime NOT NULL,
  `returned_at` datetime DEFAULT NULL,
  `pdf_filename` varchar(255) DEFAULT NULL,
  `user_id` int NOT NULL,
  `asset_id` int DEFAULT NULL,
  `consumable_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_30C544BAA76ED395` (`user_id`),
  KEY `IDX_30C544BA5DA1941` (`asset_id`),
  KEY `IDX_30C544BAA94ADB61` (`consumable_id`),
  CONSTRAINT `FK_30C544BA5DA1941` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`id`),
  CONSTRAINT `FK_30C544BAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_30C544BAA94ADB61` FOREIGN KEY (`consumable_id`) REFERENCES `consumable` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignment`
--

LOCK TABLES `assignment` WRITE;
/*!40000 ALTER TABLE `assignment` DISABLE KEYS */;
INSERT INTO `assignment` VALUES (1,'2026-04-22 12:05:00','2026-05-12 12:33:00',NULL,2,1,NULL),(2,'2026-04-22 12:13:00','2026-05-12 12:30:00',NULL,2,1,NULL),(3,'2026-04-24 11:41:00','2026-06-12 12:24:00',NULL,2,1,NULL),(4,'2026-04-24 11:45:00','2026-07-12 12:20:00',NULL,2,1,NULL),(5,'2026-04-27 08:32:00',NULL,NULL,3,2,NULL),(6,'2026-04-27 08:34:00',NULL,NULL,4,3,NULL),(7,'2026-04-27 08:35:00',NULL,NULL,4,NULL,1);
/*!40000 ALTER TABLE `assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consumable`
--

DROP TABLE IF EXISTS `consumable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consumable` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `stock_quantity` int NOT NULL,
  `stock_alert_threshold` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumable`
--

LOCK TABLES `consumable` WRITE;
/*!40000 ALTER TABLE `consumable` DISABLE KEYS */;
INSERT INTO `consumable` VALUES (1,'souris hp',4,5);
/*!40000 ALTER TABLE `consumable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20260420112752','2026-04-20 11:30:55',421),('DoctrineMigrations\\Version20260420114820','2026-04-20 11:50:49',638),('DoctrineMigrations\\Version20260422121759','2026-04-22 12:18:30',66);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int NOT NULL,
  `asset_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_27BA704BA76ED395` (`user_id`),
  KEY `IDX_27BA704B5DA1941` (`asset_id`),
  CONSTRAINT `FK_27BA704B5DA1941` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`id`),
  CONSTRAINT `FK_27BA704BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,'Statut changé en : maintenance','2026-04-22 12:36:04',2,1),(2,'Attribution créée pour IT Admin','2026-04-24 11:42:23',2,1),(3,'Attribution créée pour IT Admin','2026-04-24 11:45:56',2,1),(4,'Statut changé en : assigned','2026-04-27 08:33:48',2,2),(5,'Attribution créée pour Sophie Dupont','2026-04-27 08:33:48',2,2),(6,'Statut changé en : assigned','2026-04-27 08:34:37',2,3),(7,'Attribution créée pour Thomas Martin','2026-04-27 08:34:37',2,3),(8,'Attribution créée pour Thomas Martin','2026-04-27 08:35:17',2,NULL),(9,'Statut changé en : retired','2026-04-28 14:38:29',3,1),(10,'Statut changé en : maintenance','2026-04-28 14:41:37',2,2);
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` json NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `manager_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'admin@logikit.fr','$2y$13$x4Ef17MmVoM0EhXZv6BfdeFP5l3u1OnkPP15Tf0aSg0DXm3saFKjW','[\"ROLE_ADMIN\"]','Admin','IT',NULL),(3,'manager@logikit.fr','$2y$13$eCgzeBYKnyiUGiHvq7eb9uy4l6rcu.OCWWkYR5JN3nM0DEwJ9f1tK','[\"ROLE_MANAGER\"]','Dupont','Sophie',NULL),(4,'user@logikit.fr','$2y$13$iVXqNlKzXofgQ63ROUVzk.AL852C7UR/plSmvztSrq5/0N9D3uM16','[]','Martin','Thomas',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-30  9:09:26
