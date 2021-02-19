<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('famouses', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->integer('femaleMusic')->default(0);
            $table->integer('maleMusic')->default(0);
            $table->integer('femaleActor')->default(0);
            $table->integer('maleActor')->default(0);
            $table->integer('president')->default(0);
            $table->integer('football')->default(0);
            $table->integer('business')->default(0);
            $table->integer('basketball')->default(0);
            $table->integer('models')->default(0);
            $table->integer('carlogos')->default(0);
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
        Schema::dropIfExists('famouses');
    }
}
