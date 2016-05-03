USER_GRID_UNIQUE_ID	=	'SalesUserTable';
var ResizeUser	=	0;
var	AllUsersData	=	new Array();
AllUsersData[userID]	=	new Object();
AllUsersData[userID].Username	=	username;
var SalescolModel	=	function(){
	var colModel = [
						{name:'UserID',				index:'UserID',				width:60,	align: 'center',		 title: false, formatter:salescoModelFormatterFunction.Editbutton},
						{name:'Username',			index:'Username',			width:250, align: 'left',		sorttype: "float", title: false},
						{name:'Name',				index:'Name',				width:160, align: 'left',		sorttype: "float", title: false},
						{name:'userStatus',			index:'userStatus',				width:100, align: 'left',		 formatter:salescoModelFormatterFunction.EditSaveUserStatus},
						{name:'Organization',		index:'Organization',		width:240,	sorttype: "float",	align:"left", title: false},
						{name:'regAuthorityName',	index:'regAuthorityName',	width:200,	sorttype: "float",	align:"left", title: false},		
						{name:'RegisteredOn',		index:'RegisteredOn',		width:140,	sorttype: "date",	align:"left", title: false},		
						{name:'UserType',			index:'UserType',			width:150,	sorttype: "float",	align:"left", title: false, formatter:salescoModelFormatterFunction.userTYPEVALUE},	
						{name:'Credits',			index:'Credits',			sortable: false,	width:100, align: 'left'},
						{name:'Delete',				index:'Delete',				width:20,	sortable:false,		align:"center", formatter:salescoModelFormatterFunction.deleteUserImage}		
					];
	return colModel;
};

var salescoModelFormatterFunction	=	new Object();
function DefineSalesColModelFormatterFunctions(){
	salescoModelFormatterFunction.deleteUserImage	=	function(val,colModelOB,rowdata){
		var value = rowdata.UserID;
		AllUsersData[value]	=	rowdata;
		if(rowdata.userStatus == 1)
			return '<img src="../../Common/images/delete.png" title="Delete user" onclick="showDeleteUserForm(this);" value="'+value+'" style="cursor:pointer"/>';
		else
			return '&nbsp;';
	};

	salescoModelFormatterFunction.EditSaveUserStatus		=	function(val,colModelOB, rowdata){
//		AllUsersIdAndNames[rowdata.UserID]	=	rowdata.Username;
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

	salescoModelFormatterFunction.Editbutton	=	function (val,colModelOB, rowdata){
		if(rowdata.userStatus != '1'){
			uid	=	rowdata.UserID;
			var innerhtml	=	'<div style="float:left" id="EditUserDiv_'+uid+'"><img id="EditUser_'+uid+'" src="../../Common/images/report.png" value="'+uid+'" onclick="RenderGridInputs(this)" title="click to edit"  style="cursor:pointer"></div>';
			innerhtml		+=	'<div id="SaveUserDiv_'+uid+'" style="float:left;display:none">';
			innerhtml		+=	'<img id="SaveUser_'+uid+'" src="../../Common/images/save_floppy.png" value="'+uid+'" width="16" height="16" onclick="RestoreEditmode(this)" title = "click to save" style="cursor:pointer">';
			innerhtml		+=	'<img id="CancelUser_'+uid+'" src="../../Common/images/cancel_undo.png" value="'+uid+'" width="16" height="16" onclick="CancelAndRestoreEditmode(this)" title = "cancel" style="margin-left:8px;cursor:pointer">';
			innerhtml		+=	'</div>';
			
			return innerhtml;
		}
		else
			return '&nbsp;';
	};

	salescoModelFormatterFunction.userTYPEVALUE	=	function(val,colModelOB, rowdata){
		value	=	val;
		if(value == 1)
			return "&nbsp; Operator";
		else if(value == 2)
			return "&nbsp; Reseller";
		else if(value == 3)
			return "&nbsp; Account Manager";
		else if(value == 4)
			return "&nbsp; Super User";
		else if(value == 5)
			return "&nbsp; Venera Sales";
		else
			return "&nbsp; Sales Representative";
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

//Show input options and switch to save action image
function RenderGridInputs(editButton){
	//get the row whose column is to be altered
	var parentRow	=	$(editButton).closest('tr');
	//replace status with the select options
	var statusColumn	=	$(parentRow).children().eq(3);
	var EdituserID	=	$(editButton).attr('value');
	var userStatus	=	Element('portalUserStatus_'+EdituserID).value;
	if(userStatus != 1){
		//call create drop down list
		statusColumn.html(getStatusInputElement(EdituserID));
		createDropDownList();
		BindMethodForUIActions();
		$('#Status_'+EdituserID).val(userStatus);
		editMyRegUser(editButton, 1);
		}
}

//Remove input elements and switch to edit action image
function RestoreEditmode(saveButton){
	var stat ="", type="", feat="",pack="";
	var parentRow		=	$(saveButton).closest('tr');
	//replace status with the select options
	var statusColumn	=	$(parentRow).children().eq(3);
	var EdituserID		=	$(saveButton).attr('value');
	editMyRegUser(saveButton, 2);
	//Modify status/subscription
	var newrowdata		=	new Object();
	newrowdata.UserID	=	EdituserID;
	statusColumn.html(salescoModelFormatterFunction.EditSaveUserStatus(stat, '', newrowdata));
	RefreshGrid(USER_GRID_UNIQUE_ID);
	toggleUserOption(EdituserID,1);
}

function CancelAndRestoreEditmode(saveButton){
	RefreshGrid(USER_GRID_UNIQUE_ID);
}
