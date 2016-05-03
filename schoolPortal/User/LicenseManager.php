<?php
/*
 * Author: Rajarshi
* date: 28-jul-2014
* Description: This module is responsible for License Management 
*
*All RPC function names are preceded by RPC_XXXX
*
*/


function LM_GetLicenseInfo(&$respParam)
{
	//RETREIVE THE SESSION VARIABLES
	//GET THE SESSION ID\
	$status ='SUCCESS'; 
	if(!isset($_SESSION['userID']))
	{
		$errMsg = 'Error: Session UserID not found';
		SetErrorCodes(getErrorMessage(24), __LINE__,  __FILE__);
		$status = 'FAIL';
		goto E;
	}
	$userID = $_SESSION['userID']; 
	$errMsg = '';
	$ReadTestArray	=	array(
			'Fields'=> 'FirstTimeRegistration,SUID,ServiceID,Features',
			'Table'=> 'licenseinfo',
			'clause'=> 'UserID='.$userID,
			'order'=>""
	);
	$Result	=	DB_Read($ReadTestArray, 'ASSOC', '');
	if(!$Result)
	{
		$errMsg = 'Error: License Registration Not Found';
		SetErrorCodes(getErrorMessage(25), __LINE__,  __FILE__);
		$status = 'FAIL';
		goto E;
	}
	//get the SUID registered 
	if($_SESSION['suid'] != $Result[0]['SUID'])
	{
		$errMsg = 'Error: SUID Mismatch in License database';
		SetErrorCodes(getErrorMessage(26).', Recieved SUID : '.$_SESSION['suid'].' And SUID already present is '.$Result[0]['SUID'], __LINE__,  __FILE__);
		$status = 'FAIL';
		goto E;
	}
	//get the serviceID 
	//get the license code 
	$licCode =  $Result[0]['Features']; 
	if(!$licCode)
	{
		$errMsg = 'Error:License Features Not found';
		SetErrorCodes(getErrorMessage(27), __LINE__,  __FILE__);
		$status = 'FAIL';
		goto E;
	}
	
	//get the expiry date //right now skip the check 
	//$expiryDate =  $Result[0]['EndValidity']; 	Commented because the field has been removed from licenseinfo table
	
	//validate each of the above paramters 
	
	//if sucessful then return the license code as delimited string 
	
	
	//RETRIEVE THE SERVICE ID AND THE USER ID
	
	//GET THE LICENSE CODE
	//$appFeature = 1; 
	//$prodSubVersion = 15; 
	//$prodType = 10; 
	//$NumGenVU = 1; 
	//$NumRapidVU = 1; 
	//$SupportExpiryDate = '20-06-2015';  	
	//$licCode = $appFeature . ';' .$prodSubVersion . ';' .$prodType . ';' . $NumGenVU . ';'. $NumRapidVU. ';' . $SupportExpiryDate;
	
E:
	
	$respParam = '&STATUS=' . $status . '&' . 'LICENSE_CODE=' .  $licCode . '&MESSAGE='.$errMsg;
	 
	return true; 
	
	//1;15;10;1;1;20-06-2015
	//RETURN THE CODE
}
/*
 * ApplicationFeatures--	int--Each bit in this integer is corresponded to a licensed feature. SERVICE_MODE ->1, DOLBY->2,  LOUDNESS_CORRECTION->3, NIELSEN->4, DD+->5 bit  are set
   ProductSubVerison --	int --This is used to identify the product version for Pulsar(15 for Standard and  255 for Pro)
   ProductType 	-- int -- 	Product type used to define the controller type as defined below:
		0 = Not valid
		10 = Genral
		20 = Primary
		30 = Secondary
	NumGenVU --	int--Number of licensed VUs. For PPU it is 1 always
	NumRapidVU --int -- Number of licensed rapid VUs. For PPU it is 1 always
	SupportExpiryDate--	int--string stating the expiry date of support
 * 
 */


function LM_CheckSubscriptionValidity($userID,$accountID, &$daysRemaining, &$subscriptionType)
{
/*	$datetime1 = date_create('2009-10-11');
	$datetime2 = date_create('2009-10-13');
	$interval = date_diff($datetime1, $datetime2);
	echo $interval->format('%R%a days');
*/
		
	$ReadTestArray	=	array(
			'Fields'=> 'Subscription_Type,Validity_Start_Date,Validity_End_Date',
			'Table'=> 'usersubscriptioninfo',
			'clause'=> 'UserID='.$userID,
			'order'=>""
			);
	$Result	=	DB_Read($ReadTestArray, 'ASSOC', '');
	if(!$Result)
	{
		$errMsg = 'Error: Login Credentials not found';
		SetErrorCodes(getErrorMessage(28), __LINE__,  __FILE__);
		$status = 'FAIL';
		return false ;
	}
	
	if($Result[0]['Subscription_Type']	==	Subscription_PayPerUse){
		$ResultSubscriptionValidity	=	DB_Read(array(
				'Fields'	=> 'accountValidity',
				'Table'		=> 'accountcredit_info',
				'clause'	=> 'AccountID='.$accountID,
				), 'ASSOC', '');
				
		$datetime1	=	date_create(date('Y-m-d'));
		$datetime2	=	date_create($ResultSubscriptionValidity[0]['accountValidity']);
		$interval 	= 	date_diff($datetime1, $datetime2);
	}
	else {
		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create($Result[0]['Validity_End_Date']);
		$interval = date_diff($datetime1, $datetime2);
	}
	
	if($interval->invert == 1)
	{		
		$daysRemaining = $interval->days; 
		$logData	=	'remaining validity not found '.json_encode($datetime1).' -- '.json_encode($datetime2).' -- '.json_encode($interval).' days remaining - '.$daysRemaining;
		ErrorLogging($logData, __LINE__,  __FILE__);
		return false;
	}
	
	//STORE THE SUBSCRIPTION INFO HERE
	$subscriptionType = $Result[0]['Subscription_Type'];	
	$daysRemaining = $interval->days;
	
	return true; 
}