<?php
/*
 * Author: NITIN KUMAR
 * date: 25-JAN-2016
 * 
 */

require_once __DIR__.'./../templates/pulsar_templates_class.php';
require_once __DIR__.'./../pulsar_comon_method.php';

class _pulsar_api {
	public  $pulsar_api_init_status		=	false;
	public  $pulsar_api_init_error		=	'';
	private $pulsar_api_db_handle		=	'';
	private $copy_template_array		=	array(
													array("template_id" => 3, "template_name" => "Basic Tests")
											);
	private $ShowTemplateDetailOnReport	=	0;
	
	/**
	 * Constructor function
	 * @param:  $pulsar_api_config -> Holds configuration of db handel and some configuration that this class requires to initiate
	 * 
	 * */
	public function _pulsar_api($pulsar_api_config){
		$checkConfigIsArray	=	is_array($pulsar_api_config);
		if(!$checkConfigIsArray){
			$this->pulsar_api_init_status	=	false;
			$this->pulsar_api_init_error	=	'No config found';
			return false;
		}
		else{
			if(!isset($pulsar_api_config['pulsar_api_database_setting'])){
				$this->pulsar_api_init_status	=	false;
				$this->pulsar_api_init_error	=	'database config not available';
			}
			else {
				$this->pulsar_api_init_status	=	true;
				$db_handle	=	DBMgr_Handle($pulsar_api_config['pulsar_api_database_setting']);
				$this->pulsar_api_db_handle	=	DBMgr_Handle($pulsar_api_config['pulsar_api_database_setting']);
				
				unset($pulsar_api_config['pulsar_api_database_setting']);
			}
		}
	}
	
	/**
	 * Check pulsar controller is running or off
	 * 
	 * */
	private function CheckSoapServerForControllerRequests(){
		$output	=	array(
				'status'	=>	false
		);
		
		ini_set('soap.wsdl_cache_enabled',0);
		
		$query		= "SELECT * FROM pulsarcontroller WHERE PulsarStatus=1";
		$total1		= $this->pulsar_api_db_handle->Query($query, 'NUM_ROWS');
		if($total1==0){
			$output['status']		=	false;
			$output['data']			=	array(
												"code" 		=> 	503,
												"message"	=> 	"Service temporarily unavailable."
										);
			$output['error_description']	=	"Pulsar controller is off";
		}
		else{
			$query_check	= 	"SELECT * FROM pulsarcontroller WHERE TIME_TO_SEC(TIMEDIFF(curtime(),ModifyTime)) BETWEEN 0 AND 7 ";
			$total1_check	= 	$this->pulsar_api_db_handle->Query($query_check, 'NUM_ROWS');
	
			if($total1_check >= 1){
				$output['status']	=	true;
			}
			else{
				$output['status']	=	false;
				$output['data']		=	array(
												"code" 		=> 	503,
												"message"	=> 	"Service temporarily unavailable."
										);
				$output['error_description']	=	"Pulsar is running but heart beat is absent in last 7 sec";
			}
		}
		return $output;
	}
	
	/**
	 *
	 * Delete abr templates
	 * @param: $user_name-> Name of template creator
	 *
	 * */
	private function delete_abr_templates($user_name){
		$delete_user_abr_template_array	=	array(
				'Table'=> 'adaptivetemplates',
				'clause'=> 'AdaptiveTemplateCreatedBy = "'.$user_name.'"'
		);
		$delete_user_abr_template_array_result	=	$this->pulsar_api_db_handle->Delete($delete_user_abr_template_array);
	}
	
	/**
	 * Delete general templates
	 * @param: $user_id -> Id of template owner
	 * */
	private function delet_general_templates($user_id){
		$delete_user_general_template_array	=	array(
				'Table'=> 'templates',
				'clause'=> 'UserId = "'.$user_id.'"'
		);
		$delete_user_general_template_array_result	=	$this->pulsar_api_db_handle->Delete($delete_user_general_template_array);
	}
	
	/**
	 * Delete pulsar user
	 * @param: $user_id -> Id of the user
	 *
	 * */
	private function delete_pulsar_user($user_id){
		$delete_user_array	=	array(
				'Table'=> 'user',
				'clause'=> 'id = "'.$user_id.'"'
		);
		$delete_user_array_result	=	$this->pulsar_api_db_handle->Delete($delete_user_array);
	}
	
