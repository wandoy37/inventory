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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('item_unit_type_id');
            $table->integer('quantity');
            $table->bigInteger('price_buy');
            $table->bigInteger('price_sell');
            $table->bigInteger('price_total');
            $table->enum('status', ['purchase', 'return']);
            $table->text('note')->nullable();

            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('item_unit_type_id')->references('id')->on('item_unit_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
