<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMkulimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mkulimas', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->integer('pin');
            $table->integer('paid')->default(0);
            $table->string('inviteCode')->unique();
            $table->integer('videos')->default(0);
            $table->integer('referrals')->default(0);
            $table->integer('total')->default(0);
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
        Schema::dropIfExists('mkulimas');
    }
}
