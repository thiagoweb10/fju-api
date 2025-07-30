<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

beforeEach(function () {
    DB::table('categories')->insert([
        'id' => 1,
        'description' => 'Categoria Teste',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('championships')->insert([
        'id' => 1,
        'category_id' => 1,
        'name' => 'Campeonato Teste',
        'logo' => null,
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
});

test('Lista os campeonatos', function () {
    $response = $this->getJson('/api/championships');

    $response->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                    ->where('message', 'Listagem gerada com sucesso!')
                    ->has('data.current_page')
                    ->has('data.data')
                    ->has('data.data.0', fn ($json) => $json->hasAll([
                        'id',
                        'category_id',
                        'name',
                        'logo',
                        'logoPath',
                        'status',
                    ])
                    )
                    ->etc()
        );
});

test('Criação de campeonato', function () {
    $payload = [
        'category_id' => 1,
        'name' => 'Campeonato Pest',
        'status' => 1,
        'logo' => UploadedFile::fake()->create('logo.jpg', 100, 'image/jpeg'),
    ];

    $response = $this->postJson('/api/championships', $payload);

    $response->assertCreated()
             ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                      ->where('message', 'Campeonato criado com sucesso!')
                      ->has('data')
                      ->etc()
             );
});

it('edita um campeonato existente', function () {
    Storage::fake('public');

    $payload = [
        'category_id' => 1,
        'name' => 'Campeonato Editado',
        'status' => 1,
        'logo' => UploadedFile::fake()->create('novo_logo.png', 100, 'image/png'),
    ];

    $response = $this->patchJson('/api/championships/1', $payload);

    $response->assertOk()
             ->assertJson(fn (AssertableJson $json) => $json->where('status', true)
                      ->where('message', 'Registro atualizado com sucesso!')
                      ->etc()
             );

    // Verifica se o novo nome foi salvo no banco
    $this->assertDatabaseHas('championships', [
        'id' => 1,
        'name' => 'Campeonato Editado',
    ]);

    // Verifica se o novo logo foi salvo no disco
    Storage::disk('public')->assertExists('championships/logos/'.basename($payload['logo']->hashName()));
});

test('Excluir uma campeonato', function () {
    $response = $this->deleteJson('/api/championships/1');

    $response->assertOk()
             ->assertJson([
                 'status' => true,
                 'message' => 'Campeonato excluido com sucesso!',
             ]);

    // Verifica se foi removido do banco
    $this->assertDatabaseMissing('championships', [
        'id' => 2,
    ]);
});
