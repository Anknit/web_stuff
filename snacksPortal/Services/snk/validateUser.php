<?php
require_once __DIR__.'/php/dependencyScripts.php';
    $output =   false;
    if(isset($_POST['login']) && isset($_POST['password'])){
        $userExist  =   array();
        $userExist  =   DB_Read(
            array(
                'Table'=>'userinfo',
                'Fields'=>'userid,email,password,usertype',
                'clause'=>'loginid = "'.$_POST['login'].'"'
            ),'ASSOC','');
        if(count($userExist) == 1){
            if($userExist[0]['password'] == md5($_POST['password'])){
                $output = true;
                $_SESSION['login']  =   true;
                $_SESSION['userid']     =   $userExist[0]['userid'];
                $_SESSION['email']      =   $userExist[0]['email'];
                $_SESSION['usertype']   =   $userExist[0]['usertype'];
            }
            else{
                $output = false;
                $error_code =   1;
            }
        }
        else{
            $output = false;
            $error_code =   2;
        }
    }
    else{
        $output = false;
        $error_code =   3;
    }
    if($output){
        header('Location:./');
        exit();
    }
    else{
        header('Location:./login.php?do='.$error_code);
        exit();
    }
?>