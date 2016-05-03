var addVoucherformLoaded = false;
var cancelVoucherformLoaded = false;
$(function(){
	$('#voucherAmount').keypress(function(event){
		return numbersonly(event);
	});
	$('#cancelVoucherGenerate').on('click',closeAddVoucherpopup);
	if(!IsValueNull(Element("VoucherTab")))
	{
		var vouchertypes = new Array("Paid","Demo");
		var date = new Date();
		date.setTime(date.getTime()+(180*24*60*60*1000));
		var mindate = new Date();
		mindate.setDate(mindate.getDate()+1);
		$("#voucherEnd").jqxDateTimeInput({ width: '175px', height: '25px', formatString: "yyyy-MM-dd", theme: JQXTHEME, min: mindate.toDateString(), value: date});
		$("#voucherType").jqxDropDownList({ source: vouchertypes, selectedIndex: 0, width: 175, height: 25, dropDownHeight: 50, dropDownWidth: 175, theme: JQXTHEME});
		$('#voucherType').on('change', changeAmountField);
	}
});

var closeAddVoucherpopup	=	function(){
	var date = new Date();
	date.setTime(date.getTime()+(180*24*60*60*1000));
	$("#voucherEnd").jqxDateTimeInput({value: date});
	$("#voucherAmount").val('');
	$("#voucherType").val("Paid");
	$('#voucherNotes').val('');	
	$('#NewVoucherdiv').closest('[role="dialog"]').jqxWindow('close');
	RefreshGrid(VOUCHER_GRID_UNIQUE_ID);
};

var showNewVoucherForm = function(){
	if(addVoucherformLoaded){
		displayNewVoucherForm();
		$('#NewVoucherdiv').css('display',"block");
		return ;
	}
	else{
		addVoucherformLoaded = true;
		var obj 			= new Object();
		obj.id 				= '#NewVoucherdiv';
		obj.Heading 		= '<span style="font-family:Arial; font-size:12px">New Voucher</span>';
		obj.WindowHeight	= '310';
		obj.WindowWidth		= '320';
		obj.ok 				= 'generateVoucher';
		obj.cancel 			= 'cancelVoucherGenerate';
		obj.tab				= '#VoucherTab';
		createWindow(obj);
		$('#NewVoucherdiv').css('display',"block");
		$("#voucherStatus").text("");
		$('#inputvoucherEnd').css('border','0px');
	}
};

var displayNewVoucherForm = function(){
	$('#NewVoucherdiv').closest('[role="dialog"]').jqxWindow('open');
};

function GenerateVoucher() {
	var voucherType		    	= $('#voucherType').val();
	if(voucherType == "Paid")
		voucherType = 1;
	else if(voucherType == "Demo")
		voucherType = 2;
	var voucherAmount;
	if(voucherType ==1)
		voucherAmount = $('#voucherAmount').val();
	else
		voucherAmount = 120;
	
	if(regUserType == 2){	//For reseller voucher of atleast $100 can be generated
		if(voucherAmount < 100){ 
			AlertMessage({msg: VoucherGenerateErrorMessages[2]});
			return false;
		}
	}
	
	if(voucherAmount == 0 || voucherAmount == '' || voucherAmount == null){
		AlertMessage({msg:VoucherGenerateErrorMessages[3]});
		return false;
	}

	if(!isNumber(document.getElementById('voucherAmount').value)){
		AlertMessage({msg:VoucherGenerateErrorMessages[3]});
		return false;
	}
		


	var voucherEndDate    		= $('#voucherEnd').val();
	var userNotes				= $('#voucherNotes').val();	
	if(voucherType == "Paid")
		voucherType = 1;
	else if(voucherType == "Demo")
		voucherType = 2;
	
	var Data_random 	= randomize_Data('Operation=VoucherGenerate&voucherAmount='+voucherAmount+'&voucherEndDate='+voucherEndDate+'&voucherType='+voucherType+'&userNotes='+userNotes);
	var Data_encoded 	= EncodeData(Data_random);
	
	var voucher	=	new Object();
	voucher.actionScriptURL	=	'../InterfaceToDatabaseUpdates.php?'+Data_encoded;
	voucher.callBack		=	function (Response){
									if(Response == '1'){
										closeAddVoucherpopup();
										AlertMessage({msg:SuccessMessages[4], error:0});
									}
									else {
										closeAddVoucherpopup();
										AlertMessage({msg:VoucherGenerateErrorMessages[4]});
									}
								};
	send_remoteCall(voucher);
}

