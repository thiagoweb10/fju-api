<?php

it('Acessando endpoint de listagem de categorias', function () {
    $response = $this->get('/api/categories');

    $response->assertStatus(200);
});