<?php
/*
* Author: Aditya
* date: 
* Description: 
*
*/

require_once __DIR__."./../../require.php";

if($_SESSION['userTYPE']	==	CUSTOMER || $_SESSION['userTYPE']	==	OPERATOR) {
	switch($_GET['Request']){
		case 1:	//Pulsar installer
			header ('Location: ftp://pulsarppu:5$upp98&xc@ftp.veneratech.com/'.installerFileName);
		break;
		case 2:	//Installation guide
			header ('Location: ftp://pulsarppu:5$upp98&xc@ftp.veneratech.com/'.installerGuideFileName);
		break;
		case 3:	//Release notes
			header ('Location: ftp://pulsarppu:5$upp98&xc@ftp.veneratech.com/'.ReleaseNotesFileName);
		break;
	}		
}
else{
	echo 'Unauthorized access';
}
?>