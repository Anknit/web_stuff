<?php
/*
* Author: Aditya
* date: 16-Sep-2014
* Description: This class retrieves all user related information
*
*/

class user_details{
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
* @return Associative array of values or errors according to dbmanager module
*/
	public function profile($userId	=	''){
		if($userId	==	'')
			$userId	=	$_SESSION['userID'];
			
		$UserProfileInfo	= 	DB_Read(
			array(	'Table'=> 'userinfo',
					'Fields'=> '*',
					'clause' => 'UserID = "'.$userId.'"'
				 ),
				 'ASSOC',
				 ''
		);
		if($UserProfileInfo)
			return $UserProfileInfo[0];
	}

	public function getAccountManagerID($accountId	=	''){
		if($accountId	==	'')
			return false;

		$AccountManagerID	= 	DB_Read(
			array(	'Table'=> 'userinfo',
					'Fields'=> 'UserID',
					'clause' => 'AccountID = "'.$accountId.'" AND UserType = "'.CUSTOMER.'" AND userStatus = "'.ACTIVE.'"' 
				 ),
				 'ASSOC',
				 ''
		);
		if($AccountManagerID)
			return $AccountManagerID[0]['UserID'];
		else
			return false;
	}	

	public function userAccountID($userId	=	''){
		if($userId	==	'')
			return false;

		$AccountID	= 	DB_Read(
			array(	'Table'=> 'userinfo',
					'Fields'=> 'AccountID',
					'clause' => 'UserID = "'.$userId.'"'
				 ),
				 'ASSOC',
				 ''
		);
		if($AccountID)
			return $AccountID[0]['AccountID'];
		else
			return false;
	}

