$(function(){
	var j = 30;
	for(i=0;i<30;i++){
		$('.Arena').append('<div class="step '+j+'" >'+j+'</div>');
		j--;
	}
	
	$('.step.1').append('<div class="p" id="player1"></div>');
	$('.step.1').append('<div class="p" id="player2"></div>');
	for(k=0;k<6;k++){
		for(l=0;l<=k;l++){
			$($('.cube_s')[k]).append('<div class="dots"></div>');
		}
	}
});
var numObj	=	{
					's3':[3,6,5,1],
					's2':[2,6,4,1],
					's5':[5,6,3,1],
					's4':[4,6,2,1]
				};
var throwDice	=	function(player){
	$('.dice').css('top','350px');
	$('.dice').css('left','500px');
	faceNum	=	rotateDice();
	$('.P'+player+'Controls').find('.faceNum').html(faceNum);
};
var rotateDice	=	function(){
	ver	=	Math.ceil(Math.random()*15);
	hor	=	Math.ceil(Math.random()*15);
	$('.dice').css('transform','rotateX('+90*ver+'deg) rotateY('+90*hor+'deg)');
	return numObj[Object.keys(numObj)[(hor+4)%4]][(ver+4)%4];
};