<?php
    if(isset($_SESSION['login']) && $_SESSION['login']){
        header('Location:./index.php');
        exit();
    }
?>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="html" lang="en" name="Venera-Snacks">
        <title>Venera Snacks</title>
        <link type="text/css" rel="stylesheet" href="./../../Common/css/bootstrap/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="./css/style.css" />
    </head>
    <body class="login-body">
        <div class="transparent-background text-center text-primary" style="font-size:48px;"><strong>Venera Snacks</strong></div>
        <div class="col-md-4 col-md-offset-4 box-shadow transparent-background" style="margin-top:50px;">
            <form class="form" method="post" action="validateUser.php">
                <div class="form-group">
                    <label for="loginid" class="control-label">Login-id</label>
                    <input type="text" name="login" class="form-control" placeholder="Enter login id" />
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" />
                </div>
                <button type="submit" class="btn btn-success" >Login</button>
            </form>
        </div>
    </body>
</html>