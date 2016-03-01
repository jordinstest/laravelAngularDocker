var pizzappServices = angular.module('pizzappServices', ['ngResource']);

pizzappServices.factory('Pizza', ['$resource',
    function($resource){
        return $resource('http://api.test.com/pizza/:pizzaId/', {
            pizzaId: '@pizzaId'
        }, {
            'get':    {method:'GET'},
            'save':   {method:'POST'},
            'update':   {method:'PUT'},
            'query':  {method:'GET', isArray: true},
            'remove': {method:'DELETE'},
            'delete': {method:'DELETE'}
        });
    }]);