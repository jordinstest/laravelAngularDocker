var pizzapp = angular.module('pizzapp', [
    'ngRoute',
    'pizzappControllers',
    'pizzappServices',
    'ingredientsServices'
]);


pizzapp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
        when('/pizzas', {
            templateUrl: 'app/views/pizzaList.tpl.html',
            controller: 'PizzaListCtrl'
        }).
        when('/pizzas/:pizzaId', {
            templateUrl: 'app/views/pizzaEdit.tpl.html',
            controller: 'PizzaEditCtrl'
        }).
        otherwise({
            redirectTo: '/'
        });
    }]);

pizzapp.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.withCredentials = true;
}]);