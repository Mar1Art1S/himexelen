<?php

use App\Models\Video;
use App\Models\VideoCategory;
use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminAndContentSeeder::class);
});

test('video page shows separate "Відео огляди" and "ВІДЕО" tabs', function () {
    $this->get(route('video'))
        ->assertOk()
        ->assertSee('Відео огляди')
        ->assertSee('ВІДЕО')
        ->assertSee("?tab=videos", false)
        ->assertSee("activeTab === 'videos'", false);
});

test('the ВІДЕО tab always shows the featured video as the first card', function () {
    $this->get(route('video'))
        ->assertOk()
        ->assertSee('youtube.com/watch?v=y00wo5oxcEc', false)
        ->assertSee('Презентаційне відео');
});

test('the ВІДЕО tab is fed by its own video category type, separate from reviews', function () {
    $videosCategory = VideoCategory::create([
        'name' => 'ВІДЕО секція',
        'slug' => 'video-section',
        'type' => 'videos',
        'sort_order' => 1,
    ]);

    Video::create([
        'title' => 'Окреме відео з нової вкладки',
        'youtube_id' => 'xyz12345678',
        'video_category_id' => $videosCategory->id,
        'sort_order' => 1,
    ]);

    $this->get(route('video'))
        ->assertOk()
        ->assertSee('Окреме відео з нової вкладки');

    expect($videosCategory->videos)->toHaveCount(1);
});
