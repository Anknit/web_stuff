<?php
/*
* Author: Aditya
* date: 21-Aug-2014
* Description: This defines Permissions specific to a user
*
*/

// Create user specific permissions for various modules
$Module['SubscriptionUpdate']	=	false;
$Module['VoucherGenerate']		=	false;
$Module['VoucherActivate']		=	false;
$Module['deleteUser']			=	false;
$Module['resetUserSUID']		=	false;
$Module['sendAdminMail']		=	false;

	if(isset($_SESSION['userTYPE'])) {
		if(in_array($_SESSION['userTYPE'], $SubscriptionUpdate))
			$Module['SubscriptionUpdate']	=	true;
		if(in_array($_SESSION['userTYPE'], $voucher_User_Type_Allowed))	
			$Module['VoucherGenerate']		=	true;
		if(in_array($_SESSION['userTYPE'], $voucher_Activation_User_Type_Allowed))	
			$Module['VoucherActivate']		=	true;
		if(in_array($_SESSION['userTYPE'], $deleteUser))	
			$Module['deleteUser']			=	true;
		if(in_array($_SESSION['userTYPE'], $resetUserSUID))	
			$Module['resetUserSUID']		=	true;
		if(in_array($_SESSION['userTYPE'], $sendAdminMail))	
			$Module['sendAdminMail']		=	true;
	}	

$SubMenu['Subscriptions']	=	array();
$SubMenu['Credits']			=	array();
$SubMenu['Vouchers']		=	array();
$SubMenu['System']			=	array();

// Create the array of UIMENU list. Only the tabs which will exist in uimenu_list array will be generated
$SubMenu['Reports']['Transactions']	=	array('PermissionSet' => $UISubMenu_TransactionReportTabToUsers,'title' => TITLE27, 'assocDiv'	=>	'transReportTab', 		'name' => 'Transactions',	'PageName'	=> 'TransactionsReports.php');
$SubMenu['Reports']['Usage']		=	array('PermissionSet' => $UISubMenu_UsageReportTabToUsers, 		'title' => TITLE28, 'assocDiv'	=>	'usageReportTab', 		'name' => 'Usage', 			'PageName'	=> 'UsageReports.php');
$SubMenu['Support']['Downloads']	=	array('PermissionSet' => $UISubMenu_DownloadSupportTabToUsers, 	'title' => TITLE29, 'assocDiv'	=>	'supportDownloadDiv',	'name' => 'Downloads', 		'PageName'	=> 'SupportDownloadPage.php');
$SubMenu['Support']['Inquiry']		=	array('PermissionSet' => $UISubMenu_InquirySupportTabToUsers, 	'title' => TITLE35, 'assocDiv'	=>	'supportTab',	'name' => 'Submit an inquiry','PageName'=> 'userPageSupport.php');
/*$UISubMENU_List['Support']['Help']		=	array('PermissionSet' => $UISubMenu_HelpSupportTabToUsers, 		'title' => TITLE12, 'assocDiv'	=>	'supportHelpDiv', 		'name' => 'Help', 			'PageName'	=> 'SupportHelpPage.php');
$UISubMENU_List['Support']['FAQs']			=	array('PermissionSet' => $UISubMenu_FAQSupportTabToUsers, 		'title' => TITLE12, 'assocDiv'	=>	'supportFAQDiv', 		'name' => 'Downloads', 		'PageName'	=> 'SupportFAQPage.php');
*/
foreach($SubMenu as $key=>$value) {
	$subMenuItem	=	$key;
	foreach($SubMenu[$subMenuItem] as $key=>$value) {
		if(isset($_SESSION['userTYPE'])) {
			if(!in_array($_SESSION['userTYPE'], $value['PermissionSet']))
				unset($SubMenu[$subMenuItem][$key]);
		}
	}
}
	
// Create the array of UISubMENU list. Only the tabs which will exist in uimenu_list array will be generated

// Create the array of UIMENU list. Only the tabs which will exist in uimenu_list array will be generated
$UIMENU_List['Subscriptions']	=	array('PageName' => 'userPageSubscription.php', 'PermissionSet' => $UIMenu_SubscriptionTabToUsers, 'SubMenuItems' => $SubMenu['Subscriptions'], 'title' => TITLE7, 'assocDiv'	=>	'myUsersSubscription');
$UIMENU_List['Customers']		=	array('PageName' => 'userPageSubscription.php', 'PermissionSet' => $UIMenu_CustomersTabToUsers, 'SubMenuItems' => $SubMenu['Subscriptions'], 'title' => TITLE8, 'assocDiv'	=>	'myUsersSubscription');
$UIMENU_List['Credits']			=	array('PageName' => 'userPagePurchase.php', 'PermissionSet' => $UIMenu_PurchaseTabToUsers, 'SubMenuItems' => $SubMenu['Credits'], 'title' => TITLE9, 'assocDiv'	=>	'CreditGenerationOption');
$UIMENU_List['Vouchers']		=	array('PageName' => 'userPageVoucher.php', 'PermissionSet' => $UIMenu_VoucherTabToUsers, 'SubMenuItems' => $SubMenu['Vouchers'], 'title' => TITLE10, 'assocDiv'	=>	'VoucherTab');
$UIMENU_List['Reports']			=	array('PageName' => 'userPageReport.php', 'PermissionSet' => $UIMenu_ReportTabToUsers, 'SubMenuItems' => $SubMenu['Reports'], 'title' => TITLE11, 'assocDiv'	=>	'transReportTab');
$UIMENU_List['Support']			=	array('PageName' => 'userPageSupport.php', 'PermissionSet' => $UIMenu_SupportTabToUsers, 'SubMenuItems' => $SubMenu['Support'], 'title' => TITLE12, 'assocDiv'	=>	'supportDownloadDiv');
$UIMENU_List['System']			=	array('PageName' => 'userPageSystem.php',  'PermissionSet' => $UIMenu_SMTPTabToUsers, 'SubMenuItems' => $SubMenu['System'], 'title' => TITLE13, 'assocDiv'	=>	'SMTPdiv');
//$UIMENU_List['Profile']			=	array('PageName' => 'userPageProfile.php',  'PermissionSet' => $UIMenu_ProfileTabToUsers, 'SubMenuItems' => $SubMenu['Profile']);

foreach($UIMENU_List as $key=>$value) {
	if(isset($_SESSION['userTYPE'])) {
		if(!in_array($_SESSION['userTYPE'], $value['PermissionSet']))
			unset($UIMENU_List[$key]);
	}	
}
?>