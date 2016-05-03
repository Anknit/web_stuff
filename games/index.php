<?php
$game	=	'';
if(isset($_GET['game']))
	$game = $_GET['game'];
if($game == '')
	$game = 'cube';
include './html/'.$game.'.html';
?>