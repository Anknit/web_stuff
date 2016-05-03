(function () {
    var pswdChangeController  =   function ($scope, $routeParams, $http) {
        $('#menu-navbar-collapse-1 li.active').removeClass('active');
        $('#user-setting-menu-item').addClass('active');
        $('#statusArea').html('').addClass('invisible');
        $('#current-pswd').val('');
        $('#new-pswd').val('');
        $('#confirm-pswd').val('');
        $scope.submitNewPassword =   function (event) {
            var currentpswd    =   $('#current-pswd').val();
            var newpswd        =   $('#new-pswd').val();
            var confirmpswd    =   $('#confirm-pswd').val();
            if(newpswd != confirmpswd){
                $('#statusArea').html('New password and confirm passwords are not same');
                return false;
            }
            var data  =   {'action': 'changePassword', 'data': {'currentPswd': currentpswd,'newPswd':newpswd}}, successCallback =   function (response) {
                var responseData   =   response.data.data;
                $('#statusArea').removeClass('invisible');
                if(responseData == '101'){
                    $('#statusArea').html('Current password is incorrect');
                }
                else if(responseData == '102'){
                    $('#statusArea').html('Password not updated successfully');
                }
                else{
                    $('#statusArea').html('Password updated successfully');
                }
                $('#current-pswd').val('');
                $('#new-pswd').val('');
                $('#confirm-pswd').val('');
            }, config = {}, errorCallback =   function (response) {
                console.log(response);
            };
            $http.post('./php/requestHandler.php', data).then(successCallback, errorCallback);
        };
    };
    pswdChangeController.$inject  =   ['$scope', '$routeParams', '$http'];
    angular.module('snacksapp').controller('pswdChangeController', pswdChangeController);
}());