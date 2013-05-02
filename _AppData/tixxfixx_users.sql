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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) DEFAULT NULL,
  `oauth_uid` varchar(200) DEFAULT NULL,
  `oauth_provider` varchar(200) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `profile_image` varchar(200) DEFAULT '/images/artist-no-image.png',
  `twitter_oauth_token` varchar(200) DEFAULT NULL,
  `twitter_oauth_token_secret` varchar(200) DEFAULT NULL,
  `contributor` int(11) DEFAULT '0',
  `LastLogin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ryan@solutionx.com','1146851865','facebook','block2150','Ryan Riley','Meridian, Idaho','/images/artist-no-image.png','','',1,'2013-04-23 10:58:52'),(2,'braydenrockin@gmail.com','100002651439862','facebook','braydenrockin','Brayden Riley','','/images/artist-no-image.png','','',0,'2012-10-06 13:39:18'),(3,'','839470470','twitter','Taylor3316','Taylor','','/images/artist-no-image.png','WJzHvj048Gj8lOE1yJEGzRqqvDLl3ZvlXbcjvfiDo','7tCnIpbWgmaNnp5jFOyGoD7e34FgtqUFeVWb6ryJw',0,'2012-11-14 19:11:12'),(4,'4rileyboys@gmail.com','1442683185','facebook','4rileyboys','Christina Woolley Riley','Meridian, Idaho','/images/artist-no-image.png','','',0,'2012-12-28 17:41:24'),(5,'darronsmith108@hotmail.com','1158365664','facebook','darron.l.smith','Darron Lee Smith','','/images/artist-no-image.png','','',1,'2013-04-23 15:22:58'),(6,'janesharpsharp@hotmail.com','1645701978','facebook','jane.davis.125','Jane Davis','East Wenatchee, Washington','/images/artist-no-image.png','','',0,'2013-04-09 23:16:57'),(7,'brianshields00@yahoo.com','512453193','facebook','iamBrianShields','Brian Shields','','/images/artist-no-image.png','','',0,'2013-04-08 14:28:48'),(8,'superstud1@mail.com','1064428910','facebook','frankie.negrette','Frankie Negrette','Boise, Idaho','/images/artist-no-image.png','','',0,'2013-04-09 19:20:29'),(9,'nancykummer18@gmail.com','100004965185976','facebook','nancy.kummer.35','Nancy Kummer','Boise, Idaho','/images/artist-no-image.png','','',0,'2013-04-13 12:14:20'),(10,'tj4idaho@hotmail.com','624096933','facebook','tjthomson','TJ Thomson','Boise, Idaho','/images/artist-no-image.png','','',0,'2013-04-17 12:53:50'),(11,'astemple@micron.com','52305860','facebook','alyssa.stemple','Alyssa Stemple','','/images/artist-no-image.png','','',0,'2013-04-17 13:53:50'),(12,'kimcollage@hotmail.com','100001636165186','facebook','kimberly.cochrane.5','Kimberly Cochrane','Boise, Idaho','/images/artist-no-image.png','','',0,'2013-04-17 17:12:03'),(13,'','44419201','twitter','vonthadentweets','Andrew Von Thaden','Indiana, U.S.A.','/images/artist-no-image.png','UFWU2cuLw07nhOFkmNKJ1JEfteXNOyZidguGFhsu6o','0p25AlXuwShXdaTPGnuSq8v9InVJe05gHJxfbbEnJw',0,'2013-04-19 08:32:13'),(14,'bradday@gmail.com','1359575443','facebook','brad.day.14','Brad Day','','/images/artist-no-image.png','','',0,'2013-04-20 11:13:27'),(15,'stephanie.leraris@gmail.com','52300879','facebook','stephanie.leraris','Stephanie Stroschein Leraris','','/images/artist-no-image.png','','',0,'2013-04-20 15:20:34'),(16,'jessica_rios05@yahoo.com','1276828573','facebook','jessica.rios.1671','Jessica Rios','Boise, Idaho','/images/artist-no-image.png','','',0,'2013-04-21 10:28:46'),(17,'tk-schultz@hotmail.com','618871319','facebook','tessipoo','Tess Schultz','Boise, Idaho','/images/artist-no-image.png','','',0,'2013-04-21 10:33:34');
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

-- Dump completed on 2013-05-02  1:17:40
