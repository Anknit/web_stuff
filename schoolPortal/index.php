<?php 
session_start();
$_SESSION['SETUP_ROOT'] = str_replace('\\', '/', __DIR__."/");
$_SESSION['HTTP_ROOT']	= str_replace(basename(__FILE__), "", "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
header('Location: Info/');
?>