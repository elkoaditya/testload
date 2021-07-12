/*
SQLyog Ultimate v9.20 
MySQL - 5.6.16 : Database - fresto_demo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `menu_injek` */

DROP TABLE IF EXISTS `menu_injek`;

CREATE TABLE `menu_injek` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_position` int(11) NOT NULL,
  `menu_sub_id` int(11) DEFAULT NULL,
  `menu_name_ind` varchar(1000) NOT NULL,
  `menu_name_eng` varchar(1000) NOT NULL,
  `menu_detail` text,
  `menu_class` varchar(1000) DEFAULT NULL,
  `menu_order` int(3) DEFAULT NULL,
  `menu_show` int(2) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `menu_injek` */

LOCK TABLES `menu_injek` WRITE;

insert  into `menu_injek`(`menu_id`,`menu_position`,`menu_sub_id`,`menu_name_ind`,`menu_name_eng`,`menu_detail`,`menu_class`,`menu_order`,`menu_show`) values (1,1,NULL,'Kelas','grade',NULL,'fa fa-bell fa-fw',1,1),(2,1,NULL,'Guru','teacher',NULL,'fa fa-bookmark fa-fw',2,1),(3,1,NULL,'Siswa','student',NULL,'fa fa-user fa-fw',4,1),(5,1,NULL,'Pelajaran','study',NULL,'fa fa-book fa-fw',5,1),(7,1,NULL,'Organisasi','organitation',NULL,'fa fa-briefcase fa-fw',7,1),(8,1,NULL,'Ekstrakulikuler','ekstrakulikuler',NULL,'fa fa-flag fa-fw',8,1);

UNLOCK TABLES;

/*Table structure for table `user_injek` */

DROP TABLE IF EXISTS `user_injek`;

CREATE TABLE `user_injek` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(1000) NOT NULL,
  `user_pass` varchar(1000) DEFAULT NULL,
  `user_phone` varchar(200) DEFAULT NULL,
  `user_email` varchar(1000) DEFAULT NULL,
  `user_address` text,
  `user_sid` varchar(1000) DEFAULT NULL,
  `user_t_stamp` datetime DEFAULT NULL,
  `user_show` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `user_injek` */

LOCK TABLES `user_injek` WRITE;

insert  into `user_injek`(`user_id`,`user_name`,`user_pass`,`user_phone`,`user_email`,`user_address`,`user_sid`,`user_t_stamp`,`user_show`) values (1,'1234','827ccb0eea8a706c4c34a16891f84e7b',NULL,NULL,NULL,'04ae57847ffca36f71c3d918d3a767d2',NULL,1);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
