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
        Schema::create('harga_produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biaya_produksi_id')
                ->references('id')
                ->on('biaya_produksi')
                ->onDelete('cascade');
            $table->double('harga')->nullable();
            $table->integer('bulan')->length(2)->nullable();
            $table->integer('tahun')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_produksi');
    }
};