	/**
	 * Delete user jobs
	 * @param : $customer_name -> Jobs owner name
	 *
	 * */
	private function delete_user_jobs($customer_name){
		$output		=	array("status" => false);
		$output		=	$this->CheckSoapServerForControllerRequests();
		if($output['status'] === true){
			$jobs_read_array	=	array(
					'Fields'=> 'JobId',
					'Table'=> 'jobs_info',
					'clause'=> 'UserID = "'.$customer_name.'"',
			);
			$jobs_read_array_result	=	$this->pulsar_api_db_handle->Read($jobs_read_array);
			for($i=0; $i<count($jobs_read_array_result); $i++){
				$params		=	array(
						"DeleteJobReq"	=>	array(
								"return"=>	array(
										"strJobID"	=>	$jobs_read_array_result[$i]['JobId'],
										"bOwnJob"	=>	0,
										"bAllJob"	=>	0,
										"bDeleteUserReport" => 1
								)
						)
				);
	
				$response = _pulsar_common::getSoapHandle()->DeleteJob($params);
				$output['status']	=	true;
			}
		}
		return $output;
	}
	
	/**
	 * Remove file system info of given user id
	 *
	 * */
	private function delete_user_favorite_file_system($user_id){
		$delete_user_file_system_info_array	=	array(
				'Table'=> 'filesysteminfo',
				'clause'=> 'uid = "'.$user_id.'"'
		);
		$delete_user_file_system_info_array_result	=	$this->pulsar_api_db_handle->Delete($delete_user_file_system_info_array);
	}
	
	/**
	 * Remove favorite file system info of given user id
	 *
	 * */
	private function delete_user_file_system_info($user_id){
		$delete_user_favorite_file_system_info_array	=	array(
				'Table'=> 'favouritefilesystems',
				'clause'=> 'uid = "'.$user_id.'"'
		);
		$delete_user_favorite_file_system_info_array_result	=	$this->pulsar_api_db_handle->Delete($delete_user_favorite_file_system_info_array);
	}
	
	/**
	 * Reutrn admin's credential and cloud portal url array
	 * 
	 * */
	private function get_default_cloud_portal_url_and_credentials_of_s3_bucket(){
		$query_to_get_cloud_portal_url_and_credentials_of_s3_bucket			=	"SELECT LicenseServerUrl,CloudStorageUserName,CloudStoragePassword FROM user WHERE id = 1";
		$query_to_get_cloud_portal_url_and_credentials_of_s3_bucket_result	=	$this->pulsar_api_db_handle->Query($query_to_get_cloud_portal_url_and_credentials_of_s3_bucket, "ASSOC");
		return $query_to_get_cloud_portal_url_and_credentials_of_s3_bucket_result[0];
		
	}
	
	/**
	 * Validate that given token is valid or not
	 *  
	 * */
	private function validate_token_and_return_outputArray($data){
		$output	=	array(
				'status'	=>	false
		);
		$verify_user_token_output	=	access_token_validate($data, array('access_token_db_handle'	=>	$this->pulsar_api_db_handle));
		if($verify_user_token_output['status']	===	true){
			if($token !== false){
				$output['status']	=	true;
			}
		}
		else{ //error from sso in verifying the user, so return the same
			$output	=	$verify_user_token_output;
		}
		return $output;
	}
	
	/**
	 * Return login token for pulsar
	 * @param: $data -> That holds an array of api cradentials (Venera's token and id) and customer_id
	 * 
	 * */
	public function pulsar_api_login_token($data){
		$output	=	array('status'	=>	false);
		$output	=	access_token_get($data, array('access_token_db_handle'	=>	$this->pulsar_api_db_handle));
		return $output;
	}
	
