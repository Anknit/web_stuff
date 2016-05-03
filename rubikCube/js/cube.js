$(function(){
	var j = 0;
	var colorArray	=	['wh','gr','bl','re','ye','or'];
	$('.cube_s').each(function(){
		for(i=0;i<9;i++){
			$(this).append('<div class="cube_block '+colorArray[j]+'"></div>');
		}
		j++;
	});
});
var xAngle = 0;
var yAngle = 0;
var zAngle = 0;
var cubeStraight	=	function(){
	$('.a_cube').removeClass('rotateCube');
};
var cubeRotate3D	=	function(){
	$('.a_cube').addClass('rotateCube');
};
var rotateFace	=	function(ver,hor,zax){
	cubeStraight();
	$('.a_cube').css('transform','rotateX('+ver+'deg) rotateY('+hor+'deg) rotateZ('+zax+'deg)');
};


var cubeRotateL		=	function(){
	cubeStraight();
	xAngle += 90;
	$('.a_cube').css('transform','rotateX('+xAngle+'deg) rotateY('+yAngle+'deg)');
};
var cubeRotateR		=	function(){
	rr++;
	cubeStraight();
	$('.a_cube').css('transform','rotate3D(0,1,0,'+angle+'deg)');
};
var cubeRotateU		=	function(){
	ru++;
	cubeStraight();
	$('.a_cube').css('transform','rotate3D(1,0,0,'+angle+'deg)');
};
var cubeRotateD		=	function(){
	rd++;
	cubeStraight();
	$('.a_cube').css('transform','rotate3D(1,0,0,'+angle+'deg)');
};
