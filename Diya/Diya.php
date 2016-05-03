<?php
?>
<html>
	<head>
		<title>Test
		</title>
		<style>
			body{
				overflow:hidden;
			}
			.container{
				position:absolute;
				width: 500px;
				height: 100px;
				vertical-align: middle;
				text-align: center;
 			}
			.con1{
				margin: 0 0 0 0;
    			-webkit-animation: mymove1 5s infinite linear;
			}
			.con2{
				margin: 0 0 0 1000;
    			-webkit-animation: mymove2 5s infinite linear;
			}
			.con3{
				margin: 400 0 0 0;
    			-webkit-animation: mymove3 5s infinite linear;
			}
			.con4{
				margin: 400 0 0 1000;
    			-webkit-animation: mymove4 5s infinite linear;
			}
			@-webkit-keyframes mymove1 {
 			   from {margin: 0 0 0 0;}
    			to {margin: 400 0 0 1000;}
			}
			@-webkit-keyframes mymove2 {
 			   from {margin: 0 0 0 1000;}
    			to {margin: 400 0 0 0;}
			}
			@-webkit-keyframes mymove3 {
 			   from {margin: 400 0 0 0;}
    			to {margin: 0 0 0 1000;}
			}
			@-webkit-keyframes mymove4 {
 			   from {margin: 400 0 0 1000;}
    			to {margin: 0 0 0 0;}
			}
			@-webkit-keyframes mycolor {
 			   from {background: red; border-color: yellow}
    			to {background: yellow; border-color: red}
			}
			@-webkit-keyframes mycolor2 {
 			   from {border-Color: white}
    			to {border-color: blue}
			}
			@-webkit-keyframes messagecolor {
 			   from {color: yellow}
    			to {color: white}
			}
			@-webkit-keyframes messagetext {
 			   from {width: 22px}
    			to {width: 175px}
			}
			.light{
				background: red;
				border: 5px solid yellow;
				height: 58px;
				margin-left: 280px;
				width: 10px;
				border-top-left-radius: 20;
				border-bottom-right-radius: 10;
				position: relative;
				top: 64px;
				z-index: 3;		
    			-webkit-animation: mycolor 1s infinite linear;
			}
			.front_base{
				background: brown;
				height: 130px;
				width: 300px;
				border-bottom-left-radius: 500;
				border-bottom-right-radius: 500;
			}
			.front_design, .front_design_2{
				border-bottom: 3px solid white;
				height: 78px;
				border-bottom-left-radius: 100%;
				border-bottom-right-radius: 100%;
				width: 150px;
				position: relative;
    			-webkit-animation: mycolor2 0.5s infinite linear;
			}
			.front_design{
				top: -143px;
				left: 4px;
			}
			.back_base{
				background: black;
				height: 50px;
				width: 300px;
				border-radius: 100%;
				top: 27px;
				position: relative;
			}
			.front_design_2{
				top: -223px;
				left: 146px;
			}
			.message{
				position: relative;
				top: -202px;
				left: 79px;
				font-size: 25px;
				color:yellow;
				width: 22px;
				height: 32px;
				overflow: hidden;
    			-webkit-animation: messagecolor 1s infinite linear;
    			-webkit-animation: messagetext 5s infinite linear;
			}
		</style>
	</head>
	<body>
		<div class='container con1' >
			<div class='light' align='center'></div>
			<div class='back_base' align='center'></div>
			<div class='front_base' align='center'></div>
			<div class='front_design'></div>
			<div class='front_design_2'></div>
			<div class='message'>Happy_Diwali</div>
		</div>
		<div class='container con2' >
			<div class='light' align='center'></div>
			<div class='back_base' align='center'></div>
			<div class='front_base' align='center'></div>
			<div class='front_design'></div>
			<div class='front_design_2'></div>
			<div class='message'>Happy_Diwali</div>
		</div>
		<div class='container con3' >
			<div class='light' align='center'></div>
			<div class='back_base' align='center'></div>
			<div class='front_base' align='center'></div>
			<div class='front_design'></div>
			<div class='front_design_2'></div>
			<div class='message'>Happy_Diwali</div>
		</div>
		<div class='container con4' >
			<div class='light' align='center'></div>
			<div class='back_base' align='center'></div>
			<div class='front_base' align='center'></div>
			<div class='front_design'></div>
			<div class='front_design_2'></div>
			<div class='message'>Happy_Diwali</div>
		</div>
	</body>
</html>
