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
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `K_IDSERVICE` int(11) NOT NULL,
  `N_GERENCY` varchar(50) NOT NULL,
  `N_TYPE` varchar(10) NOT NULL,
  `N_DESCRIPTION` varchar(200) NOT NULL,
  `N_SCOPE` varchar(1000) NOT NULL,
  `N_DURATION` varchar(5) NOT NULL,
  PRIMARY KEY (`K_IDSERVICE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (0,'GDRCD (Anexo 4) CORE','C1','GENERACION DE ORDENES RELACIONADAS A ELEMENTOS Y SERVICIOS DEL PACKET CORE','El objetivo de esta actividad es la generación de órdenes de trabajo para la modificación de configuración de elementos del Packet Core. Por la complejidad, criticidad y nicho de mercado objetivo de estas configuraciones, se requiere que los recursos, tengan experienciacomprobada en la elaboración de los archivos de configuración necesarios, así como experiencia en el trato y respuesta a clientes externos.','5'),(1,'GDRCD (Anexo 4) CORE','C2','ORDENES DE TRABAJOS RELACIONADOS CON ACTIVIDADES EN EL BBIP Y RED TÉCNICA','El objetivo de esta actividad es la asignación de recursos del BBIP y Red Técnica de acuerdo a los requerimientos, dentro de este tipo de servicio se incluyen, pero no se limitan exclusivamente a los siguientes: Reservar Puertos y documentar Red técnica & BBIP, Reservar segmentos de red y documentar, Realizar OT en el BBIP de complejidad Baja (Gestion, Desbloqueo de puertos) , Realizar OT de gestión y conectividad en la red Técnica, Analizar las capacidades para los avales de las rutas IP en el BBIP.','4'),(2,'GDRCD (Anexo 4) CORE','C3','SERVICIOS DE COORDINACION Y SEGUIMIENTO PARA EL CORE DATOS ','Este servicio está orientado a labores de seguimiento y control para la implementación, optimización y ampliación de las diferentes plataformas del Core Datos.','3'),(3,'GRF (Anexo 2) RF','D1','Cambio de Parametros, Cancelacion','Cambio de Parametros, Cancelada, Suministro de servicios de elaboración de archivos DATAFILL (DF), para los elementos de las redes existentes o proyectadas de COMCEL (especialmente GSM, GPRS, EDGE, UMTS, HSDPA/HSUPA, HSPA+, LTE y VOLTE);Se debe complementar con lo correspondiente a la auditoría ','0.5'),(4,'GRF (Anexo 2) RF','D2','Creacion Elemento, Eliminacion Elemento','Activacion Estadisticas, Creacion Elemento, Eliminacion Elemento, Liberacion de Recursos, Modernizacion, Modificacion LAC, Rehoming, Retunning, Revision KPI, Swap, Suministro de servicios de elaboración de archivos DATAFILL (DF), para los elementos de las redes existentes o proyectadas de COMCEL (especialmente GSM, GPRS, EDGE, UMTS, HSDPA/HSUPA, HSPA+, LTE y VOLTE)Se debe complementar con lo correspondiente a la auditoría','1'),(5,'GRF (Anexo 2) RF','D3','Correccion por cambio Tx, Creacion Nodo Prueba','Correccion por cambio Tx, Creacion Nodo Prueba, Sitio Nuevo LTE, Revision Rehoming, Sitio Nuevo UMTS 1900, Suministro de servicios de elaboración de archivos DATAFILL (DF), para los elementos de las redes existentes o proyectadas de COMCEL (especialmente GSM, GPRS, EDGE, UMTS, HSDPA/HSUPA, HSPA+, LTE y VOLTE)Se debe complementar con lo correspondiente a la auditoría','2'),(6,'GRF (Anexo 2) RF','D4','Ampliacion, Sitio Nuevo','Ampliacion, Sitio Nuevo UMTS 850, Suministro de servicios de elaboración de archivos DATAFILL (DF), para los elementos de las redes existentes o proyectadas de COMCEL (especialmente GSM, GPRS, EDGE, UMTS, HSDPA/HSUPA, HSPA+, LTE y VOLTE)Se debe complementar con lo correspondiente a la auditoría','2'),(7,'GRF (Anexo 2) RF','D5','Sitio Nuevo GSM','Sitio Nuevo GSM, Suministro de servicios de elaboración de archivos DATAFILL (DF), para los elementos de las redes existentes o proyectadas de COMCEL (especialmente GSM, GPRS, EDGE, UMTS, HSDPA/HSUPA, HSPA+, LTE y VOLTE) Se debe complementar con lo correspondiente a la auditoría','3'),(8,'GRF (Anexo 2) RF','D6','Informe Core Nacional','Informe Core Nacional, Suministro de servicios de elaboración de archivos DATAFILL (DF), para los elementos de las redes existentes o proyectadas de COMCEL (especialmente GSM, GPRS, EDGE, UMTS, HSDPA/HSUPA, HSPA+, LTE y VOLTE); Se debe complementar con lo correspondiente a la auditoría','5'),(9,'GDRT (Anexo 3) TRANSMISIÓN','T1','ORDENES DE CONFIGURACION DE SERVICIOS DE RED DE TRANSPORTE','El objeto de la actividad es generar y consolidar las órdenes de trabajo necesarias para garantizar la integración, eliminación o modificación a nivel lógico de los parámetros de red de transporte para servicios extremo a extremo de las tecnologías de la red Móvil, de la red de Sincronismo y en general de las tecnologías que cursen a través de red de transporte de CLARO y para las cuales GDRT requiera generación de DATAFILL que permitan configurar parámetros de diseño de un servicio, cumpliendo los estándares de calidad y política de garantía de servicio y cero tolerancia a fallas de CLARO','1.5'),(10,'GDRT (Anexo 3) TRANSMISIÓN','T2','ORDENES DE TRABAJO PARA CANALES DE TRANSMISION','El objeto de la actividad es generar y consolidar las órdenes de trabajo necesarias para garantizar la creación o modificación de configuraciones que permitan establecer un enlace de transmisión extremo a extremo para un servicio a través de una o más de las redes y medios de transmisión de CLARO y para los cuales GDRT requiera configurar parámetros de diseño de un canal de transmisión, cumpliendo los estándares de calidad y política de garantía de servicio y cero tolerancia a fallas de CLARO.','1.5'),(11,'GDRT (Anexo 3) TRANSMISIÓN','T3','DISEÑO DE GESTIÓN PARA ELEMENTOS DE TRANSMISION','El objeto de la actividad es generar y consolidar las topologías y órdenes de trabajo necesarias para permitir la optimización, integración, eliminación o modificación de un elemento de la red de transmisión, la red de transporte, la red de sincronismo u otras redes de CLARO en un sistema de gestión centralizado, según requiera GDRT, cumpliendo los estándares de calidad, disponibilidad, estabilidad, eficiencia de la DCN y política de garantía de servicio y cero tolerancia a fallas de CLARO.','1.5'),(12,'GDRT (Anexo 3) TRANSMISIÓN','T4','VIABILIZAR Y DISEÑAR RUTAS DE TRANSMISIÓN','Esta actividad está orientada a viabilizar y diseñar rutas de transmisión extremo a extremo (a través de las redes SDH, IPRAN, Satelital, Microondas, datos, etc.), teniendo en cuenta los parámetros de ingeniería asociados a las plataformas de documentación y gestores de CLARO (TesGestion, U2000, SAM, y demás gestores de las redes de Transmisión), con el fin de entregar un canal para el aprovisionamiento de redes 2G, 3G, LTE y demás servicios que CLARO requiera para su operación.','1.5'),(15,'GDRT (Anexo 3) TRANSMISIÓN','T5','DOCUMENTACIÓN EN BASES DE DATOS COMCEL','Esta actividad tiene como objetivo la documentación de rutas, elementos de red y servicios de la red de transmisión de CLARO, donde se incluya el plano con la topología aplicada a cada servicio o elemento de red en las Plataformas y formatos que CLARO disponga.','0.5'),(16,'GDRT (Anexo 3) TRANSMISIÓN','T6','PREFACTIBILIDAD Y GESTIÓN DE TRANSMISIÓN PARA PROYECTOS CORPORATIVOS.',' El objeto de esta actividad es generar y gestionar los estudios de pre factibilidad dirigidos al aprovisionamiento de servicios de transmisión para Clientes Corporativos a través de la red propia o de recursos contratados con terceros, cumpliendo con los estándares de calidad y política de “garantía de servicio y cero tolerancia a fallas de CLARO”.','0.5');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-22 11:10:01
