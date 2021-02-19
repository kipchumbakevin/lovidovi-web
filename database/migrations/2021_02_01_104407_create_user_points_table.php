<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('pin');
            $table->integer('points')->default(0);
            $table->integer('actor')->default(0);
            $table->integer('billion')->default(0);
            $table->integer('convict')->default(0);
            $table->integer('virgin')->default(0);
            $table->integer('student')->default(0);
            $table->integer('car')->default(0);
            $table->integer('medicine')->default(0);
            $table->integer('plastic')->default(0);
            $table->integer('african')->default(0);
            $table->integer('jobless')->default(0);
            $table->integer('pet')->default(0);
            $table->integer('pass')->default(0);
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
        Schema::dropIfExists('user_points');
    }
}