	/**
	 * Return template id by customer id and template name
	 * @return: assoc array that will hold status true and  or false.
	 * 			if status true then array will hold template_id
	 * 			and if status false then another array named data that will hold code: 400 with message "Template not found"  
	 * */
	private function get_template_id_with_given_customer_id_and_template_name($data){
		$output	=	array(
				'status'	=>	false
		);
		
		$template_type		=	$data['template_type'];
		$template_name		=	$data['template_name'];
		$customer_id		=	$data['customer_id'];
		switch ($template_type){
			case 2 :	//adaptive 
					$customer_id			=	$this->get_user_name_by_customer_id($customer_id);
			break;
		}
		
		$template_schema	=	_common::template_schema($template_type);
		$read_input	=	array(
			'Table'	=>	$template_schema['TABLE'],
			'Fields'=>	$template_schema['ID'],	
			'clause'=>	$template_schema['NAME']." = '".$template_name."' AND ".$template_schema['USER']." = '".$customer_id."'"		
		);

		$query_to_get_template_id_result	=	$this->pulsar_api_db_handle->Read($read_input, "ASSOC");
		
		$fetched_template_id	=	$query_to_get_template_id_result[0][$template_schema['ID']];
		if($fetched_template_id != 0 && !empty($fetched_template_id)){
			$output['status']		=	true;
			$output['template_id']	=	$fetched_template_id;
		}
		else{
			$output['status']				=	false;
			$output['data']					=	array("code" => 400, "message" => "Template not found.");
			$output['error_description']	=	"Template not found";
		}
		return	$output;
	}
 
	/**
	 * Start user session for pulsar login
	 * @return: An assoc array that will hold status true and headers of pulsar instance url
	 * 
	 * */
	private function start_user_session($data){
		session_manager_close();
		$session_set_data['userID']				= 	$data['username'];
		$session_set_data['id']					= 	$data['id'];
		$session_set_data['type']				= 	$data['type'];
		$session_set_data['StartUpPage']		= 	$data['StartUpPage'];
		$session_set_data['Access_Templates']	= 	$data['Access_Templates'];
		$session_set_data['Access_HotFolders'] 	= 	$data['Access_HotFolders'];
		$session_set_data['Access_JobMonitor'] 	= 	$data['Access_JobMonitor'];
		$session_set_data['Access_PostJob']		= 	$data['Access_PostJob'];
		$session_set_data['Access_Settings']	= 	$data['Access_Settings'];
		$session_set_data['AdminControls'] 		= false;
		
		if($data['Access_Templates'] == -1 && $data['Access_HotFolders'] == -1 && $data['Access_JobMonitor'] == -1 && $data['Access_PostJob'] == -1 && $data['Access_Settings'] == -1) {
			$session_set_data['AdminControls'] = true;
		}
		
		session_manager_set($session_set_data);

		$visited	=	$data['totalVisited'] + 1;
		session_write_close();
		$query_to_udate_last_login 			= 	"UPDATE user SET lastLogin=now(), totalVisited='".$visited."' WHERE id=".$data['id'];
		$query_to_udate_last_login_result	=	$this->pulsar_api_db_handle->Query($query_to_udate_last_login, "ASSOC");
		$output['status']	=	true;
		$output['headers']	=	array("Location: ".getHttpRoot);
		return $output;
	}
	
	/**
	 * Return user name by customer id
	 * @return: username
	 * */
	private function get_user_name_by_customer_id($customer_id){
		$query_to_get_user_name			=	"SELECT username FROM user WHERE id = '".$customer_id."'";
		$query_to_get_user_name_result	=	$this->pulsar_api_db_handle->Query($query_to_get_user_name, "ASSOC");
		return $query_to_get_user_name_result[0]['username'];
	}
	
	/**
	 * Check user existance for user sync api
	 * @return: boolean
	 * 
	 * */
	private function check_user_existance_in_pulsar($user_name){
		$output	=	array('status'	=>	false);
		$query_to_check_user		=	"SELECT * FROM user WHERE username	=	'".$user_name."'";
		$query_to_check_user_result	=	$this->pulsar_api_db_handle->Query($query_to_check_user, "ASSOC");
		if(!is_array($query_to_check_user_result)){
			$output	=	array('status'	=>	true);
		}
		return $output;
	}
	
	/**
	 * Set report path api
	 * @param: $data-> That must be an assoc array of key report_path and customer_id
	 * @return: boolean
	 * 
	 * */
	public function pulsar_api_setreportpath($data){
		$output	=	$this->validate_token_and_return_outputArray($data);
		if($output['status'] === true){ // if token correct
			$query_to_set_report_path			=	"UPDATE user SET CloudStoragePath = '".$data['report_path']."' WHERE id ='".$data['customer_id']."'";
			$query_to_set_report_path_result	=	$this->pulsar_api_db_handle->Query($query_to_set_report_path, "ASSOC");
			if(!$query_to_set_report_path_result) {
				$output['status']				=	false;
				//$output['error']				=	'pulsar_api_message2';
				$output['error_description']	=	'No user found with the user id :'.$data['customer_id'];
			}
			else{
				$output['status']		=	true;
				$output['return_code']	=	0;
			}
		}
		return $output;
	}
	
