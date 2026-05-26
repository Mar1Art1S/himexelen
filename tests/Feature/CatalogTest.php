<?php

use App\Livewire\OrderForm;

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

test('home page renders simplified catalog section successfully', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200)
        ->assertSee('Каталог вуликів з ППУ')
        ->assertSee('Перейти до каталогу продукції')
        ->assertSee('home-catalog-link')
        ->assertSeeLivewire(OrderForm::class);
});
