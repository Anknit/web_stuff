<?php
/*
 * Author: Aditya
* date: 08-Aug-2014
* Description: Header html for all pages. to include top navigation menu, and all neccessary files
*/
    require_once __DIR__.'./../require.php';
    ob_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo "../../".ProductDirectory."/css/style.css";?>" type="text/css" />
    <link rel="stylesheet" href="../../Common/css/jqx/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="../../Common/css/jqx/jqx.mysummercustom.css" type="text/css" />
    <link rel="stylesheet" href="../../Common/css/jqx/jqx.menucustom.css" type="text/css" />
	<link rel="stylesheet" href="../../Common/css/jqueryUI/themes/jquery-ui.css">
	<link rel="stylesheet" href="../../Common/css/ui.jqgrid.css" />
	<?php 
		require_once '../../'.ProductDirectory.'/phpToJavscriptDefinitions.php';
	?>
	<script type="text/javascript" src="../../Common/js/jquery.js"></script>
    <script type="text/javascript" src="../../Common/js/jqx/jqxcore.js"></script> 
    <script type="text/javascript" src="../../Common/js/jqx/jqxradiobutton.js"></script>
    <script type="text/javascript" src="../../Common/js/jqx/jqxbuttons.js"></script>
    <script type="text/javascript" src="../../Common/js/jqx/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="../../Common/js/jqx/jqxnumberinput.js"></script>
    <script type="text/javascript" src="../../Common/js/jqx/jqxscrollbar.js"></script>  
    <script type="text/javascript" src="../../Common/js/jqx/jqxlistbox.js"></script>
    <script type="text/javascript" src="../../Common/js/jqx/jqxtooltip.js"></script>
    <script type="text/javascript" src="../../Common/js/jqx/jqxinput.js"></script>
    <script type="text/javascript" src="../js/spoofData.js"></script>
    <script type="text/javascript" src="../js/alertMessages.js"></script>
    <script type="text/javascript" src="../../Common/js/commonFunctions.js"></script>
    <script type="text/javascript" src="../../Common/js/JsFunctionsToLocatePopUpdiv.js"></script>
    <script type="text/javascript" src="../../Common/js/jqxAbstract.js"></script>
	<script type="text/javascript" src="../../Common/js/grid.locale-en.js"></script>
	<script type="text/javascript" src="../../Common/js/GridRelated.js"></script>
	<script type="text/javascript" src="../../Common/js/jquery.jqGrid.min.js"></script>
	<script type="text/javascript" src="../../Common/js/jqueryUI/jquery-ui.custom.js"></script>
	<script type="text/javascript" src="../js/createjqgrid.js"></script>
	<script type="text/javascript" src="../js/TextAndConstants.js"></script>
    <title>Venera Pulsar Pay-Per-Use</title>
</head>
<body>
    <img id="LoadingImage" class="browseFrame" src="../../Common/images/aloader.gif" style="display:none;width:100px;height:100px;z-index: 100000;border: none;border-radius: 50px;margin-left:50px" />
    <div id="LayOutDiv" style="background-color: rgb(255, 255, 255); position: absolute; top: 0px; z-index: 10001; opacity: 0.3; display: none;width:100%;height:100%" ></div>
    
    <script type="text/javascript">
		var callBacksFirstLevel	= new Object();
        var JQXTHEME 						= 	"custom";
        var MenuTHEME						=	"MenuCustom";
		$(function(){
			ResizePage();
			loadImage();
		});
		var ResizePage = function(){
			var bodyHeight	=	$('body')[0].clientHeight;
			var HeaderHeight	=	$('.Header')[0].clientHeight;
			var FooterHeight	=	$('.Footer')[0].clientHeight;
			var allowedheight	=	bodyHeight-(HeaderHeight + FooterHeight);
			$('.CenterBody').css('height',allowedheight);
		    $('#contentPANE').css('height', allowedheight-34);
		}
    </script>
    <div class="CompletePage" style="visibility:hidden">	<!--Closed in footer.php-->
    <div class="Header">
        <img src="../images/logo.png" class="ppulogo" alt="Pulsar Pay-Per-Use"/>
    </div>    
    <div class="CenterBody">
    <div class="GlobalInfoSection"></div>
    
    <?php
    $Elements_DisplayNone		=	array();
    $Elements_DisplayBlock		=	array();
    $Elements_CreateTooltip		=	array();
    $CustomHtml					=	array();
    $CustomData					=	array();
    $ElementsValue_ToAddSubMenu	=	array();
    
    if(isset($_SESSION['userID']) && $_SESSION['userID'] != ""){
        $Elements_DisplayBlock[]	=	'.GlobalProfileInfo';
    }
    ?>