<?php
    class requestProcessor {
        private $calledMethod;
        public function __construct($requestName) {
            $this->calledMethod =   $requestName;
        }
        public function __destruct() {
            $this->calledMethod =   '';
        }
        public function callAppMethod ($requestVars){
            $methodResponse  =   call_user_func($this->calledMethod,$requestVars);
            return $methodResponse;
        }
    }
    function processDataRequest($requestName,$requestVars){
        $processObject  =   new requestProcessor($requestName);
        $processOutput  =   $processObject->callAppMethod($requestVars);
        return $processOutput;
    }
    function submit_option_selection($requestVars){
        $db_response    =   array();
        $alreadySubmitOption    =   false;
        $fieldToIncrement   =   (int)$requestVars['optionId'];
        
        $previousResponse   =   DB_Read(array('Table'=>'userinfo','Fields'=>'presentvotestatus,presentvoteoption','clause'=>'userid = '.$_SESSION['userid']),'ASSOC','');
        if($previousResponse[0]['presentvotestatus'] == 1){
            $alreadySubmitOption    =   $previousResponse[0]['presentvoteoption'];
        }
        if($alreadySubmitOption){
            DB_Query('Update presentoption set presentoptionvotecount = presentoptionvotecount-1 where presentoptionid = '.$alreadySubmitOption);
        }
        $db_response    =   DB_Query('Update userinfo set presentvotestatus = 1,presentvoteoption = '.$fieldToIncrement.' where userid = '.$_SESSION['userid']);
        $db_response    =   DB_Query('Update presentoption set presentoptionvotecount = presentoptionvotecount+1 where presentoptionid = '.$fieldToIncrement);
        $db_response    =   DB_Query('Select ui.presentvotestatus,ui.presentvoteoption,po.*,olt.* from userinfo as ui,presentoption as po left join optionlisttable as olt on po.optionlisttableid = olt.optionid where ui.userid = '.$_SESSION['userid'],'ASSOC','','presentoptionid');
        return $db_response;
    }
    function get_present_options($requestVars){
        $db_response    =   array();
        $orderStatus    =   DB_Query('Select * from orderstatus left join optionlisttable on orderstatus.orderoptionid = optionlisttable.optionid order by orderstatus.orderid desc limit 0,1','ASSOC','');
        $db_response    =   DB_Query('Select ui.presentvotestatus,ui.presentvoteoption,po.*,olt.* from userinfo as ui,presentoption as po left join optionlisttable as olt on po.optionlisttableid = olt.optionid where ui.userid = '.$_SESSION['userid'],'ASSOC','','presentoptionid');
        return array('orderstatus'=>$orderStatus[0],'optiondata'=>$db_response);
    }
    function get_next_day_options($requestVars){
        $db_response    =   array();
        $db_response    =   DB_Query('Select ui.nextvotestatus,ui.nextvoteoption,olt.* from userinfo as ui,optionlisttable as olt where ui.userid ='.$_SESSION['userid'].' order by olt.optionVoteCount desc','ASSOC','');
        return $db_response;
    }
    function submit_next_day_option($requestVars){
        $db_response    =   array();
        $alreadySubmitOption    =   false;
        $fieldToIncrement   =   (int)$requestVars['optionId'];

        $previousResponse   =   DB_Read(array('Table'=>'userinfo','Fields'=>'nextvotestatus,nextvoteoption','clause'=>'userid = '.$_SESSION['userid']),'ASSOC','');
        if($previousResponse[0]['nextvotestatus'] == 1){
            $alreadySubmitOption    =   $previousResponse[0]['nextvoteoption'];
        }
        if($alreadySubmitOption){
            DB_Query('Update optionlisttable set optionVoteCount = optionVoteCount-1 where optionid = '.$alreadySubmitOption);
        }
        $db_response    =   DB_Query('Update userinfo set nextvotestatus = 1,nextvoteoption = '.$fieldToIncrement.' where userid = '.$_SESSION['userid']);
        $db_response    =   DB_Query('Update optionlisttable set optionVoteCount = optionVoteCount+1 where optionid = '.$fieldToIncrement);
        $db_response    =   DB_Query('Select ui.nextvotestatus,ui.nextvoteoption,olt.* from userinfo as ui,optionlisttable as olt where ui.userid ='.$_SESSION['userid'].' order by olt.optionVoteCount desc','ASSOC','');
        return $db_response;
    }
    function change_pswd($requestVars){
        $db_response    =   array();
        $db_response    =   DB_Read(
            array(
                'Table'=>'userinfo',
                'Fields'=>'password',
                'clause'=>'userid = '.$_SESSION['userid']
            ),'ASSOC','');
        if($db_response[0]['password'] == md5($requestVars['currentPswd'])){
            $db_response    =   DB_Update(array('Table'=>'userinfo','Fields'=>array('password'=>md5($requestVars['newPswd'])),'clause'=>'userid = '.$_SESSION['userid']));
            if(!$db_response){
                $db_response =   102; // password update failed
            }
        }
        else{
            $db_response  =   101;   // passwords do not match
        }
        return $db_response;
    }
    function submit_user_feedback($requestVars){
        $db_response    =   array();
        if(isset($_SESSION['userid'])){
            $feedback_insert    =   DB_Insert(
                array(
                    'Table'=>'feedbacks',
                    'Fields'=>array(
                        'feedbacktext'=>$requestVars['feedbacktext'],
                        'feedbackuser'=>$_SESSION['email'],
                        'createdon'=>date("Y-m-d H:i:s"),
                        'feedbackstatus'=>NEW_FEEDBACK
                    )
                ));
            if($feedback_insert){
                $db_response['message'] =   'Feedback submittted successfully'; 
            }
            else{
                $db_response['message'] =   'Error in storing feedback'; 
            }
        }
        else{
            $db_response['message'] =   'You are not authorised for this operation'; 
        }
        return $db_response;
    }
    function get_feedback_data($requestVars){
        $db_response    =   array();
        $db_response    =   DB_Query('Select * from feedbacks order by createdon');
        return $db_response;
    }
    function get_order_status($requestVars){
        $db_response    =   array();
        $orderStatus    =   DB_Query('Select * from orderstatus left join optionlisttable on orderstatus.orderoptionid = optionlisttable.optionid order by orderstatus.orderid desc limit 0,1','ASSOC','');
        $presentOptionStatus    =   DB_Query('Select po.*,olt.* from presentoption as po left join optionlisttable as olt on po.optionlisttableid = olt.optionid','ASSOC','','presentoptionid');
        $nextDayOptionStatus    =   DB_Query('Select olt.* from optionlisttable as olt order by olt.optionVoteCount desc, olt.lastorderedon limit 0,2','ASSOC','');
        return array('orderstatus'=>$orderStatus[0],'presentoptiondata'=>$presentOptionStatus,'nextdayoptiondata'=>$nextDayOptionStatus);
    }
    function reset_order_status($requestVars){
        //order status new entry 
        $db_response    =   array();
        $db_response    =   DB_Insert(array('Table'=>'orderstatus','Fields'=>array('orderoptionid'=>'0','ordervotecount'=>'0','status'=>'2','orderDate'=>date("Y-m-d H:i:s"))));
        return $db_response;
    }
    function build_snacks_order($requestVars){
        $db_response    =   false;
        $errorCode  =   0;
        $getOrderStatusForValidation    =   DB_Read(
            array(
                'Table'=>'orderstatus',
                'Fields'=>'status,orderid',
                'order'=>'orderid desc limit 0,1'
            ),'ASSOC','');
        if($getOrderStatusForValidation[0]['status'] == 2){
            $getTopTwoOptionForPresentList  =   DB_Read(
                array(
                    'Table'=>'optionlisttable',
                    'Fields'=>'optionid',
                    'order'=>'optionVoteCount desc, lastorderedon limit 0,2'
                ),'ASSOC','');
            $getTopOptionFromPresentList    =   DB_Read(
                array(
                    'Table'=>'presentoption',
                    'Fields'=>'presentoptionvotecount,optionlisttableid',
                    'order'=>'presentoptionvotecount desc limit 0,1'
                ),'ASSOC','');
            $updateOrderStatus  =   false;
            $updateOrderStatus    =   DB_Update(
                array(
                    'Table'=>'orderstatus',
                    'Fields'=>array(
                        'orderoptionid'=>$getTopOptionFromPresentList[0]['optionlisttableid'],
                        'ordervotecount'=>$getTopOptionFromPresentList[0]['presentoptionvotecount'],
                        'status'=>'1'
                    ),
                    'clause'=>'orderid = '.$getOrderStatusForValidation[0]['orderid']
                ));
            if($updateOrderStatus){
                $updatePresentOption    =   false;
                $updatePresentOption    =   DB_Update(
                    array(
                        'Table'=>'presentoption',
                        'Fields'=>array(
                            'optionlisttableid'=>$getTopTwoOptionForPresentList[0]['optionid'],
                            'presentoptionvotecount'=>'0'
                        ),
                        'clause'=>'optionnumber = 1'
                    ));
                $updatePresentOption    =   DB_Update(
                    array(
                        'Table'=>'presentoption',
                        'Fields'=>array(
                            'optionlisttableid'=>$getTopTwoOptionForPresentList[1]['optionid'],
                            'presentoptionvotecount'=>'0'
                        ),
                        'clause'=>'optionnumber = 2'
                    ));
                if($updatePresentOption){
                    $updateAllOptionList    =   false;
                    $updateAllOptionList    =   DB_Update(
                        array(
                            'Table'=>'optionlisttable',
                            'Fields'=>array('optionVoteCount'=>'0')
                        ));
                    $updateAllOptionList    =   DB_Update(
                        array(
                            'Table'=>'optionlisttable',
                            'Fields'=>array(
                                'lastorderedon'=>time()
                            ),
                            'clause'=>'optionid ='.$getTopOptionFromPresentList[0]['optionlisttableid']
                        ));
                    if($updateAllOptionList){
                        $updateUsersVoteOption  =   DB_Update(array('Table'=>'userinfo','Fields'=>array('presentvotestatus'=>'0','presentvoteoption'=>'0','nextvotestatus'=>'0','nextvoteoption'=>'0')));
                        $db_response    =   true;
                    }
                    else{
                        $db_response    =   false;
                        $errorCode  =   1;
                    }
                }
                else{
                    $db_response    =   false;
                    $errorCode  =   2;
                }
            }
            else{
                $db_response    =   false;
                $errorCode  =   3;
            }
        }
        else{
            $db_response    =   false;
            $errorCode  =   4;
        }
        return array('response'=>$db_response,'code'=>$errorCode);
    }
?>