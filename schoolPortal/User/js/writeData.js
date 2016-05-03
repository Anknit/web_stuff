$(function(){
	for (var key in CustomDataForInternalPurposes) {
		$(key).attr('value',CustomDataForInternalPurposes[key]);
	}

	for (var key in CustomHtmlForInternalPurposes) {
		$(key).html(CustomHtmlForInternalPurposes[key]);
	}
	
	for(var i = 0; i< Elements_DisplayBlock.length; i++) {
		$(Elements_DisplayBlock[i]).css('display', 'block');
	}
	
	for(var i = 0; i< Elements_DisplayNone.length; i++) {
		$(Elements_DisplayNone[i]).css('display', 'none');
	}
	
/*	for(var key in ElementsValue_ToAddSubMenu) {
		//Assumption: Name of all menus/submenu should be unique throughout
		
		//Find the corresponding li having the value congruent to that of key.
		var ParentLiElem	=	$('li[value="'+key+'"]');
		var SubMenu	=	"<ul>";
		for(var i = 0; i < ElementsValue_ToAddSubMenu[key]['SubMenuNames'].length; i++) {
			SubMenu	+=	"<li>"+ElementsValue_ToAddSubMenu[key]['SubMenuNames'][i]+"</li>";
		}
		SubMenu	+=	"</ul>";
		ParentLiElem.append(SubMenu);
	}
*/	
	var Content	=	"", Element	=	"";
	for(var i = 0; i< Elements_CreateTooltip.length; i++) {
		Content	=	Elements_CreateTooltip[i]['Content'];
		Element	=	$(Elements_CreateTooltip[i]['Selector']);
		Element.jqxTooltip({ content: Content,  position: 'right',  left: 10, name: 'testTooltip',theme:JQXTHEME});
		Element.jqxTooltip('open');
		Element.jqxTooltip('close',500);
		
		Content	=	"";
		Element	=	"";
	}
	
    for (var key in callBacksFirstLevel) {
    	callBacksFirstLevel[key]();
     }
});