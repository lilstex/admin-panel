<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->string('product_image')->nullable();
            $table->string('product_name');
            $table->float('product_price');
            $table->float('product_discount')->nullable();
            $table->float('final_price');
            $table->string('discount_type')->nullable();
            $table->string('meta_title');
            $table->string('meta_desc');
            $table->string('meta_keywords');
            $table->text('desc')->nullable();
            $table->string('keywords')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_color')->nullable();
            $table->string('family_color')->nullable();
            $table->string('group_code')->nullable();
            $table->string('product_weight')->nullable();
            $table->string('fabric')->nullable();
            $table->string('pattern')->nullable();
            $table->string('sleeve')->nullable();
            $table->text('wash_care')->nullable();
            $table->enum('is_featured', ['Yes', 'No']);
            $table->tinyInteger('status');
            $table->timestamps();
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
