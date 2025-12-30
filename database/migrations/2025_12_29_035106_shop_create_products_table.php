<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name')->index();
            $table->string('slug')->unique()->index();
            $table->text('short_description');
            $table->longText('description');
            $table->longText('specification')->nullable();
            $table->boolean('featured')->default(false)->index();
            $table->boolean('published')->default(false)->index();
            $table->uuid('category_id')->index();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};
