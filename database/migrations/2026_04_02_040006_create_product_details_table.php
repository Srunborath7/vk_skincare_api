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
        Schema::create('product_details', function (Blueprint $collection) {
            $collection->id();
            $collection->array('image_details');
            $collection->array('skin_type');
            $collection->string('product_type');
            $collection->array('ingredients');
            $collection->array('benefits');
            $collection->string('usage');
            $collection->string('volume_unit');
            $collection->string('texture');
            $collection->string('origin_country');
            $collection->date('expiry_date');
            $collection->date('manufacture_date');
            $collection->ObjectId('product_id');
            $collection->index('product_id');
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
        Schema::dropIfExists('product_details');
    }
};
