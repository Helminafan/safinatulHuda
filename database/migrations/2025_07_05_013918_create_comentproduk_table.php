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
        Schema::create('comentproduk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            $table->string('nama_pengguna');
            $table->text('komentar');
            $table->string('email_pengguna')->nullable();
            $table->string('status')->default('Aktif'); // 'Aktif'
            $table->integer('rating')->default(0); // Rating 0-5
            $table->boolean('is_verified')->default(false); // Untuk verifikasi komentar
            $table->timestamp('tanggal_komentar')->useCurrent(); // Tanggal
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
        Schema::dropIfExists('comentproduk');
    }
};
