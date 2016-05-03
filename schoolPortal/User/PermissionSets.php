<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines variables for various permission sets
*
*/
require_once  __DIR__.'/definitions.php';

//Permissions for backend
$voucher_User_Type_Allowed				=	array(SUPERUSER,VENERA_SALES,RESELLER);	//Allow admin, venera sales, reseller
$voucher_Activation_User_Type_Allowed	=	array(CUSTOMER);	//Allow only customer
$SubscriptionUpdate						=	array(CUSTOMER);	//Allow only account manager
$deleteUser								=	array(SUPERUSER,VENERA_SALES,CUSTOMER);
$resetUserSUID							=	array(SUPERUSER);
$sendAdminMail							=	array(SUPERUSER);

//Permissions for UI
$UIMenu_SubscriptionTabToUsers  		=	array(CUSTOMER);
$UIMenu_CustomersTabToUsers	   			=	array(SUPERUSER,RESELLER,VENERA_SALES,SALES_REP);
$UIMenu_PurchaseTabToUsers				=	array(CUSTOMER);

//$UIMenu_ProfileTabToUsers				=	array(OPERATOR,SUPERUSER,VENERA_SALES,RESELLER,CUSTOMER,SALES_REP);
$UIMenu_ReportTabToUsers				=	array(OPERATOR,SUPERUSER,VENERA_SALES,CUSTOMER,SALES_REP);
$UIMenu_SupportTabToUsers				=	array(OPERATOR,SUPERUSER,CUSTOMER,RESELLER,VENERA_SALES);
$UIMenu_VoucherTabToUsers				=	array(VENERA_SALES,RESELLER);
$UIMenu_SMTPTabToUsers					=	array(SUPERUSER);

$UISubMenu_TransactionReportTabToUsers	=	array(SUPERUSER,VENERA_SALES,CUSTOMER);
$UISubMenu_UsageReportTabToUsers		=	array(OPERATOR,SUPERUSER,CUSTOMER);
//$UISubMenu_HelpSupportTabToUsers		=	array(OPERATOR,SUPERUSER,VENERA_SALES,RESELLER,CUSTOMER,SALES_REP);
$UISubMenu_DownloadSupportTabToUsers	=	array(OPERATOR,CUSTOMER);
$UISubMenu_InquirySupportTabToUsers		=	array(OPERATOR,SUPERUSER,VENERA_SALES,RESELLER,CUSTOMER,SALES_REP);
$UISubMenu_HelpSupportTabToUsers		=	array(OPERATOR,SUPERUSER,VENERA_SALES,RESELLER,CUSTOMER,SALES_REP);
$UISubMenu_FAQSupportTabToUsers			=	array(OPERATOR,SUPERUSER,VENERA_SALES,RESELLER,CUSTOMER,SALES_REP);


//Permissible information
$userTypeListForSales			=	array(RESELLER,CUSTOMER,SALES_REP);
$userTypeListForSuperUser		=	array(RESELLER,CUSTOMER,SALES_REP,VENERA_SALES,OPERATOR);
?>