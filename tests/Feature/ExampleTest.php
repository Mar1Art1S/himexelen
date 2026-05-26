<?php

use App\Livewire\HiveCalculator;
use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminAndContentSeeder::class);
});

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('home page shows ppu hives landing content', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee('Хімекселен')
        ->assertSee('Вулики з ППУ')
        ->assertSee('Наступне покоління')
        ->assertSee('Чому обирають вулики з ППУ?')
        ->assertSee('director@himpost.com')
        ->assertSee('+38 050 340 35 47');
});

test('public content pages are available', function (string $routeName, string $expectedText) {
    $response = $this->followingRedirects()->get(route($routeName));

    $response
        ->assertOk()
        ->assertSee('Хімекселен')
        ->assertSee($expectedText);
})->with([
    'video page' => ['video', 'Відео'],
    'instruction page' => ['instruction', 'Інструкція'],
    'sizes page' => ['sizes', 'Розміри'],
    'calculator page' => ['calculator', 'Калькулятор'],
    'ecosystem page' => ['ecosystem', 'Екосистема'],
]);

test('instruction page links to copied pdf files', function () {
    $response = $this->followingRedirects()->get(route('instruction'));

    $response
        ->assertOk()
        ->assertSee('instruction-8ua.pdf')
        ->assertSee('instruction-10ua.pdf')
        ->assertSee('instruction-12ua.pdf');
});

test('hive calculator adds packages and applies discount', function () {
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '12')
        ->set('packageKey', '2')
        ->set('quantity', 40)
        ->call('addItem')
        ->assertSee('135 400')
        ->assertSee('10%')
        ->assertSee('121 860');
});

test('hive calculator adds components from price list', function () {
    Livewire::test(HiveCalculator::class)
        ->set('mode', 'expert')
        ->set('frameSize', '8')
        ->set('componentKey', '8.roof')
        ->set('componentQuantity', 3)
        ->call('addComponent')
        ->assertSee('ДАХ 8')
        ->assertSee('1 398');
});

test('ecosystem page displays the brand ecosystem and industry projects', function () {
    $response = $this->get(route('ecosystem'));

    $response
        ->assertOk()
        ->assertSee('Екосистема брендів')
        ->assertSee('Галузеві проекти компанії Хімпостачальник')
        ->assertSee('ТехПолімер Маркет')
        ->assertSee('Спеціалізований retail та B2B-проект для технічних полімерів')
        ->assertSee('Прямі поставки полімерної сировини')
        ->assertSee('Хімекселен')
        ->assertSee('Товари для бджільництва')
        ->assertSee('Сучасні полімерні вулики, годівниці');
});