	public function commaSeparatedUserIDStringRegisteredBy($userId	=	''){
		if($userId	==	'')
			$userId	=	$_SESSION['userID'];
			
		$usersIdInfo	= 	DB_Read(
			array(	'Table'=> 'userinfo',
					'Fields'=> 'UserID',
					'clause' => 'regAuthorityID IN ("'.$userId.'")'
				 ),
				 'NUM_ARR',
				 ''
		);
		$usersIdString	=	'';
		if($usersIdInfo) {
			for($i = 0; $i< count($usersIdInfo); $i++){
				if($usersIdString != '')
					$usersIdString	.=	', ';

				$usersIdString	.=		'"'.$usersIdInfo[$i][0].'"';
			}
		}	
		return $usersIdString;
	}
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
* This argument can be a list(array) of users	
* @return all the users whose regAuthorityid (added by) is userId(provided in argument). In case of array argument also, all the users registered by the provided userid's will be returned.
*/
	public function usersRegisteredBy($userIdList	=	''){
		if($userIdList	==	'' || count($userIdList) <= 0 || $userIdList	==	NULL){
			return false;
		}
		
		//Dont show operators to anyone other than customers.
		$excludeUserType	=	0;
		if($_SESSION['userTYPE']	!=	CUSTOMER)
			$excludeUserType	=	OPERATOR;
		
		$clause	=	'regAuthorityID IN (\''.implode('\',\'', $userIdList).'\') AND UserType != '.$excludeUserType;
		$registeredUsers	= 	DB_Read(
			array(	'Table'=> 'userinfo',					
					'Fields'=> 'userID',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $registeredUsers;
	}
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
* @return all the users who are registered by the users(referred in argument) or the users down the lane upto the level of customers.
* Only if the userType is superuser, then the information of operators would also be returned
*/
	public function users_under_all_Levels_to_customers($userId	=	'', $userType){
		if($userId	==	'')
			$userId	=	$_SESSION['userID'];
		
		$maxLoopCount	=	1;
		if($userType	==	SUPERUSER)
			$maxLoopCount	=	4;
		elseif($userType	==	VENERA_SALES)
			$maxLoopCount	=	2;
		elseif($userType	==	RESELLER || $userType	==	CUSTOMER)
			$maxLoopCount	=	1;
		
		$usersIDINFO	=	array();
		$retrieve_Users_registered_by	=	array();
		$retrieve_Users_registered_by[]	=	$userId;
		
		for($i = 0; $i< $maxLoopCount; $i++){
			$resultOFUSERSLIST	=	$this -> usersRegisteredBy($retrieve_Users_registered_by);
			$retrieve_Users_registered_by	=	array();	//empty the values
			for($j = 0; $j < count($resultOFUSERSLIST); $j++){
				$retrieve_Users_registered_by[]	=	$resultOFUSERSLIST[$j]['userID'];
			}
			$usersIDINFO		=	array_indexed_merge_at_end($usersIDINFO, $resultOFUSERSLIST);
		}
		
		return $usersIDINFO;
	}
	
/*
* @access public
* @param  $userId. It is optional in the sense that the default value will be considered as session id
  Behavior:	 For the userID user type is determined and as per the permission sets the profile of users registered under them are retrieved
  Hence if the userid is that of VENERA SALES person, the USER's list would comprise of all the users
* @return 
*/
	public function registeredUsersProfile($arrayParams	=	''){
		if(isset($arrayParams['userId']))
			$userId	=	$arrayParams['userId'];
			
		$ExcessClauseForSortAndLimit	=	'';
		if(isset($arrayParams['clause']))
			$ExcessClauseForSortAndLimit	=	$arrayParams['clause'];

		$userType	=	'';
		if($userId	==	''){
			$userId		=	$_SESSION['userID'];
			$userType	=	$_SESSION['userType'];
		}
		
		if($userType	==	''){
			$userProfile	=	$this ->	profile($userId);
			$userType		=	$userProfile['UserType'];
		}
		
		if($userType == VENERA_SALES){
			global $userTypeListForSales;
			$myUsers	=	$this	->	users_under_all_Levels_to_customers($userId, VENERA_SALES);
			$myusersId	=	array();
			for($i = 0; $i< count($myUsers); $i++){
				$myusersId[]	=	$myUsers[$i]['userID'];
			}
			$clause	=	'UserID IN (\''.implode('\',\'', $myusersId).'\')';
		}
		elseif($userType == SUPERUSER){
			global $userTypeListForSuperUser;
			$clause	=	'UserType IN (\''.implode('\',\'', $userTypeListForSuperUser).'\') AND UserID != '.$userId;
		}
		else	
			$clause	=	'regAuthorityID = '.$userId;

		$clause	.=	$ExcessClauseForSortAndLimit;
		$regUsersProfileInfo	= 	DB_Read(
			array(	'Table'=> 'userinfo',					
					'Fields'=> '*',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $regUsersProfileInfo;
	}
	
	public function accountUsersProfile($accountID	=	'', $arrayParam	=	''){
		if($accountID	==	''){
			$accountID	=	$_SESSION['accountID'];
		}
		$clause	=	'AccountID = '.$accountID;

		if(isset($arrayParam['clause'])){
			$clause	.=	$arrayParam['clause'];
		}
		
		$accountUsersProfile	= 	DB_Read(
			array(	'Table'=> 'userinfo',					
					'Fields'=> '*',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $accountUsersProfile;
	}
	
	public function registeredUsersAccountInfo($userIdList){
		if($userIdList	==	'' || count($userIdList) <= 0 || $userIdList	==	NULL){
			return false;
		}
		
		$clause	=	'AccountID IN (\''.implode('\',\'', $userIdList).'\')';
		$registeredUsersAccountInfo	= 	DB_Read(
			array(	'Table'=> 'accountcredit_info',					
					'Fields'=> '*',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $registeredUsersAccountInfo;
	}
	
	public function vouchersGeneratedByUser($arrayParams){
		$userIdList	=	$arrayParams['userIdList'];
		$ExcessClauseForSortAndLimit	=	'';
		if(isset($arrayParams['clause']))
			$ExcessClauseForSortAndLimit	=	$arrayParams['clause'];
		if($_SESSION['userTYPE']	!=	SUPERUSER){
			if($userIdList	==	'' || count($userIdList) <= 0 || $userIdList	==	NULL)
				return false;
		}
		if($_SESSION['userTYPE'] == VENERA_SALES){
			$vouchersGeneratedByUser	=	DB_Query('Select * from voucherinfotable, userinfo Where voucherinfotable.GeneratedBy = userinfo.UserID AND userinfo.UserID IN ('.$userIdList.') '.$ExcessClauseForSortAndLimit);
		}
		elseif($_SESSION['userTYPE'] == SUPERUSER){
			$vouchersGeneratedByUser	=	DB_Query('Select * from voucherinfotable, userinfo Where voucherinfotable.GeneratedBy = userinfo.UserID '.$ExcessClauseForSortAndLimit);
		}
		else{
			$vouchersGeneratedByUser	=	DB_Query('Select * from voucherinfotable, userinfo Where voucherinfotable.GeneratedBy = userinfo.UserID AND userinfo.UserID = '.$_SESSION['userID'].' '.$ExcessClauseForSortAndLimit);
		}
		return $vouchersGeneratedByUser;
	}
		
	public function customerAccountDetails( $accountID = '', $ExcessiveClause = '', $arg3 = '') {
		if($accountID	==	'')
			$accountID	=	$_SESSION['accountID'];

		$Query	=	'Select *, Subscription_Type AS Plan, Validity_End_Date As Expiry From userinfo Left Join usersubscriptioninfo On userinfo.UserID = usersubscriptioninfo.UserID Left Join licenseinfo  On userinfo.UserID = licenseinfo.UserID LEFT Join accountcredit_info On userinfo.AccountID = accountcredit_info.AccountID Where userinfo.AccountID = '.$accountID;	

		if($ExcessiveClause != '')
			$Query	.=	$ExcessiveClause;

		$accountDetails	=	DB_Query($Query, 'ASSOC');	
		return $accountDetails;
	}
	
	public function usersSubscription($userIdList){
		if($userIdList	==	'' || count($userIdList) <= 0 || $userIdList	==	NULL){
			return false;
		}
		
		$clause	=	'UserID IN (\''.implode('\',\'', $userIdList).'\')';
		$usersSubscriptions	= 	DB_Read(
			array(	'Table'=> 'usersubscriptioninfo',					
					'Fields'=> '*',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		return $usersSubscriptions;
	}
	
	public function usersFeatures($userIdList){
		if($userIdList	==	'' || count($userIdList) <= 0 || $userIdList	==	NULL){
			return false;
		}
		
		$clause	=	'UserID IN (\''.implode('\',\'', $userIdList).'\')';
		$result	= 	DB_Read(
			array(	'Table'=> 'licenseinfo',					
					'Fields'=> 'Features',						
					'clause'=> $clause
				 ),
				 'ASSOC',
				 ''
		);
		
		for($i = 0; $i < count($result); $i++) {
			$usersLicenseFeatures[]	=	GetCommaSeparatedApplicationFeatures($result[$i]['Features']);
		}
		
		return $usersLicenseFeatures;
	}
	
	public function systemSettings($uid = ''){	//argument has not been used inside of function. But is just a  filler
		global $UIMENU_List;
		if(isset($UIMENU_List['System']) && !$UIMENU_List['System']){
			return false;	//Unauthorized user
		}
		
		$systemSettings	= 	DB_Read(
			array(	'Table'=> 'systemsettings',					
					'Fields'=> '*'
				 ),
				 'ASSOC',
				 ''
		);
		$systemSettings	=	$systemSettings[0];
		return $systemSettings;
	}
		
	public function usageDetails($arrayParams) {	//get the usage (job analysis details corresponding to users list
		$ExcessClauseForSortAndLimit	=	'';
		if(isset($arrayParams['clause'])) {
			$ExcessClauseForSortAndLimit	=	$arrayParams['clause'];
			
			if($_SESSION['userTYPE'] == CUSTOMER){
				$usageReportResult	=	DB_Query('Select * from usageinfo, userinfo Where usageinfo.UserID = userinfo.UserID AND userinfo.AccountID = '.$_SESSION['accountID'].' '.$ExcessClauseForSortAndLimit);
			}
			elseif($_SESSION['userTYPE'] == SUPERUSER){
				$usageReportResult	=	DB_Query('Select * from usageinfo, userinfo Where usageinfo.UserID = userinfo.UserID '.$ExcessClauseForSortAndLimit);
			}
			else{
				$usageReportResult	=	DB_Query('Select * from usageinfo, userinfo Where usageinfo.UserID = userinfo.UserID AND userinfo.UserID = '.$_SESSION['userID'].' '.$ExcessClauseForSortAndLimit);
			}
		
			return $usageReportResult;
		}
	}
};
	
function checkUserTypeCustomer($argArrayUserInfo){
	if($argArrayUserInfo['UserType']	==	CUSTOMER){
		return true;
	}
	else
		return false;
}
	
function checkUserTypeReseller($argArrayUserInfo){
	if($argArrayUserInfo['UserType']	==	Reseller){
		return true;
	}
	else
		return false;
}
?>
