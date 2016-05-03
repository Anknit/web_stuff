<?php
/*
 * This maps the jqueryUI theme folder names with their value
 */
?>

<?php
session_start();
function getThemeFolderName(){
	$folderName	=	'';
	$themeValue	=	isset($_POST['userTHEME']) ? $_POST['userTHEME'] : isset($_SESSION['userTHEME']) ?  $_SESSION['userTHEME'] : 0;
	
	$ThemeValueFolderNames	=	array();
	$ThemeValueFolderNames[100]	=	'Cupertino';
	$ThemeValueFolderNames[1]	=	'Swanky';
	$ThemeValueFolderNames[2]	=	'Trontastic';
	
	$folderName	=	$ThemeValueFolderNames[$themeValue];
	if($folderName	==	''){
		$themeValue	=	100;
		$folderName	=	'Cupertino';
	}
	$_SESSION['userTHEME']	=	$themeValue;
	return $folderName;
}
$jqueryUIThemerFolderName	=	'JqueryUIThemer/';
$jqueryUIThemerFolderName	.=	getThemeFolderName();
$jqueryUITHemePaths	=	array();
$jqueryUITHemePaths['css']	=	$jqueryUIThemerFolderName.'/jquery-ui.min.css';
$jqueryUITHemePaths['js']	=	$jqueryUIThemerFolderName.'/jquery-ui.min.js';
?>