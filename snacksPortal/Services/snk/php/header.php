<?php
?>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="html" lang="en" name="Venera Snacks">
        <title>Venera Snacks</title>
        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="./css/style.css" />
    </head>
    <body data-ng-app="snacksapp">
        <header>
            <nav class='navbar navbar-default'>
                <div class='container-fluid'>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#/">Venera Snacks</a>
                    </div>
                    <div class="collapse navbar-collapse" id="menu-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-left">
                            <li id="today-option-menu-item"><a href="#/">What you want today</a></li>
                            <li id="next-day-option-menu-item"><a href="#/next-day">Choose what next</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown" id="user-setting-menu-item">
                                <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['email'];?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#/change-pswd">Change Password</a></li>
                                    <?php 
                                        if($_SESSION['usertype'] == USER_ADMIN){
                                    ?>
                                    <li><a href='./manageOrders.php'>Manage Orders as Admin</a></li>
                                    <li><a href='./manageFeedbacks.php'>Manage Feedbacks</a></li>
                                    <?php 
                                        }
                                    ?>
                                    <li><a href="./logout.php" >Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
