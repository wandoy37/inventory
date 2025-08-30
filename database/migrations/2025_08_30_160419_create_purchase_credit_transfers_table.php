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
        Schema::create('purchase_credit_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_credit_id');
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('rekening_vendor_id');
            $table->string('reference_number');

            $table->foreign('purchase_credit_id')->references('id')->on('purchase_credits')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('rekening_vendor_id')->references('id')->on('rekening_vendors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_credit_transfers');
    }
};
