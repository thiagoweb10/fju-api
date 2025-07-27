<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Acessando endpoint de listagem de categorias', function () {

    $data = [
        'description' => 'Futebol',
    ];
    $response = $this->postJson('/api/categories', $data);

    $response->assertStatus(201);

     $this->assertDatabaseHas('categories', [
        'description' => 'Futebol',
    ]);
});