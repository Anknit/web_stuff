<?php
/*
 * Author: Rajarshi 
 * date: 28-jul-2014
 * Description: This module implments all session management functionalities. 
 * Using the session ID and $_SESSION variables one can retireve the session specific data structures. 
 * 
 * 
 */
require_once __DIR__.'/OperateDB/DbMgrInterface.php';


/*
 * Author: Rajarshi
* date: 28-jul-2014
* fuinction  SM_StartSession($sessionID)
* Description:
* This function should be called to start the session at the begining of the script. If called from within a
* browser interface then call it without any sessionID argument as the session id will be 
* picked up from cookie paramters 
* 
*
*/


function SM_StartSession(&$sessionID	=	'')
{	
	if(!$sessionID)
		$retval = session_start(); 
	else
	{
		session_id($sessionID);
		$retval = session_start();
	}
		
	if($retval != true)
		return 0; 	
	$sessionID = session_id();
	
	return $sessionID;  
}

function SM_CloseSession($sessionID)
{
	$status = session_status(); 
	if($status == PHP_SESSION_ACTIVE)
	{
		//NOW UPDATE THE SESSION ID INFO TABLE
		$WriteTestArray	=	array(
				'Table'=> 'session_info',
				'Fields'=> array('EndTime'=>'now()'),
				'clause'=>'sessionID="'.$sessionID.'"'
		);
		
		
		$Result	=	DB_Update($WriteTestArray);
		if(!$Result)
		{
			$errMsg = 'Error: Unable to Update Session Info field';
			$status = 'FAIL';		
		}			
		session_destroy();
		session_unset(); 
		$_SESSION = array();
	}	
}

function SM_IS_SessionValid($sessionID)
{
	//gets the session status 
	/*
	$status = session_status(); 
	if($status == PHP_SESSION_ACTIVE)
	{
		$currsessID = session_id(); 
		if($currsessID == $sessionID)
			return true; 
		else 
			return false; 
	}
	*/
	if(isset($_SESSION['sessionID']))
	{
		if($_SESSION['sessionID'] == $sessionID)
			return true;
		else
			return false; 
	}			
	else 
		return false; 
			
	return false; 
}

// proceed to set and retrieve values by key from $_SESSION
?>