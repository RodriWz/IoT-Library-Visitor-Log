<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('password_otps', function (Blueprint $table) {
            $table->integer('resend_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('password_otps', function (Blueprint $table) {
            $table->dropColumn('resend_count');
        });
    }
};
