<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('judul_produk');
            $table->string('gambar_produk')->nullable();
            $table->text('deskripsi_produk')->nullable();
            $table->integer('harga');
            $table->integer('diskon')->default(0);
            $table->integer('berat');
            $table->string('status_produk')->default('Aktif'); // 'Aktif'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk');
    }
};