	/**
	 * Pulsar POST job 
	 * @param: An assoc array that will hold file_path, user_note, user_password, user_password, customer_id, job_id, template_type
	 * @return: An assoc array that key will be status and data(an assoc array)
	 * 			if status true then array data will hold code: 200, jobid, message: "Job posted successfully"
	 * 			if status false then array data will hold code: 400, message: "Job submission failed"
	 * 
	 * */
	public function pulsar_api_postjob($data){
 		$output			=	array('status'	=>	false);
		$validate_token	=	$this->validate_token_and_return_outputArray($data);
 		$user_note		=	"";
 		$user_name		=	"";
 		$user_password	=	"";
 			
		if($validate_token['status'] === true){
			$template_id	=	$this ->get_template_id_with_given_customer_id_and_template_name($data);
			if($template_id['status'] !== false){
				if(isset($data['user_note'])){
					$user_note	=	$data['user_note'];
				}
					
				if(isset($data['user_name'])){
					$user_name	=	$data['user_name'];
				}
					
				if(isset($data['user_password'])){
					$user_password	=	$data['user_password'];
				}
				
				$soapMethod	=	false;	
				if($data['template_type']	==	1){// General
					$params = array (
						"PostJobReq" => array (
							"return" => array (
								"sJobInfo" => array (
											"strFilePath" 	 			=> 		(string) $data ['file_path'], 		  /* Authenticated url of file */
											"eContainerType"			=>		(int) 0,
											"eVideoCodecType"			=>		(int) 0,
											"eAudioCodecType"			=>		(int) 0,
											"strUserID"		 			=> 		(string) $this->get_user_name_by_customer_id($data['customer_id']),		  /* user id */
											"strUserNote"				=>		(string) $user_note,
											"nTemplateID"	 			=> 		(int) $template_id['template_id'], /* template id feteched from template name and template type */
											"eJobType"					=>		(int) $data['job_type'],
											"strBandwidthInPlaylist"	=>		(string) NULL,
											"un64XMLFolderID"			=>		(int) 0,
											"strABRInfo"				=>		(string) NULL,
											"strUserName"				=> 		(string) $user_name,
											"strPassword" 				=> 		(string) $user_password
											
								) 
							) 
						)
					);
					
					$soapMethod	=	'PostJob';
				}
				else if($data['template_type'] == 2){//ABR
					$StreamingContentType	=	1;//Currently send 1 in pulsar application also 
					$eStreamingContentTpe	=	0;
					$file_path				=	$data ['file_path'];
					$strUserID				=	$this->get_user_name_by_customer_id($data['customer_id']);
					$strUserNote			=	(string) $user_note;
					
					$sub_file_info							=	array();
						
					/*Creating array for file post.*/
					$sub_file_info['strFilePath']			=	$file_path;
					$sub_file_info['eContainerType']		=	0;
					$sub_file_info['eVideoCodecType']		=	0;
					$sub_file_info['eAudioCodecType']		=	0;
					$sub_file_info['strUserID']				=	$strUserID;
					$sub_file_info['strUserNote']			=	$strUserNote;
					$sub_file_info['nTemplateID']			=	$template_id['template_id'];
					$sub_file_info['eJobType']				=	$data['job_type'];
					$sub_file_info['strBandwidthInPlaylist']=	"";
					$sub_file_info['un64XMLFolderID']		=	0;
					$sub_file_info['strABRInfo']			=	"";
					$sub_file_info['strUserName']			=	$user_name;
					$sub_file_info['strPassword']			=	$user_password;
				
					
					$params = array(
						"PostJobReq" => array (
							"return" => array (
								"sJobInfo" => array (
										"strFilePath" 			=> 		$file_path,
										"strUserID"	  			=> 		$strUserID, 
										"eStreamingContentTpe"	=>		$StreamingContentType,
										"strUserNote"			=>		$user_note,
										"vecJobInfo"			=>		$sub_file_info,
										/* "un64XMLFolderID"		=>		"", */
										"strUserName"			=> 		$user_name,
										"strPassword" 			=> 		$user_password
								) 
							) 
						) 
					);
					
					$soapMethod	=	'StreamingContentPostJob';
				}
				
				if($soapMethod !== false){
					$controllerRunning		=	$this->CheckSoapServerForControllerRequests();
					if($controllerRunning['status'] === true){
						$response = _pulsar_common::getSoapHandle()->$soapMethod($params);
						
						if($response->return->eRetCode	==	0){
							$output['status']	=	true;
							$output['data']		=	array(
								"code" 		=>	200, 
								"jobid" 	=>	$response->return->strResponseData,
								"message"	=>	"Job posted successfully"
							);
						}
						else{
							$output['data']		=	array(
								"code" 		=>	400,
								"message"	=>	"Job submission failed"
							);
							$output['error_description']	=	"Controller error returns : ".$response->return->eRetCode;
						}
					}
					else{
						$output	=	$controllerRunning;
					}
				}
			}
		}
		return $output;
	}
	
	
	/**
	 * Pulsar cancel job
	 * @param:  An array tht holds api cradentials (Venera's token and id), jobid_id_list and customer_id
	 * @return: An assoc array that hold status as boolean and data array that hold code: 200 or 503 and message
	 * 
	 * */
	public function pulsar_api_canceljob($data){
		$output	=	$this->validate_token_and_return_outputArray($data);
		if($output['status'] === true){ // if token correct
			$jobs_id_string		=	$data['job_id_list'];
			$customer_id		=	$this->get_user_name_by_customer_id($data['customer_id']);
			$query_to_get_only_user_job_ids			=	"SELECT JobId, UserID FROM jobs_info where JobId IN (".$jobs_id_string.")";
			$query_to_get_only_user_job_ids_result	=	$this->pulsar_api_db_handle->Query($query_to_get_only_user_job_ids, "ASSOC");

			$cancel_job_status_array	=	array("status" => false);
			$cancel_job_status_array_return	=	array();
			for($i=0; $i<count($query_to_get_only_user_job_ids_result); $i++){
				$cancel_job_id_with_status_array	=	array();
				if($query_to_get_only_user_job_ids_result[$i]['UserID'] == $customer_id){
					$params 	= array(
									"CancelJobReq" => array (
										"return" => array (
											"strJobID" => $query_to_get_only_user_job_ids_result[$i]['JobId'],
											"bAllJob"  => 0
										)
									)
								);
					
					$controllerRunning		=	$this->CheckSoapServerForControllerRequests();
					if($controllerRunning['status'] === true){
						$response = _pulsar_common::getSoapHandle()->CancelJob($params);
						if($response->return->eRetCode	==	0){
							$cancel_job_status_array['status']	=	true;
							$cancel_job_id_with_status_array[$query_to_get_only_user_job_ids_result [$i]['JobId']]	=	array("code" => 200, "message" => "Job cancelled successfully.");
							$cancel_job_status_array[]	=	$cancel_job_id_with_status_array;
						}
						else{
							$cancel_job_id_with_status_array[$query_to_get_only_user_job_ids_result [$i]['JobId']]	=	array("code" => 503, "message" => "Service temporarily unavailable.");
							$cancel_job_status_array[]	=	$cancel_job_id_with_status_array;
						}
					}
				}
				else{
					$cancel_job_id_with_status_array[$query_to_get_only_user_job_ids_result [$i]['JobId']]	=	array("code" => 404, "message" => "Job id not found.");
					$cancel_job_status_array[]	=	$cancel_job_id_with_status_array;
				}
				$cancel_job_status_array_return['data']		=	$cancel_job_id_with_status_array;
			}
		}
		return $cancel_job_status_array;
	}
	
