CREATE DATABASE  IF NOT EXISTS `snacksdb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `snacksdb`;
-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: snacksdb
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `optionlisttable`
--

DROP TABLE IF EXISTS `optionlisttable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `optionlisttable` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT,
  `optionName` varchar(200) DEFAULT NULL,
  `optionVoteCount` varchar(45) DEFAULT NULL,
  `lastorderedon` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`optionid`),
  UNIQUE KEY `optionid_UNIQUE` (`optionid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `optionlisttable`
--

LOCK TABLES `optionlisttable` WRITE;
/*!40000 ALTER TABLE `optionlisttable` DISABLE KEYS */;
INSERT INTO `optionlisttable` VALUES (1,'Poha','0','1452356000'),(2,'Fruit Salad','0','1452356040'),(3,'Patties','0','1452355774'),(4,'Sandwich','0','1452356092'),(5,'Bhelpuri','1','1452356127');
/*!40000 ALTER TABLE `optionlisttable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderstatus`
--

DROP TABLE IF EXISTS `orderstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderstatus` (
  `orderid` int(10) NOT NULL AUTO_INCREMENT,
  `orderoptionid` int(10) DEFAULT NULL,
  `ordervotecount` int(10) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `orderDate` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`orderid`),
  UNIQUE KEY `orderid_UNIQUE` (`orderid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderstatus`
--

LOCK TABLES `orderstatus` WRITE;
/*!40000 ALTER TABLE `orderstatus` DISABLE KEYS */;
INSERT INTO `orderstatus` VALUES (1,2,4,1,'2015-01-09'),(2,1,2,1,''),(3,2,2,1,'2016-01-09 21:34:48'),(4,5,3,1,'2016-01-09 21:37:06'),(5,3,2,1,'2016-01-09 21:38:19'),(6,1,3,1,'2016-01-09 21:43:14'),(7,2,0,1,'2016-01-09 21:43:53'),(8,4,0,1,'2016-01-09 21:44:25'),(9,4,0,1,'2016-01-09 21:44:46'),(10,5,0,1,'2016-01-09 21:45:07'),(11,5,0,1,'2016-01-09 21:45:17'),(12,0,0,2,'2016-01-09 21:46:55');
/*!40000 ALTER TABLE `orderstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presentOption`
--

DROP TABLE IF EXISTS `presentOption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presentOption` (
  `presentoptionid` int(11) NOT NULL AUTO_INCREMENT,
  `optionnumber` int(11) DEFAULT NULL,
  `presentoptionvotecount` int(11) DEFAULT NULL,
  `optionlisttableid` int(11) DEFAULT NULL,
  PRIMARY KEY (`presentoptionid`),
  UNIQUE KEY `optionid_UNIQUE` (`presentoptionid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presentOption`
--

LOCK TABLES `presentOption` WRITE;
/*!40000 ALTER TABLE `presentOption` DISABLE KEYS */;
INSERT INTO `presentOption` VALUES (1,1,0,3),(2,2,1,1);
/*!40000 ALTER TABLE `presentOption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userinfo` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `loginid` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `usertype` int(2) DEFAULT NULL,
  `userstatus` int(2) DEFAULT NULL,
  `presentvotestatus` int(2) DEFAULT '0',
  `presentvoteoption` int(2) DEFAULT '0',
  `nextvotestatus` int(2) DEFAULT '0',
  `nextvoteoption` int(2) DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid_UNIQUE` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userinfo`
--

LOCK TABLES `userinfo` WRITE;
/*!40000 ALTER TABLE `userinfo` DISABLE KEYS */;
INSERT INTO `userinfo` VALUES (1,'ankit.agrawal@veneratech.com','anknit','0192023a7bbd73250516f069df18b500',2,NULL,1,2,1,5),(2,'ankitakkii24@gmail.com','anknit1','0192023a7bbd73250516f069df18b500',1,NULL,0,0,0,0),(3,'test_user1@veneratech.com','anknit2','0192023a7bbd73250516f069df18b500',1,0,0,0,0,0);
/*!40000 ALTER TABLE `userinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-09 21:48:57
