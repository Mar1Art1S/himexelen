<?php

use App\Filament\Resources\VideoSections\Pages\ListVideoSections;
use App\Models\User;
use App\Models\Video;
use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminAndContentSeeder::class);
});

test('the ВІДЕО admin page lists only videos from the videos-type section', function () {
    $admin = User::where('email', 'admin@himexelen.test')->first();
    $this->actingAs($admin);

    $sectionVideos = Video::whereHas('category', fn ($q) => $q->where('type', 'videos'))->get();
    $generalVideo = Video::whereHas('category', fn ($q) => $q->where('type', 'general'))->first();

    expect($sectionVideos)->not->toBeEmpty()
        ->and($generalVideo)->not->toBeNull();

    Livewire::test(ListVideoSections::class)
        ->assertCanSeeTableRecords($sectionVideos)
        ->assertCanNotSeeTableRecords([$generalVideo]);
});

test('the ВІДЕО admin page is reachable through its resource route', function () {
    $admin = User::where('email', 'admin@himexelen.test')->first();

    $this->actingAs($admin)
        ->get('/admin/video-section')
        ->assertOk();
});
