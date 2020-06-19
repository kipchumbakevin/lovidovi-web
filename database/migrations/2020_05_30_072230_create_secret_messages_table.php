<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecretMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secret_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id');
            $table->string('receiver_id')->default(0);
            $table->integer('group_id')->default(0);
            $table->integer('chat_id')->default(0);
            $table->string('message');
            $table->boolean('has_media')->default(false);
            $table->boolean('receiver_read')->default(false);
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
        Schema::dropIfExists('secret_messages');
    }
}
