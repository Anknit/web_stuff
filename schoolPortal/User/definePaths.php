<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines absolute paths for common and Project specific folder
*
*/

//names of code directories under root folder
define('ProductDirectory', 'User');
define('ProductInterfaces', 'User Interface');

$DocRoot	=	$_SESSION['SETUP_ROOT'];
$PPU		=	$DocRoot.ProductDirectory.'/';
define('Common', $DocRoot.'Common/');
define('PPU', $PPU);
define('UserDataFilePath', $DocRoot.'temp/');
define('sampleInterfaces', $DocRoot.'sampleInterfaces/');

?>
