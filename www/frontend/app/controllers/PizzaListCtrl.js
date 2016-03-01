var pizzappControllers = angular.module('pizzappControllers', [
    'ingredientsServices'
]);

pizzappControllers.controller('PizzaListCtrl', function ($scope, $location, Pizza) {

    $scope.pizzas = Pizza.query();



    $scope.editPizza = function (pizza) {
        if(!pizza) {
            pizza = {id: 0}
        }

        $location.path('pizzas/'+pizza.id+'/');
    };

});