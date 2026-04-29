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
        Schema::create('products', function (Blueprint $collection) {
            $collection->id();
            $collection->string('name');
            $collection->string('sku');
            $collection->string('barcode');
            $collection->array('tags');
            $collection->double('price', 10, 2);
            $collection->double('cost_price', 10, 2);
            $collection->double('discount',10,2);
            $collection->integer('stock');
            $collection->boolean('status');
            $collection->double("rating",3,2);
            $collection->integer('review_count')->default(0);
            $collection->string('description');
            $collection->array('image');
            $collection->array('image_url');
            $collection->ObjectId('brand_id');
            $collection->ObjectId('creator');
            $collection->ObjectId('category_id');
            $collection->index('brand_id');
            $collection->index('creator');
            $collection->index('category_id');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