	/**
	 *  Pulsar job status 
	 *  @param:  An array tht holds api cradentials (Venera's token and id), jobid_id_list and customer_id
	 * 	@return: An assoc array that hold status as boolean and data array that hold code: 200 or 404 and message or data array that will hold jobid, jobstatus
	 * 
	 *  */
	public function pulsar_api_getjobstatus($data){
		$output	=	$this->validate_token_and_return_outputArray($data);
		if($output['status'] === true){
			$job_id_list_string					=	$data['job_id_list'];	
			$query_to_get_Job_status			=	"SELECT PercentageCompleted,Status,JobId,UserID FROM jobs_info WHERE JobId IN (".$job_id_list_string.")";
			$query_to_get_Job_status_result		=	$this->pulsar_api_db_handle->Query($query_to_get_Job_status, "ASSOC");
			
			if(!is_array($query_to_get_Job_status_result)) {
				$output['status']				=	false;
				$output['data']					=	array("code" => 520, "message" => "Unknown failure. Please try again");
				$output['error_description']	=	'Faild to get job status, Query output failed. Query is :'.$query_to_get_Job_status.'. Given ids are: '.job_id_list;
			}
			else{
				$output	=	array("status" => false, "data" => array());
				$customer_name	=	$this->get_user_name_by_customer_id($data['customer_id']);
				$given_id_array	=	explode(",", $job_id_list_string);
				for($i=0; $i<count($given_id_array); $i++){
					$job_id		=	$query_to_get_Job_status_result[$i]['JobId'];
					$user_id	=	$query_to_get_Job_status_result[$i]['UserID'];
					$each_job_deatils	=	array();
					if(in_array($job_id, $given_id_array) && ($user_id == $customer_name)){
						$output['status']	=	true;
						$each_job_deatils['jobid']			=	$job_id;
						$each_job_deatils['jobstatus']		=	$query_to_get_Job_status_result[$i]['PercentageCompleted'];
						$output['data'][]		=	array($job_id => array("code" => 200, "message"=>  $query_to_get_Job_status_result[$i]['Status'],"jobstatus" => $query_to_get_Job_status_result[$i]['PercentageCompleted']));
					}
					else{
						$output['data'][]		=	array($given_id_array[$i] =>array( "code" => 404, "message" => "Job id not found."));
					}
				}
			}
		}
		return $output;
	}
	
