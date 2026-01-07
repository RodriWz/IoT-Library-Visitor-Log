<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('visitors', function (Blueprint $table) {
        $table->id();
        $table->string('nama');     // Tambahkan ini
        $table->string('nim');      // Tambahkan ini
        $table->string('prodi');    // Tambahkan ini
        $table->text('tujuan');     // Tambahkan ini
        $table->string('ip_address')->nullable();
        $table->text('user_agent')->nullable();
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('visitors');
    }
};