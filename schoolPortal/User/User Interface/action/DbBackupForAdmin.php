<?php
/*
 * Author: Aditya
* date: 07-OCT-2014
* Description: This script is only for superuser. It will be used to backup Database
*/
session_start();
require_once __DIR__.'./../../adminMethods.php';
$DBOutput	=	DB_Backup('');
if($DBOutput !== false){
	echo $DBOutput;
}
else
	echo '0';
?>