	/**
	 * Pulsar job details 
	 * 
	 * */
	public function pulsar_api_getjobdetails($data){
		$output	=	$this->validate_token_and_return_outputArray($data);
		if($output['status'] === true){
			
			$start_time		=	$data['start_time'];
			$end_date		=	$data['end_time:'];
			$template_name	=	$data['template_name'];

			$query_to_get_job_details	=	"SELECT JobId, Status, JobStartTime, JobEndTime FROM jobs_info LEFT JOIN user on jobs_info.UserID = user.username WHERE JobId IN (".$data['job_id_list'].") AND user.id = ".$data['customer_id'];
				
			if(isset($data['job_status'])){
				switch($data['job_status']){
					case "Completed without error/warning":
						$query_to_get_job_details			.=	" AND RuleId=0 AND Status='COMPLETED' AND NoOfError=0 AND NoOfWarning=0 ";
						break;
					case "Completed with error & warnings":
						$query_to_get_job_details			.=	" AND RuleId=0 AND Status='COMPLETED' AND NoOfError!=0 AND NoOfWarning!=0 ";
						break;
					case "Completed with warnings only":
						$query_to_get_job_details			.=	" AND RuleId=0 AND Status='COMPLETED' AND NoOfWarning!=0 AND NoOfError=0 ";
						break;
					case "Completed with errors only":
						$query_to_get_job_details			.=	" AND RuleId=0 AND Status='COMPLETED' AND NoOfError!=0 AND NoOfWarning=0 ";
						break;
					case "Aborted by application":
						$query_to_get_job_details			.=	" AND RuleId=0 AND (Status='VRE CONNECTION LOSS' OR  Status='FAILED' OR  Status='PARTIAL FAILED' OR  Status='INSUFFICIENT USER CREDIT') ";
						break;
					case "Aborted by user":
						$query_to_get_job_details			.=	" AND RuleId=0 AND Status='ABORTED' ";
						break;
				}
			}	
			
			if(isset($data['start_time'])){
				$query_to_get_job_details	.=	" AND Date(JobStartTime) >= '".$data['start_time']."'";
			}
			
			if(isset($data['end_time'])){
				$query_to_get_job_details	.=	" AND Date(JobStartTime) <= '".$data['end_time']."'";
			}

			if(isset($data['template_name'])){
				$query_to_get_job_details	.=	"";
			}
				
			$query_to_get_job_details_result	=	$this->pulsar_api_db_handle->Query($query_to_get_job_details, "ASSOC");
			
			if($query_to_get_job_details_result === false) {
				$output['status']				=	false;
				$output['data']					=	array("code" => 520, "message" => "Unknown failure. Please try again");
				$output['error_description']	=	'Faild to get job details, Query output failed. Query is :'.$query_to_get_Job_status.'. Given ids are: '.$data['job_id_list'];
			}
			elseif($query_to_get_job_details_result === 0){
				$output['status']				=	true;
				$output['data']					=	array('No jobs found with this criteria/filters');
			}
			else{
				$output	=	array();
				for($i=0; $i<count($query_to_get_job_details_result); $i++){
					$each_job_deatils	=	array();
					$each_job_deatils['jobid']			=	$query_to_get_job_details_result[$i]['JobId'];
					$each_job_deatils['jobstatus']		=	$query_to_get_job_details_result[$i]['Status'];
					$each_job_deatils['startdatetime']	=	$query_to_get_job_details_result[$i]['JobStartTime'];
					$each_job_deatils['enddatetime']	=	$query_to_get_job_details_result[$i]['JobEndTime'];
					
					$jobs[]		=	$each_job_deatils;
				}
				
				$output['status']		=	true;
				$output['return_code']	=	0;
				$output['data']			=	$jobs;
			}	
				
		}
		return $output;
	}	
	
