(function () {
    var homeController  =   function ($scope, $routeParams, $http) {
        loadOverlay();
        $('#menu-navbar-collapse-1 li.active').removeClass('active');
        $('#today-option-menu-item').addClass('active');
        var data    =   {'action':'presentoptionstatus','data':{}},config={},successCallback = function (response) {
            $scope.orderStatus  =   response.data.data.orderstatus;
            $scope.presentOptionList   =   response.data.data.optiondata;
            UnloadOverlay();
        }, errorCallback = function (response) {
            console.log(response);
            $scope.presentOptionList   =   [];
            UnloadOverlay();
        };
        $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
        $scope.confirmSelection =   function (event) {
            loadOverlay();
            var data  =   {'action': 'optionSelect', 'data': {'optionId': $(event.currentTarget).attr('data-optionval')}}, successCallback =   function (response) {
                $scope.presentOptionList   =   response.data.data;
                var responseData    =   $scope.presentOptionList;
                for(var key in responseData){
                    $scope.presentOptionList[key]['percentCount']    =   (Math.floor(parseInt(responseData[key].presentoptionvotecount)*100/30)).toString() + '%';
                }
                UnloadOverlay();
            }, config = {}, errorCallback =   function (response) {
                console.log(response);
                UnloadOverlay();
            };
            $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
        };
        $scope.getpercentstring =   function (dataArrOpt, index) {
            dataArrOpt.percentCount    =    (Math.floor(parseInt(dataArrOpt.presentoptionvotecount)*100/30)).toString() + '%';
        };
    };
    homeController.$inject  =   ['$scope', '$routeParams', '$http'];
    angular.module('snacksapp').controller('homeController', homeController);
}());