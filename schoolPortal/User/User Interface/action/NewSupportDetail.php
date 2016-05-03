<?php
/*
 * Author: Ankit
 * Date: 29-September-2014
 * Description: This php file will be the first page after a user is logged in. 
 * 		where the SMTP setings and the new user creation modules are implemented. 
 * 		Form is submitted by the user for receiving a registration link on his email ID. 
 * 
 */
	require_once __DIR__."./../../require.php";
	require_once Common."/php/MailMgr.php";
	$cleanquery	=	$_SERVER['QUERY_STRING'];
	parse_str($cleanquery);
	$output = 0;
	if(isset($_SESSION['userID'])){
		
		if($supportUserSummary == '' || $supportUserSummary ==null ||$supportUserSubject == '' || $supportUserSubject ==null || $supportUserDescription == '' || $supportUserDescription == null){
			echo $output;
			return;	
		}
		if(isset($_SESSION['accountID'])){
			$userAccount	=	$_SESSION['accountID'];	//Would always be set for customers and operators
		}
		else{
			$userAccount	=	$_SESSION['userID'];
		}
		$newFile			=	time()."supportAttachement";
		$newFilePath		=	$_SESSION['SETUP_ROOT']."/temp/".$newFile;
		if(isset($_FILES['file']))
			$movedFile			=	move_uploaded_file($_FILES['file']['tmp_name'], $newFilePath);
		$userInfo			=	getInfoFrom('user_details', 'profile', $_SESSION['userID']);
		$newRequestResult	=	DB_Insert(array(	
					                    'Table'=> 'supportrequest',					
					                    'Fields'=> array (							
												'UserID'		  =>$_SESSION['userID'],
					                            'AccountID'       =>$userAccount,
					                            'organisation'    =>$userInfo['Organization'],
					                            'summary'  		  =>$supportUserSummary,
					                            'request_type'    =>$supportUserSubject,
							                    'Description'	  =>$supportUserDescription,
												'Version'		  =>$supportUserVersion,
//												'attachment'	  =>$newFilePath,
					                    )
					            ));
		if($newRequestResult){
			switch ($supportUserSubject){
				case 0:
					$supportUserSubject	=	'Issue';
					break;
				case 1:
					$supportUserSubject	=	'Feedback';
					break;
				case 2:
					$supportUserSubject	=	'Other';
					break;
			}
			
			$NewSupportRequestMailBody		=	getEmailBody('NewSupportRequest', array('NewRequestOrganisation' => $userInfo['Organization'], 'NewRequestSummary' => $supportUserSummary, 'NewRequestTicket' => $newRequestResult, 'NewRequestSubject' => $supportUserSubject, 'NewRequestDescription' => $supportUserDescription));
			$NewSupportRequestMailSubject	=	getEmailSubject('NewSupportRequest', array('NewRequestTicket' => $newRequestResult, 'NewRequestSummary' => $supportUserSummary));
			
			$mailResult	=	send_Email($SupportTeamEmail, $NewSupportRequestMailSubject , $NewSupportRequestMailBody, '', $newFilePath);
			if($mailResult){
				$output	 =	'Your request has been successfully registered. <br />';
//				$output	.=	'Your reference ticket ID for the following request is <b>'.$newRequestResult.'</b><br />';
//				$output	.=	'<b>Please save this ticket ID for future communication</b><br />';	
				$output	.=	'<b>Category: </b>'.$supportUserSubject.'<br />';	
				$output	.=	'<b>Pulsar Version: </b>'.$supportUserVersion.'<br />';	
				$output	.=	'<b>Summary: </b>'.$supportUserSummary.'<br />';
				$output	.=	'<b>Description: </b>'.$supportUserDescription.'<br />';
			}
			else {
				SetErrorCodes(13, __LINE__,  __FILE__);// failed to send email
			}
		}
		else{
			SetErrorCodes(14, __LINE__,  __FILE__);// failed to insert request details in Database
		}
	}
echo $output;