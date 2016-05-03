<?php
/*
* Author: Aditya
* date: 05-Nov-2014
* Description: This defines some common functions required only by admin
*
*/

function DB_Backup($backupFilePath = ''){
	
	if($backupFilePath == '') { 
		$newlyCreatedFilename = date("Y-m-d_H-i-s").".sql";
		$setupRoot		=	getSetupRoot();
		$sqlPathInfo	=	$setupRoot."/temp/";
		$backupFilePath	=	$sqlPathInfo.$newlyCreatedFilename;
	}
	require_once __DIR__.'./../Common/php/OperateDB/DbConfig.php';
	$query = "mysqldump -h ".$host." --port=".$port." --user=".$username." --password=".$password." --databases ".$database." > ".$backupFilePath;

	exec($query);
	if(file_exists($backupFilePath))
		return basename($backupFilePath);
	else
		return false;	
}

function getSetupRoot(){
	$setupRootDir	=	str_replace(ProductDirectory,"",__DIR__); 
	return $setupRootDir;
}

function expireVouchers(){
	$updateVouchersStatus	=	DB_Update(array(
		'Table'	=> 'voucherinfotable',
		'Fields'=> array('voucherStatus'	=>	4),
		'clause'=> 'EndValidity <= CURDATE() AND voucherStatus = 1',
	)); 
	return $updateVouchersStatus;
}

function resetUserSUID($userID = ''){
	if($userID == ''){
		return false;	//userId not set
	}
	
	$resetUserSUID	=	DB_Update(array(
		'Table'	=> 'licenseinfo',
		'Fields'=> array('FirstTimeRegistration'	=>	0, 'SUID'	=>	''),
		'clause'=> 'UserID = '.$userID,
	)); 
	return $resetUserSUID;
}
?>
