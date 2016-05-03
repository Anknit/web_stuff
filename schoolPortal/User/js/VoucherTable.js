$(function(){
	$('#jqgridaddvoucherbutton').on('click',showNewVoucherForm);
});
var VOUCHER_GRID_UNIQUE_ID	=	'VoucherTable';
var	ResizeVoucher	=	0;
var GeneratedByHidden	=	false;
if(regUserType	==	2)	// if reseller hide GeneratedBy
	GeneratedByHidden	=	true;
var voucherColModel	=	function(){
	var colModel = [
	                	{name:'voucherIndex',	index:'voucherIndex',	width:0,	hidden: true, 		title: false},
	                	{name:'CustomerID',		index:'CustomerID',		width:0,	hidden: true, 		title: false},
						{name:'voucherID',		index:'voucherID',		width:70,	align: 'left',		title: false},
						{name:'Amount',			index:'Amount',			width:40,	align: 'left',		sorttype: "float",	align:"left", title: false},
						{name:'VoucherType',	index:'VoucherType',	width:25,	align: 'left',		sorttype: "float", 	title: false, formatter:voucherColModelFormatterFunction.VoucherType},
						{name:'voucherStatus',	index:'voucherStatus',	width:30, 	align: 'left',		sorttype: "float", 	title: false, formatter:voucherColModelFormatterFunction.voucherStatus},
						{name:'StartValidity',	index:'StartValidity',	width:50,	sorttype: "date",	align:"left", title: false},		
						{name:'EndValidity',	index:'EndValidity',	width:60, 	align: 'left',		formatter:voucherColModelFormatterFunction.EndValidity},
						{name:'GeneratedBy',	index:'GeneratedBy',	width:120, 	align: 'left',		hidden: GeneratedByHidden, formatter:voucherColModelFormatterFunction.GeneratedBy},
						{name:'UsedBy',			index:'CustomerID',		width:100, 	hidden: true, 		formatter:voucherColModelFormatterFunction.UsedBy},
						{name:'UserNotes',		index:'UserNotes',		width:120, 	align: 'left'},
						{name:'AssignedTo',		index:'AssignedTo',		width:150, 	align: 'left',		classes:'vertical_Center', title:false,	sortable: false, formatter:voucherColModelFormatterFunction.AssignedTo},
//						{name:'Invoice',		index:'Invoice',		width:15, 	align: 'left',		hidden: false, formatter:voucherColModelFormatterFunction.Invoice},
						{name:'Delete',			index:'Delete',			width:30, 	align: 'left',		hidden: false, formatter:voucherColModelFormatterFunction.DeleteVoucher},
					];
	return colModel;
};

var voucherColModelFormatterFunction	=	new Object();
function DefinevoucherColModelFormatterFunctions(){
	voucherColModelFormatterFunction.VoucherType		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = 'Paid';
				break;
			}
			case '2':{
				innerhtml = 'Demo';
				break;
			}
			default:{
				break;
			}
		}
		innerhtml += '<input type="hidden" id="Voucher_'+rowdata.voucherIndex+'" value="'+val+'" /> ';
		return innerhtml;
	};

	voucherColModelFormatterFunction.voucherStatus		=	function(val,colModelOB, rowdata){
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = 'Unused';
				break;
			}
			case '2':{
				innerhtml = 'Active';
				break;
			}
			case '3':{
				innerhtml = 'Cancelled';
				break;
			}
			case '4':{
				innerhtml = 'Expired';
				break;
			}
			default:{
				break;
			}
		}
		return innerhtml;
	};
	
	voucherColModelFormatterFunction.AssignedTo	=	function(val,colModelOB, rowdata){
		var innerhtml='';
		if(!IsValueNull(rowdata.CustomerID)){
			var customerName	=  getCustomerUserName(rowdata.CustomerID);
			if(IsValueNull(customerName))
				customerName	=	"N/A";
			innerhtml	+=	'<span title="'+rowdata.Organization+'">'+customerName+'</span>';
			
		}
		else{
			if(rowdata.voucherStatus == 1)
				innerhtml	+= "<input id='assignInput_"+ rowdata.voucherIndex+"' title='Double click to see customer list' placeholder='Enter email of customer' class='assigninput' list='voucherCustomers' name='voucherCustomer' style='float:left'/><img value="+rowdata.voucherIndex+" src='../../Common/images/sendMailIcon.png' onclick='assignVoucher(this)' title='Assign to user' alt='assign user' style='width:20px; cursor:pointer;margin: 2 5 0 5' class='hoverEffect'>";
		}
			return innerhtml;
	};
	
	voucherColModelFormatterFunction.DeleteVoucher	=	function(val, colModelOB, rowdata){
		var value = rowdata.voucherIndex;
		if(rowdata.voucherStatus == 1)
			return '<img src="../../Common/images/Cancel.png" title="Cancel Voucher" onclick="showDeleteVoucherForm(this);" value="'+value+'" style="cursor:pointer"/>';
		else
			return '&nbsp;';
	};
	
	voucherColModelFormatterFunction.Invoice	=	function(val, colModelOB, rowdata){
		var voucherID = rowdata.voucherID;
		var InvoiceUserID ='';
		if(rowdata.CustomerID != '' && rowdata.CustomerID != null && rowdata.voucherStatus != 3){
			if(rowdata.GeneratedBy	==	userID){
				InvoiceUserID	=	rowdata.CustomerID;
			}
			else{
				InvoiceUserID	=	rowdata.GeneratedBy;
			}
			return '<img src="../../Common/images/pdf.png" title="Generate Invoice" onclick="GenerateTransactionInvoice(this);" mode=2 voucherID="'+voucherID+'" InvoiceUserID="'+InvoiceUserID+'" style="cursor:pointer"/>';
		}
		else
			return '&nbsp;';
	};
	
	voucherColModelFormatterFunction.EndValidity	=	function(val, colModelOB, rowdata){
		var EndValidity	=	'&nbsp;';
		if(rowdata.voucherStatus == 1 || rowdata.voucherStatus == 4 )
			EndValidity	= val;
			
		return EndValidity;	
	};
	
	voucherColModelFormatterFunction.GeneratedBy	=	function(val, colModelOB, rowdata){
		var generatedBy	=	AllUsersData[val];
		if(IsValueNull(generatedBy))
			generatedBy	=	"N/A";
		else
			generatedBy	=	generatedBy.Username;
		return generatedBy;
	};
	voucherColModelFormatterFunction.UsedBy	=	function(val, colModelOB, rowdata){
		return rowdata.Organization;
	};
	voucherColModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	VOUCHER_GRID_UNIQUE_ID;
		if(ResizeVoucher	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeVoucher++;
		}	
		worksOnAllGridComplete(Table);
	};
}

DefinevoucherColModelFormatterFunctions();