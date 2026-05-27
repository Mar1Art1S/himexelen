<?php

use App\Livewire\OrderForm;
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
        ->assertSee('Продукція та ціни')
        ->assertSee('Вулик на 8 рамок')
        ->assertSee('Вулик на 10 рамок')
        ->assertSee('Вулик на 12 рамок')
        ->assertSeeLivewire(OrderForm::class);
});

test('public pages have catalog link in header navigation', function () {
    $this->get(route('home'))->assertSee('Каталог');
    $this->followingRedirects()->get(route('sizes'))->assertSee('Каталог');
    $this->get(route('calculator'))->assertSee('Каталог');
});

test('public pages have ecosystem link in header navigation', function () {
    $this->get(route('home'))->assertSee('Екосистема');
    $this->followingRedirects()->get(route('sizes'))->assertSee('Екосистема');
    $this->get(route('calculator'))->assertSee('Екосистема');
    $this->get(route('ecosystem'))->assertSee('Екосистема');
});
