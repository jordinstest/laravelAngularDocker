var ingredientsServices = angular.module('ingredientsServices', ['ngResource']);

ingredientsServices.factory('Ingredients', ['$resource',
    function($resource){
        return $resource('http://api.test.com/ingredient/:ingredientId', {
            ingredientId: '@ingredientId'
        }, {
            'get':    {method:'GET'},
            'save':   {method:'POST'},
            'query':  {method:'GET', isArray: true},
            'remove': {method:'DELETE'},
            'delete': {method:'DELETE'}
        });
    }]);