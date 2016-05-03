<?php
/*
 * Author: Aditya
* date: 13-Aug-2014
* Description: Login is the landing page in user driven mode
*/

require_once '../require.php';

function unset_all_vars($a)
{ 
	foreach($a as $key => $val)
  	{
		if(isset($GLOBALS))
			unset($GLOBALS[$key]);
	}
  return serialize($a); 
}
if(isset($_COOKIE['tab']))
	 	setcookie("tab", "", time()-3600);
session_destroy();	//destroy all the session variable
unset_all_vars(get_defined_vars());	//unset all the variable (memory free)
RedirectTo('Login');//redirect to home page
?>