<?php
$createNewUserName	=	'dbuser';
$hostForNewUser		=	$_POST['mysql_host'];
$createNewUserPassword	=	'dbuser';
$newUserDatabaseName	=	$_POST['newDatabase'];

$userQuery		=	"CREATE USER '".$createNewUserName."'@'".$hostForNewUser."' IDENTIFIED BY '".$createNewUserPassword."'";
$userPrivilegesQuery	=	"GRANT ALL PRIVILEGES ON ".$newUserDatabaseName." . * TO '".$createNewUserName."'@'".$hostForNewUser."'";
$flushPrivilegesQuery	=	"FLUSH PRIVILEGES";
?>
