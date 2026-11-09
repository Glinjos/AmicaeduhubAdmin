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
        Schema::create('livegame_history', function (Blueprint $table) {
            $table->id('lghId');
            $table->unsignedBigInteger('lgmId');
            $table->foreign('lgmId')->references('lgmId')->on('livegame_master')->onDelete('cascade');
            $table->integer('userId')->comment('A user who is either a player or an opponent');
            $table->string('nickname')->comment('nickname of the user in this particular game');
            $table->integer('winnerId')->comment('Winner of this particular game (refer id of game, lgmId )');
            $table->integer('totalQuestions');
            $table->Integer('attendedQuestions');
            $table->Integer('rightAns');
            $table->Integer('wrongAns');
            $table->string('score');
            $table->tinyInteger('isAvail')->default('0');
            
            $table->string('created_by')->default('0');
            $table->dateTime('created_at')->comment('Start time of the game');
            $table->string('updated_by')->default('0');
            $table->dateTime('updated_at')->comment('End time of the game');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livegame_history');
    }
};
