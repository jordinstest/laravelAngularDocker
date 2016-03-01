var pizzappControllers = angular.module('pizzappControllers');


pizzappControllers.controller('PizzaEditCtrl', function ($scope, $routeParams, $location, Pizza, Ingredients) {


    Ingredients.query(function (ingredientsList) {
        $scope.ingredientsList = ingredientsList;

        var pizzaId = $routeParams.pizzaId;
        if(!pizzaId || pizzaId < 1) {

            $scope.pizza = new Pizza ();
            $scope.pizza.name = '';
            $scope.pizza.ingredients = [];

        } else {
            Pizza.get({pizzaId: pizzaId}, function (pizza) {
                $scope.pizza = pizza;
                fillPizzaIngredientsWithInfo();
            });

        }
    });

    $scope.addIngredientsToPizza = function (ingredientsList) {

        ingredientsList.forEach(function (ingredient) {
           if(ingredient.selected) {
               var pizzaIng = getPizzaIngredientById(ingredient.id);
               if(!pizzaIng) {
                   $scope.pizza.ingredients.push({
                       ingredient_id: ingredient.id,
                       name: ingredient.name,
                       quantity: 1
                   });
               } else {
                   pizzaIng.quantity ++;
               }
           }
        });
    };


    $scope.save = function () {
        if(!$scope.pizza.id) {
            $scope.pizza.$save(function (pizza) {
                $scope.pizza.id = pizza.id;
                $location.path('pizzas/'+pizza.id+'/');
            });
        } else {
            $scope.pizzaId = $scope.pizza.id;
            $scope.pizza.$update({
                pizzaId: $scope.pizza.id
            }, function (pizza) {
                $scope.pizza.id = pizza.id;
                $scope.pizza.name = pizza.name;
                fillPizzaIngredientsWithInfo();
                unselectIngredientsList();
            }, function (err){
                console.error('Error updating', err);
            });

        }
    };


    function getIngredientInfo (ingredientId) {
        return $scope.ingredientsList.find(function (ingredientInfo) {
            return ingredientInfo.id === ingredientId;
        });
    }


    function unselectIngredientsList () {
        $scope.ingredientsList.forEach(function (ingredient) {
            ingredient.selected = false;
        });
    }

    function fillPizzaIngredientsWithInfo() {
        if($scope.pizza && $scope.pizza.ingredients) {
            $scope.pizza.ingredients.forEach(function (ingredient) {
                var ingredientInfo = getIngredientInfo(ingredient.ingredient_id);
                if (ingredientInfo) {
                    ingredient.name = ingredientInfo.name;
                }
            });
        }
    }

    function getPizzaIngredientById (ingredientId) {
        if(!$scope.pizza.ingredients) {
            $scope.pizza.ingredients = [];
        }
        return $scope.pizza.ingredients.find(function (ingredientInfo) {
            return ingredientInfo.ingredient_id === ingredientId;
        });
    }



});