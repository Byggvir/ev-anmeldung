-- MySQL dump 10.17  Distrib 10.3.25-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: evservices
-- ------------------------------------------------------
-- Server version	10.3.25-MariaDB-0+deb10u1

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
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PIN` bigint(20) DEFAULT NULL,
  `Firstname` char(255) DEFAULT NULL,
  `Name` char(255) DEFAULT NULL,
  `Street` char(64) DEFAULT NULL,
  `PostalCode` char(16) DEFAULT '53359',
  `City` char(64) DEFAULT 'Rheinbach',
  `EMail` char(255) DEFAULT NULL,
  `Phone` char(16) DEFAULT '02226-',
  `Konfirmand` tinyint(1) DEFAULT 0,
  `DonotDelete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `PIN` (`PIN`),
  KEY `Firstname` (`Firstname`),
  KEY `Name` (`Name`),
  KEY `Street` (`Street`),
  KEY `PostalCode` (`PostalCode`),
  KEY `City` (`City`),
  KEY `Phone` (`Phone`),
  KEY `EMail` (`EMail`),
  KEY `Konfirmand` (`Konfirmand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventgroups`
--

DROP TABLE IF EXISTS `eventgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventgroups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` char(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventgroups`
--

LOCK TABLES `eventgroups` WRITE;
/*!40000 ALTER TABLE `eventgroups` DISABLE KEYS */;
INSERT INTO `eventgroups` VALUES (1,'Sonntags-Gottesdienste'),(2,'Gottesdienste');
/*!40000 ALTER TABLE `eventgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) DEFAULT NULL,
  `Starttime` datetime DEFAULT NULL,
  `Endtime` datetime DEFAULT NULL,
  `Title` char(64) DEFAULT NULL,
  `Subtitle` char(64) DEFAULT NULL,
  `SeatCapacity` int(11) DEFAULT 10,
  `ReservedSeats` int(11) DEFAULT 0,
  `MaxGroups` int(11) DEFAULT 2,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  KEY `Starttime` (`Starttime`),
  KEY `Endtime` (`Endtime`),
  KEY `Title` (`Title`),
  KEY `Subtitle` (`Subtitle`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `eventgroups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,1,'2020-11-08 10:00:00','2020-11-08 10:45:00','Gottesdienst','Trinitatis',60,3,40),(2,1,'2020-11-15 10:00:00','2020-11-15 10:45:00','Gottesdienst','Trinitatis',60,3,40),(3,1,'2020-11-22 10:00:00','2020-11-22 10:45:00','Gottesdienst','Trinitatis',60,3,40),(4,1,'2020-11-15 10:00:00','2020-11-15 11:00:00','Gottesdienst','Vorletzter Sonntag d. Kj.',90,0,90),(5,1,'2020-11-22 10:00:00','2020-11-22 11:00:00','Gottesdienst','Letzter Sonntag d. Kj.',90,0,90),(6,1,'2020-11-29 10:00:00','2020-11-29 11:00:00','Gottesdienst','1. Advent',90,0,90),(7,1,'2020-12-06 10:00:00','2020-11-06 11:00:00','Gottesdienst','2. Advent',90,0,90),(8,1,'2020-12-13 10:00:00','2020-11-13 11:00:00','Gottesdienst','3. Advent',90,0,90),(9,1,'2020-12-20 10:00:00','2020-11-20 11:00:00','Gottesdienst','3. Advent',90,0,90);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seats`
--

DROP TABLE IF EXISTS `seats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seats` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eid` bigint(20) DEFAULT NULL,
  `Name` char(16) DEFAULT NULL,
  `Number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seats`
--

LOCK TABLES `seats` WRITE;
/*!40000 ALTER TABLE `seats` DISABLE KEYS */;
/*!40000 ALTER TABLE `seats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eid` bigint(20) DEFAULT NULL,
  `cid` bigint(20) DEFAULT NULL,
  `reserved` tinyint(1) DEFAULT 0,
  `Confirmed` tinyint(1) DEFAULT 0,
  `Canceled` tinyint(1) DEFAULT 0,
  `Seats` bigint(20) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`),
  KEY `cid` (`cid`),
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `eventgroup` (`id`),
  CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `contacts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-13 18:57:39
