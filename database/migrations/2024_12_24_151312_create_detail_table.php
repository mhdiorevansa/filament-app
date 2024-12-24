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
        Schema::create('detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('faktur_id')->constrained('faktur')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('diskon');
            $table->string('nama_barang', 100);
            $table->bigInteger('harga');
            $table->bigInteger('sub_total');
            $table->integer('qty');
            $table->integer('hasil_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail');
    }
};
