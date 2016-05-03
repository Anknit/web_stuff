<?php
/*
 * Author: Ankit
 * Date: 11-Aug-2014
 * Description: Home page to all users. 
 * 
 */
 
/*
$queryString 		= $tempQuery;
$cleanQuery			= Random_decode($queryString);
*/

//Make payment
if(isset($_POST['payment_Confirm']) && $_POST['payment_Confirm'] != ''){
	require_once Common.'php/PaypalModule/PaypalConfirm.php';
	/*
	$paymentRecieptPdfPath	=	$_SESSION['SETUP_ROOT']."/temp/".$_SESSION['invoicenum'].".pdf";
	$pdfFileHttpPath	=	$_SESSION['HTTP_ROOT']."/temp/".$_SESSION['invoicenum'].".pdf";
	
	  
	 generatePDF($str, $paymentRecieptPdfPath);
	if(!file_exists($paymentRecieptPdfPath)){
		$paymentRecieptPdfPath	=	'';
	}
	*/
	//From above script, a variable $str shows the html (payment info).
	//So here show a poping out div displaying this information ($str). The div should show print button
	?>
	<div id="paypalPaymentDetail" style='display:none'>
		<?php 
			if(isset($str))
				echo $str;
		?>
		<br />
		<div align ="center">
		<?php if(isset($paymentRecieptPdfPath) && $paymentRecieptPdfPath !=	''){?>
			<button id='getPayPalDetails' onclick='window.open("<?php echo $pdfFileHttpPath;?>");'>Generate Pdf</button>
		<?php }else {?>
			<button id='getPayPalDetails' onclick='window.print();'>Print</button>
		<?php }?>
		</div>
	</div>
	<script>
		$(function(){
			callBacksFirstLevel.DisplayCredits	=	function(){
				$('li[assocdiv="CreditGenerationOption"]').click();
			};
		});
	</script>
	<?php 
	unset($_POST['payment_Confirm']);
}
function fill_user_profile_data_columns($ActiveUserProfileInfo){
	global $CustomHtml;
	global $Elements_DisplayBlock;
	
	$CustomHtml['.GlobalInfoSection']	=   'Welcome '.$ActiveUserProfileInfo['Name'].' ';
	$Elements_DisplayBlock[]			=	'.GlobalInfoSection';
	$CustomHtml['#profileName']			=	$ActiveUserProfileInfo['Name'];
	$CustomHtml['#profileOrg']			=	$ActiveUserProfileInfo['Organization'];
	
	if($ActiveUserProfileInfo['Website'] != "" || $ActiveUserProfileInfo['Website'] != NULL)
		$CustomHtml['#profileWeb']			=	$ActiveUserProfileInfo['Website'];
	else 
		$CustomHtml['#profileWeb'] = "-";
	
	$emptyaddress = true;
	$CustomHtml['#profileAdd']	=	'';
	if($ActiveUserProfileInfo['Address'] != "" || $ActiveUserProfileInfo['Address'] != NULL){
		$CustomHtml['#profileAdd']			=	$ActiveUserProfileInfo['Address'];
		$emptyaddress = false;
	}
	
	if($ActiveUserProfileInfo['City'] != "" || $ActiveUserProfileInfo['City'] != NULL){
		if(!$emptyaddress)	
			$CustomHtml['#profileAdd']	.=	', ';
		$CustomHtml['#profileAdd']	.=	$ActiveUserProfileInfo['City'];
		$emptyaddress = false;
	}
	
	if($ActiveUserProfileInfo['Country'] != "" || $ActiveUserProfileInfo['Country'] != NULL){
		if(!$emptyaddress)	
			$CustomHtml['#profileAdd']	.=	', ';
		$CustomHtml['#profileAdd']	.=	$ActiveUserProfileInfo['Country'];
		$emptyaddress = false;
	}
	
	if($ActiveUserProfileInfo['PinCode'] != "" || $ActiveUserProfileInfo['PinCode'] != NULL){
		if(!$emptyaddress)	
			$CustomHtml['#profileAdd']	.=	', ';
		$CustomHtml['#profileAdd']	.=	$ActiveUserProfileInfo['PinCode'];
		$emptyaddress = false;
	}
	
	if($emptyaddress)
		$CustomHtml['#profileAdd']	.= "-";
	
	if($ActiveUserProfileInfo['MailID'] != "" || $ActiveUserProfileInfo['MailID'] != NULL)
		$CustomHtml['#profileEmail']	=	$ActiveUserProfileInfo['MailID'];
	
	else
		$CustomHtml['#profileEmail'] = "-";
	
	if($ActiveUserProfileInfo['phonePersonal'] != "" || $ActiveUserProfileInfo['phonePersonal'] != NULL)
		$CustomHtml['#profilePersP']			=	$ActiveUserProfileInfo['phonePersonal'];
	
	else
		$CustomHtml['#profilePersP'] = "-";
	
	if($ActiveUserProfileInfo['phoneOffice'] != "" || $ActiveUserProfileInfo['phoneOffice'] != NULL)
		$CustomHtml['#profileOffP']			=	$ActiveUserProfileInfo['phoneOffice'];
	
	else
		$CustomHtml['#profileOffP'] = "-";
	
	$CustomHtml['#profileRegTime']		=	$ActiveUserProfileInfo['RegisteredOn'];
	
	
	$CustomHtml['#profileRegAuth']		=	$ActiveUserProfileInfo['regAuthorityName'];
	$usrtype							=	$ActiveUserProfileInfo['UserType'];
	switch ($usrtype){
		case 1:{
			$usrtype = "Operator";
			break;
		}
	case 2:{
			$usrtype = "Reseller";
			break;
		}
	case 3:{
			$usrtype = "Account Manager";
			break;
		}
	case 4:{
			$usrtype = "SuperUser";
			break;
		}
	case 5:{
			$usrtype = "Venera Sales";
			break;
		}
	case 6:{
			$usrtype = "Sales Representative";
			break;
		}
		default:{
			break;
		}
	}
	$CustomHtml['.GlobalInfoSection']	.=	'('.$usrtype.') | <a class="LogoutLink" title="Check your Profile info" href="#" onclick ="showProfileDiv();">My Profile</a> | <a class="LogoutLink" href="'.$_SESSION['HTTP_ROOT'].'/'.ProductDirectory.'/User Interface/Logout.php">Logout</a>';
}

