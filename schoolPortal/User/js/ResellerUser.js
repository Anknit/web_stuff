USER_GRID_UNIQUE_ID	=	'ResellerUserTable';
var ResizeUser	=	0;
var	AllUsersData	=	new Array();
AllUsersData[userID]	=	new Object();
AllUsersData[userID].Username	=	username;
var SalescolModel	=	function(){
	var colModel = [
						{name:'UserID',				index:'UserID',				width:30,	hidden: true, title: false},
						{name:'Username',			index:'Username',			width:250, 	align: 'left',		sorttype: "float", title: false},
						{name:'Name',				index:'Name',				width:160, 	align: 'left',		sorttype: "float", title: false},
						{name:'userStatus',			index:'userStatus',			width:100, 	align: 'left',		hidden: false, formatter:salescoModelFormatterFunction.EditSaveUserStatus},
						{name:'Organization',		index:'Organization',		width:240,	sorttype: "float",	align:"left", title: false},
						{name:'RegisteredOn',		index:'RegisteredOn',		width:120,	sorttype: "date",	align:"left", title: false},		
						{name:'Credits',			index:'Credits',			width:100,	align: 'left',		sortable:false, hidden: false, formatter:salescoModelFormatterFunction.Credits},
					];
	return colModel;
};

var salescoModelFormatterFunction	=	new Object();
function DefineSalesColModelFormatterFunctions(){
	salescoModelFormatterFunction.EditSaveUserStatus		=	function(val,colModelOB, rowdata){
		var value = rowdata.UserID;
		AllUsersData[value]	=	rowdata;
		var innerhtml='';
		switch (val){
			case '1':{
				innerhtml = 'Unverified';
				break;
			}
			case '2':{
				innerhtml = 'Active';
				break;
			}
			case '3':{
				innerhtml = 'Inactive';
				break;
			}
			default:{
				break;
			}
		}
		innerhtml += '<input type="hidden" id="portalUserStatus_'+rowdata.UserID+'" value="'+val+'" /> ';
		return innerhtml;
	};

	salescoModelFormatterFunction.Credits		=	function(val,colModelOB, rowdata){
		var currency = 'USD';
		return val+' '+currency;
	};


	salescoModelFormatterFunction.gridComplete	=	function(){
		var Table			=	$(this);
		GRID_UNIQUE_ID	=	USER_GRID_UNIQUE_ID;
		if(ResizeUser	==	0){
			CommonGridCompleteFunctions(Table);
			ResizeUser++;
		}	
		worksOnAllGridComplete(Table);
	};
}

DefineSalesColModelFormatterFunctions();