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
        Schema::create('brands', function (Blueprint $collection) {
            $collection->id();
            $collection->string('name');
            $collection->string('country');
            $collection->string('logo');
            $collection->string('logo_url');
            $collection->string('status');
            $collection->string('description');
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
        Schema::dropIfExists('brands');
    }
};
