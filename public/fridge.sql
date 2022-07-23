-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: fridge
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.19-MariaDB-1:10.4.19+maria~focal

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
-- Table structure for table `consumption_date`
--

DROP TABLE IF EXISTS `consumption_date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consumption_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_676E5DED126F525E` (`item_id`),
  CONSTRAINT `FK_676E5DED126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumption_date`
--

LOCK TABLES `consumption_date` WRITE;
/*!40000 ALTER TABLE `consumption_date` DISABLE KEYS */;
INSERT INTO `consumption_date` VALUES (213,'398ea553-a75c-4d31-a0c7-a16010d0cd72','2022-07-27'),(214,'4031b40a-869d-4425-a611-e02747379cdd','2022-07-27'),(215,'5a689291-354e-4669-ad76-20bf930f75c7','2022-07-28'),(216,'762b5fb4-4241-47f6-9dcd-976b3bfcdf91','2022-07-28'),(217,'c71eda2e-1aed-41e6-973d-a4bd76fc2c4f','2022-07-28'),(218,'cfd7da32-5a48-447a-bd23-78af8b7fe480','2022-07-29');
/*!40000 ALTER TABLE `consumption_date` ENABLE KEYS */;
UNLOCK TABLES;
