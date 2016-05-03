<?php
/*
 * Author: Aditya
* date: 17-Oct-2014
* Description:	This page update the system settings, only for Super User.
*/
require_once("../../require.php");
$Output	=	'0' ;
if($_SESSION['userTYPE']	==	4) {	//Super user
	$readInput 	= array(
							'Table'=> 'systemsettings',					
							'Fields'=> '*'
						);
	$resultSystemSettingsCount = DB_Read($readInput, 'NUM_ROWS', '');
	switch($_GET['requestType']){
		case '1' :	//Support email address change
			$supportEmailID		= $_GET['supportEmailID'];
			$systemSettings 	= array(
									'Table'=> 'systemsettings',					
									'Fields'=> array (			
										'supportEmailID'	=>$supportEmailID
									)
								);
			if($resultSystemSettingsCount > 0)	//Update because entry is present
				$result = DB_Update($systemSettings);
			else
				$result = DB_Insert($systemSettings);
		
			if($result)
				$Output	=	'1' ;
			else
				$Output	=	'0' ;
				
		break;	
	}//close switch
}	//close if super user

echo $Output;
?>
