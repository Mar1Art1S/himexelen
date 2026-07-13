<?php

use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminAndContentSeeder::class);
});

test('catalog page renders successfully', function () {
    $response = $this->get(route('catalog'));

    $response->assertStatus(200)
        ->assertSee('Каталог товарів ТМ Хімекселен')
        ->assertSee('Продукція та ціни');
});

test('catalog page uses the current price images', function () {
    $this->get(route('catalog'))
        ->assertSuccessful()
        ->assertSee('/images/pricenew/bee-8new.png')
        ->assertSee('/images/pricenew/bee-10new.png')
        ->assertSee('/images/pricenew/bee-12new.png')
        ->assertSee('/images/pricenew/bee-othernew.png')
        ->assertDontSee('/images/price/');
});

test('public pages have catalog link in header navigation', function () {
    $this->get(route('home'))->assertSee('Продукція та ціни');
    $this->followingRedirects()->get(route('sizes'))->assertSee('Продукція та ціни');
    $this->get(route('calculator'))->assertSee('Продукція та ціни');
});

test('public pages have ecosystem link in header navigation', function () {
    $this->get(route('home'))->assertSee('Екосистема');
    $this->followingRedirects()->get(route('sizes'))->assertSee('Екосистема');
    $this->get(route('calculator'))->assertSee('Екосистема');
    $this->get(route('ecosystem'))->assertSee('Екосистема');
});
