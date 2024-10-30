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
        Schema::table('produk', function (Blueprint $table) {
            $table->foreignId('kategori_id')->after('created_by')->references('id')->on('kategori');
        });

        Schema::table('assign_bonus', function (Blueprint $table) {
            $table->foreignId('transaksi_pengeluaran_id')->after('id')->references('id')->on('transaksi_pengeluaran');
            $table->foreignId('user_id')->after('transaksi_pengeluaran_id')->references('id')->on('users');
            $table->foreignId('bonus_id')->after('user_id')->references('id')->on('master-bonus');
        });

        Schema::table('target_penjualan', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->references('id')->on('users');
        });

        Schema::table('transaksi_pengeluaran', function (Blueprint $table) {
            $table->foreignId('produk_id')->after('order_date')->references('id')->on('produk');
            $table->foreignId('user_id')->after('produk_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
