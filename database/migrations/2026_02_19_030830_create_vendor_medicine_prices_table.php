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
        Schema::create('vendor_medicine_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('medicine_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('price', 15, 2);
            $table->decimal('discount', 8, 2)->nullable();
            $table->integer('stock')->nullable();

            $table->timestamps();

            // 🔥 penting supaya tidak duplicate harga obat yang sama di vendor yang sama
            $table->unique(['vendor_id', 'medicine_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_medicine_prices');
    }
};
