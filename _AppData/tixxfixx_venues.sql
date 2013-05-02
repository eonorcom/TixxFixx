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
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VenueID` varchar(45) DEFAULT NULL,
  `VenueName` varchar(256) DEFAULT NULL,
  `VenueDesc` text,
  `VenueType` varchar(45) DEFAULT NULL,
  `Address` varchar(256) DEFAULT NULL,
  `City` varchar(45) DEFAULT NULL,
  `State` varchar(45) DEFAULT NULL,
  `PostalCode` varchar(5) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `Longitude` varchar(45) DEFAULT NULL,
  `Latitude` varchar(45) DEFAULT NULL,
  `AddedOn` datetime DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `UpdatedOn` datetime DEFAULT NULL,
  `UpdatedBy` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

LOCK TABLES `venues` WRITE;
/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
INSERT INTO `venues` VALUES (1,'V0-001-000368423-7','The Reef',NULL,NULL,'105 South Sixth Street','Boise','ID','','United States','-116.2014338','43.6143069','2012-08-28 16:01:15',2,NULL,NULL,1),(2,'V0-001-000206075-9','Liquid Lounge',NULL,NULL,'405 South 8th Street','Boise','ID','','United States','-116.2058629','43.6131638','2012-08-28 16:43:51',2,NULL,NULL,1),(3,'null','null',NULL,NULL,'null','null','null','null','null','null','null','2012-08-28 16:52:08',2,NULL,NULL,1),(4,'V0-001-001140831-3','Neurolux',NULL,NULL,'111 N Eleventh','Boise','ID','','United States','-116.2066458','43.6177801','2012-08-28 16:53:59',2,NULL,NULL,1),(5,'V0-001-000164401-3','John\'s Alley',NULL,NULL,'114 E Sixth Street','Moscow','ID','','United States','-117.0011470','46.7301357','2012-08-28 17:00:49',2,NULL,NULL,1),(6,'V0-001-000257374-9','The Venue',NULL,NULL,'523 Broad St','Boise','ID','','United States','-116.2033222','43.6120239','2012-08-28 17:01:18',2,NULL,NULL,1),(7,'V0-001-006206699-7','Revolution Concert House &amp; Event Center',NULL,NULL,'4983 Glenwood St. Unit 4','Garden City','ID','','United States','-116.2797444','43.6501432','2012-08-28 17:29:13',2,NULL,NULL,1),(8,'V0-001-001502710-7','Idaho Botanical Garden',NULL,NULL,'2355 N Penitentiary Road','Boise','ID','','United States','-116.1638531','43.6024389','2012-08-28 22:18:26',2,NULL,NULL,1),(9,'V0-001-000139485-3','Knitting Factory Concert House',NULL,NULL,'416 S Ninth Street','Boise','ID','','United States','-116.2073485','43.6131935','2012-08-28 22:30:57',2,NULL,NULL,1),(10,'V0-001-003589077-8','Sun Valley Pavilion',NULL,NULL,'300 Dollar Road','Sun Valley','ID','','United States','-114.3505515','43.6909535','2012-08-29 08:40:45',2,NULL,NULL,1),(11,'V0-001-000307781-7','Morrison Center',NULL,NULL,'2201 Cesar Chavez Lane','Boise','ID','','United States','-116.2045700','43.6053621','2012-09-10 06:26:19',1,NULL,NULL,1),(12,'V0-001-000958350-5','Power House Event Center',NULL,NULL,'621 S 17th Street','Boise','ID','83702','null','-116.2186790','-116.2186790','2013-03-29 16:12:05',5,NULL,NULL,1);
/*!40000 ALTER TABLE `venues` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-02  1:17:40
