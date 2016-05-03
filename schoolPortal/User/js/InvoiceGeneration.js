var GenerateTransactionInvoice	= function(object){
	loadImage();
	var remoteCallQuery	=	'';
	var mode	=	$(object).attr('mode');
	if(mode	== 1){
		var paymentIndex	=	$(object).attr('value');
		remoteCallQuery		+=	'paymentIndex='+paymentIndex;
	}
	else if(mode	== 2){
		var voucherID		=	$(object).attr('voucherID');
		var InvoiceUserID	=	$(object).attr('InvoiceUserID');
		remoteCallQuery		+=	'voucherID='+voucherID+'&InvoiceUserID='+InvoiceUserID;
	}
	var InvoiceObj	=	new Object();
	
	InvoiceObj.actionScriptURL	=	'action/InvoiceGeneration.php?mode='+mode+'&'+remoteCallQuery;
	InvoiceObj.callBack		=	function (Response){
		deloadImage();
		if(Response == 0){
			AlertMessage({msg:ErrorMessages[21]});
		}
		else if(Response == 1) {
			AlertMessage({msg:SuccessMessages[9], error:0});
		}
		else if(Response != ''){
			window.open('../../temp/'+Response);
		}
	};
	send_remoteCall(InvoiceObj);
};