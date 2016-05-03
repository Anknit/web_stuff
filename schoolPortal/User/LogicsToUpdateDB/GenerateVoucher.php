<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This generates a voucher code and sends an email to the registered email id
*
*/
global $Module;
require_once __DIR__.'./../require.php';
require_once $_SESSION['SETUP_ROOT'].'Common/php/MailMgr.php';
	
if($Module['VoucherGenerate'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		if($voucherAmount != "" && $voucherEndDate != "" && $voucherType != "" && $voucherAmount != NULL && $voucherEndDate != NULL && $voucherType != NULL)
		{
			$voucherID			=	randomNumber_String(14);
			$insertVoucherInput = array(
										'Table'=> 'voucherinfotable',					
										'Fields'=> array (							
												'voucherID'		=>$voucherID,
												'StartValidity'	=>'now()',
												'EndValidity'   =>$voucherEndDate,
												'VoucherType'   =>$voucherType,
												'UserNotes'   	=>$userNotes,
												'Amount'        =>$voucherAmount,	//Just for demo
												'voucherStatus' =>voucherUnused,	//Unused initially
												'GeneratedBy'  	=>$_SESSION['userID']
											)
										);
			$result = DB_Insert($insertVoucherInput);
			if($result)	//If successfully saved in database
			{
				$VoucherTypeValue	=	$voucherType;
				if($voucherType	==	Demo)	
					$voucherType	=	'Demo';
				elseif($voucherType	==	Paid)
					$voucherType	=	'Paid';

				$VoucherGeneratorName	=	DB_Read(array('Table'=> 'userinfo',	'Fields'=> 'Name', 'clause'	=> 'UserID	=	'.$_SESSION['userID']));
				$recipientFullName	=	$VoucherGeneratorName[0]['Name'];
				if($recipientFullName == ""){$recipientFullName	=	'User';}
				
				$voucherMailBody		=	getEmailBody('NewVoucher', array('RecipientsName' => $recipientFullName, 'VoucherCodeNumber' => $voucherID, 'VoucherAmount' => $voucherAmount, 'VoucherValidity' => $voucherEndDate, 'VoucherType' => $voucherType, 'VoucherTypeValue' => $VoucherTypeValue, 'Notes'	=>	$userNotes));

				$VoucherMailSubject		=	getEmailSubject('NewVoucher', array('VoucherCodeNumber' => $voucherID));


				$voucherMailRecipient	=	$_SESSION['Username'];
				$voucherMailResult		=	send_Email($voucherMailRecipient, $VoucherMailSubject , $voucherMailBody);
				//if($voucherMailResult)
				$Output	=	1;	//When the voucher has been saved in database send output	=	1
			}
		}
	}
}
else {
	$Output	=	SetErrorCodes(9, __LINE__,  __FILE__);	//User is not authorized to create vouchers
}
?>
