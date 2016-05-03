<?php
/*
* Author: Aditya
* date: 21-Aug-2014
* Description: 
*
*/

require_once __DIR__.'/require.php';


function getFieldsList($Arraydefined)
{
	$List	=	"";
	$List	=	implode(',', $Arraydefined);
}

if(isset($_SERVER['QUERY_STRING']))
{
	$Output	=	SetErrorCodes(0, __LINE__,  __FILE__);
	//For all the backend processes, define an elment in below array
	$OperationTable['Subscription']		=	'LogicsToUpdateDB/SubscriptionLogic.php';
	$OperationTable['VoucherGenerate']	=	'LogicsToUpdateDB/GenerateVoucher.php';
	$OperationTable['VoucherActivate']	=	'LogicsToUpdateDB/verifyVoucherCode.php';
	$OperationTable['deleteUser']		=	'LogicsToUpdateDB/deleteUser.php';
	$OperationTable['VoucherEditing']	=	'LogicsToUpdateDB/EditVoucher.php';
	$OperationTable['resetUserSUID']	=	'LogicsToUpdateDB/resetUserSUID.php';
	$OperationTable['sendAdminMail']	=	'LogicsToUpdateDB/sendAdminMail.php';
	
	$queryString 		= $_SERVER['QUERY_STRING'];
	$cleanQuery			= Random_decode($queryString);
	parse_str($cleanQuery);
	if(isset($OperationTable[$Operation]))
	{
		require_once	$OperationTable[$Operation];	//Run the logic of corresponding file
	}
	echo $Output;
}
?>