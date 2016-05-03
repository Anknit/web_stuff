/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.6.17 : Database - ppudatabase
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `ppudatabase`;

USE `ppudatabase`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Data for the table `accountcredit_info` */

LOCK TABLES `accountcredit_info` WRITE;

UNLOCK TABLES;

/*Data for the table `licenseinfo` */

LOCK TABLES `licenseinfo` WRITE;

UNLOCK TABLES;

/*Data for the table `payment_info` */

LOCK TABLES `payment_info` WRITE;

UNLOCK TABLES;

/*Data for the table `session_info` */

LOCK TABLES `session_info` WRITE;

UNLOCK TABLES;

/*Data for the table `supportrequest` */

LOCK TABLES `supportrequest` WRITE;

UNLOCK TABLES;

/*Data for the table `systemsettings` */

LOCK TABLES `systemsettings` WRITE;

insert  into `systemsettings`(`smtpHostName`,`smtpUsername`,`smtpPassword`,`smtpPort`,`sender`) values ('mail.veneratech.com','pulsarppuadmin@veneratech.com','ppuadminVenera12*',25,'pulsarppuadmin@veneratech.com');

UNLOCK TABLES;

/*Data for the table `usageinfo` */

LOCK TABLES `usageinfo` WRITE;

UNLOCK TABLES;

/*Data for the table `userinfo` */

LOCK TABLES `userinfo` WRITE;

insert  into `userinfo`(`UserID`,`AccountID`,`Username`,`MailID`,`Password`,`UserType`,`userStatus`,`regAuthorityID`,`regAuthorityName`,`Name`,`Address`,`City`,`Country`,`PinCode`,`Organization`,`Website`,`phoneOffice`,`phonePersonal`,`PartnerID`,`Commision`,`RegisteredOn`) values (1,0,'admin@veneratech.com','pulsarppuadmin@veneratech.com','0192023a7bbd73250516f069df18b500',4,2,1,'Aditya','Aditya ','Noida','Noida','India','110007','Venera Technologies','www.venera.com','7503790445','8862598745',NULL,NULL,'2014-08-28');

UNLOCK TABLES;

/*Data for the table `usersubscriptioninfo` */

LOCK TABLES `usersubscriptioninfo` WRITE;

insert  into `usersubscriptioninfo`(`OrderID`,`UserID`,`ProductFamily`,`ServiceID`,`ServiceDescription`,`Subscription_Type`,`Validity_Start_Date`,`Validity_End_Date`,`Package`,`Auto_Renewal`) values (1,2,NULL,NULL,NULL,NULL,'2014-10-13','2014-10-13 11:49:45',0,2);

UNLOCK TABLES;

/*Data for the table `voucherinfotable` */

LOCK TABLES `voucherinfotable` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
