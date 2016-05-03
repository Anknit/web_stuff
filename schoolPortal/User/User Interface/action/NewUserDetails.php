<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description: This page update the profile info of the user 
*/

require_once "../../".ProductDirectory."/require.php";

$queryString 	= $_GET['RegisterValues'];
$cleanQuery		= Random_decode($queryString);
parse_str($cleanQuery);
$userStatus = ACTIVE;	//

$updateInput 	= array(
						'Table'=> 'userinfo',					
						'Fields'=> array (							
								'userStatus'	=>$userStatus,
								'Name'			=>$fname.' '.$lname,
								'Address'		=>$add,
								'City'			=>$city,
								'Country'		=>$country,
								'Pincode'		=>$pin,
								'Organization'	=>$org,
								'Website'		=>$csite,
								'phoneOffice'	=>$offPhone,
								'phonePersonal'	=>$persPhone
						),  
						'clause' => 'UserID = "'.$userID.'"'
);

if($usrStatus	==	UNVERIFIED)	//If user completes registration for first time, the status is unverified, so update password if it is not blank
{
	if($pwd	==	'') {
		$Output	=	SetErrorCodes(6 , __LINE__ , __FILE__);	//User has not set the password which was mandatory
		$page	=	"Login";
		$url = Random_encode('err='.$Output);
		RedirectTo($page, $url);
		exit();
	}
	else {
		$updateInput['Fields']['Password']	=	md5($pwd);
	}
}
else {
	if($pwd	!=	'') {
		$updateInput['Fields']['Password']	=	md5($pwd);
	}
}

$result = DB_Update($updateInput);
if($result){
	//Read user details from database to set session variables for this user	
	 $userInfo = DB_Read(array(
							'Table'=> 'userinfo',					
							'Fields'=> '*',  
							'clause' => 'UserID = "'.$userID.'"'
							 ),'ASSOC','' );
	 $userInfoResult	=	$userInfo[0];
 
	//Set session variables when a new user completes the registration			
	 if($result && $result[0]['UserID'] != "" && $result[0]['userStatus'] == ACTIVE && !isset($_SESSION['UserID'])) {
		SetUserLoginSessionVars($userInfoResult['UserID'], $userInfoResult['UserType'], $userInfoResult['Username'], $userInfoResult['AccountID']);
	 }
	$url	=	''; 
	if($usrStatus	==	UNVERIFIED)	//If user completes registration for first time, the status is unverified
		$page	=	"Logout";
	else
		$page	=	"Home";

}
else{
	$page	=	"Login";
	$url = Random_encode("err=1");
}
RedirectTo($page, $url);