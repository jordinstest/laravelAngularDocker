suite('PizzaEditCtrl', function(){
    setup(module('pizzapp'));
    setup(module('pizzappControllers'));

    var $controller, $routeParams,
        controller, $scope,
        Pizza, Ingredients;

    setup(inject(function(_$controller_, _$routeParams_, _Pizza_,_Ingredients_){
        $controller = _$controller_;
        Pizza = _Pizza_;
        Ingredients = _Ingredients_;
        $routeParams = _$routeParams_;

        controller = {};
        $scope = {};
    }));

    function initController(controller, $routeParams, Pizza, Ingredients) {
        $scope = {};
        controller = $controller('PizzaEditCtrl', {
            $scope: $scope,
            $routeParams: $routeParams,
            Pizza: Pizza,
            Ingredients: Ingredients
        });
        return controller;
    }

    suite('init', function(){

        setup(function() {
            initController(controller, $routeParams, Pizza, Ingredients);
        });

        test("should get all ingredients list", function(){
            sinon.stub(Ingredients, 'query');
            initController(controller, $routeParams, Pizza, Ingredients);
            assert(Ingredients.query.calledOnce);
        });

        test("when getting all ingredients list should store it in $scope", function(){
            var fakeIngredientsList = stubAndCallIngredientsList();
            initController(controller, $routeParams, Pizza, Ingredients);
            assert.equal($scope.ingredientsList, fakeIngredientsList);
        });


        suite('Edit pizza', function () {
            var fakePizzaId;
            setup(function () {
                fakePizzaId = 1;
                $routeParams.pizzaId = fakePizzaId;
                stubAndCallIngredientsList();
            });
            test("when url param pizzaId is valid should get that pizza from pizzaService", function () {
                sinon.stub(Pizza, 'get');
                initController(controller, $routeParams, Pizza, Ingredients);
                assert(Pizza.get.calledOnce);
                assert(Pizza.get.calledWith({pizzaId: fakePizzaId}));
            });

            test("when getting a pizza from pizzaService fill the pizza ingredients with name and quantity", function () {
                sinon.stub(Pizza, 'get').callsArgWith(1, createFakePizza());

                initController(controller, $routeParams, Pizza, Ingredients);

                var pizzaIngredients = [{ingredient_id: 2, quantity: 3, name: 'ceba'}, {ingredient_id: 1, quantity: 5, name: 'bacon'}];
                assert.deepEqual($scope.pizza.ingredients, pizzaIngredients);
            });
        });

        suite('addIngredientsToPizza', function () {
            function prepareAddIngredients() {
                var pizzaIngredients = createFakeIngredientsList();
                $scope.ingredientsList = pizzaIngredients;
                $scope.pizza = createFakePizza();
                return pizzaIngredients;
            }

            test('when called should add the selected ingredients to the pizza ingredients', function () {
                var pizzaIngredients = prepareAddIngredients();
                pizzaIngredients[0].selected = true;
                $scope.addIngredientsToPizza(pizzaIngredients);

                var expectedPizzaIng = [{ingredient_id: 2, quantity: 3}, {ingredient_id: 1, quantity: 6}];
                assert.deepEqual($scope.pizza.ingredients, expectedPizzaIng);
            });

            test('when called with new ingredients should add the selected ingredients to the pizza ingredients', function () {
                var pizzaIngredients = prepareAddIngredients();
                pizzaIngredients[2].selected = true;
                $scope.addIngredientsToPizza(pizzaIngredients);

                var expectedPizzaIng = [{ingredient_id: 2, quantity: 3}, {ingredient_id: 1, quantity: 5}, {ingredient_id: 3, name: 'carxofa', quantity: 1}];
                assert.deepEqual($scope.pizza.ingredients, expectedPizzaIng);
            });

        });

    });

    function stubAndCallIngredientsList() {
        var fakeIngredientsList = createFakeIngredientsList();
        sinon.stub(Ingredients, 'query').callsArgWith(0, fakeIngredientsList);
        return fakeIngredientsList;
    }

    function createFakeIngredientsList() {
        return [{"id":1,"name":"bacon"},{"id":2,"name":"ceba"},{"id":3,"name":"carxofa"}];
    }

    function createFakePizza() {
        return {
            "id":1,
            "name":"Diavola",
            "ingredients": [
                {
                    "ingredient_id": 2,
                    "quantity": 3
                },
                {
                    "ingredient_id": 1,
                    "quantity": 5
                }
        ]};
    }

});