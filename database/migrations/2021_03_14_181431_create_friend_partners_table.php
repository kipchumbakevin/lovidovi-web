<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_partners', function (Blueprint $table) {
            $table->id();
            $table->integer('self_id');
            $table->integer('category_id');
            $table->string('evaluatorPhone');
            $table->string('evaluateePhone');
            $table->string('evaluatorChoice');
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
        Schema::dropIfExists('friend_partners');
    }
}
