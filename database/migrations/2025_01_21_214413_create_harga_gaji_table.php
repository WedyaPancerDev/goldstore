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
        Schema::create('harga_gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biaya_gaji_id')
                ->references('id')
                ->on('biaya_gaji')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->double('harga')->nullable();
            $table->integer('bulan')->length(2)->nullable();
            $table->integer('tahun')->nullable();
            $table->boolean("is_deleted")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_gaji');
    }
};
