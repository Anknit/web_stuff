<?php

//USER TYPE DEFINTION 
define('OPERATOR', 1);
define('RESELLER', 2);
define('CUSTOMER', 3);
define('SUPERUSER', 4);
define('VENERA_SALES', 5);
define('SALES_REP', 6);

//User STAtUS 
define('UNVERIFIED', 1); 
define('ACTIVE', 2); 
define('INACTIVE', 3);
 
define('THRESHOLD', 30); 


//Voucher Types
define('Paid', 1); 
define('Demo', 2); 

//Voucher status
define('voucherUnused',1);
define('voucherActive',2);
define('voucherCancelled',3);
define('voucherExpired',4);

//Payment Modes
define('Voucher_Demo',0);
define('PayPal',1);
define('Voucher_Paid',2);

//User Subscription Types
define('Subscription_PayPerUse', 1); 
define('Subscription_PayPerMonth', 2); 

//User Subscription Packages Types
$PackageName[0]	=	0; 	//For PPU
$PackageName[1]	=	30; 	//Days
$PackageName[2]	=	60; 
$PackageName[3]	=	90; 
$PackageName[4]	=	120; 
$PackageName[5]	=	150; 
$PackageName[6]	=	180; 
$PackageName[7]	=	210; 

//Features
define('DefaultFeaturesForPPU', '4;264;10;1;0;20-06-2015'); 
$FeaturesList[1]	=	1; //PULSAR_SERVICE_MODE
$FeaturesList[2]	=	2; //DOLBYE_ANALYSIS_ON
$FeaturesList[3]	=	4; //LOUDNESS_CORRECTION_ON
$FeaturesList[4]	=	8; //NIELSEN_WATERMAEKED_ANALYSIS_ON
$FeaturesList[5]	=	16; //DD_PLUS_ANALYSIS_ON
$FeaturesList[6]	=	32; //HARDING_PSE_ANALYSIS_ON
$FeaturesList[7]	=	64; //VC1_ANALYSIS_ON
$FeaturesList[8]	=	128; //WMA_ANALYSIS_ON
$FeaturesList[9]	=	256; //Feature9
$FeaturesList[100]	=	''; //place Holder for showing basic feature

//PricePerMonth
$FeaturesPricePerMonth[0]	=	500; //Base features cost. It is the minimum cost in monthly package
$FeaturesPricePerMonth[1]	=	10; //Feature1 price per month
$FeaturesPricePerMonth[2]	=	20; //Feature2 price per month
$FeaturesPricePerMonth[3]	=	90; //Loudness correction Feature price per month
$FeaturesPricePerMonth[4]	=	40; //Feature4 price per month

/* Product Sub Version*/
$ProductSubversion[1]	=	15;		//PULSAR_LITE
$ProductSubversion[2]	=	255;	//PULSAR_PRO
$ProductSubversion[3]	=	511; 	//PULSAR_PRO_PPU
$ProductSubversion[4]	=	8;  	//PULSAR_BASIC
$ProductSubversion[5]	=	264; 	//PULSAR_BASIC_PPU

/* ProductType/ControllerType*/
$ProductType[0]	=	0;		//Unknown
$ProductType[1]	=	10;		//General
$ProductType[2]	=	20;		//Primary
$ProductType[3]	=	30;		//Secondary

$GeneralVU	=	1;//GeneralVU
$RapidVU	=	0;//RapidVU
$SupportExpiry	=	'20-06-2015';//SupportExpiry

// Demo Voucher Amount
$demoAmount = 120;

//PPU Dates
$defaultPPUDates[1]	=	"+180 day";	//Add new Customer in ppu mode and set the accountValidity by this date
$defaultPPUDates[2]	=	"+30 day";	//Used in case of demo vouchers. After this much time registration completion process wont be allowed

//AutoRenewal
define('RENEWAL_ON', 1);
define('RENEWAL_OFF', 2);

//DefaultCredits
define('defaultCredits', 100);
?>