var addUserformLoaded = false;
var deleteUserformLoaded = false;
$(function(){
	$('.JqxMenus').jqxMenu({height: '32px',enableHover: true, theme: MenuTHEME});
	var found =false;
	var id="";
	var custominnerhtml = '';
	var openedTab	=	document.cookie.split(';');
	for(i = 0; i<openedTab.length; i++){
		if(openedTab[i].indexOf('tab=') != -1){
			found =true;
			break;
		}
	}
	
	if(found){
		openedTab	=	openedTab[i].split('=');
		openedTab	=	openedTab[1];
	}
	else{
		if(regUserType == 1)
			openedTab	=	"#supportDownloadDiv";
		else
		openedTab 	=	"#myUsersSubscription";
	}
	$('.tabDiV').css("display","none");
	$(openedTab).css("display","");
	$('#menuBar').on('itemclick', changeTab);
	
//	$(".subsType").children().on('change', changeSubsOption);
//	$(".column_status").children().on('change', changeStatOption);
	
	if(regUserType == 2 || regUserType == 3 ){
		   $('.usrtyperow').css('display', 'none');
	}
	else if(regUserType == 1){
		$('#NewUserdiv').css('display', 'none');
	}
	
	if(regUserType == 6 || regUserType == 3 ){
	   $('#demoCreditsRow').css('display', 'none');
	}
	else{
		if($("#checkDemoCredits").length >0)
			$("#checkDemoCredits").jqxCheckBox({ width: 120, height: 20, theme: JQXTHEME});
	}
	
	$('#jqgridadduserbutton').on('click',showNewUserForm);

	$('#supportFormEmail').text(username);
	$('#supportFormSubject').jqxDropDownList({source:PPU_TEXT_CONSTANTS.supportOptions, width: '200px',dropDownHeight: '50px', theme:JQXTHEME});
	$('#supportFormSubmit').on('click',submitSupportForm);
	$('#closeSupportstatus').on('click',showNewSupportForm);
	$('#newSupportForm').on('click',showNewSupportForm);
	
	//put a space in empty table cells
	callBacksFirstLevel.FillEmptyCells	=	function(){
		var allTableCells	=	$('tr[id]').find($('td'));
		allTableCells.each(function(){
			if($(this).html()	==	'')
				$(this).html('&nbsp;');
		});
	};
	
});
function editProfile(){
	var Data_random 	= randomize_Data('email='+username+'&userID='+userID);
	var Data_encoded 	= EncodeData(Data_random);
	window.location 	= 'Registration.php?'+Data_encoded;
}
var createDropDownList	=	function(){
	var associatedDivID	=	"", associatedDiv	=	"", width	=	"", height	=	"", theme	=	JQXTHEME, dropDownHeight	=	"", CreateDiv	=	"", SelfId	=	"", checkbox, SelectedValues;
	$('[customDropDownId]').each(function(){
		checkbox	=	false;
		disabled	=	false;
		SelectedValues	=	"";
		selectedIndex	=	"";	jqxDropDownList	=	"";
		associatedDivID	=	$(this).attr('customDropDownId');
		CreateDiv		=	'<div id="'+associatedDivID+'"></div>' ;
		$(this).before(CreateDiv);
		associatedDiv	=	$('#'+associatedDivID);
		width			=	$(this).attr('width');
		height			=	$(this).attr('height');
		if(IsValueNull(width)){width	=	'100%';}
		dropDownHeight	=	$(this).attr('dropDownHeight');
		SelfId			=	$(this).attr('id');
		if($(this).attr('checkbox') == 'true'){
			checkbox	=	true;
		}
		if($(this).attr('disabled') == 'disabled'){
			disabled	=	true;
		}
		Properties		=	{width:width, theme:theme, dropDownHeight: dropDownHeight, checkboxes:checkbox, disabled:disabled};
		if(!IsValueNull(height)){
			Properties.height	=	height;
		}
		jqxDropDownList	=	associatedDiv.jqxDropDownList(Properties);
		associatedDiv.jqxDropDownList('loadFromSelect', SelfId);
		
		//If some value is to be set give data-value as comma separated multiple values
		SelectedValues	=	$(this).attr('data-val');
		if(!IsValueNull(SelectedValues)){
			SetJqxDropDownItemsByValuesList('#'+associatedDivID, SelectedValues);
		}
		
		if($(this).val() != ""){
			selectedIndex	= $(this).val();
			jqxDropDownList.val(selectedIndex);
		}
		$(this).remove();
	});
};
var changeTab = function (event){
	var element = event.args;
	var displayDiv	=	$(element).attr('assocDiv');
	if($('#'+displayDiv).length == 0)
		return false;
	else{
		$('.tabDiV').css("display","none");
		$('#'+displayDiv).css('display','block');
	}
};
var EnableDisableAllSubscriptionDropDownsForUser	=	function(UserID, Action) {
	if(Action	==	1)Action	=	false;else	Action	=	true;
	EnableDisableUserSubscriptionDropDowns('Status_'+UserID, Action);
	EnableDisableUserSubscriptionDropDowns('Subscription_'+UserID, Action);
	EnableDisableUserSubscriptionDropDowns('Features_'+UserID, Action);
	EnableDisableUserSubscriptionDropDowns('AutoRenew_'+UserID, Action);
	if(Action)
		$('#AutoRenew_'+UserID).css('visibility','hidden');
	else
		$('#AutoRenew_'+UserID).css('visibility','visible');
		
	//EnableDisableUserSubscriptionDropDowns('Package_'+UserID, Action);
};
var EnableDisableOptionsDependingOnStatusValue	=	function(userStatus, UserID) {
	if(userStatus == 2) {	//If status is active
		type	=	EnableDisableUserSubscriptionDropDowns('Subscription_'+UserID, 1);
		if(type	==	2) {	//Monthly subscription
			items	=	EnableDisableUserSubscriptionDropDowns('Features_'+UserID, 1);	//Enable features
			//pack	=	EnableDisableUserSubscriptionDropDowns('Package_'+UserID, 1);	//Enable package
		}
		
		if(IsValueNull(type)) {	//This means monthly because for ppu subscription drop down would exist
			$('#AutoRenew_'+UserID).css('visibility','visible');
			renew	=	EnableDisableUserSubscriptionDropDowns('AutoRenew_'+UserID, 1);
		}
		else {
			$('#AutoRenew_'+UserID).css('visibility','hidden');
		}

	}
	else {	//If status is inactive
		type	=	EnableDisablejqxDropDown($('#Subscription_'+UserID), 2);
		EnableDisablejqxDropDown($('#Features_'+UserID), 2);
		//EnableDisablejqxDropDown($('#Package_'+UserID), 2);
	}
	
};
var editMyUser = function (src, Action){	//Action = 1 means edit click, 2 means save click
	var stat = "",type ="", items ="",pack = 1;
	var UserID	=	$(src).attr('value');
	if(Action == 1){	//Edit click
		stat	=	2;
		if(UserID != userID){
			stat	=	EnableDisableUserSubscriptionDropDowns('Status_'+UserID, 1);	//Get status object and enable it
		}
		EnableDisableOptionsDependingOnStatusValue(stat, UserID);
		
		toggleUserOption(UserID,2);
	}
	else {	//Save click
		if(UserID != userID)
			stat	=	EnableDisableUserSubscriptionDropDowns('Status_'+UserID, 2);
		else
			stat	=	2;
		type	=	EnableDisableUserSubscriptionDropDowns('Subscription_'+UserID, 2);
		feat	=	EnableDisableUserSubscriptionDropDowns('Features_'+UserID, 2);
		renewal	=	EnableDisableUserSubscriptionDropDowns('AutoRenew_'+UserID, 2);
//		feat	=	feat.replace('100,','');
//		feat	=	feat.split(',');
		//pack	=	EnableDisableUserSubscriptionDropDowns('Package_'+UserID, 2);
		
		if(stat != 2)	//If not active
			type	=	"",	feat	=	"",	pack	=	"";

		var result	= changeUserSubs(UserID,stat,type,feat,pack,renewal);	//Modify status/subscription
		toggleUserOption(UserID,1);
	}
};
var editMyRegUser = function (src, Action){
	var stat = "",type	=	"",	feat	=	"",	pack	=	"",renewal	=	"";
	var UserID	=	$(src).attr('value');
	if(Action == 1){	//Edit click
		stat	=	EnableDisableUserSubscriptionDropDowns('Status_'+UserID, 1);	//Get status object and enable it
		toggleUserOption(UserID,2);
	}
	else {
		stat	=	EnableDisableUserSubscriptionDropDowns('Status_'+UserID, 2);
		var result	= changeUserSubs(UserID,stat,type,feat,pack,renewal);	//Modify status/subscription
		toggleUserOption(UserID,1);
	}
};
var EnableDisableUserSubscriptionDropDowns	=	function (objId, Action){
	obj	=	$('#'+objId);
	if(!IsValueNull(obj.html())){
		objValue	=	obj.val();
		EnableDisablejqxDropDown(obj, Action);
		return objValue;
	}
};
var EnableDisablejqxDropDown	=	function (obj, Action){
	if(Action	==	1)//Enable
		Action	=	false;
	else
		Action	=	true;
		
	if(!IsValueNull(obj.html())){
		obj.jqxDropDownList('disabled', Action);
	}
};
var changeUserSubs	=	function(user,status,Type,Features,Package,renewal){
	var Query	=	'Operation=Subscription&UID='+user;
	if(status != "")
		Query	+=	'&userStatus='+status;
	if(Type != "")
		Query	+=	'&Subscription='+Type;
	if(Features != "")
		Query	+=	'&Features='+Features;
	if(Package != "")
		Query	+=	'&Package='+Package;
	if(renewal != "")
		Query	+=	'&renewal='+renewal;

	var Data_random 			= randomize_Data(Query);
	var Data_encoded 			= EncodeData(Data_random);
	var changeSub				= new Object();
	changeSub.actionScriptURL	= '../InterfaceToDatabaseUpdates.php?'+Data_encoded;
	changeSub.callBack			= function (Response){
		if(Response	==	'2')
			AlertMessage({msg:ErrorMessages[2]});
		else if(Response == "4")
			AlertMessage({msg:ErrorMessages[4]});
		else if(Response == "24")
			AlertMessage({msg:ErrorMessages[24]});
		else if(Response == "1")
			AlertMessage({msg:SuccessMessages[1],error:0});	
//		refreshdata('#myUsersSubscription');
	};
	send_remoteCall(changeSub);
};
var showNewUserForm	=	function(){
	if(addUserformLoaded){
		displayNewUserForm();
		return true;
	}
	addUserformLoaded = true;
	var obj = new Object();
	obj.id = '#NewUserdiv';
	obj.WindowHeight	=	'180';
	obj.WindowWidth	=	'280';

	if(regUserType ==2){
		obj.Heading = '<span style="font-family:Arial; font-size:12px">New Customer</span>';
		obj.WindowHeight	=	'140';
	}
	else if(regUserType ==3) {
		obj.WindowHeight	=	'110';
		obj.Heading = '<span style="font-family:Arial; font-size:12px">New operator</span>';
	}
	else if(regUserType ==4 || regUserType ==5){
		obj.Heading = '<span style="font-family:Arial; font-size:12px">New user</span>';
	}
		
	obj.ok = 'addButton';
	obj.cancel = 'cancelAddUser';
	obj.tab				= '#myUsersSubscription';
	createWindow(obj);
	createDropDownList();
	$('#NewUserdiv').css('display',"block");
	$("#addStatus").text('');
};
var displayNewUserForm = function(){
	$('#NewUserdiv').closest('[role="dialog"]').jqxWindow('open');
};
var showDeleteUserForm = function(object){
	var test 			= object.attributes.value.value;
	$('#deleteButton').attr('value',test);
	if(deleteUserformLoaded){
		displayDeleteUserForm();
		return true;
	}
	deleteUserformLoaded = true;
	var obj				= new Object();
	obj.id 				= '#DeleteUserDiv';
	obj.Heading 		= '<span style="font-family:Arial; font-size:12px">Delete user</span>';
	obj.WindowHeight	=	'130';
	obj.WindowWidth		=	'260';
	obj.cancel 			= 'canceldeleteUserButton';
	obj.tab				= '#myUsersSubscription';
	createWindow(obj);
	$('#DeleteUserDiv').css('display',"block");
	$("#DeleteUserDiv").find('span').css('display','block');
//	$('#deleteButton').css('display','block');
};
var displayDeleteUserForm = function(){
	$('#DeleteUserDiv').closest('[role="dialog"]').jqxWindow('open');
};
var cancelAddUser	=	function(){
	closeAddUserpopup();
};
var changeStatOption = function (event) {
	var args = event.args;
	if (args) {            
		var ArrayToGetUID		=	$(this).attr('id').split('_');
		var UID		=	ArrayToGetUID[ArrayToGetUID.length - 1];
		var value	=	$(this).val();
		EnableDisableOptionsDependingOnStatusValue(value, UID);
	}
};
var changeSubsOption = function (event) {
	var args = event.args;
	if (args) {            
		var ArrayToGetUID		=	$(this).attr('id').split('_');
		var UID		=	ArrayToGetUID[ArrayToGetUID.length - 1];
		var value	=	$(this).val();
		if(value == 2){	//Monthly
			EnableDisablejqxDropDown($('#Features_'+UID), 1);
			$('#AutoRenew_'+UID).css('visibility','visible');
			$('#AutoRenew_'+UID).val('1');	//By default show monthly as on
			EnableDisablejqxDropDown($('#AutoRenew_'+UID), 1);
			//EnableDisablejqxDropDown($('#Package_'+UID), 1);
		}
		else{
			EnableDisablejqxDropDown($('#Features_'+UID), 2);
			EnableDisablejqxDropDown($('#AutoRenew_'+UID), 2);
			$('#AutoRenew_'+UID).css('visibility','hidden');
			//EnableDisablejqxDropDown($('#Package_'+UID), 2);
			//Pending	:-	Uncheck all the indexes of features
		}
	}
}; 
function addUser(){
	var EntryCorrect = Uservalidate();
	if(EntryCorrect == 'err1'){
           
		$("#usertypeoption").jqxTooltip({ content: AddUserErrorMessages[0],  position: 'right',  left: 50, name: 'testTooltip',theme:'orange'});
		$("#usertypeoption").jqxTooltip('open');
        $("#usertypeoption").jqxTooltip('close',500);
		return;
	}
	else if(EntryCorrect == 'err2'){
		$("#email").jqxTooltip({ content: AddUserErrorMessages[1],  position: 'right',  left: 5, name: 'testTooltip',theme:'orange'});
		$("#email").jqxTooltip('open');
        $("#email").jqxTooltip('close',500);
		return;
	}
	else if(EntryCorrect == 'err3'){
		$("#email").jqxTooltip({ content: AddUserErrorMessages[2],  position: 'right',  left: 5, name: 'testTooltip',theme:'orange'});
		$("#email").jqxTooltip('open');
        $("#email").jqxTooltip('close',500);
		return;
	}
	else if(EntryCorrect == 'correct'){

		var newUser	=	new Object();
        var usrtype = 3;
        if(regUserType == 4 || regUserType == 5){
            var usrtype	= $('#usertypeoption').jqxDropDownList('getSelectedItem').value;
        }
        if(regUserType == 3){
            var usrtype = 1;
        }
        var email	= $('#email').val();
		var DemoCredits	=	0;
		
		if($('#checkDemoCredits').length >0){
	        if($('#checkDemoCredits').jqxCheckBox('checked'))
				DemoCredits	=	1;
		}
		
		newUser.actionScriptURL	=	'action/saveNewUser.php?type='+usrtype+'&email='+email+'&regID='+userID+'&DemoCredits='+DemoCredits;
		newUser.callBack		=	function (Response){
			if(Response == '3'){
				AlertMessage({msg:"User is already registered"});
				$("#email").val('');
			}			
			else if(Response == '1'){
				closeAddUserpopup();
				AlertMessage({msg:SuccessMessages[3],error:0});
			}
			else {
				closeAddUserpopup();
				AlertMessage({msg:UserAddEditDelete[2]});
			}
		};
		send_remoteCall(newUser);
	}

}
var Uservalidate	=	function (){
	if($('#usertypeoption').jqxDropDownList('getSelectedItem') == null ) {
		if(regUserType == 1){
			return 'err1';
		}
	}
	if($('#email').val() == '' || $('#email').val() == undefined ) {
		return 'err2';
	}
	else if(!emailcheck($('#email').val())) {
		return 'err3';
	}
	else {
		return 'correct';
	}
};
var deleteUser = function (){
	var UserID			=	$('#deleteButton').attr('value');
	var deleteThisUser	=	new Object();
	var	Query			= 'Operation=deleteUser&UID='+UserID;
	var Data_random 	= randomize_Data(Query);
	var Data_encoded 	= EncodeData(Data_random);

	deleteThisUser.actionScriptURL	=	'../InterfaceToDatabaseUpdates.php?'+Data_encoded;
	deleteThisUser.callBack			=	function (Response){
		if(Response == '1'){
			$('body').find('[role="dialog"]').jqxWindow('close');
			RefreshGrid(USER_GRID_UNIQUE_ID);
		}
		else {
			AlertMessage({msg:UserAddEditDelete[1]});
		}
	};
	send_remoteCall(deleteThisUser);
};
var showProfileDiv = function(){
	$('.tabDiV').css("display","none");
	$('#personalInfoDiv').css("display","");
};
function getStatusInputElement(id){
	return "<select height='20px' width='90%' id= 'UserStatus_"+id+"' customDropDownId= 'Status_"+id+"' dropDownHeight='50'  disabled='true'><option value=2 selected>Active</option><option value=3 >Inactive</option>";
}
function getPlanInputElement(id){
	return "<select height='20px' width='90%' id='UserPlan_"+id+"' customDropDownId= 'Subscription_"+id+"' dropDownHeight='50' disabled='true'><option value=1 selected>By Content Duration</option><option value=2 >Unlimited</option>";
}
function getFeaturesInputElement(userid, userFeatures){
	return "<select height='20px' width='90%' id= 'UserFeatures_"+userid+"' checkbox='true' customDropDownId= 'Features_"+userid+"' dropDownHeight='50' data-val='"+userFeatures+"' disabled='true'><option value=3 selected>Loudness Correction</option>";
}
function getRenewInputElement(userid, userRenew){
	return "<select height='20px' width='90%' id= 'UserAutoRenew_"+userid+"' customDropDownId= 'AutoRenew_"+userid+"' dropDownHeight='50' data-val='"+userRenew+"' disabled='true'><option value=1 selected>ON</option><option value=2 >OFF</option>";
}
var closeAddUserpopup = function(){
	$("#email").val('');
	$('#NewUserdiv').closest('[role="dialog"]').jqxWindow('close');
	RefreshGrid(USER_GRID_UNIQUE_ID);
};
function closedeleteuserpopup(){
	$('body').find('[role="dialog"]').jqxWindow('close');
	RefreshGrid(USER_GRID_UNIQUE_ID);
}
var toggleUserOption	=	function(userID,option){
	switch(option){
		case 1:	//show edit user option
			$('#SaveUserDiv_'+userID).css('display','none');
			$('#EditUserDiv_'+userID).css('display','block');
		break;
		case 2:	//show save user option
			$('#EditUserDiv_'+userID).css('display','none');
			$('#SaveUserDiv_'+userID).css('display','block');
		break;
	}
};

