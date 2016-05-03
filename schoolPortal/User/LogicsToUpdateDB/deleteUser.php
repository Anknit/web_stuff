<?php 
/*
* Author: Aditya
* date: 16-Sep-2014
* Description: This is invoked from 2 instances, one when new user addition fails for some reason (so this rollbacks the user addition to database), and secondly when user is deleted from interface.
*
*/
global $Module;
if($Module['deleteUser'])	//If subscription update is set to true for the logged in user
{
	function DeleteUserInfoFromTable($TableName, $OperatorUID = "") {
		global $UID;
		if($OperatorUID != "") {	//If the operators id is sent then change the uid to operator's id. This is the case when an account has been deleted and then respective operators are being deleted
			$UID	=	$OperatorUID;
		}
			
		$result = DB_Delete(array(
							'Table'=> $TableName,						//Mandatory
							'clause'=> 'UserID = '.$UID,
							));
		return $result;					
	}
	
	function DeleteCreditInfo(){
		global $UID;
		$accountID	=	getInfoFrom('user_details', 'userAccountID', $UID);
		$result = DB_Delete(array(
							'Table'=> 'accountcredit_info',						//Mandatory
							'clause'=> 'AccountID = '.$accountID,
							));
	}
	
	function DeleteRelatedOperatorsInfo(){
		global $UID;	//This is account id
		$accountID	=	getInfoFrom('user_details', 'userAccountID', $UID);
		$result = DB_Read(array(	//get the operators related to the account
							'Table'=> 'userinfo',						
							'Fields'=> 'UserID',
							'clause'=> 'AccountID = '.$accountID,
							));
		if($result) {
			for($i = 0; $i< count($result); $i++) {
				$userID				=	$result[$i]['UserID'];
				$deleteUser			=	DeleteUserInfoFromTable('userinfo', $userID);
				$deleteLicense		=	DeleteUserInfoFromTable('licenseinfo', $userID);
				$deleteSubscription	=	DeleteUserInfoFromTable('usersubscriptioninfo', $userID);
				$deleteSessions		=	DeleteUserInfoFromTable('session_info', $userID);
				$deleteUsage		=	DeleteUserInfoFromTable('usageinfo', $userID);
				$deleteUsage		=	DeleteUserInfoFromTable('usageinfo', $userID);
			}
			return true;	
		}
	}
	
	function CleanUsersInfoFromDb(){
		global $userTYPE;	//This will be present when script is invoked by savenewUser.php page
		global $UID;
		if(!IfValid($userTYPE))
			$userTYPE	=	getUserType($UID);
			
		$deleteUser	=	DeleteUserInfoFromTable('userinfo');
		if($userTYPE == OPERATOR || $userTYPE == CUSTOMER) {
			$deleteLicense		=	DeleteUserInfoFromTable('licenseinfo');
			$deleteSubscription	=	DeleteUserInfoFromTable('usersubscriptioninfo');
			$deleteSessions		=	DeleteUserInfoFromTable('session_info');
			$deleteUsage		=	DeleteUserInfoFromTable('usageinfo');
			$deleteUsage		=	DeleteUserInfoFromTable('usageinfo');
		}
		
		if($userTYPE	==	CUSTOMER) {
			//$deleteCredits			=	DeleteCreditInfo();
			//$deleteoperatorsInfo	=	DeleteRelatedOperatorsInfo();
		}
		
		if($deleteUser) {
			$deleteUser	=	1;	//Operation successful
		}
		else
			$deleteUser	=	2;
			
		return $deleteUser;
	}
	
	require_once __DIR__.'./../require.php';
	if(!isset($UID)) {
		$query = $_SERVER['QUERY_STRING'];
		parse_str($query);
	}
	$Output	=	CleanUsersInfoFromDb();
	
}
else {
	$Output	=	SetErrorCodes(11, __LINE__,  __FILE__);	//User is not authorized to create vouchers
}
?>