<?php
/*
 * Author: Aditya
* date: 08-Aug-2014
* Description: Header html for all pages. to include top navigation menu, and all neccessary files
*/
?>
</div>	<!--CenterBody Opened in header.php-->
<div class="Footer" >
    <div class="FooterContent FooterCentralContent">
        <?php echo COPYRIGHT;?>
    </div>
    <div class="FooterContent FooterRightContent">
        <?php echo PortalVersion;?>
    </div>
</div>
<div id="ScrollMessagesDiv" class="AnimateMessagesBar">
	<div id="ScrollMessagesContent" class="ScrollMessagesContent"></div>
	<div id="closeMessageDiv" style="float:right; padding: 2% 7px 0px 0px"><img height="9" width="9" src="../../Common/images/close.png" alt="close" onclick="AlertMessageMethods.Hide();" style="cursor:pointer" /></div>
</div>
</div>	<!--Opened in header.php-->
<script type="text/javascript" src="../js/ppuCommon.js"></script>
<script type="text/javascript">
	var Elements_DisplayNone			= <?php echo json_encode($Elements_DisplayNone);?>;
	var Elements_DisplayBlock			= <?php echo json_encode($Elements_DisplayBlock);?>;
	var Elements_CreateTooltip			= <?php echo json_encode($Elements_CreateTooltip);?>;
	var	CustomHtmlForInternalPurposes	= <?php echo json_encode($CustomHtml);?>;
	var	CustomDataForInternalPurposes	= <?php echo json_encode($CustomData);?>;
	//var	ElementsValue_ToAddSubMenu		= <?php //echo json_encode($ElementsValue_ToAddSubMenu);?>;
	
	$(function(){
		//Disable entering & in input and text fields
		$( "input" ).blur(function( ) {
			$(this).val(this.value.replace('&', ''));
		});
		$('textarea').blur(function( ) {
			$(this).val(this.value.replace('&', ''));
		});
		
		deloadImage();
		$('.CompletePage').css('visibility', 'visible');
	});


</script>
<script type="text/javascript" src="../js/writeData.js"></script>
</body>
</html>