<?php
/*
* Author: Aditya
* date: 7-Nov-2014
* Description: This resets the user's SUID
*
*/
/*
	$Output	=	0;	//No processing
	$Output	=	11;	//Success
	$Output	=	26;	//UserID not set
	$Output	=	27;	//UserType not a valid product user 
	$Output	=	28;	//Failed in DB query, failed to reset SUID
*/	
global $Module;
global $Output;
require_once __DIR__.'./../require.php';

if($Module['resetUserSUID'])	
{
	require_once __DIR__.'./../adminMethods.php';
	if($userID == ''){
		$Output	=	26;	//UserID not set. False request
	}
	else {
		$userTYPE	=	getUserType($userID);
		if( $userTYPE != CUSTOMER && $userTYPE != OPERATOR ) 
			$Output	=	27;	//Not a product user
			
		$resultResetUserID	=	resetUserSUID($userID);
		if($resultResetUserID)
			$Output	=	11;
		else
			$Output	=	28;	//Failed in query
	}
}	
else {
	SetErrorCodes(getErrorMessage(35).' SessionDetails: '.var_dump($_SESSION), __LINE__,  __FILE__);	//User is not authorized to reset SUID
	$Output	= 31;	
}
?>