var changeAmountField = function (event)
{     
    var args = event.args;
    if (args) {
    // index represents the item's index.                      
	    var index = args.index;
	    var date = new Date();
	    if(index == 1){ 
	    	$('#voucherAmount').css('display','none');
			date.setTime(date.getTime()+(15*24*60*60*1000));
	    	$('#fixedVoucher').css('display','block');
	    }
	    else{
	    	$('#voucherAmount').css('display','block');
			date.setTime(date.getTime()+(180*24*60*60*1000));
	    	$('#fixedVoucher').css('display','none');
	    }
		$("#voucherEnd").val(date);
    } 
};


var showDeleteVoucherForm 	= function(object){
	var test 				= object.attributes.value.value; 
	$('#YesButton').attr('value',test);
	if(cancelVoucherformLoaded){
		displayCancelVoucherForm();
		return ;
	}
	else{
		cancelVoucherformLoaded	=	true;
		var obj					= new Object();
		obj.id 					= '#CancelVoucherDiv';
		obj.Heading 			= '<span style="font-family:Arial; font-size:12px">Cancel Voucher</span>';
		obj.WindowHeight		=	'130';
		obj.WindowWidth			=	'260';
		obj.cancel 				= 'NoButton';
		obj.tab					= '#VoucherTab';
		createWindow(obj);
		$('#CancelVoucherDiv').css('display',"block");
		$("#CancelVoucherDiv").find('span').css('display','block');
	}
//	$('#deleteButton').css('display','block');
};

var displayCancelVoucherForm = function(){
	$('#CancelVoucherDiv').closest('[role="dialog"]').jqxWindow('open');
};


function cancelVoucher(){
	var voucherIndex	= 	$('#YesButton').attr('value');
	if(!IsValueNull(voucherIndex)){
		var voucher	=	new Object();
		var Data_random 	= randomize_Data('Operation=VoucherEditing&cat=cancel&voucherIndex='+voucherIndex);
		var Data_encoded 	= EncodeData(Data_random);
		voucher.actionScriptURL	=	'../InterfaceToDatabaseUpdates.php?'+Data_encoded;
		voucher.callBack		=	function (Response){
										$('body').find('[role="dialog"]').jqxWindow('close');
										if(Response == '1'){
											AlertMessage({msg:SuccessMessages[6],error:0});
											RefreshGrid(VOUCHER_GRID_UNIQUE_ID);
										}
										else {
											AlertMessage({msg:ErrorMessages[13]});
										}
									};
		send_remoteCall(voucher);
	}
}

function assignVoucher(object){
	var voucherIndex	= 	$(object).attr('value');
	if(!IsValueNull(voucherIndex)){
		if(!IsValueNull($("#assignInput_"+voucherIndex).val()))
			var AssignedUser	=	getCustomerUserID($("#assignInput_"+voucherIndex).val());
		else{
			AlertMessage({msg:ErrorMessages[14]});
			return false;
		}
		
		if(AssignedUser == 'Invalid user'){
			AlertMessage({msg:ErrorMessages[14]});
			return false;
		}
		
		var voucher	=	new Object();
		var Data_random 	= randomize_Data('Operation=VoucherEditing&cat=assign&voucherIndex='+voucherIndex+'&user='+AssignedUser);
		var Data_encoded 	= EncodeData(Data_random);

		voucher.actionScriptURL	=	'../InterfaceToDatabaseUpdates.php?'+Data_encoded;
		voucher.callBack		=	function (Response){
										if(Response == '1'){
											AlertMessage({msg:SuccessMessages[7],error:0});
											RefreshGrid(VOUCHER_GRID_UNIQUE_ID);
										}
										else {
											AlertMessage({msg:ErrorMessages[15]});
										}
									};
		send_remoteCall(voucher);
	}

}