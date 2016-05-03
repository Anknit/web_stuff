<?php
    require_once __DIR__.'/php/dependencyScripts.php';
    if(isset($_SESSION['login']) && $_SESSION['login']){
        require_once __DIR__.'/php/header.php';
        require_once __DIR__.'/php/body.php';
        require_once __DIR__.'/php/footer.php';
    }
    else{
        header('Location: ./login.php');
        exit();
    }
?>