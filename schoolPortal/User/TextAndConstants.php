<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines different texts as constants
*
*/

//Texts displayed in User interface
define('UserTableCaption',	'User Details');
define("COPYRIGHT",	'Developed and maintained <br />by Aditya');
define('PortalVersion',	'');

define('installerFileName',	'Pulsar.exe');
define('installerGuideFileName','PulsarPPUInstallationGuide.pdf');
define('ReleaseNotesFileName', 'ReleaseNotes.pdf');

//Below are the variables and constants that are used globally across scripts but their value needs to be populated at run time
$systemDetails 	= getInfoFrom('user_details', 'systemSettings');
$systemDetailsCount	=	count($systemDetails);	
if($systemDetailsCount > 0) {
	$SupportTeamEmail	=	$systemDetails['supportEmailID'];
}
?>
