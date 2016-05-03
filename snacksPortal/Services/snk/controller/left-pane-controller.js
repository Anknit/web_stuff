(function () {
    "use strict";
    var leftPaneController  =   function ($scope, $http, $location) {
        $scope.states   =   JSON.parse(stateJson);
        $scope.getStateCity = function () {
            $scope.cities   =   [];
            $scope.locations   =   [];
            $scope.schoolSearchCity =   '';
            $scope.schoolSearchLocation =   '';
            if ($scope.schoolSearchState !== '') {
                var data  =   {'action': 'act_01', 'data': {'stateId': $scope.schoolSearchState}}, successCallback =   function (response) {
                    $scope.cities   =   response.data.data;
                }, config = {}, errorCallback =   function (response) {
                    console.log(response);
                };
                $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
            }
        };
        $scope.getCityLocation = function () {
            var data  =   {'action': 'act_02', 'data': {'cityId': $scope.schoolSearchCity}}, successCallback =   function (response) {
                $scope.locations   =   response.data.data;
            }, config = {}, errorCallback =   function (response) {
                console.log(response);
                $scope.locations   =   [];
            };
            $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
        };
        $scope.getStateSchool    =   function(){
            $location.path('/search/schools/'+angular.uppercase($scope.states[$scope.schoolSearchState]['stateName']));
/*
            var data  =   {'action': 'act_03', 'data': {'stateName': angular.uppercase($scope.states[$scope.schoolSearchState]['stateName'])}}, successCallback =   function (response) {
                $scope.schools   =   response.data.data;
            }, config = {}, errorCallback =   function (response) {
                console.log(response);
                $scope.locations   =   [];
            };
            $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
*/
        }
    };
    leftPaneController.$inject  =   ['$scope', '$http', '$location'];
    angular.module('schoolap').controller('leftPaneController', leftPaneController);
}());