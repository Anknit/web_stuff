(function () {
    var orderManageController  =   function ($scope, $http) {
        var data  =   {'action': 'manageOrderStatus', 'data': {}},
        successCallback =   function (response) {
            var responseData   =   response.data.data;
            $scope.orderStatus  =   responseData.orderstatus;
            $scope.presentOptionStatus  =   responseData.presentoptiondata;
            $scope.nextDayOptionStatus  =   responseData.nextdayoptiondata;
        },
        config = {},
        errorCallback =   function (response) {
            console.log(response);
        };
        $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
        
        $scope.ResetOrderStatus =   function (event) {
            var confirmDecision =   false;
            confirmDecision =   confirm('Do you really want to reset order status. This action is irreversible');
            if(confirmDecision){
                var data  =   {'action': 'resetOrderStatus', 'data': {}}, successCallback =   function (response) {
                    var responseData   =   response.data.data;
                    var reloadMessage   =   '';
                    if(responseData){
                        reloadMessage   =   'Order Reset successfully. Page is reloading';
                    }
                    else{
                        reloadMessage   =   'Action Failed. Page is reloading';
                    }
                    alert(reloadMessage);
                    location.reload();
                }, config = {}, errorCallback =   function (response) {
                    console.log(response);
                };
                $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
            }
            else{
                $('#statusArea').removeClass('invisible').html('You have not confirm your decision');
                return false;
            }
        };

        $scope.BuildSnacksOrder =   function (event) {
            var confirmDecision =   false;
            confirmDecision =   confirm('Do you really want to build order for today\'s snacks. This action is irreversible');
            if(confirmDecision){
                var data  =   {'action': 'buildSnacksOrder', 'data': {}}, successCallback =   function (response) {
                    var responseData   =   response.data.data;
                    var reloadMessage   =   '';
                    if(responseData.response){
                        reloadMessage   =   'Snacks Order Build successfully. Page is reloading';
                    }
                    else{
                        reloadMessage   =   'Action Failed. Page is reloading. Error Code: 000'+responseData.code;
                    }
                    alert(reloadMessage);
                    location.reload();
                }, config = {}, errorCallback =   function (response) {
                    console.log(response);
                };
                $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
            }
            else{
                $('#statusArea').removeClass('invisible').html('You have not confirm your decision');
                return false;
            }
        };
        
    };
    orderManageController.$inject  =   ['$scope', '$http'];
    angular.module('snacksOrderManage').controller('orderManageController', orderManageController);
}());