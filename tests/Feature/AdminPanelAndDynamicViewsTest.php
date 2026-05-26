<?php

use App\Models\User;
use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed initial data using the seeder
    $this->seed(AdminAndContentSeeder::class);
});

test('video page renders successfully and displays seeded videos', function () {
    $response = $this->get('/video');

    $response->assertStatus(200);
    $response->assertSee('Огляд вуликів з ППУ');
    $response->assertSee('Вулик на 8 рамок');
    $response->assertSee('Вулик на 10 рамок');
    $response->assertSee('Вулик на 12 рамок');
});

test('instruction page redirects to tabbed video materials page and displays seeded content', function () {
    $response = $this->get('/instruction');
    $response->assertRedirect('/video?tab=instruction');

    $response = $this->followRedirects($response);
    $response->assertStatus(200);
    $response->assertSee('Інструкція для 8-рамкового вулика');
    $response->assertSee('Інструкція для 10-рамкового вулика');
    $response->assertSee('Інструкція для 12-рамкового вулика');
    // Ensure assembly videos are displayed
    $response->assertSee('вулика 8-рамочного');
});

test('sizes page redirects to tabbed video materials page and displays seeded content', function () {
    $response = $this->get('/sizes');
    $response->assertRedirect('/video?tab=sizes');

    $response = $this->followRedirects($response);
    $response->assertStatus(200);
    $response->assertSee('Рамка 145');
    $response->assertSee('Рамка 230');
    $response->assertSee('Рамка 300');
    $response->assertSee('Комплектація 8 рамок');
    $response->assertSee('Комплектація 10/12 рамок');
});

test('filament login page is accessible', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
});

test('admin can log in and access filament dashboard', function () {
    $admin = User::where('email', 'admin@himexelen.test')->first();

    $this->actingAs($admin);

    $response = $this->get('/admin');

    $response->assertStatus(200);
});
