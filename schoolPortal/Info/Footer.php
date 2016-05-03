<?php
/*
 * Author: Aditya
* date: 08-Aug-2014
* Description: Header html for all pages. to include top navigation menu, and all neccessary files
*/
?>
</div>	<!--CenterBody Opened in header.php-->
<div class="Footer">
</div>
</div>	<!-- CompletePage Opened in header.php-->
<script type="text/javascript">
	$(function(){
		var ResizePage = function(){
			var bodyHeight	=	$('body')[0].clientHeight;
			var HeaderHeight	=	$('.Header')[0].clientHeight;
			var FooterHeight	=	$('.Footer')[0].clientHeight;
			var allowedheight	=	bodyHeight-(HeaderHeight + FooterHeight);
			$('.CenterBody').css('height',allowedheight);
		    $('#contentPANE').css('height', allowedheight-34);
		};
		window.onresize = ResizePage;
		ResizePage();
		loadImage();
	});
</script>
<script type="text/javascript" src="../Common/js/JsFunctionsToLocatePopUpdiv.js"></script>
<script type="text/javascript" src="../Common/js/commonFunctions.js"></script>
<script type="text/javascript" src="<?php echo '../Common/'.$jqueryUITHemePaths['js'];?>"></script>
<script type="text/javascript" src="../Common/js/JqueryUIBindingsAndCOnverters.js" ></script>

<script type="text/javascript">
	$(function(){
		deloadImage();
	});
</script>
</body>
</html>