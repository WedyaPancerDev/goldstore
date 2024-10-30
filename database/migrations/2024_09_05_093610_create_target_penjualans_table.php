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
        Schema::create('target_penjualan', function (Blueprint $table) {
            $table->id();
            $table->enum('bulan', [
                'JAN',
                'FEB',
                'MAR',
                'APR',
                'MAY',
                'JUN',

                'JUL',
                'AUG',
                'SEP',
                'OCT',
                'NOV',
                'DEC'
            ]);
            $table->integer("total")->default(0);
            $table->string("status")->default("TIDAK TERPENUHI");
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_penjualans');
    }
};
