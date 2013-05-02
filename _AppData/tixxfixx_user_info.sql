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
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `FirstName` varchar(256) DEFAULT NULL,
  `LastName` varchar(256) DEFAULT NULL,
  `Address1` varchar(256) DEFAULT NULL,
  `Address2` varchar(256) DEFAULT NULL,
  `City` varchar(256) DEFAULT NULL,
  `State` varchar(256) DEFAULT NULL,
  `Zip` varchar(56) DEFAULT NULL,
  `Phone` varchar(256) DEFAULT NULL,
  `Email` varchar(256) DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (1,1,'Ryan','Riley','2150 N. Hickory Way','','Meridian','Idaho','83646','208-550-8852','block2150@gmail.com','2013-03-29 15:23:36','2013-03-29 15:31:39'),(2,1,'Ryan','Riley','2150 N. Hickory Way','','Meridian','Idaho','83646','208-550-8852','block2150@gmail.com','2013-03-29 15:31:39','2013-04-03 00:36:25'),(3,5,'Darron','Smith','4272 E. Stonebridge Dr','','Meridian','ID','83642','208-284-4358','darronsmith108@hotmail.com','2013-04-03 00:35:40','2013-04-03 10:34:43'),(4,1,'Ryan','Riley','2150 N. Hickory Way','','Meridian','Idaho','83646','208-550-8852','block2150@gmail.com','2013-04-03 00:36:25','2013-04-03 01:50:27'),(5,1,'Ryan','Riley','2150 N. Hickory Way','','Meridian','Idaho','83646','208-550-8852','block2150@gmail.com','2013-04-03 01:50:27','2013-04-03 09:49:57'),(6,1,'Ryan','Riley','2150 N. Hickory Way','','Meridian','Idaho','83646','208-550-8852','block2150@gmail.com','2013-04-03 09:49:57','2013-04-03 10:15:52'),(7,1,'Ryan','Riley','2150 N. Hickory Way','','Meridian','Idaho','83646','208-550-8852','block2150@gmail.com','2013-04-03 10:15:52','2013-04-03 10:42:40'),(8,5,'Darron','Smith','4272 E. Stonebridge Dr','','Meridian','ID','83642','208-284-4358','darronsmith108@hotmail.com','2013-04-03 10:34:43',NULL),(9,1,'Ryan','Riley','2150 N. Hickory Way','','Meridian','Idaho','83646','208-550-8852','block2150@gmail.com','2013-04-03 10:42:40',NULL),(10,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-07 09:41:57','2013-04-07 09:43:58'),(11,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-07 09:43:58','2013-04-07 09:47:21'),(12,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-07 09:47:21','2013-04-07 09:53:02'),(13,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-07 09:53:02','2013-04-07 09:53:58'),(14,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-07 09:53:58','2013-04-07 09:54:26'),(15,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-07 09:54:26','2013-04-08 08:41:39'),(16,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-08 08:41:39','2013-04-08 22:20:04'),(17,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-08 22:20:04','2013-04-08 22:20:54'),(18,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-08 22:20:54','2013-04-08 23:39:58'),(19,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-08 23:39:58','2013-04-09 23:05:25'),(20,8,'Frankie ','Negrette','6806 S Southdale Ave','','Boise','Id','83709','208-250-9578','superstud1@mail.com','2013-04-09 19:24:50','2013-04-09 19:25:53'),(21,8,'Frankie ','Negrette','6806 S Southdale Ave','','Boise','Id','83709','208-250-9578','superstud1@mail.com','2013-04-09 19:25:53',NULL),(22,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-09 23:05:25','2013-04-09 23:17:42'),(23,6,'Jane','Davis','2452 Columbia Ave NW Unit 17','','East Wenatchee','WA','98802','509-885-2010','janesharpsharp@hotmail.com','2013-04-09 23:17:42',NULL),(24,10,'TJ','Thomson','12451 W. Abram Dr.','','Boise','ID','83713','208-559-6010','tj4idaho@hotmail.com','2013-04-17 12:50:16',NULL),(25,12,'Kimberly','Cochrane','525 Bitteroot Drive','','Boise','Idaho','83709','1-208-230-4375','kimcollage@hotmail.com','2013-04-17 17:14:45','2013-04-19 18:40:59'),(26,12,'Kimberly','Cochrane','525 Bitteroot Drive','','Boise','Idaho','83709','1-208-230-4375','kimcollage@hotmail.com','2013-04-19 18:40:59','2013-04-19 18:43:23'),(27,12,'Kimberly','Cochrane','525 Bitteroot Drive','','Boise','Idaho','83709','1-208-230-4375','kimcollage@hotmail.com','2013-04-19 18:43:23',NULL),(28,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:05:43','2013-04-20 11:13:53'),(29,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:13:53','2013-04-20 11:16:39'),(30,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:16:39','2013-04-20 11:20:08'),(31,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:20:08','2013-04-20 11:22:16'),(32,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:22:16','2013-04-20 11:26:37'),(33,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:26:37','2013-04-20 11:33:41'),(34,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:33:41','2013-04-20 11:36:37'),(35,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83647','210-693-9700','bradday@gmail.com','2013-04-20 11:36:37','2013-04-20 11:38:23'),(36,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83648','210-693-9700','bradday@gmail.com','2013-04-20 11:38:23','2013-04-20 11:42:01'),(37,14,'Bradley','Day','495 S. 2nd East','','Mountain Home','ID','83648','210-693-9700','bradday@gmail.com','2013-04-20 11:42:01',NULL),(38,15,'Stephanie','Leraris','3977 N. Buckstone Ave','','Meridian','Id','83646','208.631.9217','stephanie.leraris@gmail.com','2013-04-20 15:16:55','2013-04-20 15:22:39'),(39,15,'Stephanie','Leraris','3977 N. Buckstone Ave','','Meridian','Id','83646','208.631.9217','stephanie.leraris@gmail.com','2013-04-20 15:22:39',NULL),(40,16,'Jessica ','Rios','506 S Benjamin Ave','','Boise','Idaho','83709','2082199192','jessica_rios05@yahoo.com','2013-04-21 10:14:08','2013-04-21 10:16:56'),(41,16,'Jessica ','Rios','506 S Benjamin Ave','','Boise','Idaho','83709','2082199192','jessica_rios05@yahoo.com','2013-04-21 10:16:56','2013-04-21 10:20:35'),(42,16,'Jessica ','Rios','506 S Benjamin Ave','','Boise','Idaho','83709','2082199192','jessica_rios05@yahoo.com','2013-04-21 10:20:35','2013-04-21 10:27:29'),(43,16,'Jessica ','Rios','506 S Benjamin Ave','','Boise','Idaho','83709','2082199192','jessica_rios05@yahoo.com','2013-04-21 10:27:29','2013-04-21 10:29:13'),(44,16,'Jessica ','Rios','506 S Benjamin Ave','','Boise','Idaho','83709','2082199192','jessica_rios05@yahoo.com','2013-04-21 10:29:13',NULL);
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
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
