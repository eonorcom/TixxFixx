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
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EventID` varchar(45) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TicketType` varchar(45) DEFAULT NULL,
  `TicketDesc` varchar(512) DEFAULT NULL,
  `Section` varchar(45) DEFAULT NULL,
  `Row` varchar(45) DEFAULT NULL,
  `Seats` varchar(45) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `Sold` int(11) DEFAULT '0',
  `Price` decimal(10,0) DEFAULT NULL,
  `Splits` varchar(45) DEFAULT NULL,
  `AdditionalInfo` text,
  `eTixx` varchar(45) DEFAULT NULL,
  `FedEx` varchar(45) DEFAULT NULL,
  `WillCall` varchar(45) DEFAULT NULL,
  `Contact` varchar(45) DEFAULT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'E0-001-043942704-6',1,'General','General Seating','null','null','null',10,0,10,'true','',NULL,NULL,NULL,NULL,'2012-09-10 13:33:52',1,NULL,NULL,1),(2,'E0-001-043942704-6',1,'General','VIP','null','null','null',10,0,10,'true','',NULL,NULL,NULL,NULL,'2012-09-10 13:33:52',1,NULL,NULL,1),(3,'E0-001-050415172-2',1,'General','General Seating','null','null','null',10,0,20,'true','Tickets will be available at will call',NULL,NULL,NULL,NULL,'2012-09-10 15:18:00',1,NULL,NULL,1),(4,'E0-001-050415172-2',1,'General','General Seating','null','null','null',4,0,7,'true','',NULL,NULL,NULL,NULL,'2012-09-10 17:32:19',1,NULL,NULL,1),(5,'E0-001-050415172-2',1,'General','General Seating','null','null','null',2,0,31,'true','',NULL,NULL,NULL,NULL,'2012-09-10 17:41:59',1,NULL,NULL,1),(6,'E0-001-050415172-2',1,'General','VIP Section','null','null','null',2,0,50,'true','',NULL,NULL,NULL,NULL,'2012-09-10 18:02:16',1,NULL,NULL,1),(7,'E0-001-043942704-6',1,'General','VIP Section','null','null','null',4,0,20,'true','',NULL,NULL,NULL,NULL,'2012-09-10 18:04:31',1,NULL,NULL,1),(8,'E0-001-049928566-6',1,'General','General Setting','null','null','null',4,0,24,'true','Tickets will be available at will call!',NULL,NULL,NULL,NULL,'2012-09-10 21:38:34',1,NULL,NULL,1),(9,'E0-001-049928566-6',1,'General','VIP Section','null','null','null',2,0,49,'true','',NULL,NULL,NULL,NULL,'2012-09-10 21:38:34',1,NULL,NULL,1),(10,'E0-001-050415172-2',1,'Allocated','Section: AA, Row: 2, Seat(s): 1-4','AA','2','1-4',4,0,30,'false','',NULL,NULL,NULL,NULL,'2012-09-10 21:39:26',1,NULL,NULL,1),(11,'E0-001-052872832-6',1,'General','General Admission','null','null','null',10,0,25,'true','','false','false','false','true','2013-02-25 18:31:46',1,NULL,NULL,1),(12,'E0-001-052872832-6',1,'General','General Admission','null','null','null',10,0,20,'true','','false','false','false','true','2013-02-25 18:37:01',1,NULL,NULL,1),(13,'E0-001-052872832-6',1,'General','Tet','null','null','null',20,0,20,'true','','false','false','false','true','2013-02-25 18:38:42',1,NULL,NULL,1),(14,'E0-001-052590758-8',1,'General','GA','null','null','null',2,0,50,'true','','false','false','false','true','2013-02-28 16:54:36',1,NULL,NULL,1),(15,'E0-001-052530352-4',5,'Allocated','Section: Main Floor, Row: C, Seat(s): 7','Main Floor','C','7',1,0,75,'true','','false','false','false','true','2013-02-28 17:22:23',5,NULL,NULL,1),(16,'E0-001-046138673-1@2013032919',1,'General','Test','null','null','null',100,1,0,'true','','true','true','false','false','2013-03-29 15:22:47',1,NULL,NULL,5),(17,'E-EA411E-6EF-9F4EF4F6',1,'General','General Admission','null','null','null',500,5,15,'true','','false','false','true','false','2013-04-03 00:31:48',1,NULL,NULL,1),(18,'E-EA411E-6EF-9F4EF4F6',1,'General','VIP','null','null','null',100,2,30,'true','','false','false','true','false','2013-04-03 00:31:48',1,NULL,NULL,1);
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

-- Dump completed on 2013-05-02  1:17:41
