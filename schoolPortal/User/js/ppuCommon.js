/*
* Author: Aditya
* date: 21-Aug-2014
* Description: This defines methods which are common but for some reason are still ppu specific
*/

var	AlertMessageMethods	=	new Object();
AlertMessageMethods.show	=	function(){
	$(' .AnimateMessagesBar').fadeIn( "slow" );
	//$('.AnimateMessagesBar').animate({height:100}, 500, 'swing');
	var timerID	=	window.setTimeout(AlertMessageMethods.Hide, 4000);
	$('.AnimateMessagesBar').mouseover(function(){AlertMessageMethods.cancelAutoHide(timerID)});
	//$('.AnimateMessagesBar').css('border', '1px solid #eee');
};
AlertMessageMethods.Hide	=	function(src){
	var MessageDiv	=	$('.AnimateMessagesBar');
	MessageDiv.fadeOut( 2000 );
//	MessageDiv.animate({height:0}, 50, 'swing');
//	$('.AnimateMessagesBar').css('border', 'none');
//	$('.ScrollMessagesContent').html('');
};
AlertMessageMethods.cancelAutoHide	=	function(timer){
	 clearTimeout(timer);
}

function AlertMessage(ResponseObject){
	var msg	=	ResponseObject.msg;
	var MessageDiv	=	$('.AnimateMessagesBar');
/*	if(ResponseObject.error	==	0)	//By default is error, but if 0 is recieved then successful message
		MessageDiv.css('color', '#ffffff');
	else*/	
	if(ResponseObject.error	!=	0)	//By default is error, but if 0 is recieved then successful message
	{
//		MessageDiv.css('background-color', '#D26732');
		MessageDiv.css('background-color', '#d7d7d7');		
		MessageDiv.css('color', '#ff0000');		
		MessageDiv.css('opacity', '0.9');		
	}
	else
	{
		MessageDiv.css('background-color', '#E3FFA7');		
		MessageDiv.css('color', '#000');		
		MessageDiv.css('opacity', '0.8');				
	}
		
	$('.ScrollMessagesContent').html(msg);
	AlertMessageMethods.show();
}

var showHideEditableOptions	=	function(User_TYPE){
	var disableItemsArray	=	 new Array();
	var allDivs				=	new Array();
	allDivs		=	['user_SUBS','user_FEAT','user_CREDIT','user_VALIDITY','user_RENEW'];
	enableElementsByID(allDivs);
	switch(User_TYPE){
	case User_SALES:
		disableItemsArray	=	['user_SUBS','user_FEAT','user_CREDIT','user_VALIDITY','user_RENEW'];
		break;
	case User_RESELLER:
		disableItemsArray	=	['user_SUBS','user_FEAT','user_CREDIT','user_VALIDITY','user_RENEW'];
		break;
	case User_CUSTOMER:
//		disableItemsArray	=	['user_SUBS','user_FEAT','user_CREDIT','user_VALIDITY','user_RENEW'];
		break;
	case User_OPERATOR:
//		disableItemsArray	=	['user_SUBS','user_FEAT','user_CREDIT','user_VALIDITY','user_RENEW'];
		break;
	case User_REPRESENTATIVE:
		disableItemsArray	=	['user_SUBS','user_FEAT','user_CREDIT','user_VALIDITY','user_RENEW'];
		break;
	}
	disableElementsByID(disableItemsArray);
};


var disableElementsByID	=	function(IDArray){
	var selectedDiv	=	'';
	if(IDArray.length >0){
		for(i=0;i<IDArray.length;i++){
			selectedDiv	=	$('#'+IDArray[i])[0];
			$(selectedDiv).closest('tr').css('display','none');
		}
	}
};

var enableElementsByID	=	function(IDArray){
	var selectedDiv	=	'';
	if(IDArray.length >0){
		for(i=0;i<IDArray.length;i++){
			selectedDiv	=	$('#'+IDArray[i])[0];
			$(selectedDiv).closest('tr').css('display','inline-block');
		}
	}
};

$(function(){
	var smallButtonsList	=	$('.smallButton');
	var mediumButtonsList	=	$('.mediumButton');
	var largeButtonsList	=	$('.largeButton');
	var xxlargeButtonsList	=	$('.xxlargeButton');
	if(smallButtonsList.length > 0)
		smallButtonsList.jqxButton({theme:JQXTHEME});
	if(mediumButtonsList.length > 0)
		mediumButtonsList.jqxButton({theme:JQXTHEME});
	if(largeButtonsList.length > 0)
		largeButtonsList.jqxButton({theme:JQXTHEME});
	if(xxlargeButtonsList.length > 0)
		xxlargeButtonsList.jqxButton({theme:JQXTHEME});

	var smallInputBox	=	$('.smallInputBox');
	var mediumInputBox	=	$('.mediumInputBox');
	var largeInputBox	=	$('.largeInputBox');
	var xxlargeInputBox	=	$('.xxlargeInputBox');
	var textAreaBox		=	$('.textAreaBox');
	var largeTextAreaBox=	$('.largeTextAreaBox');
	var input200x20		=	$('.input200x20');
	var input600x20		=	$('.input600x20');
	if(smallInputBox.length > 0)
		smallInputBox.jqxInput({theme:JQXTHEME});
	if(mediumInputBox.length > 0)
		mediumInputBox.jqxInput({theme:JQXTHEME});
	if(largeInputBox.length > 0)
		largeInputBox.jqxInput({theme:JQXTHEME});
	if(xxlargeInputBox.length > 0)
		xxlargeInputBox.jqxInput({theme:JQXTHEME});
	if(textAreaBox.length > 0)
		textAreaBox.jqxInput({theme:JQXTHEME});
	if(largeTextAreaBox.length > 0)
		largeTextAreaBox.jqxInput({theme:JQXTHEME});
	if(input200x20.length > 0)
		input200x20.jqxInput({theme:JQXTHEME});
	if(input600x20.length > 0)
		input600x20.jqxInput({theme:JQXTHEME});

	
	var allDisabledButton	=	$('button[disabled="disabled"]');
	allDisabledButton.each(function(){
		var	disabled	=	true;
		$(this).jqxButton({disabled:disabled});
	});
	
/*	var allDisabledInput	=	$('input[disabled="disabled"]');
	allDisabledInput.each(function(){
		var	disabled	=	true;
		$(this).jqxInput({disabled:disabled});
	});
*/
});

/*function call_php_func (funcNAME, Args){
	if(IsValueNull(Args))
		Args	=	'';
	var Object	=	new Object();
	Object.actionScriptURL	=	'action/callPHPFunctions.php?func='+funcNAME+'&arg='+Args;
	Object.callBack		=	function (Response){
		if(Response == 0){
			AlertMessage({msg:'php function error'});
		}
		else if(Response != ''){
			window.open('../../temp/'+Response);
		}
	};
	send_remoteCall(InvoiceObj);

}*/


var validateSpecialCharacters	=	function(FieldObject){
	var iChars = "[]'{}\"";
	for (var i = 0; i < FieldObject.value.length; i++) {
		if (iChars.indexOf(FieldObject.value.charAt(i)) != -1) {
			return false;
		}
	}
	return true;
};