<?php
    require_once __DIR__.'/php/dependencyScripts.php';
    if(isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['usertype']) && $_SESSION['usertype'] == USER_ADMIN){
?>
    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta content="html" lang="en" name="Venera Snacks">
            <title>Venera Snacks Orders</title>
            <link type="text/css" rel="stylesheet" href="./../../Common/css/bootstrap/bootstrap.min.css" />
            <link type="text/css" rel="stylesheet" href="./css/style.css" />
        </head>
        <body data-ng-app="snacksOrderManage">
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
                            <a class="navbar-brand" href="./">Venera Snacks</a>
                        </div>
                        <div class="collapse navbar-collapse" id="menu-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-left">
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="container">
                <div class="col-md-12" data-ng-controller="orderManageController">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <caption>Currently Competitng Order Option Data</caption>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Option Name</th>
                                        <th>Option Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="option in presentOptionStatus">
                                        <td>{{option.optionnumber}}</td>
                                        <td>{{option.optionName}}</td>
                                        <td>{{option.presentoptionvotecount}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <caption>Top two options for next order</caption>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Option Name</th>
                                        <th>Option Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="option in nextDayOptionStatus">
                                        <td>{{$index + 1}}</td>
                                        <td>{{option.optionName}}</td>
                                        <td>{{option.optionVoteCount}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <p class="alert alert-warning invisible" id="statusArea"></p>
                    </div>
                    <div class="col-md-4 col-md-offset-4 text-center" data-ng-class="{ 'hide' : orderStatus.status != 1}">
                        <button class="btn btn-primary btn-lg" data-ng-click="ResetOrderStatus()">Today's Order has been delievered. Reset order status</button>
                    </div>
                    <div class="col-md-4 col-md-offset-4 text-center" data-ng-class="{ 'hide' : orderStatus.status == 1}">
                        <button class="btn btn-primary btn-lg" data-ng-click="BuildSnacksOrder()">Close Voting for today's snacks. Build Order for today</button>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div class='col-md-12 text-center'>
                    <p class='center-block text-primary text-center'>&#169; <?php echo COPYRIGHT ;?></p>
                </div>
            </div>
            <footer>
                <script type="text/javascript" src="./../../Common/js/jquery/jquery.js"></script>
                <script type="text/javascript" src="./../../Common/js/bootstrap/bootstrap.min.js"></script>
                <script type="text/javascript" src="./../../Common/js/angular/angular.min.js"></script>
                <script type="text/javascript" src="./js/ordermodule.js"></script>
                <script type="text/javascript" src="./controller/order-manage-controller.js"></script>
            </footer>
        </body>
    </html>
<?php
    }
    else{
        header('Location: ./');
        exit();
    }
?>