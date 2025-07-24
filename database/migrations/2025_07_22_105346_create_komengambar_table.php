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
        Schema::create('komengambar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komen_id')->constrained('comentproduk')->onDelete('cascade')->onUpdate('cascade');
            $table->string('foto_komentar');
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
        Schema::dropIfExists('komengambar');
    }
};
