CREATE DATABASE  IF NOT EXISTS `tixxfixx` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tixxfixx`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: tixxfixx
-- ------------------------------------------------------
-- Server version	5.5.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `data_categories`
--

DROP TABLE IF EXISTS `data_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_categories` (
  `Namespace` varchar(45) NOT NULL,
  `Description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`Namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_categories`
--

LOCK TABLES `data_categories` WRITE;
/*!40000 ALTER TABLE `data_categories` DISABLE KEYS */;
INSERT INTO `data_categories` VALUES ('business','Business &amp; Networking'),('clubs_associations','Organizations &amp; Meetups'),('community','Neighborhood'),('conference','Conferences &amp; Tradeshows'),('family_fun_kids','Kids &amp; Family'),('fashion-show','Fashion Show'),('festivals_parades','Festivals'),('food','Food &amp; Wine'),('fundraisers','Fundraising &amp; Charity'),('learning_education','Education'),('music','Concerts &amp; Tour Dates'),('other','Other &amp; Miscellaneous'),('outdoors_recreation','Outdoors &amp; Recreation'),('performing_arts','Performing Arts'),('religion_spirituality','Religion &amp; Spirituality'),('schools_alumni','University &amp; Alumni'),('singles_social','Nightlife &amp; Singles'),('sports','Sports'),('support','Health &amp; Wellness');
/*!40000 ALTER TABLE `data_categories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-02  1:17:41
