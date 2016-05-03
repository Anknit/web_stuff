<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This php file will be the first page after a user is logged in. 
 * 		where the SMTP setings and the new user creation modules are implemented. 
 * 		Form is submitted by the user for receiving a registration link on his email ID. 
 * 
 */
	require_once __DIR__."./../../require.php";
	require_once Common."/php/MailMgr.php";	
	
	$Email			= trim($_GET['email']);
	//1 Look user entry in userinfo table
	$userExist 	= array(
			'Table'=> 'userinfo',					
			'Fields'=> '*',
			'clause'=> 'Username = "'.$Email.'"'
	  );
	$resultCheckUserExistence = DB_Read($userExist, 'NUM_ROWS', '');

	if($resultCheckUserExistence > 0){
		echo '3' ;
		return;
	}
	else{
		function CreateNewAccount(){
			global $User_Type, $currencyCode, $creditAmount, $accountValidity;
			$createAccount =  DB_Insert(array(	//Just for demo
					'Table'=> 'accountcredit_info',					
					'Fields'=> array (							
							'CreatedOn'         =>'now()',
							'CreditAmount'		=>$creditAmount,
							'accountStatus'		=>ACTIVE,
							'accountValidity'	=>$accountValidity,
							'currencyCode'		=>$currencyCode
					)
			));
			return $createAccount;
		}
		
		$User_Type		= $_GET['type'];
		$regAuthorityID = $_SESSION['userID'];

		$currencyCode	=	'USD';
		if(isset($_GET['currencyCode']))
			$currencyCode 	= $_GET['currencyCode'];

		$accountValidity	=	defaultPPUDates(1);
		$creditAmount	=	0;
		if(IfValid($_GET['DemoCredits']) && $_GET['DemoCredits']	==	1) {
			$creditAmount	=	defaultCredits;
			$accountValidity	=	defaultPPUDates(2);
		}
			
		$regAuthorityName = $_SESSION['Username'];
		
		//1.1 Add entry in account table so as to get accountID
		if($User_Type == OPERATOR)
			$AccountID	=	$_SESSION['accountID'];
		elseif($User_Type == CUSTOMER) {
			$AccountID	=	CreateNewAccount();
			if(!$AccountID) {
				echo '2';
				return;
			}
			elseif($creditAmount != 0) {
				//Placeholder section for recording transaction of demo credits
			}
		}
				
		//2 Add user entry in userinfo table
		$createUserInput 	= array(
			'Table'=> 'userinfo',					
			'Fields'=> array (							
				'Username'          =>$Email,
				'MailID'            =>$Email,
				'UserType'          =>$User_Type,
				'userStatus'        =>UNVERIFIED,
				'RegisteredOn'		=>'now()',
	//              'Password'          =>md5('start123'),
				'regAuthorityID'    =>$regAuthorityID,
				'regAuthorityName'  =>$regAuthorityName
			)
		);
	
		if(isset($AccountID)) {
			$createUserInput['Fields']['AccountID']	=	$AccountID;
		}
			
		$resultAddUser = DB_Insert($createUserInput);	//$resultAddUser contains the uid
		if($resultAddUser)
		{
			if(isset($AccountID)) {
				$Insertlicenseinfo =  DB_Insert(array(
					'Table'=> 'licenseinfo',					
					'Fields'=> array (							
							'UserID'          		=>$resultAddUser,
							'Features'       		=>DefaultFeaturesForPPU,
							'ServiceID'       		=>'PPU'
					 )
				));
				
				$InsertSubscriptionInfo =  DB_Insert(array(	
					'Table'=> 'usersubscriptioninfo',					
					'Fields'=> array (							
						'UserID'          	 =>$resultAddUser,
						'Subscription_Type'  =>Subscription_PayPerUse,
						'Auto_Renewal'		 =>RENEWAL_OFF,
						'Package'			 =>$PackageName[0],
					)
				));
			}
			
		//3 send e-Mail to user for registration complete
			function GenerateQueryToVerifyUser($username, $uid)
			{
				$Expirydate		=	defaultPPUDates(2);
				$QueryString	=	"userID=".$uid."&email=".$username."&ExpireOn=".$Expirydate;
				return $QueryString;
			}
			
			$VerificationLinkQueryData	=	Random_encode(GenerateQueryToVerifyUser($Email, $resultAddUser));
			$VerificationPageAddress	=	$_SESSION['HTTP_ROOT'].ProductDirectory.'/User Interface/Registration.php?'.$VerificationLinkQueryData;
			$VerificationLink			=	"<a href = '".$VerificationPageAddress."'>Register</a>";
			
			$NewUserMailBody		=	getEmailBody('NewUser', array('NewUserType' => $User_Type, 'RegistrationLink' => $VerificationLink, 'RegistrationPageAddress' => $VerificationPageAddress));
			$NewUserMailSubject		=	getEmailSubject('NewUser', array('NewUserType' => $User_Type));
	
			$mailResult	=	send_Email($Email, $NewUserMailSubject , $NewUserMailBody);
			if($mailResult){
				echo '1';
			}
			else {
				//Roll back the changes if mail sending fails
				SetErrorCodes(12, __LINE__,  __FILE__);	//Delete user info because mail cannot be sent. hence the message could not add user
				$UID	=	$resultAddUser;
				$$userTYPE	=	$User_Type;
				require_once __DIR__.'./../../LogicsToUpdateDB/deleteUser.php';
				echo '2';
			}
		}
	}//close elseif user exist
?>
