<?php

use App\Livewire\HiveCalculator;
use App\Mail\CalculationMail;
use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminAndContentSeeder::class);
});

test('calculator page renders hive calculator component', function () {
    $this->get(route('calculator'))
        ->assertOk()
        ->assertSeeLivewire(HiveCalculator::class);
});

test('applies updated discount tiers based on legacy wordpress specifications', function () {
    // 8-frame Комплектація 3 = 3,112 грн each
    // 15 units = 46,680 грн subtotal → ≥30,000 threshold → 5% discount = 2,334 грн → Total = 44,346 грн
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 15)
        ->call('addItem')
        ->assertSee('46 680 грн')
        ->assertSee('Знижка 5%')
        ->assertSee('44 346');

    // 25 units = 77,800 грн subtotal → ≥70,000 threshold → 7% discount = 5,446 грн → Total = 72,354 грн
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 25)
        ->call('addItem')
        ->assertSee('77 800 грн')
        ->assertSee('Знижка 7%')
        ->assertSee('72 354');

    // 12-frame Комплектація 2 = 3,385 грн each
    // 40 units = 135,400 грн subtotal → ≥120,000 threshold → 10% discount = 13,540 грн → Total = 121,860 грн
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '12')
        ->set('packageKey', '2')
        ->set('quantity', 40)
        ->call('addItem')
        ->assertSee('135 400 грн')
        ->assertSee('Знижка 10%')
        ->assertSee('121 860');
});

test('applies packaging box option correctly without discounting it', function () {
    // 8-frame Комплектація 3 = 3,112 грн each
    // 10 units = 31,120 грн subtotal → ≥30,000 → 5% discount = 1,556 грн
    // Packaging = 10 × 70 = 700 грн
    // Total = 31,120 - 1,556 + 700 = 30,264 грн
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 10)
        ->set('includePackaging', true)
        ->call('addItem')
        ->assertSee('31 120 грн')
        ->assertSee('Знижка 5%')
        ->assertSee('30 264');

    // 15 units = 46,680 грн subtotal → 5% discount = 2,334 грн
    // Packaging = 15 × 70 = 1,050 грн
    // Total = 46,680 - 2,334 + 1,050 = 45,396 грн
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 15)
        ->set('includePackaging', true)
        ->call('addItem')
        ->assertSee('46 680 грн')
        ->assertSee('Знижка 5%')
        ->assertSee('45 396');
});

test('displays package components when selecting a configuration', function () {
    // Under the new open UI, all ready-set cards list their component details on the page
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '8')
        ->assertSee('Комплектація 3')
        ->assertSee('Комплектація 1')
        ->assertSee('ДАХ 8')
        ->assertSee('ДНО в комплекті')
        ->assertSee('корпус 300 з кутиками')
        ->assertSee('корпус 145 з кутиками')
        ->assertSee('годівниця');
});

test('unpacks package components into individual items in constructor correctly', function () {
    // Select 8-frame package 3 (has 1 roof, 1 bottom, 1 body 300, 2 bodies 145, 1 feeder)
    // Quantity = 3.
    // Unpacking should yield: 3 roof, 3 bottom, 3 body 300, 6 body 145, 3 feeder.
    Livewire::test(HiveCalculator::class)
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 3)
        ->call('loadPackageIntoConstructor')
        ->assertSet('mode', 'expert')
        ->assertSet('items.0.quantity', 3) // ДАХ 8
        ->assertSet('items.1.quantity', 3) // ДНО 8 в комплекті
        ->assertSet('items.2.quantity', 3) // корпус 300/8 з кутиками
        ->assertSet('items.3.quantity', 6) // корпус 145/8 з кутиками
        ->assertSet('items.4.quantity', 3); // годівниця 8 у комплекті
});

test('sends calculation email successfully with valid data', function () {
    Mail::fake();

    Livewire::test(HiveCalculator::class)
        ->set('name', 'Іван Тест')
        ->set('phone', '+380991234567')
        ->set('email', 'test@example.com')
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 2)
        ->call('addItem')
        ->call('sendCalculation')
        ->assertHasNoErrors()
        ->assertSet('isSent', true)
        ->assertSee('Розрахунок успішно надіслано!');

    Mail::assertSent(CalculationMail::class, function ($mail) {
        return $mail->calcData['name'] === 'Іван Тест' &&
               $mail->calcData['phone'] === '+380991234567' &&
               $mail->calcData['email'] === 'test@example.com' &&
               count($mail->calcData['items']) === 1 &&
               $mail->calcData['total'] > 0;
    });
});

test('fails sending calculation if name or phone are invalid', function () {
    Mail::fake();

    // Missing name and phone
    Livewire::test(HiveCalculator::class)
        ->set('name', '')
        ->set('phone', '')
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 2)
        ->call('addItem')
        ->call('sendCalculation')
        ->assertHasErrors(['name' => 'required', 'phone' => 'required']);

    Mail::assertNothingQueued();
});

test('automatically adds current package in beginner mode when items are empty and send is clicked', function () {
    Mail::fake();

    Livewire::test(HiveCalculator::class)
        ->set('mode', 'beginner')
        ->set('name', 'Іван Тест')
        ->set('phone', '+380991234567')
        ->set('frameSize', '8')
        ->set('packageKey', '3')
        ->set('quantity', 2)
        // items is empty here
        ->call('sendCalculation')
        ->assertHasNoErrors()
        ->assertSet('isSent', true);

    Mail::assertSent(CalculationMail::class, function ($mail) {
        return $mail->calcData['name'] === 'Іван Тест' &&
               count($mail->calcData['items']) === 1 && // automatically added 1 item
               $mail->calcData['items'][0]['packageKey'] === '3';
    });
});
