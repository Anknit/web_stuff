<?php 
    require_once 'dependencyScripts.php';
    $requestOutput  =   array('status' => false, 'data' => array());
    if(!isset($_REQUEST['action'])){
        echo json_encode($requestOutput);
        exit();
    }
    else{
        $requestOutput['status']  =   true;
        $requestOutput['data']  =   mapRequestAction();
        echo json_encode($requestOutput);
    }
?>