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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode_produk')->unique();
            $table->enum('satuan', ['pcs', 'kg', 'gr', 'mg', 'ml', 'l', 'm', 'cm', 'mm', 'inch', 'feet', 'yard']);
            $table->double('harga_beli')->default(0);
            $table->double('harga_jual')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->double("stok")->default(0);
            $table->boolean("is_deleted")->default(0);
            $table->foreignId("created_by")->references("id")->on("users");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
