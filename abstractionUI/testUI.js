var jsonDataObj	=	{
					'html':[
						    {
								'label':'Menu1',
								'link':'#',
								'attr':{
									'id':'Menu1ID'
										}
							},
							{
								'label':'Menu2',
								'link':'#',
								'class':'testLi ulLi'
							},
							{
								'label':'Menu3',
								'link':'#',
								'dropdowndata':[
								                {
								                	'label':'Dropdown1',
								                	'link':'#'
								                },
								                {
								                	'label':'Dropdown2',
								                	'link':'#'
								                },
								                {
								                	'label':'Dropdown3',
								                	'link':'#'
								                }
								                ]
							}],
					'attr':{
								'id':'dynamicUl'
							},
					'class':'nav navbar-nav'
					};
$(function(){
	UI_createButton('#myButton','','','alert1','warning');
	UI_createButton('.classButton','','',alert1,'info');
	UI_createModal('#myModal','<div>This is header</div>','<div>This is Body</div>','<div>This is footer</div>',function(){alert('Handler working');},false);
	UI_bindModalButton('#myButton','#myModal');
	UI_createTooltip('[data-my]','data-my','right',function(event){$(event.target).toggleClass('btn-success');});
	UI_createTextBox('#myTextBox');
	UI_postAddon('#myTextBox','glyphicon-ok',true);
	UI_preAddon('#myTextBox','$');
	UI_createCheckBox('#checkBox1');
	UI_createRadioBox('[name="rg1"]',radioHandle);
	UI_createTable('#dynamictable',[['col1','col2','col3'],[11,12,13],[21,22,23],[31,32,33]],'table-striped table-condensed table-bordered table-hover');
	UI_createTabs('#myTab');
	UI_createNavBar("#myNavBar");
	UI_createNavBar("#jsonNav",jsonDataObj);
});
var alert1	=	function(event){
	alert($(event.target).attr("data-button")+' clicked');
};
var radioHandle	=	function(event){
	alert($(event.target).attr('id'));
}