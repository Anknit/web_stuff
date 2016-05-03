<?php
/*
 * Author: Rajarshi
* date: 28-jul-2014
* Description: This module is responsible for applying Business Rules Management
* The module will be responsible for authenticating client for further analysis , debiting the 
* amount from the account in case of PPU. 
*
*All RPC function names are preceded by RPC_XXXX
*
*/



include_once 'PricingModel.php'; 
include_once __DIR__.'./../Common/php/commonfunctions.php'; 
include_once __DIR__.'./userDetails.php'; 

/*
 * JOB_ID -- value of the job ID
* FILE_NAME -- name of the file intended for the job 
* CONTENT_DURATION -- duration of the content analysed 
* ARRAY_FEATURES -- array of features used for this job
 */
function BRM_ValidateUsage(&$respParam)
{
	// parse the string 
	parse_str($respParam);
	$status = 'SUCCESS'; 
	$errMsg = '';
	$jobID = strtoupper($JOB_ID);
	$fileName = strtoupper($FILE_NAME);
	$contentDur = strtoupper($CONTENT_DURATION);
	//retrieve the session variables 
	$arrLength = $ARRAY_LENGTH; 
	$featureArr = array(); 
	$featuresUsed = ''; 
	$finalValue = 0;
	for($k =0;  $k < $arrLength; $k++)
	{
		$featureArr[] = $FEATURELIST[$k];
		
		$featuresUsed = $featuresUsed . $FEATURELIST[$k] . ' + '; 
		//$featureArr->array_push($FEATURELIST[$k]); 
	}
	
	$subscrType	= 	DB_Read(
		array(	'Table'=> 'usersubscriptioninfo',					
				'Fields'=> '*',						
				'clause'=> 'UserID	=	'.$_SESSION['userID'],
			 ),
			 'ASSOC',
			 ''
	);
	if($subscrType)
		$subscrType	=	$subscrType[0]['Subscription_Type'];
		
	$_SESSION['subscriptionType']	=	$subscrType ;//$_SESSION['subcriptionType']; 
	//$startDate = $_SESSION['start_date']; 
	//$endDate = $_SESSION['end_date']; 
	
	if($subscrType == Subscription_PayPerUse)
	{
		//calculate the virtual price
		$creditValue = BRM_CheckCreditBalance($_SESSION['accountID']);
		$price = BRM_CalculatePrice($contentDur, $featureArr);
		$errMsg = "Price:" . $price;
		$finalValue = $creditValue - $price;
		global $gMinFilePrice;
		//Dont allow after debit value to go negative. And since gMinfile price is used in confirmdebit don't change the defined value
		if($finalValue < 0)	
		{
			$status = 'FAIL';
			$errMsg = 'Error: Insufficient Credit Value to Allow Analysis';
			goto E;
		
		}
		$errMsg = 'Credit Balance: $' . $finalValue ; 
	}//if($subscrType == Subscription_PayPerUse)

	else if($subscrType == Subscription_PayPerMonth)
	{
		/*
		$datetime1 = date_create('2009-10-11');
		$datetime2 = date_create('2009-10-13');
		$interval = date_diff($datetime1, $datetime2);
		echo $interval->format('%R%a days');
		*/
		$retval = LM_CheckSubscriptionValidity($_SESSION['userID'], $_SESSION['accountID'], $daysLeft, $subscriptionType); 
		if($retval != true)
		{
			$status = 'FAIL';
			$errMsg = 'Error: Subscription No More Valid';
			goto E;
		}
		$errMsg = 'Expiry Period Remaining(days):' . $daysLeft ; 
		$price = 0; 
		
	}
	
	//check with the account pool 
	//if negative then send appropriate error else success
	
	//Storing these values in session variables for dumping in database once confirmation comes from
	//client
	$_SESSION['jobid']= $jobID; 
	$_SESSION['filename']= $fileName;
	$_SESSION['contentduration']= $contentDur;
	$_SESSION['cost']= $price;
	$_SESSION['features']= $featuresUsed; 
E: 	
	
	$respParam = '&STATUS='.$status. '&MESSAGE='.$errMsg; 
}
/*
 * $nextWeek = time() + (7 * 24 * 60 * 60);
                   // 7 days; 24 hours; 60 mins; 60 secs
echo 'Now:       '. date('Y-m-d') ."\n";
echo 'Next Week: '. date('Y-m-d', $nextWeek) ."\n";
// or using strtotime():`
echo 'Next Week: '. date('Y-m-d', strtotime('+1 week')) ."\n";
 */

