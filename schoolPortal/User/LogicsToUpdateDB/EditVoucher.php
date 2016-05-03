<?php
/*
* Author: Ankit
* date: 22-Sep-2014
* Description: This modifies the voucher - Assigning User or changing the status
*
*/
global $Module;
require_once __DIR__.'./../require.php';
require_once $_SESSION['SETUP_ROOT'].'Common/php/MailMgr.php';
	
if($Module['VoucherGenerate'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		if($cat == 'cancel'){
			if($voucherIndex != "" && $voucherIndex != NULL){
				$currentStatus		=	DB_Read(array('Table'=>'voucherinfotable','Fields'=> 'voucherStatus','clause'=> 'voucherIndex = '.$voucherIndex),'ASSOC','');
				if($currentStatus[0]['voucherStatus'] == voucherUnused){
					$updateVoucherInput	=	array(
													'Table'=> 'voucherinfotable',					
													'Fields'=> array(
																'voucherStatus' =>voucherCancelled
																	)	,
													'clause'=> 'voucherIndex = '.$voucherIndex
											);
					$result = DB_Update($updateVoucherInput);
				}
				else{
					$Output = 2;
				}					
			}
			
		}
		elseif($cat == 'assign'){
			if($voucherIndex != "" && $voucherIndex != NULL && $user != "" && $user != NULL){
				$currentStatus		=	DB_Read(array('Table'=>'voucherinfotable','Fields'=> '*', 'clause'=> 'voucherIndex = '.$voucherIndex),'ASSOC','');
				if($currentStatus[0]['voucherStatus'] == voucherUnused && $currentStatus[0]['CustomerID'] == null){
					$accountID	=	$user;
					$updateVoucherInput	=	array(
						'Table'=> 'voucherinfotable',					
						'Fields'=> array('CustomerID' =>$user),
						'clause'=> 'voucherIndex = '.$voucherIndex
					);
					$result = DB_Update($updateVoucherInput);
				}					
			}
			
			if(isset($result)){	//If successfully saved in database
					$VoucherGeneratorName	=	DB_Read(array('Table'=> 'userinfo',	'Fields'=> 'Name', 'clause'	=> 'UserID	=	'.$_SESSION['userID']));
					$AssignedUserProfileInfo=	getInfoFrom('user_details', 'profile', $user);
					$recipientFullName		=	$AssignedUserProfileInfo['Name'];
					if($recipientFullName == ""){$recipientFullName	=	'User';}
					$voucherType			=	$currentStatus[0]['VoucherType'] ==	1 ? 'Paid' : 'Demo';
					$voucherMailBody		=	getEmailBody('VoucherAssigned', array('RecipientsName' => $recipientFullName, 'VoucherCodeNumber' => $currentStatus[0]['voucherID'], 'VoucherAmount' => $currentStatus[0]['Amount'], 'VoucherValidity' => $currentStatus[0]['EndValidity'], 'VoucherType' => $voucherType, 'VoucherTypeValue' => $currentStatus[0]['VoucherType'], 'Notes'	=>	$currentStatus[0]['UserNotes']));
					$VoucherMailSubject		=	getEmailSubject('VoucherAssigned', array('VoucherCodeNumber' => $currentStatus[0]['voucherID']));

					$voucherMailRecipient	=	$AssignedUserProfileInfo['Username'];
					$voucherMailResult		=	send_Email($voucherMailRecipient, $VoucherMailSubject , $voucherMailBody);
				}
			}
		}
		if($result)	//If successfully saved in database
			$Output	=	1;	//When the voucher has been saved in database send output	=	1
	}

else {
	$Output	=	SetErrorCodes(9, __LINE__,  __FILE__);	//User is not authorized to create vouchers
}
?>
