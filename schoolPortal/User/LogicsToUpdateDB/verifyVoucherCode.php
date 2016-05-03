<?php
/*
* Author: Ankit
* date: 20-Aug-2014
* Description: This verifies a voucher code and credit the amount of the voucher to the user account
*
*/
global $Module;
global $Output;
require_once __DIR__.'./../require.php';

if($Module['VoucherActivate'])	//If subscription update is set to true for the logged in user
{
	if(isset($_SESSION) && $_SESSION['userID'] != "" )
	{
		if($voucherCode != "" && $voucherCode != NULL){
			$voucherExist = DB_Read(array(
								'Table' => 'voucherinfotable',
								'Fields'=> '*',
								'clause'=> 'voucherID = "'.$voucherCode.'"'
			));
			
			//Check status of voucher
			if($voucherExist){	//If voucher codes exist in the database
				//Check if it is assigned then the same customer is using it.
				if(IfValid($voucherExist[0]['CustomerID'])){
					if($voucherExist[0]['CustomerID']	!=	$_SESSION["userID"]){
						$Output	=	10;			// already mapped to different account
					}
				}
				
				if($Output	== 0){	//If no error code has been set yet
					if(!HasDateExpired($voucherExist[0]['EndValidity'])) { //If voucher validity has not expired
						if($voucherExist[0]['voucherStatus'] == voucherUnused){
							$amount = $voucherExist[0]['Amount'];
							$voucherType = $voucherExist[0]['VoucherType'];
			/*						$presentCreditValue = DB_Read(array(
															'Table' => 'accountcredit_info',
															'Fields'=> 'CreditAmount',
															'clause'=> 'AccountID = '.$_SESSION["accountID"]
											));
			
							$amount = $presentCreditValue[0]['CreditAmount'];
			*/
						// check for the account entry in accountcreditinfo table
							$accountexist = DB_Read(array(
										'Table' => 'accountcredit_info',
										'Fields'=> 'CreditAmount',
										'clause'=> 'AccountID = '.$_SESSION["accountID"]
							));
							if(count($accountexist)>0){
						//Update Credit info
								if($voucherType	==	Paid)
									$EndValidity	=	defaultPPUDates(1);
								else
									$EndValidity	=	defaultPPUDates(2);

								$creditUpdate = DB_Update(array(
									'Table' => 'accountcredit_info',
									'Fields'=> array('CreditAmount' => $accountexist[0]['CreditAmount'] + $amount,
													 'UpdatedOn'	=> 'now()',
													 'accountValidity'	=> $EndValidity		
													),
									'clause'=> 'AccountID = '.$_SESSION["accountID"]
								));
												
								if($creditUpdate){
									switch($voucherType){
										case Paid:	$pay_Mode	=	Voucher_Paid;	break;
										case Demo:	$pay_Mode	=	Voucher_Demo;	break;
									}
						//Update voucher status
						
									$paymentInfoInsert = DB_Insert(array(
										'Table' => 'payment_info',
										'Fields'=> array('TransactionID' => $voucherCode,
														 'CustomerID'	=> $_SESSION["userID"],
							   							 'AmountPaid' => $amount,
														 'PayDate'	=> 'now()',
														 'Invoicenum'=> randomNumber_String(7),
														 'Pay_Mode'	=> $pay_Mode,
														 'Payment_ModeID' => $voucherCode,		
														),
									));
									$voucherUsed = DB_Update(array(
													'Table' 	=> 'voucherinfotable',
													'Fields' 	=> array('voucherStatus' => voucherActive,'CustomerID' => $_SESSION["userID"]),
													'clause'=> 'voucherID = "'.$voucherCode.'"'
									));
									$Output	= 1;	// successfully activated
									
									//Send invoice mail to the customer
/*									if($paymentInfoInsert) {
										$Paymentinfo	=	isPresentInDatabse('payment_info','PaymentIndex',$paymentInfoInsert);
										generateAndMailInvoice($Paymentinfo);
									}
*/								}
								else
									$Output = 9;	// not updated due to database error
							}
						}
						elseif($voucherExist[0]['voucherStatus'] == voucherActive )
							$Output = 3;		// already used
						elseif($voucherExist[0]['voucherStatus'] ==	voucherCancelled )
							$Output = 4;		// cancelled
						elseif($voucherExist[0]['voucherStatus'] ==	voucherExpired ) {
							$Output = 5;		// expired
						}
					}// close if validity
					else {
						$voucherExpired = DB_Update(array(
							'Table' 	=> 'voucherinfotable',
							'Fields' 	=> array('voucherStatus' => voucherExpired),
							'clause'	=> 'voucherID = "'.$voucherCode.'"'
						));
						$Output	=	5;			// validity has expired
					}
				}
			}
			else
				$Output	=	6;			// no generated vouchers or invalid vouchers
		}
		else 
			$Output = 8;		// voucher code is empty
	}
	else{
		RedirectTo("Login");
	}
}	//close if module voucheractivate
else {
	$Output	=	SetErrorCodes(10, __LINE__,  __FILE__);	//User is not authorized to activate vouchers
}
?>
