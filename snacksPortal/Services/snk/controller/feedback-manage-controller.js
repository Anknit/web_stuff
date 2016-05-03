(function () {
    var feedbackManageController  =   function ($scope, $http) {
        var data  =   {'action': 'feedbackStatus', 'data': {}},
        successCallback =   function (response) {
            var responseData   =   response.data.data;
            $scope.feedbackList =   responseData;
        },
        config = {},
        errorCallback =   function (response) {
            console.log(response);
        };
        $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
        $scope.getStatusText    =   function(value){
            var stringValue =   'New Feedback';
            switch(value){
                case '1':
                    stringValue =   'New Feedback';
                    break;
                case '2':
                    stringValue =   'Implemented Feedback';
                    break;
                case '3':
                    stringValue =   'Invalid Feedback';
                    break;
                default:
                    stringValue =   'New Feedback';
                    break;
            }
            return stringValue;
        };
    };
    feedbackManageController.$inject  =   ['$scope', '$http'];
    angular.module('snacksFeedback').controller('feedbackManageController', feedbackManageController);
}());