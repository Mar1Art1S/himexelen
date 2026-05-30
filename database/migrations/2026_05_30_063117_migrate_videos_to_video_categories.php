<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Insert default categories using DB builder
        $now = now();

        $generalId = DB::table('video_categories')->insertGetId([
            'name' => 'Загальні огляди',
            'slug' => 'zahalni-ohliady',
            'type' => 'general',
            'sort_order' => 10,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $assemblyId = DB::table('video_categories')->insertGetId([
            'name' => 'Збірка елементів вулика',
            'slug' => 'zbirka-elementiv-vulyka',
            'type' => 'assembly',
            'sort_order' => 20,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Associate existing videos
        // If column 'category' still exists (which it does), update video_category_id
        if (Schema::hasColumn('videos', 'category')) {
            DB::table('videos')->where('category', 'general')->update(['video_category_id' => $generalId]);
            DB::table('videos')->where('category', 'assembly')->update(['video_category_id' => $assemblyId]);
            DB::table('videos')->whereNull('video_category_id')->update(['video_category_id' => $assemblyId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For down, we don't have to do much since tables are dropped in other migrations
    }
};
