/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.6.17 : Database - demoDatabase
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `demoDatabase`;

USE `demoDatabase`;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `accountcredit_info` */

LOCK TABLES `accountcredit_info` WRITE;

UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `licenseinfo` */

LOCK TABLES `licenseinfo` WRITE;

UNLOCK TABLES;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `payment_info` */

LOCK TABLES `payment_info` WRITE;

UNLOCK TABLES;

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

LOCK TABLES `session_info` WRITE;

UNLOCK TABLES;

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

LOCK TABLES `supportrequest` WRITE;

UNLOCK TABLES;

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

LOCK TABLES `systemsettings` WRITE;

UNLOCK TABLES;

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

LOCK TABLES `usageinfo` WRITE;

UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `userinfo` */

LOCK TABLES `userinfo` WRITE;

UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `usersubscriptioninfo` */

LOCK TABLES `usersubscriptioninfo` WRITE;

UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `voucherinfotable` */

LOCK TABLES `voucherinfotable` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
