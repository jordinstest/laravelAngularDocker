<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IngredientTest extends TestCase
{
    use DatabaseMigrations;

    public function testWhenPostingIngredientShouldReturnCorrectJson()
    {
        $this->post('/ingredient', ['name' => 'Roquefort'])
             ->seeJson([
                 "id"=>1, "name"=>"Roquefort"
             ]);
    }

    public function testWhenDeletingIngredientShouldRemoveIt()
    {
        $this->insertIngredient('Roquefort');
        $response = $this->call('DELETE', '/ingredient/1');
        $this->assertEquals(200, $response->status());
    }

    public function testWhenDeletingUnexistingIngredientShouldReturnError()
    {
        $this->insertIngredient('Roquefort');
        $response = $this->call('DELETE', '/ingredient/7823');
        $this->assertEquals(404, $response->status());
    }


    public function testWhenGettingAllIngredientsShouldReturnList()
    {
        $this->insertIngredient('Roquefort');
        $this->insertIngredient('Xampinyons');
        $this->get('/ingredient')
                     ->seeJson([
                         "id"=>1, "name"=>"Roquefort"
                     ],[
                         "id"=>2, "name"=>"Xampinyons"
                     ]);
    }


    public function testWhenUpdatingAnIngredientShouldModifyItCorrectly()
    {
        $this->insertIngredient('Roquefort');
        $this->put('/ingredient/1', ["name"=>"RoquefortModified"]);
        $this->get('/ingredient/1')
                    ->seeJson([
                         "id"=>1, "name"=>"RoquefortModified"
                     ]);
    }


    protected function insertIngredient ($name) {
        $this->post('/ingredient', ['name' => $name]);
    }

}
