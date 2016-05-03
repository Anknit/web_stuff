(function () {
    "use strict";
    var app = angular.module('snacksapp', ['ngRoute']);
    app.config(function ($routeProvider) {
        $routeProvider
            .when('/', {
                controller: 'homeController',
                templateUrl: 'template/main.html'
            })
            .when('/next-day', {
                controller: 'nextDayController',
                templateUrl: 'template/nextDay.html'
            })
            .when('/change-pswd', {
                controller: 'pswdChangeController',
                templateUrl: 'template/pswdChange.html'
            })
/*
            .when('/result/class/12', {
                controller: '',
                templateUrl: ''
            })
            .when('/result/internal', {
                controller: '',
                templateUrl: ''
            })
            .when('/compare', {
                controller: '',
                templateUrl: ''
            })
            .when('/ranking', {
                controller: '',
                templateUrl: ''
            })
            .when('/admission/process', {
                controller: '',
                templateUrl: ''
            })
            .when('/admission/apply', {
                controller: '',
                templateUrl: ''
            })
            .when('/scholarship/central', {
                controller: '',
                templateUrl: ''
            })
            .when('/scholarship/state', {
                controller: '',
                templateUrl: ''
            })
            .when('/scholarship/private', {
                controller: '',
                templateUrl: ''
            })
            .when('/joblist', {
                controller: '',
                templateUrl: ''
            })
            .when('/appStatus', {
                controller: '',
                templateUrl: ''
            })
            .when('/signup', {
                controller: '',
                templateUrl: ''
            })
*/
            .otherwise({ redirectTo: '/'});
    });
    app.config(function($httpProvider) {
        // Use x-www-form-urlencoded Content-Type
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        /**
        * The workhorse; converts an object to x-www-form-urlencoded serialization.
        * @param {Object} obj
        * @return {String}
        */ 
        var param = function(obj) {
        var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

        for(name in obj) {
          value = obj[name];

          if(value instanceof Array) {
            for(i=0; i<value.length; ++i) {
              subValue = value[i];
              fullSubName = name + '[' + i + ']';
              innerObj = {};
              innerObj[fullSubName] = subValue;
              query += param(innerObj) + '&';
            }
          }
          else if(value instanceof Object) {
            for(subName in value) {
              subValue = value[subName];
              fullSubName = name + '[' + subName + ']';
              innerObj = {};
              innerObj[fullSubName] = subValue;
              query += param(innerObj) + '&';
            }
          }
          else if(value !== undefined && value !== null)
            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
        }

        return query.length ? query.substr(0, query.length - 1) : query;
        };

        // Override $http service's default transformRequest
        $httpProvider.defaults.transformRequest = [function(data) {
            return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
        }];
    });
}());
var loadOverlay =   function(){
    $('#overlayBlock').removeClass('hide');
};
var UnloadOverlay =   function(){
    $('#overlayBlock').addClass('hide');
};