function BRM_CalculatePrice($content_duration, $feature_arr)
{	
	global $gPriceInfo, $gMeterUnitSize,$gMinFilePrice,$gMaxMeterUnitAllowed;	
	$totalUnits = $content_duration / $gMeterUnitSize;
	$feature_len = count($feature_arr); 
	
	$totalUnitPrice = 0;
	
	for($i = 0 ; $i < $feature_len; $i++)
	{
		$feature_name = $feature_arr[$i]; 
		if(!isset($gPriceInfo[$feature_name]))
			return 0; 
		
		$featurePrice = $gPriceInfo[$feature_name];		
		$totalUnitPrice += $featurePrice;
	}
	/* New logic of calculaing price_rm*/
	$totalPrice = $totalUnits * $totalUnitPrice; 
	$totalPrice = round($totalPrice, 2);	//Round of totalPrice to 2 decimal places
	$finalPrice = max($gMinFilePrice,$totalPrice ); 
	return $finalPrice; 
	
}

function BRM_ConfirmDebit(&$respParam)
{
	parse_str($respParam);
	
	$jobID = strtoupper($JOB_ID);
	$errMsg = '';
	$status= 'SUCCESS'; 
	//get all the session variables 
	
	//verify if jobid passed is same  = ''as the one last stored if not return error 
	
	// check subscription type 
	//if PPU then debit the amount from the account 
	//else do nothing or may be check the rental expiry date 
	//
	//dump the analysis info into the database 
	//return  from here 
	
	
	if(!isset($_SESSION['jobid']))
	{
		$status = 'FAIL';
		$errMsg = 'Error: Job ID not Set Properly';
		SetErrorCodes(getErrorMessage(20), __LINE__,  __FILE__);	//Job ID not set properly in session variable
		goto E;
	}
	if($jobID != strtoupper($_SESSION['jobid']))
	{
		$status = 'FAIL'; 
		$errMsg = 'Error: Job ID mismatch'; 
		SetErrorCodes(getErrorMessage(21), __LINE__,  __FILE__);	//Job ID mismatch
		goto E;
	}
	
	if($_SESSION['subscriptionType'] == Subscription_PayPerUse)
	{
		//now debit the amount
		$creditValue = BRM_CheckCreditBalance($_SESSION['accountID']);		
		$debitAmount = $_SESSION['cost'];
		$creditValue -= $debitAmount;	
		if($creditValue < 0)
		{
			$errMsg = 'Error: Insufficient Credit while Updating';
			$status = 'FAIL';
			goto E;
		}	
		//now update into the database
		$WriteTestArray	=	array(
				'Table'=> 'accountcredit_info',
				'Fields'=> array('CreditAmount'=> $creditValue,
//						'accountValidity'=> date('Y-m-d', strtotime('+180 day')),
						'UpdatedOn'=>'now()'),
				'clause'=> 'AccountID='.$_SESSION['accountID']
		);
		$Result	=	DB_Update($WriteTestArray);
		if(!$Result)
		{
			$errMsg = 'Error: Unable to Update Credit Info Table';
			SetErrorCodes(getErrorMessage(22), __LINE__,  __FILE__);
			$status = 'FAIL';
			goto E;
		}
		$errMsg	=	'Credit Balance: $' . $creditValue;
			
		
	}
	$sessionID = session_id(); 
	$WriteTestArray	=	array(
			'Table'=> 'usageinfo',
			'Fields'=> array('jobID'=> $_SESSION['jobid'],
					'sessionID'=>$sessionID, 'FileName'=>$_SESSION['filename'],
					'ContentDuration'=>$_SESSION['contentduration'],'UserID'=>$_SESSION['userID'],
					'Charges'=>$_SESSION['cost'], 'JobEndTime'=>	'now()', 'FeaturesUsed'=>$_SESSION['features'])
					);
	$Result	=	DB_Insert($WriteTestArray);
	if(!$Result)
	{
		$errMsg = 'Error: Unable to Update Usage Info Table';
		$status = 'FAIL';
		SetErrorCodes(getErrorMessage(23), __LINE__,  __FILE__);
		goto E;
	}	
	//now clean up the session variables before leaving ???
	$today = date("Y-m-d H:i:s", time());	
E: 	
	
	$respParam = '&STATUS='.$status . '&MESSAGE='. $errMsg;
	return true; 
	//
	
}

/*
 * Checks out the account balance 
 */
function BRM_CheckCreditBalance($accountID)
{
	$ReadTestArray	=	array(
			'Fields'=> 'CreditAmount',
			'Table'=> 'accountcredit_info',
			'clause'=> 'AccountId='.$accountID,
			'order'=>""
	);
	
	
	$Result	=	DB_Read($ReadTestArray, 'ASSOC', '');
	if(!$Result)
		return 0;
	
	$amount = $Result[0]['CreditAmount']; 
	$amount = round($amount, 2);	//Round of amount to 2 decimal places
	return $amount; 
}
?>