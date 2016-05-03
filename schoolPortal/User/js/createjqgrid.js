var USER_GRID_UNIQUE_ID ;

$(function(){
	RenderJQGrids();
});
var RenderJQGrids = function(){ 	
	$('.convertTojqGrid').each(function(){
		customJqgrid($(this)[0]);
	});
};

var ResizeTable = function(Table)
{
	var TableHeight		=	Table.height();
	var MaxDivHeight	=	Element('contentPANE').clientHeight;
	var MaxDivWidth		=	Element('contentPANE').clientWidth;
	var SetHeight	=	MaxDivHeight-130;
	var SetWidth	=	0.99 * MaxDivWidth;
	Table.jqGrid('setGridHeight', SetHeight);
	Table.jqGrid('setGridWidth', SetWidth);
};

var fetchjqGridObject = function(gridObject){
	return {
			datatype: 	function(postdata){
				jQuery.ajax({
					url:$(gridObject).attr('url'),
					data:postdata,
					contentType: "application/json",
					dataType:"json",
					complete: function(jsondata,stat){
					  if(stat=="success") {
							TotalPages		=	jsondata.responseJSON.total;
							ResponseData	=	jsondata.responseJSON.rows;
							var thegrid 	= jQuery('#'+$(gridObject).attr('id'))[0];
							thegrid.addJSONData(jsondata.responseJSON);
					  }
				   }
				});
			},
			colNames:$(gridObject).attr('colNames').split(','),
			colModel:window[$(gridObject).attr('colModel')](),
			/*[
						{name:'UserID',				index:'UserID',				width:60,	hidden: false, title: false, formatter:Editbutton},
						{name:'Username',			index:'Username',			width:250, sorttype: "float", title: false},
						{name:'Name',				index:'Name',				width:160, sorttype: "float", title: false},
						{name:'userStatus',				index:'userStatus',				width:100, hidden: false, formatter:EditSaveUserStatus},
						{name:'Organization',		index:'Organization',		width:240,	sorttype: "float",	align:"left", title: false,},
						{name:'RegisteredOn',		index:'RegisteredOn',		width:120,	sorttype: "date",	align:"left", title: false},		
						{name:'UserType',			index:'UserType',			width:150,	sorttype: "float",	align:"left", title: false, formatter:userTYPEVALUE},	
						{name:'Delete',				index:'Delete',				width:50,	sortable:false,		align:"center", formatter:deleteUser}		
			]*/
			jsonReader : {
				 root: "rows",
				 records: "records",
				 viewrecords: true,
				 repeatitems: true,
				 cell: "",
				 id: "0"
			},
			rowNum:20,
			rowList:[10,20,30],
			gridview: true,
			ignoreCase: true,
			autoencode: true,
			//loadonce: true,	If this is on the total pages in pager wouldn't work well. This will load records at once only
   			emptyrecords: "No records found",
  			shrinktoFit: true,
 			pager : '#gridpager_'+$(gridObject).attr('id'),
  			forceFit: true,
			recordpos: 'left',
			viewrecords: true,
			pginput : true,
  			sortname: $(gridObject).attr('sortBy'),
			sortorder: 'asc',
			toolbar:[false,'top'],
			beforeSelectRow: function(){
				return false;
			},
			gridComplete: window[$(gridObject).attr('gridComplete')].gridComplete
			/*function(){
				var Table			=	$(this);
				ResizeTable();
				$('.regUserEditButton').jqxButton({width:'100px', height:'35px'});
				createDropDownList();
				
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
			}*/
		};
};

var customJqgrid = function(gridObject){
	var GridUniqueid	=	$(gridObject).attr('id');
	var ResponseData	=	"";
	var TotalPages;
	var jqgridOBJECT = fetchjqGridObject(gridObject);
	$('#'+GridUniqueid).jqGrid(jqgridOBJECT);
};
