(function () {
    var footerController  =   function ($scope, $http) {
        $scope.textareaLength   =   120;
        $scope.submitFeedback =   function (event) {
            if($scope.feedback.text.length > 0){
                var data  =   {'action': 'feedbackSubmit', 'data': {'feedbacktext': $scope.feedback.text}}, successCallback =   function (response) {
                    var responseData    =   response.data.data.message;
                    $('#feedback-message').html(responseData).removeClass('invisible');
                    setTimeout(function(){
                        $('#feedback-message').html('').addClass('invisible');
                    },3000);
                    $scope.feedback.text    = '';
                }, config = {}, errorCallback =   function (response) {
                    console.log(response);
                };
                $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
            }
        };
    };
    footerController.$inject  =   ['$scope', '$http'];
    angular.module('snacksapp').controller('footerController', footerController);
}());