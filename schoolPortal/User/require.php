<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This is required to be included to include basic functional files e.g. DBMgr.php.  If there exists a file which is in general required most of the times e.g. for permission set or constant defining class, then all such files should be included into this file.
*
*/
    require_once __DIR__.'/definitions.php';	//This has some neccessary variables which define permissions for different users. Hence included at the top
	require_once __DIR__.'/PermissionSets.php';	//This has some neccessary variables which define permissions for different users. Hence included at the top
	require_once __DIR__.'./../Common/php/SessionManager.php';
	SM_StartSession();

	//if session setup_root is not set, then set its value
	if(!isset($_SESSION['SETUP_ROOT'])){	
		$_SESSION['SETUP_ROOT'] = str_replace(ProductDirectory,"",__DIR__); 
	}
	//if session HTTP_ROOT is not set, then set its value
	if(!isset($_SESSION['HTTP_ROOT'])){	
		$_SESSION['HTTP_ROOT'] = strstr(str_replace(basename(__FILE__), "", "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME']), ProductDirectory, true);
	}
    require_once __DIR__.'/toolTipMessage.php';
	require_once __DIR__.'/UserSpecificPermissions.php';	//This has variables that defines user specific permissions
    require_once __DIR__.'/definePaths.php';
    require_once Common.'/php/OperateDB/DbMgrInterface.php';
    require_once Common.'/php/ErrorHandling.php';
    require_once PPU.'/PageId.php';
    require_once PPU.'/ErrorMessages.php';
    require_once Common.'/php/commonfunctions.php';
    require_once Common.'/php/MailMgr.php';
    require_once PPU.'/CommonMethods.php';
    require_once PPU.'/mailingDetails.php';
	require_once PPU.'/userDetails.php';
    require_once PPU.'/dateTimeMethods.php';
    require_once PPU.'/TextAndConstants.php';
    require_once PPU.'/RedirectToInterfaceIfLogin.php';
    require_once PPU.'/RestrictAccessToActiveUsers.php';
?>
