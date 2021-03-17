<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThisThatUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('this_that_users', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->integer('pin');
            $table->integer('lifestyle')->default(0);
            $table->integer('food')->default(0);
            $table->integer('celebrity')->default(0);
            $table->integer('partner')->default(0);
            $table->integer('complete')->default(0);
            $table->integer('would')->default(0);
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
        Schema::dropIfExists('this_that_users');
    }
}
