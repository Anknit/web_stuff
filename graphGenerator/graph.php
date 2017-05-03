<?php
?>
<html>
<head>
<style>
html,body,div{
	margin:0px;
	padding:0px;
}
</style>
</head>
<body>
<div align="center" style="margin:auto; width:100%; height:100%">
<canvas id='graphcanvas' width='1000' height='600' style='border:1px solid black; background:lightgreen'></canvas>
<br />
<div style="width:200px; color:white; background:orange">Current Value is </div>
<div id="valDiv" style="width:100px; color:white; background:green"></div>
</div>
<script type="text/javascript" src="./../jquery.js"></script>
<script type="text/javascript">
var Xpos=0, Ypos=300, ctx='', c='', valDiv='' ;
$(function(){
	c = $("#graphcanvas");
	ctx = c[0].getContext("2d");
	ctx.beginPath();
	valDiv	=	$('#valDiv');
	ctx.moveTo(Xpos, Ypos);
	repeatCall(ctx);
});
var startGraph	=	function(ctx){
	Xpos	=	Xpos+Math.random();
	Ypos	=	Ypos+(Math.random() < 0.5 ? -1 : 1);
	if(Xpos > 1000){
		var imageData = ctx.getImageData(0, 0, 1000, 600);
		var newCanvas = $("<canvas>")
		    .attr("width", imageData.width)
		    .attr("height", imageData.height)[0];
		newCanvas.getContext("2d").putImageData(imageData, 0, 0);
		ctx.clearRect(0,0,1000,600);
		c = $("#graphcanvas");
		ctx = c[0].getContext("2d");
		ctx.scale(0.5, 1);
		ctx.drawImage(newCanvas, 0, 0);
		ctx.scale(2, 1);
		Xpos	=	Xpos*0.5;
		ctx.beginPath();
		ctx.moveTo(Xpos,Ypos);
	}
	if(Ypos > 590 || Ypos < 10){
		var imageData = ctx.getImageData(0, 0, 1000, 600);
		var newCanvas = $("<canvas>")
		    .attr("width", imageData.width)
		    .attr("height", imageData.height)[0];
	    if(Ypos > 590){
		    offset	= -150;
		    Ypos	= 600;	
	    }
	    else{
		    offset	=	150;
		    Ypos	=	0;
	    }
		newCanvas.getContext("2d").putImageData(imageData, 0, 0);
		ctx.clearRect(0,0,1000,600);
		c = $("#graphcanvas");
		ctx = c[0].getContext("2d");
		ctx.scale(1, 0.5);
		ctx.drawImage(newCanvas, 0, offset);
		ctx.scale(1, 2);
		Ypos	=	(Ypos+offset)*0.5;
		ctx.beginPath();
		ctx.moveTo(Xpos,Ypos);
	}
	else{
		ctx.lineTo(Xpos, Ypos);
		ctx.stroke();
		valDiv.html(600-Ypos);
	}
}
var repeatCall	=	function(ctx){
	startGraph(ctx);
	setTimeout(function(){repeatCall(ctx);},1);	
};
</script> 
</body>
</html>