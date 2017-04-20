-- MySQL dump 10.13  Distrib 5.6.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pucci
-- ------------------------------------------------------
-- Server version	5.6.31-0ubuntu0.14.04.2

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
-- Table structure for table `device_action`
--

DROP TABLE IF EXISTS `device_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sound` varchar(255) NOT NULL,
  `reading` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device_action`
--

LOCK TABLES `device_action` WRITE;
/*!40000 ALTER TABLE `device_action` DISABLE KEYS */;
INSERT INTO `device_action` VALUES (1,1,'This is Test alert Message 1.','Sound alert1','30','2016-10-25 14:05:27'),(2,1,'This is Test Alert Message 2.','Sound alert2','40','2016-10-25 14:05:27'),(3,1,'This is Test Alert Message 3.','Sound alert3','60','2016-10-25 14:05:27'),(4,2,'kip','Sound alert3','10','2016-11-04 04:40:42');
/*!40000 ALTER TABLE `device_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `device_name` varchar(200) NOT NULL,
  `device_id` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_icon` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (23,'Tommy','70gwowgua1n',2,'image.jpg','2016-11-17 11:11:22'),(24,'stub','phwnh3vjb1r',2,'image.jpg','2016-11-17 11:32:26'),(25,'','pmpucsttwe',2,'image.jpg','2016-11-17 11:38:43'),(26,'','ghrksadv3r',2,'image.jpg','2016-11-17 11:44:28'),(27,'taffy','ogu8m1j1v',2,'image.jpg','2016-11-17 11:46:59'),(28,'fruu','7jnm7rltud',3,'image.jpg','2016-11-17 12:18:08'),(29,'rabbit','hev4xlf2j74',2,'image.jpg','2016-11-18 06:59:00'),(30,'puppy','whs3zmfr',2,'image.jpg','2016-11-18 06:59:25'),(31,'doggy','892ckltzh',2,'image.jpg','2016-11-18 11:43:01'),(32,'My Dog','zydm3i1d',5,'image.jpg','2016-11-21 04:01:53'),(33,'My Cat','rp07nyf65',5,'image.jpg','2016-11-21 04:17:12'),(34,'catty','ktutu7gmp',2,'image.jpg','2016-11-21 06:32:50'),(35,'','tbfyd1es1f8',2,'image.jpg','2016-11-21 06:48:39'),(36,'','9ythjgt7hi',2,'image.jpg','2016-11-21 06:54:51'),(37,'','4ptnxmgyn26',2,'image.jpg','2016-11-21 06:59:12'),(38,'','',2,'image.jpg','2016-11-21 07:03:12'),(39,'duccy','mmyeanid7i',2,'image.jpg','2016-11-21 07:07:12'),(40,'','',2,'image.jpg','2016-11-22 06:22:14'),(41,'fmfhgmfmf','camxasal0bi0rpbcur8f9wwmi',1,'image.jpg','2016-11-23 11:17:46'),(42,'dsad','uzkftvpa0kom5s5fuz3erk9',8,'image.jpg','2016-11-23 11:30:52'),(43,'zubby','tirv2qjjdcl',13,'image.jpg','2016-11-23 11:59:23');
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_contacts`
--

DROP TABLE IF EXISTS `group_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_contacts`
--

LOCK TABLES `group_contacts` WRITE;
/*!40000 ALTER TABLE `group_contacts` DISABLE KEYS */;
INSERT INTO `group_contacts` VALUES (1,2,35,'2016-11-21 09:00:23'),(2,0,0,'2016-11-22 07:08:07'),(3,1,2,'2016-11-22 07:08:41'),(4,6,7,'2016-11-22 07:12:21'),(5,6,7,'2016-11-22 07:13:39'),(6,6,7,'2016-11-22 07:23:42'),(7,6,7,'2016-11-22 07:23:56'),(8,8,0,'2016-11-22 07:31:49'),(9,8,0,'2016-11-22 10:38:59');
/*!40000 ALTER TABLE `group_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_name` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (8,2,'family','2016-11-22 05:36:40'),(10,2,'roomates','2016-11-22 05:37:09'),(11,2,'seniors','2016-11-22 05:37:18'),(12,2,'juniors','2016-11-22 05:37:27');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'abc','hdajh'),(2,'abc','hdajh'),(4,'My pet lost',''),(5,'stub lost','stub description'),(6,'a','b'),(7,'doggy','doggy description'),(8,'',''),(9,'testing','testing message test'),(10,'testing','testing'),(11,'testmsg','test'),(12,'testmsg','test'),(13,'testmsg','test'),(14,'testmsg','test');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Manpreet','Singh','manpreet@retouchingwork.org','d41d8cd98f00b204e9800998ecf8427e','2016-10-24 08:24:57'),(2,'dmparser1','singh','harpreet@gmail.com','d41d8cd98f00b204e9800998ecf8427e','2016-11-01 11:30:08'),(3,'mehak','chopra','mehak@gmail.com','e10adc3949ba59abbe56e057f20f883e','2016-11-17 06:08:19'),(4,'abc','def','abc@gmail.com','e10adc3949ba59abbe56e057f20f883e','2016-11-18 05:31:18'),(5,'Deepak','Bansal','deepakbansal81@gmail.com','498b5924adc469aa7b660f457e0fc7e5','2016-11-21 04:00:54'),(6,'','','harpreet@uretouchingwork.org','d41d8cd98f00b204e9800998ecf8427e','2016-11-23 09:01:55'),(7,'','','harpreet@yhetouchingwork.org','d41d8cd98f00b204e9800998ecf8427e','2016-11-23 09:03:04'),(8,'Ritika','Sharma','riti@fhg.im','e10adc3949ba59abbe56e057f20f883e','2016-11-23 10:19:25'),(9,'','','xyz@gmail.com','d41d8cd98f00b204e9800998ecf8427e','2016-11-23 10:49:20'),(10,'','','aa@gmail.com','d41d8cd98f00b204e9800998ecf8427e','2016-11-23 10:49:31'),(11,'','','f@gmail.com','d41d8cd98f00b204e9800998ecf8427e','2016-11-23 10:50:19'),(12,'','','dfdf@gmail.com','d41d8cd98f00b204e9800998ecf8427e','2016-11-23 10:58:11'),(13,'ktk','arora','ktk@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','2016-11-23 11:57:59');
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

-- Dump completed on 2016-11-24  2:13:39
