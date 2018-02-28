-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: treemapdb.coslpxdzbpfq.us-west-2.rds.amazonaws.com    Database: treeMapDB
-- ------------------------------------------------------
-- Server version	5.6.35-log

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
-- Table structure for table `imageTable`
--

DROP TABLE IF EXISTS `imageTable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imageTable` (
  `imageid` int(11) NOT NULL AUTO_INCREMENT,
  `treeid` int(11) NOT NULL,
  `filepath` varchar(45) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`imageid`)
) ENGINE=InnoDB AUTO_INCREMENT=693 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imageTable`
--

LOCK TABLES `imageTable` WRITE;
/*!40000 ALTER TABLE `imageTable` DISABLE KEYS */;
INSERT INTO `imageTable` VALUES (30,650,'upload/jpeg2000-home.jpeg',NULL),(34,656,'upload/20180122_094701_resized.jpg',NULL),(665,658,'upload/pexels-photo-177809.jpg',NULL),(667,657,'upload/jpeg2000-home.jpeg',NULL),(669,659,'upload/pexels-photo-177809.jpg',NULL),(670,175,'upload/Siberian Elm.jpg',NULL),(673,304,'upload/American Dogwood.jpg',NULL),(674,187,'upload/Post Oak.jpg',NULL),(675,188,'upload/Sugar Maple.jpg',NULL),(676,193,'upload/Pin Oak.jpg',NULL),(677,195,'upload/Northern Red Oak.jpg',NULL),(678,212,'upload/Bald Cypress.jpg',NULL),(679,216,'upload/Callery Pear.jpg',NULL),(680,238,'upload/Southern Magnolia.jpg',NULL),(681,275,'upload/Ginkgo.jpg',NULL),(682,298,'upload/Basswood.jpg',NULL),(683,292,'upload/Black Maple.jpg',NULL),(684,406,'upload/Catalpa.jpg',NULL),(685,293,'upload/Chinquapin Oak.jpg',NULL),(686,278,'upload/White Pine.jpg',NULL),(687,405,'upload/Redbud.jpg',NULL),(688,327,'upload/Silver Maple.jpg',NULL),(689,300,'upload/Sweet Gum.jpg',NULL),(690,407,'upload/American Sycamore.jpg',NULL),(691,285,'upload/White Ash.jpg',NULL),(692,303,'upload/Willow Oak.jpg',NULL);
/*!40000 ALTER TABLE `imageTable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-28 15:35:36
