$(function(){
	$('#pay_Using_Voucher').jqxRadioButton({ width: 250, height: 25, theme: JQXTHEME, checked: true});
	$('#pay_Using_PayPal').jqxRadioButton({ width: 250, height: 25, theme: JQXTHEME});
	$('#payPalPurchaseAmount').keypress(function(event){
		return numbersonly(event);
	});
	$('#pay_Using_Voucher').click(function(){
		ShowHideHTMLentity(3, 1, 'voucher_Payment_options', '')
		ShowHideHTMLentity(3, 0, 'paypal_Payment_options', '')
	});
	$('#pay_Using_PayPal').click(function(){
		ShowHideHTMLentity(3, 1, 'paypal_Payment_options', '')
		ShowHideHTMLentity(3, 0, 'voucher_Payment_options', '')
	});
});

function activateVoucher(){
	var enteredCode	= $('#voucherCodeValue').val();
	
	var Data_random 	= randomize_Data('Operation=VoucherActivate&voucherCode='+enteredCode);
	var Data_encoded 	= EncodeData(Data_random);
	
	var codeActivation 	= new Object();
	codeActivation.actionScriptURL	=	'../InterfaceToDatabaseUpdates.php?'+Data_encoded;
	codeActivation.callBack		=	function (Response){
		if(!IsValueNull(Response)){
			if(Response == 1){
				alert(SuccessMessages[5]);
				refreshdata('#CreditGenerationOption');
			}
			else{
				AlertMessage({msg:CreditErrorMessages[Response]});
				$('#voucherCodeValue').val('');
			}
		}
	};
	send_remoteCall(codeActivation);
}

function startPaypalTransaction(){
	var paypalAmount	=	$('#payPalPurchaseAmount').val();
	if(paypalAmount < 100){ 
		AlertMessage({msg: ErrorMessages[23]});
		return false;
	}
	if(paypalAmount == 0 || paypalAmount == '' || paypalAmount == null){
		AlertMessage({msg:ErrorMessages[23]});
		return false;
	}
	
	if(!isNumber(document.getElementById('payPalPurchaseAmount').value)){
		AlertMessage({msg:ErrorMessages[23]});
		return false;
	}
	document.getElementById('payPalPurchaseForm').submit();
}
