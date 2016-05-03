<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This is required to be in require.php. This restricts the user access to scripts only by login page, except for some exceptions
*
*/

$RedirectToUserInterface	=	false;

$PagesAccessibleWithoutLogin[]	=	'Registration';
$PagesAccessibleWithoutLogin[]	=	'ForgotPassword';
$PagesAccessibleWithoutLogin[]	=	'changePassword';

if(isset($_SESSION['userID']) && $_SESSION['userID'] != '')	//Redirect users if already logged in.
	$RedirectToUserInterface	=	true;
else if(in_array(basename($_SERVER['SCRIPT_NAME'], ".php") , $PagesAccessibleWithoutLogin))	//Dont redirect when login page is accessed
	$RedirectToUserInterface	=	false;
else if($_SERVER['QUERY_STRING'] != "")
{
	$queryString 	= $_SERVER['QUERY_STRING'];
	$cleanQuery		= Random_decode($queryString);
	if(!$cleanQuery){
		parse_str($queryString);
		$cleanQuery = Random_decode($RegisterValues);
	}
    parse_str($cleanQuery);
    $Username		= $email;
    $UserStatusFromDb	=	DB_Read(array(
    							'Table' =>	'userinfo',
    							'Fields'=>	'userStatus',
    							'clause'=>	'Username = "'.$Username.'"'
    						));
    if($UserStatusFromDb[0]['userStatus'] == UNVERIFIED && $UserStatusFromDb[0]['userStatus'] !== false)						
    	$RedirectToLogin	=	false;
}
	
if($RedirectToLogin)
	RedirectTo('Login');
?>
