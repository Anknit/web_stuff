<?php
/*
* Author: Aditya
* date: 21-Aug-2014
* Description: 
*
*/
global $Module;
if(IfValid($userStatus))	//Update user status in user info table
{
	$DbOperationArray	=	array('Fields' => array('userStatus' => $userStatus), 'Table' => 'userinfo', 'clause' => 'UserID	=	'.$UID);
	$result	=	DB_Update($DbOperationArray);
	if($result)
		$Output	=	SetErrorCodes(1, __LINE__,  __FILE__);	//All success
}
if($Module['SubscriptionUpdate'])	//If subscription update is set to true for the logged in user
{
	if($userStatus	==	2) {	//If user is active then only perform other operations
		if(IfValid($Subscription))	//Update user subscription in usersubscription table
		{
			if($Subscription	==	Subscription_PayPerUse)	//PPU
			{
				$renewal	=	RENEWAL_OFF;
				//Check if user is currently in monthly ssubscription mode. If yes, then query for expiry date to check if validity is still remaining. If validity is still remaining, then deny the change of subscription to ppu, as it will be loss for customer.
				$SubscriptionInfoRead		=	array('Table' => 'usersubscriptioninfo', 'Fields' => 'Validity_End_Date, Subscription_Type', 'clause' => 'UserID	=	'.$UID);
				$SubscriptionInfo			=	DB_Read($SubscriptionInfoRead);
				if($SubscriptionInfo[0]['Subscription_Type']	==	Subscription_PayPerMonth && (strtotime($SubscriptionInfo[0]['Validity_End_Date']) - strtotime(date('Y-m-d'))) > 0) {
						$Output	=	SetErrorCodes(4, __LINE__,  __FILE__);	//User has already paid for monthly package
						return $Output;
				}
				else {
					//Update the license info for service and features. Before this read the existing features
					$Insertlicenseinfo =  DB_Update(array(
							'Table'=> 'licenseinfo',					
							'Fields'=> array (							
									'Features'       		=>DefaultFeaturesForPPU,
									'ServiceID'       		=>'PPU'
							 ),
							 'clause' => 'UserID	=	'.$UID
					));
					//Dont check for package, features, rather just update the subscription only if the expiry date has passed or is blank
					$InsertSubscriptionInfo =  DB_Update(array(	
															'Table'=> 'usersubscriptioninfo',					
															'Fields'=> array (							
																	'Subscription_Type'  =>Subscription_PayPerUse,
																	'Validity_End_Date'	 =>'',	//End validity in PPU should be read from accountTable
																	'Package'	 		 =>0,	//There 's no package value for ppu
															),
															 'clause' => 'UserID	=	'.$UID
					));
				}
			}
			elseif($Subscription	==	Subscription_PayPerMonth)	//Monthly
			{
				//Calculate Package Price for selected package.
				require_once 'CalculatePackagePricing.php';
				$PackagePrice	=	CalculatePriceByFeaturesAndPackage($Features, $Package);
				
				$ReadCreditsInput	=	array('Table' => 'accountcredit_info', 'Fields'	=> 'CreditAmount,accountValidity', 'clause' => 'AccountID	=	'.$_SESSION['accountID']);
				$accountCreditInfo	=	DB_Read($ReadCreditsInput);
				$Credits			=	$accountCreditInfo[0]['CreditAmount'];
				$accountValidity	=	$accountCreditInfo[0]['accountValidity'];
				
				if(!HasDateExpired($accountValidity))	{	//If account validity hasn't expired
					//Read the available credits in accountby session userID, Because only the account manager can update subscription of operators. Therefore the userID corresponds to the account id here
					if($Credits	>	0 && $Credits >= $PackagePrice)//If credits available are greater than package pricing than allow else return the error code.
					{
						$DeductCreditsInput	=	array('Table' => 'accountcredit_info', 'Fields'	=> array('CreditAmount'	=>	$Credits - $PackagePrice, 'UpdatedOn'	=>	'now()', /*'accountValidity'	=>	defaultPPUDates(1)*/), 'clause' => 'AccountID	=	'.$_SESSION['accountID']);
						$DeductCredits	=	DB_Update($DeductCreditsInput);
						if($DeductCredits	===	true)
						{
							//Update subscriptioinfo validity
							$EndValidity	=	Get_EndValidityOfPackage($Package);
							
							
							if(!IfValid($renewal)){
								$renewal	=	RENEWAL_ON;
							}
							
							$SubscriptionInfoInput		=	array('Table' => 'usersubscriptioninfo', 'Fields' => array('Validity_End_Date'	=>	$EndValidity, 'Subscription_Type'	=>	Subscription_PayPerMonth, 'Package'	=>	$Package), 'clause' => 'UserID	=	'.$UID);
								
							$SubscriptionInfoUpdate		=	DB_Update($SubscriptionInfoInput);
							if($SubscriptionInfoUpdate)	//When license details have been updated
							{
								//Update the license info for EndValidity and features. Before this read the existing features.
								//Asof now update the demo value to the features :- DefaultFeaturesForPPU
								$Features	=	new getFeaturesList(array($Features, '', '', '', '', ''));	// change it to actual format
								$Features	=	$Features->Features;	
								$LicenseInfoInput	=	array('Table' => 'licenseinfo', 'Fields'	=> array('Features'	=>	$Features), 'clause' => 'UserID	=	'.$UID);
								$LicenseUpdate		=	DB_Update($LicenseInfoInput);
							}
							
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
	}	
							
	if(!IfValid($renewal)){
		if($Subscription	==	Subscription_PayPerMonth)	//Monthly
			$renewal	=	RENEWAL_ON;
	}
	$SubscriptionRenewal		=	array('Table' => 'usersubscriptioninfo', 'Fields' => array('Auto_Renewal'	=>	$renewal), 'clause' => 'UserID	=	'.$UID);
	$SubscriptionRenewalUpdate		=	DB_Update($SubscriptionRenewal);
}
?>