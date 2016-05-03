<?php
/*
 * Author: Ankit
* date: 08-Aug-2014
* Description:	This page verifies the login credentials of the signing user.
*/
    require_once "../../".ProductDirectory."/require.php";
    $queryString 	= $_GET['FormValues'];
    $cleanQuery		= Random_decode($queryString);
    parse_str($cleanQuery);
    $Username		= trim($usname);
	$Password		= trim($pswd);
    $readInput      = array(
				'Table' => 'userinfo',					
				'Fields'=> 'UserID, userStatus, UserType, AccountID',
                                'clause'=> 'Username = "'.$Username.'" AND Password = "'.md5($Password).'"'
                               );
        
    $result = DB_Read($readInput, 'ASSOC', '');
    $url	=	"";
    if(isset($_SESSION['accountID']))
		$StatusReadFromAccountTable		=	getInfoFrom('user_details', 'registeredUsersAccountInfo', array($_SESSION['accountID']));

    if($result){
    	if($result[0]['userStatus'] == INACTIVE){
	    	$page	=	"Login";
    		$url = Random_encode("err=8");
	    }
		elseif(isset($StatusReadFromAccountTable[0]['accountStatus']) && $StatusReadFromAccountTable[0]['accountStatus'] == INACTIVE) {
	    	$page	=	"Login";
    		$url = Random_encode("err=33");
		}
	    elseif($result[0]['UserID'] != ""){
	    	SetUserLoginSessionVars($result[0]['UserID'], $result[0]['UserType'], $Username, $result[0]['AccountID']);
	    	$page	=	"Home";
	    }

    }
    else{
    	$page	=	"Login";
    	$url = Random_encode("err=7");
    }
    RedirectTo($page, $url);
?>