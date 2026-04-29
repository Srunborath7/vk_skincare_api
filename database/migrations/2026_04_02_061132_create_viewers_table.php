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
        Schema::create('viewers', function (Blueprint $collection) {
            $collection->id();
            $collection->double('rating',3,2);
            $collection->string('comment');
            $collection->ObjectId('product_id');
            $collection->ObjectId('creator');
            $collection->index('product_id');
            $collection->index('creator');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viewers');
    }
};
