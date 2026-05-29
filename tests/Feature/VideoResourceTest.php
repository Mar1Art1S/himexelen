<?php

use App\Filament\Resources\Videos\Pages\ListVideos;
use App\Models\User;
use App\Models\Video;
use Database\Seeders\AdminAndContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminAndContentSeeder::class);
});

test('admin can delete a video material from the list page', function () {
    $admin = User::where('email', 'admin@himexelen.test')->first();
    $this->actingAs($admin);

    $video = Video::first();
    expect($video)->not->toBeNull();

    Livewire::test(ListVideos::class)
        ->assertTableActionExists('delete')
        ->callTableAction('delete', $video);

    expect(Video::find($video->id))->toBeNull();
});
