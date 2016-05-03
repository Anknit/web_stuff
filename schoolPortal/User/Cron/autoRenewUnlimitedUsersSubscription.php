<?php
/*
* Author: Aditya
* date: 
* Description: 
*
*/
require_once __DIR__.'./../../Common/php/OperateDB/DbMgrInterface.php';

// read all users from database whose subscription has to be renewed
$usersInUnlimitedSubscriptionMode	=	DB_Read(array(
	'Table'=> 'usersubscriptioninfo',
	'Fields'=> '*',
	'clause'=>	'Subscription_Type = 2 AND Auto_Renewal = 1 AND Validity_End_Date < CURDATE()',
), 'ASSOC', '');

if($usersInUnlimitedSubscriptionMode != 0){
	require_once __DIR__.'./../CommonMethods.php';
	require_once __DIR__.'./../dateTimeMethods.php';
	require_once __DIR__.'./../definitions.php';
	require_once __DIR__.'./../LogicsToUpdateDB/CalculatePackagePricing.php';
	
	for($i =0; $i< count($usersInUnlimitedSubscriptionMode); $i++){
		// get existing features of the user
		$feat	=	DB_Read(array(
			'Table'=> 'licenseinfo',
			'Fields'=> 'Features',
			'clause'=> 'UserID = '.$usersInUnlimitedSubscriptionMode[$i]['UserID'],
		),'ASSOC','');
		$usersInUnlimitedSubscriptionMode[$i]['Features']	=	$feat[0]['Features'];
		// convert feature string to comma separated values
		$CurrentFeatures	=	GetCommaSeparatedApplicationFeatures($usersInUnlimitedSubscriptionMode[$i]['Features']);
		$CurrentPackage		=	$usersInUnlimitedSubscriptionMode[$i]['Package'];
		
		//Calculate Package Price for selected package.
		$PackagePrice		=	CalculatePriceByFeaturesAndPackage($CurrentFeatures, $CurrentPackage);
		
		// get account ID of this user 
		$userAccountID		=	DB_Read(array(
			'Table'=> 'userinfo',
			'Fields'=> 'AccountID',
			'clause'=> 'UserID = '.$usersInUnlimitedSubscriptionMode[$i]['UserID'],
		),'ASSOC','');	
		
		$userAccountID		= $userAccountID[0]['AccountID'];
		// check account information of this user
		$ReadCreditsInput	=	array('Table' => 'accountcredit_info', 'Fields'	=> 'CreditAmount,accountValidity', 'clause' => 'AccountID	=	'.$userAccountID);
		$accountCreditInfo	=	DB_Read($ReadCreditsInput);

		$Credits			=	$accountCreditInfo[0]['CreditAmount'];
		$accountValidity	=	$accountCreditInfo[0]['accountValidity'];
		
		if(!HasDateExpired($accountValidity))	{	//If account validity hasn't expired
			//Read the available credits in accountby session userID, Because only the account manager can update subscription of operators. Therefore the userID corresponds to the account id here
			if($Credits	>	0 && $Credits >= $PackagePrice)//If credits available are greater than package pricing than allow else return the error code.
			{
				$DeductCreditsInput	=	array('Table' => 'accountcredit_info', 'Fields'	=> array('CreditAmount'	=>	$Credits - $PackagePrice, 'UpdatedOn'	=>	'now()', /*'accountValidity'	=>	defaultPPUDates(1)*/), 'clause' => 'AccountID	=	'.$userAccountID);
				$DeductCredits	=	DB_Update($DeductCreditsInput);
				if($DeductCredits	===	true)
				{
					//Get EndValidity for current package
					$EndValidity	=	Get_EndValidityOfPackage($CurrentPackage);
					//Update subscriptioinfo validity

					$SubscriptionInfoInput		=	array('Table' => 'usersubscriptioninfo', 'Fields' => array('Validity_End_Date'	=>	$EndValidity), 'clause' => 'UserID	=	'.$usersInUnlimitedSubscriptionMode[$i]['UserID']);
					$SubscriptionInfoUpdate		=	DB_Update($SubscriptionInfoInput);
					$Output	=	SetErrorCodes(1, __LINE__,  __FILE__);	//All success
				}
				else {
					$Output	=	SetErrorCodes(2, __LINE__,  __FILE__);	//Failed to update credits
				}
			}
			else {
				$Output	=	SetErrorCodes(2, __LINE__,  __FILE__, 0);	//Insufficient funds
			}
		}
		else {
			$Output	=	SetErrorCodes(24, __LINE__,  __FILE__);	//Account validity has expired
		}
	}
}

?>

