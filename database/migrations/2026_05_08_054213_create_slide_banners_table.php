<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slide_banners', function (Blueprint $collection) {
            $collection->id();
            $collection->string('title');
            $collection->string('desc');
            $collection->string('image');
            $collection->ObjectId('creator');
            $collection->index('creator');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slide_banners');
    }
};