if($_SESSION['userTYPE'] == SUPERUSER){
	if(count($systemDetailsCount) > 0) {
		$CustomData['#smtpHostName']	=	$systemDetails['smtpHostName'];
		$CustomData['#SmtpPortNumber']	=	$systemDetails['smtpPort'];
		$CustomData['#SmtpSenderName']	=	$systemDetails['sender'];
		$CustomData['#smtpUserName']	=	$systemDetails['smtpUsername'];
		$CustomData['#supportEmailID']	=	$SupportTeamEmail;
	}
}

$ActiveUserProfileInfo					=	getInfoFrom('user_details', 'profile', $_SESSION['userID']);
fill_user_profile_data_columns($ActiveUserProfileInfo);
$MyRegisteredUserInfo					=	getInfoFrom('user_details', 'registeredUsersProfile', array('userId'	=>	$_SESSION['userID']));
if(is_array($MyRegisteredUserInfo)) {
	$MyCustomersInfo					=	array_filter($MyRegisteredUserInfo, 'checkUserTypeCustomer');
	$MyCustomersInfo					=	array_values($MyCustomersInfo);
}

if($_SESSION['userTYPE'] == OPERATOR || $_SESSION['userTYPE'] == CUSTOMER) {

	$customerID							=	array();
	$customerID[]						=	$_SESSION['userID'];
	
	// User's own subscription
	$ActiveUserSubscriptionInfo			= 	getInfoFrom('user_details', 'usersSubscription', $customerID);
	$ActiveUserSubscriptionInfo			=	$ActiveUserSubscriptionInfo[0];
	$CustomHtml['#showSubsType']		=   '<span style="font-size: large"> &nbsp;&nbsp;'.$ActiveUserSubscriptionInfo['Subscription_Type'].' </span>';
	$ActiveUserCreditInfo				=	getInfoFrom('user_details', 'registeredUsersAccountInfo', array($_SESSION['accountID']));
	$ActiveUserCreditInfo				=	$ActiveUserCreditInfo[0];
	
	if($ActiveUserSubscriptionInfo['Subscription_Type'] == Subscription_PayPerMonth) {	//If operator and in monthly mode 
		$ActiveUserExpiry				=	$ActiveUserSubscriptionInfo['Validity_End_Date'];
		$CustomHtml['.GlobalInfoSection']	.=	'<br />Subscription expiry: '.$ActiveUserExpiry;
	}
	
	if($ActiveUserSubscriptionInfo['Subscription_Type'] == Subscription_PayPerUse || $_SESSION['userTYPE'] == CUSTOMER){
		$AccountCreditsExpiry				=	$ActiveUserCreditInfo['accountValidity'];
		$CustomHtml['.GlobalInfoSection']	.=	'<br />Account credits(US $): '.$ActiveUserCreditInfo['CreditAmount'].', valid until '.convertDateToFormat($AccountCreditsExpiry, 'Mdy');
	}
	if(!isset($MyRegisteredUserInfo) || $MyRegisteredUserInfo	== ''){
		$MyRegisteredUserInfo	=	array();
	}
}
if(!isset($MyCustomersInfo) || $MyCustomersInfo	== ''){
	$MyCustomersInfo	=	array();
}
?>
<script>
	var regUserType					=	'<?php echo $_SESSION['userTYPE']; ?>';
	var userID 						= 	'<?php echo $_SESSION['userID']; ?>';
	var username 					= 	'<?php echo $_SESSION['Username'];?>';
	var GRID_UNIQUE_ID;
	var customersInfo 				= 	<?php echo json_encode($MyCustomersInfo);?>;	//This is required global object
	statusTypes	=	"";
