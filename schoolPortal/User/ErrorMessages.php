<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines some common functions required throughout the project
*
*/
$ErrorCodes[0]	= array('ErrorMessage'	=>	'All requests have been completed successfully');
$ErrorCodes[1]	= array('ErrorMessage'	=>	'The user does not have sufficient funds');
$ErrorCodes[2]	= array('ErrorMessage'	=>	'The user does not have sufficient funds');
$ErrorCodes[3]	= array('ErrorMessage'	=>	'No processing has been done yet');
$ErrorCodes[4]	= array('ErrorMessage'	=>	'No processing has been done yet');
$ErrorCodes[5]	= array('ErrorMessage'	=>	'User has been logged out');
$ErrorCodes[6]	= array('ErrorMessage'	=>	'No processing has been done yet');
$ErrorCodes[7]	= array('ErrorMessage'	=>	'Incorrect Username or password. Please re-enter your credentials');
$ErrorCodes[8]	= array('ErrorMessage'	=>	'Your Status is Inactive. Please contact your Registering Authority');
$ErrorCodes[9]	= array('ErrorMessage'	=>	'User is not authorized to create vouchers');
$ErrorCodes[10]	= array('ErrorMessage'	=>	'User is not authorized to activate vouchers');
$ErrorCodes[11]	= array('ErrorMessage'	=>	'User is not authorized to delete users');
$ErrorCodes[12]	= array('ErrorMessage'	=>	'User verification mail could not be sent. Hence failed to add user');
$ErrorCodes[13]	= array('ErrorMessage'	=>	'Mail to Veneratech Support Team not sent. Hence failed to process support request');
$ErrorCodes[14]	= array('ErrorMessage'	=>	'Failed to insert support request in database.');
$ErrorCodes[15]	= array('ErrorMessage'	=>	'Failed to fetch Payment Index.');
$ErrorCodes[16]	= array('ErrorMessage'	=>	'Failed to fetch Voucher Index or Invoice UserID');
$ErrorCodes[17]	= array('ErrorMessage'	=>	'Invalid Payment Index');
$ErrorCodes[18]	= array('ErrorMessage'	=>	'Failed to send email for this invoice');
$ErrorCodes[19]	= array('ErrorMessage'	=>	'Invalid Voucher Index');
$ErrorCodes[20]	= array('ErrorMessage'	=>	'Job ID not Set Properly');
$ErrorCodes[21]	= array('ErrorMessage'	=>	'Job ID mismatch');
$ErrorCodes[22]	= array('ErrorMessage'	=>	'Unable to Update Credit Info Table');
$ErrorCodes[23]	= array('ErrorMessage'	=>	'Unable to Update Usage Info Table');
$ErrorCodes[24]	= array('ErrorMessage'	=>	'Session UserID not found');
$ErrorCodes[25]	= array('ErrorMessage'	=>	'License Registration Not Found');
$ErrorCodes[26]	= array('ErrorMessage'	=>	'SUID Mismatch in License database');
$ErrorCodes[27]	= array('ErrorMessage'	=>	'License Features Not found');
$ErrorCodes[28]	= array('ErrorMessage'	=>	'Login Credentials not found');
$ErrorCodes[29]	= array('ErrorMessage'	=>	'User ID not set properly');
$ErrorCodes[30]	= array('ErrorMessage'	=>	'Unable to Update SUID field');
$ErrorCodes[31]	= array('ErrorMessage'	=>	'The registered system does not match with the current system. Please Contact the support');
$ErrorCodes[32]	= array('ErrorMessage'	=>	'Unable to Update Session Info field');
$ErrorCodes[33]	= array('ErrorMessage'	=>	'Your account is inactive');
$ErrorCodes[34]	= array('ErrorMessage'	=>	'Failed to reset SUID for user');
$ErrorCodes[35]	= array('ErrorMessage'	=>	'User is not authorized to reset SUID');
$ErrorCodes[36]	= array('ErrorMessage'	=>	'User is not authorized to send admin mail');

function getErrorMessage($ErrorNumber)
{
	global $ErrorCodes;
	if($ErrorNumber != '') {
		return $ErrorCodes[$ErrorNumber]['ErrorMessage'];
	}
}

function SetErrorCodes($Output, $LineNumber, $FileName, $writeLog = 1)
{
	global $ErrorCodes;
	if($Output != '1' && $Output != '0' && $writeLog == 1) {
		ErrorLogging($Output.' near line number '.$LineNumber.' in '.$FileName);
	}
	return $Output;
}
?>
