$(function(){
	var xAngle = 0;
	var yAngle = 0;
	$('body').on("keydown",function(e){
		switch(e.keyCode){
			case 37:
				yAngle -= 90; 
				break;
			case 38:
				xAngle += 90; 
				break;
			case 39:
				yAngle += 90; 
				break;
			case 40:
				xAngle -= 90; 
				break;
		}
		$('.contentCube').css('transform','rotateX('+xAngle+'deg) rotateY('+yAngle+'deg)');
	})
});