</script>
<div id="menuBar" class="JqxMenus" style="width: 99%; height: 90%">
	<ul>
		<?php
            foreach($UIMENU_List as $key=>$value) {
                echo '<li title = "'.$value['title'].'" class="menuItems" style="font-family: Arial" value='.$key.' assocDiv='.$value['assocDiv'].'><b>'.$key.'</b>';
				$sublistitem	=	$value['SubMenuItems'];
				if(count($sublistitem) > 0) {	//If submenu names array has some elements
					echo '<ul>';
					foreach($sublistitem as $key=>$value){
						$submenu = $sublistitem[$key];
						/*data is obtained just need to put the data code is incomplete */
						echo '<li style="font-family: Arial" value='.$submenu['name'].' title="'.$submenu['title'].'" assocDiv='.$submenu['assocDiv'].'>'.$submenu['name'].'</li>';
					}
					echo '</ul>';
				}
				echo '</li>';	
            }	
		?>
	</ul>
</div>
<div id='contentPANE' style="height:95%; max-height:95% ;overflow-y:auto;overflow-x:hidden">
	<?php    
        foreach($UIMENU_List as $key=>$value) {
            require_once $value['PageName'];
        }
        foreach($UIMENU_List as $key=>$value) {
            $sublistitem	=	$value['SubMenuItems'];
            foreach($sublistitem as $key=>$value)
            	require_once $sublistitem[$key]['PageName'];
        }
        require_once 'userPageProfile.php';
    ?>
</div>    
<link rel="stylesheet" href="../css/UserPage.css" type="text/css" />
<script type="text/javascript" src="../../Common/js/jqx/jqxtabs.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxcheckbox.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxdata.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxdatatable.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxgrid.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxwindow.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxmenu.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxdatetimeinput.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxcalendar.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/globalization/globalize.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxgrid.sort.js"></script> 
<script type="text/javascript" src="../../Common/js/jqx/jqxgrid.pager.js"></script> 
<script type="text/javascript" src="../../Common/js/jqx/jqxgrid.selection.js"></script> 
<script type="text/javascript" src="../../Common/js/jqx/jqxgrid.filter.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxgrid.columnsresize.js"></script> 
<script type="text/javascript" src="../../Common/js/jqx/jqxgrid.edit.js"></script>
<script type="text/javascript" src="../../Common/js/jqx/jqxwindow.js"></script>
<script type="text/javascript" src="../js/UserPage.js"></script>
<script type="text/javascript" src="../../Common/js/renderGrid.js"></script>
<datalist id="voucherCustomers">
	<?php for($j = 0; $j< count($MyCustomersInfo); $j++){?>
    	<option value="<?php echo $MyCustomersInfo[$j]['Username'] ;?>"></option>
    <?php }?>
</datalist>