	/**
	 * Pulsar user login
	 * 
	 * */
	public function pulsar_api_user_login($data){
		$output	=	array(
				'status'	=>	false
		);
		$output	=	$this->validate_token_and_return_outputArray($data);
		if($output['status'] === true){
			$query_to_get_user_preferences  		= 	'SELECT * from user WHERE id = "'.$data['user_id'].'"';
			$query_to_get_user_preferences_result	=	$this->pulsar_api_db_handle->Query($query_to_get_user_preferences, "ASSOC");
			$output		=	$this->start_user_session($query_to_get_user_preferences_result[0]);
		}
		
		access_token_delete(array('access_token'	=>	$data['access_token']), array('access_token_db_handle'	=>	$this->pulsar_api_db_handle));
		
		return $output;
	}
	
	/**
	 * Pulsar add user info into pulsar db
	 * 
	 * */
	public function pulsar_api_add_user_info_into_pulsar_db($data){
		$output	=	array("status" => false);
		$validate_token	=	$this->validate_token_and_return_outputArray($data);
		if($validate_token['status'] === true){
			$user_existance	=	$this->check_user_existance_in_pulsar($data['username']);
			if($user_existance['status'] === true){
				$data['type']	=	"user";//For now set by default user
				$default_cloud_portal	=	$this->get_default_cloud_portal_url_and_credentials_of_s3_bucket();
				$query_to_add_user_user_info_into_pulsar_db  	= 	"INSERT INTO user SET id = '".$data['id']."', type = '".$data['type']."', username = '".$data['username']."', emailId = '".$data['username']."', CloudStoragePath = '".$data['s3bucketurl']."', Access_Templates = 4, Access_PostJob = 1, LicenseServerUrl = '".$default_cloud_portal['LicenseServerUrl']."', CloudStorageUserName = '".$default_cloud_portal['CloudStorageUserName']."', CloudStoragePassword = '".$default_cloud_portal['CloudStoragePassword']."'";
				$query_to_get_user_preferences_result_result	=	$this->pulsar_api_db_handle->Query($query_to_add_user_user_info_into_pulsar_db, "ASSOC");
				if($query_to_get_user_preferences_result_result != false){
					$output['status'] = true;
					$try	=	0;
					$template_class	=	new _pulsar_templates(get_PulsarConfig());
					$result		=	$template_class->copy_factory_templates($this->copy_template_array[0]['template_id'], $this->copy_template_array[0]['template_name'], $data['id']);
						
					if($result['status']	!== true && $try < 3){
						$result		=	$template_class->copy_factory_templates($this->copy_template_array[0]['template_id'], $this->copy_template_array[0]['template_name'], $data['id']);
						$try++;
					}
				}
				else{
					$output['error']	=	'Failed to add user';
					$output['error_description']	=	__LINE__.' line no. in file: '.__FILE__.' . function name: '.__FUNCTION__.' Failure in Query: :'.$query_to_add_user_user_info_into_pulsar_db ;
				}
			}
			else{
				$output['status']	= 	false;
				$output['data'] 	= 	array("code" => 400, "message" => "User already exist.");
			}
		}
		return $output;
	}
	
