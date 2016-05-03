<?php
    function mapRequestAction(){
        $mapRequestOutput   =   array();
        switch($_REQUEST['action']){
            case SUBMIT_OPTION:
                $mapRequestOutput   =   processDataRequest('submit_option_selection',$_REQUEST['data']);
                break;
            case PRESENT_OPTION_STATUS:
                $mapRequestOutput   =   processDataRequest('get_present_options','');
                break;
            case NEXT_DAY_OPTIONS:
                $mapRequestOutput   =   processDataRequest('get_next_day_options','');
                break;
            case SUBMIT_NEXT_DAY_OPTION:
                $mapRequestOutput   =   processDataRequest('submit_next_day_option',$_REQUEST['data']);
                break;
            case CHANGE_PASSWORD:
                $mapRequestOutput   =   processDataRequest('change_pswd',$_REQUEST['data']);
                break;
            case ORDER_STATUS:
                $mapRequestOutput   =   processDataRequest('get_order_status','');
                break;
            case RESET_ORDER_STATUS:
                $mapRequestOutput   =   processDataRequest('reset_order_status','');
                break;
            case BUILD_SNACKS_ORDER:
                $mapRequestOutput   =   processDataRequest('build_snacks_order','');
                break;
            case SUBMIT_FEEDBACK:
                $mapRequestOutput   =   processDataRequest('submit_user_feedback',$_REQUEST['data']);
                break;
            case FEEDBACK_DATA:
                $mapRequestOutput   =   processDataRequest('get_feedback_data','');
                break;
            default:
                break;
        }
        return $mapRequestOutput;
    }
?>