var worksOnAllGridComplete	=	function(Table){
	var	RowDataArrays	=	Table.jqGrid('getRowData');
	
	
	return ;
	//If no record is found the show no record found at the centre		
	if(RowDataArrays.length	==	0)	//If no records are found then maintain some height of table
	{
		Table.find('.jqgfirstrow').html('<td width="100%" height="200px" valign="middle" style="vertical-align:middle; border:none"><div style="text-align:center; width:100%">No records found</div></td>');
	}
};
var CommonGridCompleteFunctions = function(Table){
	//Get row datas in array
	var	RowDataArrays	=	Table.jqGrid('getRowData');
	ResizeTable(Table);
	ModifyGridHeaderProperties(Table);

	//createDropDownList();
	$('#t_'+GRID_UNIQUE_ID).css('border','none');
	$('#t_'+GRID_UNIQUE_ID).css('height','30px');
	$('#t_'+GRID_UNIQUE_ID).attr('align','left');
	// Manage ui-pg-input element.
	$('input.ui-pg-input').keyup(function() {
		if($(this).val() > TotalPages)
		{
			$(this).val(TotalPages);
			return false;
		}
		else
			return true;
	});
};
function BindMethodForUIActions (){
	$(".subsType").children().on('change', changeSubsOption);
	$(".column_status").children().on('change', changeStatOption);

}