	/**
	 * Pulsar send usage info to portal
	 * 
	 * */
	public function pulsar_api_send_usage_info_to_portal($data, $api_count = 1){
		$query_string	=	$_SERVER['QUERY_STRING'];
		$query_to_get_portal_url			=	"SELECT LicenseServerUrl FROM user WHERE id=1";
		$query_to_get_portal_url_result		=	$this->pulsar_api_db_handle->Query($query_to_get_portal_url, "ASSOC");
		$url	=	$query_to_get_portal_url_result[0]['LicenseServerUrl'].'?'.$query_string;
		$http_array	=	array(
				'http' => array(
						'method'  => "GET"
				)
		);
		$result		=	sendExternalRequest($http_array, $url);
		if($result === false || $result['status'] == false){
			if($api_count <=3)	//retry if usage info update fails
				pulsar_api_send_usage_info_to_portal($data, $api_count+1);
			else{
				$output['error_description']	=	__LINE__.' line no. in file: '.__FILE__.' .Failure in updating usage info at portal. Request url:'.$url ;
			}
		}
		else{
			$output['status']	=	$result;
		}

		return $output;
	}
	
	/**
	 * Pulsar get xml report path
	 * 
	 * */
	public function pulsar_api_get_xml_report($data){
		$output	=	$this->validate_token_and_return_outputArray($data);
		if($output['status'] === true) {
			$query_to_get_job_data			=	"SELECT WebReportPath, UserID, JobId FROM jobs_info WHERE JobId IN (".$data['job_id_list'].")";
			$query_to_get_job_data_result	=	$this->pulsar_api_db_handle->Query($query_to_get_job_data, "ASSOC");
			
			if(!is_array($query_to_get_job_data_result) && $query_to_get_job_data_result != 0) {
				$output['status']				=	false;
				$output['data']					=	array("code" => 520, "message" => "Unknown failure. Please try again");
				$output['error_description']	=	'Faild to get xml report path, Query output failed. Query is :'.$query_to_get_job_data.'. Given ids are: '.$data['job_id_list'];
			}
			else {
				$output		=	array("status" => false, "data" => array());
				$customer_name		=	$this->get_user_name_by_customer_id($data['customer_id']);
				$given_id_array	=	explode(",", $data['job_id_list']);
				for($i=0; $i<count($given_id_array); $i++){
					$job_id		=	$query_to_get_job_data_result[$i]['JobId'];
					$user_id	=	$query_to_get_job_data_result[$i]['UserID'];
					$each_job_deatils	=	array();
					if(in_array($job_id, $given_id_array) && ($user_id == $customer_name)){
						$output['status']	=	true;
						$report_name		=	"";
						if($query_to_get_job_data_result[$i]['WebReportPath'] != ""){
							$report_name		=	$query_to_get_job_data_result[$i]['WebReportPath'].".zip";
						}
						$output['data'][]		=	array($job_id => array("code" => 200, "report_folder" => $report_name));
					}
					else{
						$output['data'][]		=	array($given_id_array[$i] =>array( "code" => 404, "message" => "Job id not found."));
					}
				
				}
			}
		}
		
		return $output;
	}

	/**
	 * Remove user and his data from pulsar
	 * 
	 * */
	public function pulsar_api_delete_user($data){
		$output	=	$this->validate_token_and_return_outputArray($data);
		$user_id	=	$data['customer_id'];
		$user_name	=	$this->get_user_name_by_customer_id($user_id);
		if(!empty($user_name)){
			$this->delete_abr_templates($user_name);
			$this->delet_general_templates($user_id);
			$this->delete_user_file_system_info($user_id);
			$this->delete_user_favorite_file_system($user_id);
			$this->delete_pulsar_user($user_id);
			$output	=	$this->delete_user_jobs($user_name);
			
			$output['data']['code']	=	200;
		}
		else{
			$output['status']			=	false;
			$output['data']['code']		=	404;
			$output['error_description']=	"User does not exist";	
		}
		return $output;
	}
	
};

?>
