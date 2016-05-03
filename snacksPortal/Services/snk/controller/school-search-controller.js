(function () {
    "use strict";
    var schoolSearchController  =   function ($scope, $routeParams, $http) {
        var data  =   {'action': 'act_03', 'data': {'stateName': decodeURIComponent($routeParams.stateName)}}, successCallback =   function (response) {
            $scope.schools   =   response.data.data;
        }, config = {}, errorCallback =   function (response) {
            console.log(response);
            $scope.locations   =   [];
        };
        $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
    };
    schoolSearchController.$inject  =   ['$scope', '$routeParams', '$http'];
    angular.module('schoolap').controller('schoolSearchController', schoolSearchController);
}());