function getCustomerUserName(Customer_Id){
	for (var key in customersInfo) {
	   var obj = customersInfo[key];
		if(obj.UserID    ==    Customer_Id)
			return obj.Username;
	}
}
function getCustomerUserID(Customer_Name){
    for (var value in customersInfo) {
       var obj = customersInfo[value];
        if(obj.Username    ==    Customer_Name)
            return obj.UserID;
    }
    return 'Invalid user';
} 
var submitSupportForm = function(){
	var userSupportSummary			=	$('#supportFormSummary').val();
	var userSupportVersion			=	$('#supportFormVersion').val();
	var userSupportSubject			=	$('#supportFormSubject').jqxDropDownList('getSelectedIndex');
//	var userSupportVersionIndex		=	$('#supportFormVersion').jqxDropDownList('getSelectedIndex');
	var userSupportDescription		=	$('#supportFormDescription').val();
	if(IsValueNull(userSupportSummary) || IsValueNull(userSupportDescription) || IsValueNull(userSupportVersion) || userSupportSubject == -1){
		AlertMessage({msg:ErrorMessages[18]});
		return false;
	}
	var SupportDetails	=	new Object();
	var formData		=	new FormData();
	formData.append('file', $('input[type=file]')[0].files[0]);
	SupportDetails.additionalData	=	formData;
	SupportDetails.actionScriptURL	=	'action/NewSupportDetail.php?supportUserSummary='+userSupportSummary+'&supportUserSubject='+userSupportSubject+'&supportUserDescription='+userSupportDescription+'&supportUserVersion='+userSupportVersion;
	SupportDetails.callBack		=	function (Response){
		if(Response == 0){
			AlertMessage({msg:ErrorMessages[19]});
		}
		else {
			$('#supportSeekingForm').css('display','none');
			$('#supportSubmitStatus').css('display','block');
			$('#postSupportActions').css('display','block');
			$('#supportSubmitStatus').html(Response);
		}
	};
	send_remoteCall(SupportDetails);
};
var showNewSupportForm = function(){
	$('#supportSubmitStatus').html('');
	$('#supportFormSummary').val('');
	$('#supportFormAttachment').val('');
	$('#supportFormSubject').jqxDropDownList('selectedIndex','-1');
	$('#supportFormVersion').val('');
	$('#supportFormDescription').val('');
	$('#supportSeekingForm').css('display','block');
	$('#supportSubmitStatus').css('display','none');
	$('#postSupportActions').css('display','none');
};
