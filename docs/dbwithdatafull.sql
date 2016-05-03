/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.5.40-0ubuntu0.12.04.1 : Database - backUpTest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `backUpTest`;

USE `backUpTest`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `accountcredit_info` */

DROP TABLE IF EXISTS `accountcredit_info`;

CREATE TABLE `accountcredit_info` (
  `AccountID` int(11) NOT NULL AUTO_INCREMENT,
  `CreditAmount` float DEFAULT NULL,
  `CreatedOn` date DEFAULT NULL,
  `UpdatedOn` date DEFAULT NULL,
  `accountStatus` int(10) DEFAULT '2' COMMENT '2: Active, 3: Inactive',
  `accountValidity` varchar(100) DEFAULT NULL,
  `accMgr` varchar(100) DEFAULT NULL,
  `currencyCode` varchar(50) DEFAULT 'USD' COMMENT 'USD/GBP/EURO',
  PRIMARY KEY (`AccountID`),
  UNIQUE KEY `AccountID` (`AccountID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `accountcredit_info` */

insert  into `accountcredit_info`(`AccountID`,`CreditAmount`,`CreatedOn`,`UpdatedOn`,`accountStatus`,`accountValidity`,`accMgr`,`currencyCode`) values (3,500,'2014-11-05','2014-11-06',2,'2015-05-05',NULL,'USD'),(4,800,'2014-11-05','2014-11-06',2,'2015-05-05',NULL,'USD'),(5,350,'2014-11-05','2014-11-06',2,'2015-05-05',NULL,'USD'),(6,380,'2014-11-05','2014-11-06',2,'2015-05-05',NULL,'USD'),(7,200,'2014-11-05','2014-11-06',2,'2015-05-05',NULL,'USD'),(8,710,'2014-11-05','2014-11-06',2,'2015-05-05',NULL,'USD');

/*Table structure for table `licenseinfo` */

DROP TABLE IF EXISTS `licenseinfo`;

CREATE TABLE `licenseinfo` (
  `LicenseIndex` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `FirstTimeRegistration` tinyint(1) DEFAULT '0',
  `Features` varchar(50) NOT NULL COMMENT 'int with bits set',
  `SUID` varchar(100) DEFAULT NULL,
  `ServiceID` varchar(20) NOT NULL,
  PRIMARY KEY (`LicenseIndex`),
  UNIQUE KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `licenseinfo` */

insert  into `licenseinfo`(`LicenseIndex`,`UserID`,`FirstTimeRegistration`,`Features`,`SUID`,`ServiceID`) values (3,8,0,'4;264;10;1;0;20-06-2015',NULL,'PPU'),(4,9,0,'4;264;10;1;0;20-06-2015',NULL,'PPU'),(5,12,0,'4;264;10;1;0;20-06-2015',NULL,'PPU'),(6,13,0,'4;264;10;1;0;20-06-2015',NULL,'PPU'),(7,15,0,'4;264;10;1;0;20-06-2015',NULL,'PPU'),(8,17,0,'4;264;10;1;0;20-06-2015',NULL,'PPU'),(9,19,0,'4;264;10;1;0;20-06-2015',NULL,'PPU'),(10,20,0,'4;264;10;1;0;20-06-2015',NULL,'PPU');

/*Table structure for table `payment_info` */

DROP TABLE IF EXISTS `payment_info`;

CREATE TABLE `payment_info` (
  `PaymentIndex` int(11) NOT NULL AUTO_INCREMENT COMMENT 'For the sake of indexing',
  `InvoiceNum` varchar(10) NOT NULL COMMENT 'Invoice number  4 character + 6 digitsing',
  `TransactionID` varchar(50) NOT NULL,
  `ReceiptNo` varchar(50) NOT NULL COMMENT 'Recipt No. after Payment is made',
  `CustomerID` int(11) NOT NULL COMMENT 'WhoMadeTheTransaction',
  `PurchaseDescription` text,
  `AmountPaid` int(10) NOT NULL,
  `CurrencyCode` varchar(4) NOT NULL,
  `PayDate` datetime NOT NULL,
  `Pay_Mode` int(5) NOT NULL COMMENT '1- Paypal, 2- voucher',
  `Payment_ModeID` varchar(100) NOT NULL,
  `paymentStatus` varchar(50) DEFAULT NULL COMMENT '1: Success, 2: Failed, 3: Unconfirmed',
  PRIMARY KEY (`PaymentIndex`),
  UNIQUE KEY `InvoiceNum` (`InvoiceNum`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `payment_info` */

insert  into `payment_info`(`PaymentIndex`,`InvoiceNum`,`TransactionID`,`ReceiptNo`,`CustomerID`,`PurchaseDescription`,`AmountPaid`,`CurrencyCode`,`PayDate`,`Pay_Mode`,`Payment_ModeID`,`paymentStatus`) values (1,'21741540','984609599483012','',8,NULL,120,'','2014-11-06 10:21:09',0,'984609599483012',NULL),(2,'39197044','641802192432381','',8,NULL,120,'','2014-11-06 10:21:26',0,'641802192432381',NULL),(3,'PPUS022474','3PX24551LU393251K','0787-4481-8454-4468',8,'Pulsar Pay-Per-Use credit purchase',160,'USD','2014-11-06 04:52:49',1,'',NULL),(4,'95107464','649587871441259','',12,NULL,120,'','2014-11-06 10:24:14',0,'649587871441259',NULL),(5,'22718621','620842764999004','',12,NULL,120,'','2014-11-06 10:24:24',0,'620842764999004',NULL),(6,'PPUS408248','1BC991382E916214L','1267-1483-0152-3588',12,'Pulsar Pay-Per-Use credit purchase',460,'USD','2014-11-06 04:55:34',1,'',NULL),(7,'90300653','393339962754276','',20,NULL,500,'','2014-11-06 10:27:59',2,'393339962754276',NULL),(8,'PPUS302230','0B889770N25138816','4569-7044-3100-8111',20,'Pulsar Pay-Per-Use credit purchase',110,'USD','2014-11-06 04:58:47',1,'',NULL),(9,'PPUS159324','99065261NJ633130H','2581-0439-6065-4856',15,'Pulsar Pay-Per-Use credit purchase',250,'USD','2014-11-06 05:00:29',1,'',NULL),(10,'71750505','618894726013199','',17,NULL,120,'','2014-11-06 10:31:22',0,'618894726013199',NULL),(11,'PPUS793949','8L734837L9162483L','5501-6462-6099-4135',17,'Pulsar Pay-Per-Use credit purchase',160,'USD','2014-11-06 05:02:03',1,'',NULL),(12,'PPUS625332','5SN18325G01906227','0762-7073-8358-2473',19,'Pulsar Pay-Per-Use credit purchase',100,'USD','2014-11-06 05:18:55',1,'',NULL);

/*Table structure for table `session_info` */

DROP TABLE IF EXISTS `session_info`;

CREATE TABLE `session_info` (
  `sessionID` varchar(100) NOT NULL,
  `UserID` int(10) NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime DEFAULT NULL,
  PRIMARY KEY (`sessionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `session_info` */

/*Table structure for table `supportrequest` */

DROP TABLE IF EXISTS `supportrequest`;

CREATE TABLE `supportrequest` (
  `request_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `organisation` varchar(50) NOT NULL,
  `summary` text,
  `request_type` int(11) NOT NULL COMMENT '1: Issue, 2: Feedback, 3:other',
  `Description` text NOT NULL,
  `Version` varchar(20) NOT NULL,
  `requestStatus` varchar(50) DEFAULT '1' COMMENT '1:Open, 2: Reopened, 3: Invalid, 4:Resolved, 5:WontFix , 6: Closed ',
  PRIMARY KEY (`request_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `supportrequest` */

/*Table structure for table `systemsettings` */

DROP TABLE IF EXISTS `systemsettings`;

CREATE TABLE `systemsettings` (
  `smtpHostName` varchar(50) DEFAULT NULL,
  `smtpUsername` varchar(50) DEFAULT NULL,
  `smtpPassword` varchar(50) DEFAULT NULL,
  `smtpPort` int(11) DEFAULT '25',
  `sender` varchar(50) DEFAULT 'Administrator',
  `supportEmailID` varchar(100) DEFAULT 'pulsarsupport@veneratech.com'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `systemsettings` */

insert  into `systemsettings`(`smtpHostName`,`smtpUsername`,`smtpPassword`,`smtpPort`,`sender`,`supportEmailID`) values ('mail.veneratech.com','pulsarppuadmin@veneratech.com','ppuadminVenera12*',25,'pulsarppuadmin@veneratech.com','pulsarsupport@veneratech.com'),('mail.veneratech.com','pulsarppuadmin@veneratech.com','ppuadminVenera12*',25,'pulsarppuadmin@veneratech.com','pulsarsupport@veneratech.com'),('mail.veneratech.com','pulsarppuadmin@veneratech.com','ppuadminVenera12*',25,'pulsarppuadmin@veneratech.com','pulsarsupport@veneratech.com');

/*Table structure for table `usageinfo` */

DROP TABLE IF EXISTS `usageinfo`;

CREATE TABLE `usageinfo` (
  `JobIndex` int(11) NOT NULL AUTO_INCREMENT,
  `jobID` int(11) NOT NULL,
  `sessionID` varchar(100) NOT NULL,
  `FileName` text NOT NULL,
  `FileDescription` text,
  `ContentDuration` int(10) DEFAULT NULL,
  `FeaturesUsed` varchar(50) DEFAULT NULL,
  `JobStartTime` datetime NOT NULL,
  `JobEndTime` datetime DEFAULT NULL,
  `Charges` float DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`JobIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `usageinfo` */

/*Table structure for table `userinfo` */

DROP TABLE IF EXISTS `userinfo`;

CREATE TABLE `userinfo` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountID` int(10) unsigned DEFAULT NULL COMMENT 'Holds AccountID ',
  `Username` varchar(100) DEFAULT NULL COMMENT 'This is actual Login ID',
  `MailID` varchar(100) NOT NULL COMMENT 'Used by RegAuthority to register new user',
  `Password` varchar(255) DEFAULT NULL,
  `UserType` int(5) DEFAULT NULL COMMENT 'Int 5 {Enum 1: Nor, 2: Resell, 3: Acc_Mgr, 4: SuperUser, 5: Ven_Sales, 6: Sales_rep}',
  `userStatus` int(5) DEFAULT '1' COMMENT 'Int 5 {Enum: 1: Unverified, 2: Active, 3: Inactive, 4: Delete}',
  `regAuthorityID` int(11) DEFAULT NULL,
  `regAuthorityName` varchar(100) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `PinCode` varchar(50) DEFAULT NULL,
  `Organization` text,
  `Website` varchar(256) DEFAULT NULL,
  `phoneOffice` varchar(100) DEFAULT NULL,
  `phonePersonal` varchar(100) DEFAULT NULL,
  `PartnerID` int(11) DEFAULT NULL,
  `Commision` float DEFAULT NULL,
  `RegisteredOn` date DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `AccountID` (`AccountID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `userinfo` */

insert  into `userinfo`(`UserID`,`AccountID`,`Username`,`MailID`,`Password`,`UserType`,`userStatus`,`regAuthorityID`,`regAuthorityName`,`Name`,`Address`,`City`,`Country`,`PinCode`,`Organization`,`Website`,`phoneOffice`,`phonePersonal`,`PartnerID`,`Commision`,`RegisteredOn`) values (1,0,'admin@veneratech.com','pulsarppuadmin@veneratech.com','0192023a7bbd73250516f069df18b500',4,2,1,'Aditya','Aditya ','Noida','Noida','India','110007','Venera Technologies','www.venera.com','7503790445','8862598745',NULL,NULL,'2014-08-28'),(6,NULL,'test_sales@veneratech.com','test_sales@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',5,2,1,'admin@veneratech.com','Sales User','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(7,NULL,'test_reseller@veneratech.com','test_reseller@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',2,2,6,'test_sales@veneratech.com','Reseller User','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(8,3,'test_customer1@veneratech.com','test_customer1@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',3,2,7,'test_reseller@veneratech.com','Customer User 1','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(9,3,'test_user1@veneratech.com','test_user1@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',1,2,8,'test_customer1@veneratech.com','Operator User 1','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(10,NULL,'ankit.agrawal@veneratech.com','ankit.agrawal@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',5,2,1,'admin@veneratech.com','Ankit Agarwal','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(11,NULL,'ankitakkii24@gmail.com','ankitakkii24@gmail.com','a3b9c163f6c520407ff34cfdb83ca5c6',2,2,10,'ankit.agrawal@veneratech.com','Ankit Agarwal','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(12,4,'test_customer2@veneratech.com','test_customer2@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',3,2,11,'ankitakkii24@gmail.com','Customer User 2','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(13,4,'test_user2@veneratech.com','test_user2@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',1,2,12,'test_customer2@veneratech.com','Operator User 2','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(14,NULL,'arpit.porwal@veneratech.com','arpit.porwal@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',2,2,6,'test_sales@veneratech.com','Arpit Reseller',NULL,NULL,NULL,NULL,'Venera',NULL,NULL,NULL,NULL,NULL,'2014-11-05'),(15,5,'arpit.kporwal@gmail.com','arpit.kporwal@gmail.com','a3b9c163f6c520407ff34cfdb83ca5c6',3,2,6,'test_sales@veneratech.com','Arpit Customer',NULL,NULL,NULL,NULL,'Venera',NULL,NULL,NULL,NULL,NULL,'2014-11-05'),(16,NULL,'manish.upadhyay@veneratech.com','manish.upadhyay@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',2,2,10,'ankit.agrawal@veneratech.com','Manish Reseller',NULL,NULL,NULL,NULL,'Venera',NULL,NULL,NULL,NULL,NULL,'2014-11-05'),(17,6,'rahul.jaiswal@veneratech.com','rahul.jaiswal@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',3,2,10,'ankit.agrawal@veneratech.com','Rahul ','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(18,NULL,'aditya@veneratech.com','aditya@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',2,2,1,'admin@veneratech.com','Aditya Reseller','','','','','Venera','','','',NULL,NULL,'2014-11-05'),(19,7,'prankur.garg@veneratech.com','prankur.garg@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',3,2,1,'admin@veneratech.com','Prankur Customer',NULL,NULL,NULL,NULL,'Venera',NULL,NULL,NULL,NULL,NULL,'2014-11-05'),(20,8,'vivek.upadhyay@veneratech.com','vivek.upadhyay@veneratech.com','a3b9c163f6c520407ff34cfdb83ca5c6',3,2,18,'aditya@veneratech.com','Vivek Customer',NULL,NULL,NULL,NULL,'Venera',NULL,NULL,NULL,NULL,NULL,'2014-11-05');

/*Table structure for table `usersubscriptioninfo` */

DROP TABLE IF EXISTS `usersubscriptioninfo`;

CREATE TABLE `usersubscriptioninfo` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ProductFamily` varchar(20) DEFAULT NULL COMMENT '{Enum: 1: Pulsar, 2: Nova, 3: Transcoder}..',
  `ServiceID` varchar(20) DEFAULT NULL,
  `ServiceDescription` varchar(255) DEFAULT NULL,
  `Subscription_Type` varchar(12) DEFAULT NULL COMMENT '{Enum: 1 ppu, 2: Monthly} etc..',
  `Validity_Start_Date` date DEFAULT NULL,
  `Validity_End_Date` varchar(50) DEFAULT NULL,
  `Package` int(5) DEFAULT '0',
  `Auto_Renewal` int(5) NOT NULL DEFAULT '2' COMMENT '{Enum: 1 Renewal On,2: Renewal Off}',
  PRIMARY KEY (`OrderID`),
  UNIQUE KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `usersubscriptioninfo` */

insert  into `usersubscriptioninfo`(`OrderID`,`UserID`,`ProductFamily`,`ServiceID`,`ServiceDescription`,`Subscription_Type`,`Validity_Start_Date`,`Validity_End_Date`,`Package`,`Auto_Renewal`) values (4,8,NULL,NULL,NULL,'1',NULL,NULL,0,2),(5,9,NULL,NULL,NULL,'1',NULL,NULL,0,2),(6,12,NULL,NULL,NULL,'1',NULL,NULL,0,2),(7,13,NULL,NULL,NULL,'1',NULL,NULL,0,2),(8,15,NULL,NULL,NULL,'1',NULL,NULL,0,2),(9,17,NULL,NULL,NULL,'1',NULL,NULL,0,2),(10,19,NULL,NULL,NULL,'1',NULL,NULL,0,2),(11,20,NULL,NULL,NULL,'1',NULL,NULL,0,2);

/*Table structure for table `voucherinfotable` */

DROP TABLE IF EXISTS `voucherinfotable`;

CREATE TABLE `voucherinfotable` (
  `voucherIndex` int(11) NOT NULL AUTO_INCREMENT,
  `voucherID` varchar(50) NOT NULL,
  `StartValidity` date DEFAULT NULL,
  `EndValidity` varchar(50) DEFAULT NULL,
  `VoucherType` int(5) NOT NULL COMMENT 'Enum{1: paid, 2:demo}etc..',
  `Amount` int(11) DEFAULT NULL,
  `voucherStatus` int(5) NOT NULL DEFAULT '1' COMMENT 'Enum{1: Unused, 2: Activated, 3:Cancelled, 4: Expired}',
  `CustomerID` int(11) DEFAULT NULL COMMENT 'Optional- if voucher creator wants to add the account id',
  `GeneratedBy` int(11) NOT NULL COMMENT 'Who creates the voucher',
  `UserNotes` text,
  `voucherCurrencyCode` varchar(50) DEFAULT 'USD',
  PRIMARY KEY (`voucherIndex`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `voucherinfotable` */

insert  into `voucherinfotable`(`voucherIndex`,`voucherID`,`StartValidity`,`EndValidity`,`VoucherType`,`Amount`,`voucherStatus`,`CustomerID`,`GeneratedBy`,`UserNotes`,`voucherCurrencyCode`) values (3,'984609599483012','2014-11-05','2014-11-20',2,120,2,8,6,'','USD'),(4,'180407925957458','2014-11-05','2014-11-20',2,120,1,15,6,'','USD'),(5,'912809077135476','2014-11-05','2015-05-04',1,250,1,NULL,6,'','USD'),(6,'837645509035345','2014-11-05','2015-05-04',1,125,1,NULL,6,'','USD'),(7,'641802192432381','2014-11-05','2014-11-20',2,120,2,8,7,'','USD'),(8,'205666844529333','2014-11-05','2015-05-04',1,180,3,NULL,7,'','USD'),(9,'772847366404319','2014-11-05','2014-11-20',2,120,1,NULL,14,'','USD'),(10,'618894726013199','2014-11-05','2014-11-20',2,120,2,17,10,'','USD'),(11,'649587871441259','2014-11-05','2014-11-20',2,120,2,12,10,'','USD'),(12,'906253576179380','2014-11-05','2015-05-04',1,200,1,NULL,10,'','USD'),(13,'346799634057077','2014-11-05','2014-11-20',2,120,1,NULL,11,'','USD'),(14,'620842764999004','2014-11-05','2014-11-20',2,120,2,12,11,'','USD'),(15,'663192685825109','2014-11-05','2015-05-04',1,300,3,12,11,'','USD'),(16,'841597880858725','2014-11-05','2015-05-04',1,220,1,NULL,16,'','USD'),(17,'159833923991587','2014-11-05','2014-11-20',2,120,1,NULL,16,'','USD'),(18,'393339962754276','2014-11-06','2015-05-05',1,500,2,20,18,'','USD');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
