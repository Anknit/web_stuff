<?php
/*
 * Author: Ankit
 * Date: 29-September-2014
 * Description: This php file will be the first page after a user is logged in. 
 * 		where the SMTP setings and the new user creation modules are implemented. 
 * 		Form is submitted by the user for receiving a registration link on his email ID. 
 * 
 */
	require_once __DIR__."./../../require.php";
	require_once Common."/php/MailMgr.php";
	$cleanquery	=	$_SERVER['QUERY_STRING'];
	parse_str($cleanquery);
	$output = 0;
	if(isset($_SESSION['userID'])){
		
		if($mode == '' || $mode ==null ){
			$output	=	'';
		}
		else {	
			switch ($mode){
				case 1:	//	Credit/Debit card
					if($paymentIndex == '' || $paymentIndex ==null ){
						$output	=	SetErrorCodes(15, __LINE__,  __FILE__);// failed to receive paymentIndex
					}
					else {
						$Paymentinfo	=	isPresentInDatabse('payment_info','PaymentIndex',$paymentIndex);
						if(!$Paymentinfo){
							$output	=	SetErrorCodes(17, __LINE__,  __FILE__);// invalid paymentIndex
						}
					}
					break;
				case 2: // Voucher Activation
					if($voucherID == '' || $voucherID ==null || $InvoiceUserID == '' || $InvoiceUserID ==null ){
						$output	=	SetErrorCodes(16, __LINE__,  __FILE__);// failed to receive voucherID or Invoice UserID
					}
					else {
						//voucherID is looked in payment table below
						$Paymentinfo	=	isPresentInDatabse('payment_info','TransactionID',$voucherID);
						if(!$Paymentinfo){
							$output	=	SetErrorCodes(17, __LINE__,  __FILE__);// invalid voucher code (not found in payment info table
						}
					}
					break;
			}	//close switch
			
			if(isset($Paymentinfo) && $Paymentinfo != '')
				$output	=	generateAndMailInvoice($Paymentinfo, false);
		}// close if(mode) else
	}
	else{
		$output	 =	SetErrorCodes(14, __LINE__,  __FILE__);// failed to insert request details in Database
	}
echo $output;