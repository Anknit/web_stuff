<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This is required to be in require.php. This restricts the user access to scripts only by login page, except for some exceptions
*
*/

$PagesAllowedForLogout	=	array('Logout', 'Anonymous');

$RedirectToLogout	=	false;
//Check if user session is set. If user session exists 
if(isset($_SESSION['userID']) && $_SESSION['userID'] != '')	//check if user status in database is active or not.	
{
	$StatusReadFromDb		=	DB_Read( array('Table' => 'userinfo', 'Fields' => 'userStatus,AccountID,UserType', 'clause' => 'UserID	=	'.$_SESSION['userID']) );
	if($StatusReadFromDb[0]['userStatus'] != ACTIVE) {
		$RedirectToLogout	=	true;
	}
	else {
		if(isset($_SESSION['userTYPE']) && ($_SESSION['userTYPE']	==	CUSTOMER || $_SESSION['userTYPE']	==	OPERATOR)) {
			$StatusReadFromDb		=	getInfoFrom('user_details', 'registeredUsersAccountInfo', array($_SESSION['accountID']));
			if($StatusReadFromDb[0]['accountStatus'] != ACTIVE) {
				$RedirectToLogout	=	true;
			}
		}
	}
}

if(in_array(basename($_SERVER['SCRIPT_NAME'], ".php") , $PagesAllowedForLogout))	//Dont redirect when login page is accessed
	$RedirectToLogout	=	false;

if($RedirectToLogout)
	RedirectTo('Logout');
?>
