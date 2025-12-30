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
        Schema::create('shop_related_products', function (Blueprint $table) {
            $table->uuid('parent_id')->index();
            $table->uuid('children_id')->index();
            $table->primary(['parent_id', 'children_id']);

            $table->foreign('parent_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('RESTRICT');

            $table->foreign('children_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_related_products');
    }
};
