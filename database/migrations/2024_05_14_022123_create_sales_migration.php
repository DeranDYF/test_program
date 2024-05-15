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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->integer('harga');
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->string('telp');
            $table->timestamps();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->datetime('tgl');
            $table->unsignedBigInteger('cust_id');
            $table->integer('jumlah_barang');
            $table->integer('subtotal');
            $table->integer('diskon');
            $table->integer('ongkir');
            $table->integer('total_bayar');
            $table->foreign('cust_id')->references('id')->on('customers');
            $table->timestamps();
        });

        Schema::create('saledets', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('harga_bandrol');
            $table->integer('qty');
            $table->integer('diskon_pct');
            $table->integer('diskon_nilai');
            $table->integer('harga_diskon');
            $table->integer('total_harga');
            $table->foreign('sales_id')->references('id')->on('sales');
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('saledets');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('barangs');
    }
};
