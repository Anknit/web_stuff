(function () {
    "use strict";
    var schoolController  =   function ($scope, $routeParams, $http) {
        var data  =   {'action': 'act_04', 'data': {'stateName': $routeParams.stateName, 'schoolId': $routeParams.schoolId}}, successCallback =   function (response) {
            $scope.schoolInfo   =   response.data.data;
        }, config = {}, errorCallback =   function (response) {
            console.log(response);
            $scope.schoolInfo   =   [];
        };
        $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
    };
    schoolController.$inject  =   ['$scope', '$routeParams', '$http'];
    angular.module('schoolap').controller('schoolController', schoolController);
}());