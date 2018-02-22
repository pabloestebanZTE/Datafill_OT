-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: datafill_ot
-- ------------------------------------------------------
-- Server version	5.7.19-log

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `K_IDUSER` varchar(20) NOT NULL,
  `K_IDROLE` int(11) DEFAULT NULL,
  `N_NAME` varchar(50) NOT NULL,
  `N_LASTNAME` varchar(50) NOT NULL,
  `N_MAIL` varchar(50) NOT NULL,
  `N_PHONE` varchar(20) NOT NULL,
  `N_CELPHONE` varchar(20) NOT NULL,
  `N_PASSWORD` varchar(20) NOT NULL,
  `N_USERNAME` varchar(20) NOT NULL,
  PRIMARY KEY (`K_IDUSER`),
  KEY `FK_USER_ROLE` (`K_IDROLE`),
  CONSTRAINT `FK_USER_ROLE` FOREIGN KEY (`K_IDROLE`) REFERENCES `role` (`K_IDROLE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('1',5,'Jhon Alejandro','Salazar Tapasco','Alejandro.Salazar@claro.com.co',' ',' ',' ',' '),('10',5,'Lina Marcela','Duque Morales','Lina.Duque@claro.com.co',' ',' ',' ',' '),('1012399862',2,'Jhon Fredy','Novoa','Jhon.Novoa.ext@claro.com.co','','3125572832','a4b3c2d1','jfnovoa'),('1014251868',1,'Marcela Fernanda','Herrera Quila',' ',' ',' ','a4b3c2d1','mfherreraq'),('1016028754',1,'Lina','Casallas Melgarejo',' ',' ',' ','a4b3c2d1','lcasallasm'),('1022350779',1,'Giovanny','Reyes Torres','Giovanny.Reyes.ext@claro.com.co','','3125532731','a4b3c2d1','greyest'),('1030565500',1,'David','Arevalo Bravo','David.Arevalo.ext@claro.com.co','','3125423158','a4b3c2d1','darevalob'),('1032364958',1,'Cesar David','Duran Alvarez','Cesar.Durana.ext@claro.com.co','','3125536570','a4b3c2d1','cadurana'),('1065631508',2,'Julián Camilo','Durán Hernández','Julian.Duran.ext@claro.com.co','','3125484908','a4b3c2d1','jcduranh'),('1069722400',4,'Andrea Lorena','Rosero Chasoy','','','','a4b3c2d1','alroseroc'),('1070916624',2,'Daniel Guillermo','Reyes Prieto','Daniel.Reyes.ext@claro.com.co','','3125572971','a4b3c2d1','dgreyesp'),('11',5,'Luis Mauricio','Gomez Arias','Luis.Gomeza@claro.com.co',' ',' ',' ',' '),('12',5,'Luis Gabriel','Pineda Gomez','Luis.Pineda@claro.com.co',' ',' ',' ',' '),('13',5,'Luis Carlos','Mejia Ahumada','Luisc.Mejia@claro.com.co',' ',' ',' ',' '),('14',5,'Oscar Javier','Barbosa Cuellar','Oscar.Barbosa@claro.com.co',' ',' ',' ',' '),('15',5,'Oscar Eduardo','Otero Flores','Oscar.Otero@claro.com.co',' ',' ',' ',' '),('16',5,'Vivian Lorena','Plazas Riano','Vivian.Plazas.ext@claro.com.co',' ',' ',' ',' '),('17',5,'Yolanda','Cortes Gil','Yolanda.Cortes.ext@claro.com.co',' ',' ',' ',' '),('18',5,'Eduardo','Martinez','Eduardo.Martinez@claro.com.co',' ',' ',' ',' '),('19',5,'Guillermo','Riaño','Guillermo.Riano@claro.com.co',' ',' ',' ',' '),('2',5,'Andres','Hernandez','Andres.Hernandez@claro.com.co',' ',' ',' ',' '),('20',5,'r','Riano','rriano@comcel.com.co',' ',' ',' ',' '),('21',5,'Diego','Velez','diego.velez@claro.com.co',' ',' ',' ',' '),('3',5,'Carlos Andres','Tovar Piraban','Carlos.Tovar@claro.com.co',' ',' ',' ',' '),('4',5,'Henry','Ledesma','Henry.ledesma@claro.com.co',' ',' ',' ',' '),('5',5,'Javier','Pineda Lopez','Javier.Pineda@claro.com.co',' ',' ',' ',' '),('52700033',5,'Sandra Paola','Varón García','paola.varon.ext@claro.com.co','','3143446683','a4b3c2d1','spvarong'),('6',5,'Jhon Vicente','Salgado Rodriguez','Jhon.Salgado@claro.com.co',' ',' ',' ',' '),('7',5,'Johann Smit','Orozco Larrota','Johann.Orozco@claro.com.co',' ',' ',' ',' '),('8',5,'Jorge Anibal','Hernandez Rodriguez','Jorge.HernandezR@claro.com.co',' ',' ',' ',' '),('80158472',1,'Andres Alberto','Rubio Idrobo','Andres.Rubio.ext@claro.com.co','','3125492102','a4b3c2d1','aarubioi'),('80160305',1,'Miguel Angel','Moreno Alarcon','Miguel.Moreno.ext@claro.com.co','','3125490345','a4b3c2d1','mamorenoa'),('80392886',1,'Juan Carlos','Olmos Bonilla','Juan.Olmos.ext@claro.com.co','','3125490370','a4b3c2d1','jcolmosb'),('9',5,'Jose','Zambrano','Jose.Zambrano@claro.com.co',' ',' ',' ',' ');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-22 11:10:04
