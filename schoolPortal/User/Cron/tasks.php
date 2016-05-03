<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines cron tasks that are required to be automated
*
*/

require_once __DIR__.'/../../Common/php/OperateDB/DbMgrInterface.php';
require_once __DIR__.'/../../Common/php/ErrorHandling.php';
require_once __DIR__.'/../ErrorMessages.php';
require_once __DIR__.'/../adminMethods.php';

//Database backup
$backupCreatedFileInTempDir	=	DB_Backup('');
$dbbackupFilePath	=	__DIR__.'/../../temp/'.$backupCreatedFileInTempDir;

if(!file_exists($dbbackupFilePath)){
	ErrorLogging('Cron error: Failed to create db backup. Error on line number- '.__LINE__.', in file '.__FILE__);
}

//Update account validities. This isn't required because account validities are automatically updated by 6 months when user purchases credits in account
/*
	Scenario: For all types of credit purchases in account, the accountvalidity is updated by 180 days., For all types of debits, the account updatedon field is updated
	So as per this, if accountvalidity expiry date is met, and updated on field has datethat lies in last 180 days, then update account validity by 6 months
*/

//Auto renewal
/*
	Scenario: For all pulsar users in unlimited mode, whose validity end date has expired, check their auto renewal field. If it is on, then perform all the operations done while shifting a user from hourly to unlimited mode. Keep this logic at sync.
*/
require_once 'autoRenewUnlimitedUsersSubscription.php';
//Calculate Package Price for selected package.


//Expire vouchers by setting their status
/*
	Scenario: For all vouchers whose end date has passed, set status to Expired (4)
*/

$expireVouchersOP	=	expireVouchers();

?>
