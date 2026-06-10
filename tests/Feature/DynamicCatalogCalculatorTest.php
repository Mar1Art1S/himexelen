<?php

use App\Livewire\HiveCalculator;
use App\Models\ProductCategory;
use App\Models\ProductComplectation;
use App\Models\ProductComponent;
use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed initial data using the seeder
    $this->seed(AdminAndContentSeeder::class);
});

test('calculator page renders successfully', function () {
    $response = $this->get('/calculator');
    $response->assertStatus(200);
});

test('calculator loads packages and components from the database', function () {
    // Check that we have categories, packages, and components seeded
    expect(ProductCategory::count())->toBeGreaterThan(0);
    expect(ProductComplectation::count())->toBeGreaterThan(0);
    expect(ProductComponent::count())->toBeGreaterThan(0);

    // Test Livewire component loading initial catalog from db
    Livewire::test(HiveCalculator::class)
        ->assertSet('frameSize', '10')
        ->assertSet('packageKey', '');
});

test('updating product component price in database instantly updates calculator subtotal', function () {
    $category = ProductCategory::where('slug', '10-frames')->first();

    // Create/update a component under the '10' group
    $component = ProductComponent::updateOrCreate(
        ['product_category_id' => $category->id, 'name' => 'Унікальна деталь 10-рамкова'],
        ['price' => 500, 'group' => '10', 'sort_order' => 1]
    );

    $calc = Livewire::test(HiveCalculator::class)
        ->set('frameSize', '10');

    // Key formula: $group . '.' . preg_replace('/[^a-z0-9а-яіїєґ\-_]/ui', '', str_replace(' ', '-', strtolower($compName)))
    $key = '10.унікальна-деталь-10-рамкова';

    $calc->set('componentKey', $key)
        ->set('componentQuantity', 2)
        ->call('addComponent')
        ->assertSee('Унікальна деталь 10-рамкова');

    // Initial subtotal should be 2 * 500 = 1000
    expect($calc->instance()->subtotal())->toBe(1000);

    // Update component price in database
    $component->update(['price' => 750]);

    // Clear and re-add component to ensure new price from database is loaded
    $calc->call('clear')
        ->set('componentKey', $key)
        ->set('componentQuantity', 2)
        ->call('addComponent');

    // Subtotal should now be 2 * 750 = 1500
    expect($calc->instance()->subtotal())->toBe(1500);
});

test('updating product complectation price in database instantly updates calculator subtotal', function () {
    $category = ProductCategory::where('slug', '10-frames')->first();

    // Create/update a complectation
    $complectation = ProductComplectation::updateOrCreate(
        ['product_category_id' => $category->id, 'name' => 'Комплектація 99'],
        [
            'description' => 'Тестова комплектація',
            'price' => 4000,
            'components' => [['name' => 'Тест деталі', 'qty' => 1, 'unit' => 'шт']],
            'sort_order' => 1000,
        ]
    );

    $calc = Livewire::test(HiveCalculator::class)
        ->set('frameSize', '10')
        ->set('packageKey', '99')
        ->set('quantity', 2)
        ->call('addItem');

    // Initial subtotal should be 2 * 4000 = 8000
    expect($calc->instance()->subtotal())->toBe(8000);

    // Update complectation price in database
    $complectation->update(['price' => 4500]);

    // Clear and re-add package to ensure new price from database is loaded
    $calc->call('clear')
        ->set('frameSize', '10')
        ->set('packageKey', '99')
        ->set('quantity', 2)
        ->call('addItem');

    // Subtotal should now reflect 2 * 4500 = 9000
    expect($calc->instance()->subtotal())->toBe(9000);
});
