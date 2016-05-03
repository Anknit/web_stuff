<?php
function ieversion()
{
  	ereg('MSIE ([0-9]\.[0-9])',$_SERVER['HTTP_USER_AGENT'],$reg);
  	if(!isset($reg[1])) 
	{
    	return -1;
  	} 
	else 
	{
    	return floatval($reg[1]);
  	}
}

//Generate a random number (as string) of length recieved in arguments
function randomNumber_String($length)
{
	$i=0;
	$randomCode	=	"".mt_rand(1,9);
	do {
		$randomCode .= mt_rand(0, 9);
	} while(++$i < $length);

	return $randomCode;
}

//This method checks if the object for  a class exists. If it doesn't then the object with class name is created with global scope. The class name is taken as an argument
function getclassObject($className){
	global $$className;
	if(!isset($$className)){
		$$className	=	 new $className();
	}
	return $$className;
}

/*
	calls a class method and returns the output
	@param classname : exact name of the class whose method is to be called
	@param function : exact name of the class method
	@param arguments : argument should be single. If inside a function multiple arguments are required then they should be recieved via 		
	an array
	Probably this corresponds to call_user_func
*/
function getInfoFrom($className, $operationName, $arguments = '', $arg2 = '', $arg3 = '', $arg4 = ''){
	$classObject	=	 getclassObject($className);
	return call_user_func(array($classObject, $operationName), $arguments, $arg2, $arg3, $arg4);
}

function IfValid ($variable) {
	if($variable	!=	"" && $variable != NULL)
		return true;
	else
		return false;
}

function array_indexed_merge_at_end($arr1, $arr2){
	$initFrom	=	count($arr1);
	$PushUpto	=	count($arr2);
	$j = 0;
	for($i = $initFrom; $j< $PushUpto; $i++){
		if(IfValid($arr2[$j]))
			$arr1[$i]	=	$arr2[$j];
			
		$j++;
	}
	return $arr1;
}
?>