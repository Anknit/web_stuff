<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed in two cases
 * 				1. when the user is redirected from the link sent to his mail ID to complete the registration
 * 				2. when the user click edit button on My Profile page to edit his profile info.
 */
 $queryString 		= $_SERVER['QUERY_STRING'];
 $cleanQuery		= Random_decode($queryString);
 parse_str($cleanQuery);
 if(isset($email))
	 $Username		= $email; 
 if(isset($Username) && $Username != "") {
	 $result = DB_Read(array(
	                        'Table'=> 'userinfo',					
	                        'Fields'=> '*',  
	                        'clause' => 'UserID = '.$userID
	                         ),'ASSOC','' );
	 $details	=	$result[0];
	 if($details){
		 $name 						= 	explode(" ",$details['Name']);
		 
		 $CustomData['#fname']		=	$name[0];
		 $CustomData['#lname']		=	str_replace($CustomData['#fname'],'',$details['Name']);
		 if($details['userStatus'] 		==	ACTIVE  && !isset($_SESSION['userID'])){
			RedirectTo("Login");
		 }			 
		 
		 if($details['userStatus'] 		!=	UNVERIFIED){
			 $CustomData['#pwd']		=	'*ENCRYPTED*';
			 $CustomData['#conf_pwd']	=	'*ENCRYPTED*';
		 }
		 //if($details['userStatus'] !=	UNVERIFIED)
		 //	 $Elements_DisplayNone[]	=	'#conf_pwd';
			 
		 $CustomData['#usrType']	=	$details['UserType'];
		 $CustomData['#usrId']		=	$userID;
		 $CustomData['#org']		=	$details['Organization'];
		 $CustomData['#csite']		=	$details['Website'];
		 $CustomData['#city']		=	$details['City'];
		 $CustomData['#pin']		=	$details['PinCode'];
		 $CustomData['#country']	=	$details['Country'];
		 $CustomData['#offPhone']	=	$details['phoneOffice'];
		 $CustomData['#persPhone']	=	$details['phonePersonal'];
		 $CustomData['#usrStatus']	=	$details['userStatus'];
		 $CustomHtml['#email']		=	$details['Username'];
		 $CustomData['#type']		=	$details['Username'];
		 $CustomHtml['#add']		=   $details['Address'];
	 }
}
	                         
if(!$cleanQuery)
	parse_str($queryString);
	
if(isset($RegisterValues) && IfValid($RegisterValues)) {
	require_once __DIR__.'./../action/NewUserDetails.php';
}

if(isset($err) && $err == 1) {$CustomHtml['Status']	=	'Error in your registration process';}

$userStatus	=	'undefined';
if($details['userStatus'] != '')
	$userStatus	=	$details['userStatus'];
?>
<link rel="stylesheet" href="../css/Registration.css" type="text/css" />
<script>
	var userStatus 	= 	<?php echo $userStatus; ?>;
</script>

<hr style="margin-left: 0px;opacity: 0.5;color: #eee;" />
<div id = "maindiv">
    <div id= "formDiv">
    <span style="font-size:13px"><b>My Details</b></span>
    <br /><br />
        <form id="userRegistrationForm" action="">
            <table cellspacing="3px" style="font-size:12px">
                <tr>
                    <td align="right">
                        Username
                    </td>
                    <td align="left">
                        <span id="email" style="border: none"></span>
                        <input name="email" type="hidden" id="type">
                        <input name="usrType" type="hidden" id="usrType">
                        <input name="usrStatus" type="hidden" id="usrStatus">
                        <input name="usrId" type="hidden" id="usrId">
                    </td>
                    <td colspan="2">&nbsp;
                        
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Password<span style="color: red"><sup>*</sup></span>
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="password" id="pwd" name="pwd">
                    </td>
                    <td colspan="2" style="color: red">
                        Password should be greater than 6 and less than 20 characters
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Confirm Password<span style="color: red"><sup>*</sup></span>
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="password" id="conf_pwd">
                    </td>
                    <td colspan="2">&nbsp;
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr class="formDemarkation">
                    </td>
                </tr>
                <tr>
                    <td align="right">First Name<span style="color: red"><sup>*</sup></span></td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="fname" name="fname">
                    </td>
                    <td align="right">Last Name</td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="lname" name="lname">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Organization<span style="color: red"><sup>*</sup></span>
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="org" name="org"/>
                    </td>
                    <td align="right">
                        Website
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="csite" name="csite">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Address
                    </td>
                    <td align="left" rowspan="3">
                        <textarea class="textAreaBox" style="resize:none;padding-left:5px" id="add" name="add" rows="5" cols="27"></textarea>
                    </td>
                    <td align="right">
                        City
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="city" name="city"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="right">
                        Zip Code
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="pin" name="pin">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="right">
                        Country
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="country" name="country">
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Phone
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="offPhone" name="offPhone">
                    </td>
                    <td align="right">
                        Mobile
                    </td>
                    <td align="left">
                        <input class="mediumInputBox" type="text" id="persPhone" name="persPhone" >
                    </td>
                </tr>
                <tr style="height:50px">
                    <td>
                        <input type="hidden" name="RegisterValues" id="RegisterValues" value="" />
                    </td>
                    <td style="text-align: right;">
                        <button class="largeButton" type="submit" id="registerButton" onClick="return Register();">Save</button>
                    </td>
                    <td colspan="2">
                    <?php if($details['userStatus'] == 2){?>
                        <button class="largeButton" type="button" onClick="backToHome();">Cancel</button>
                    <?php }?>	
                    </td>
               </tr>
               <tr>
                   <td colspan="2" align="center">
                        <span style="color: red"><sup>*</sup>  Mandatory Fields</span> 
                   </td>
                   <td colspan="2">&nbsp;</td>
               </tr>
            </table>
        </form>
    </div>
    <div id="Status" align="center"></div>
</div>
<script type="text/javascript" src="../js/Registration.js"></script>