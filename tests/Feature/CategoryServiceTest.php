<?php

use App\Models\Category;
use App\DTOs\CategoryDTO;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new CategoryService();
});

test('Lista de categorias', function(){

    Category::factory()->create(['description' => 'Futebol']);
    Category::factory()->create(['description' => 'Cinema']);
    Category::factory()->create(['description' => 'Tecnologia']);

    $result = $this->service->getListAll();

    expect($result)->toHaveCount(3)
        ->and($result->first())->toBeInstanceOf(\App\Models\Category::class);
});

test('Cria uma nova categoria', function () {

    $data = [
        'description' => 'Futebol'
    ];
    
    $dto = CategoryDTO::fromArray($data);
    $category = $this->service->create($dto);

    expect($category)->toBeInstanceOf(Category::class)
                     ->and($category->description)->toBe('Futebol');
});

test('Alterar descrição de uma categoria', function(){
    
    Category::factory()->create(['description' => 'Futebol']);

    $data = [
        'description' => 'JiuJitsu'
    ];
     
    $dto = CategoryDTO::fromArray($data);
    $result = $this->service->create($dto , 1);

    expect($result)->toBeInstanceOf(Category::class)
                     ->and($result->description)->toBe('JiuJitsu');
});

test('Excluir uma categoria', function(){

    $category = Category::factory()->create(['description' => 'Futebol']);

    $this->service->delete($category);
    
    expect(Category::find($category->id))->toBeNull();

});