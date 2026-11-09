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
        Schema::create('gz_history', function (Blueprint $table) {
            $table->id('ghId');
            $table->unsignedBigInteger('giId');
            $table->foreign('giId')->references('giId')->on('gz_initialization')->onDelete('cascade');
            $table->integer('userId');
            $table->Integer('winnerId');
            $table->Integer('totalQuestion');
            $table->Integer('attendedQuestions');
            $table->Integer('rightAns');
            $table->Integer('wrongAns');
            $table->Integer('score');
            $table->tinyInteger('isPlayer')->default('0')->comment('isPlayer => 1, not => 0');
            $table->tinyInteger('isOpponent')->default('0')->comment('isOpponent => 1, not => 0');
            
            $table->tinyInteger('isAvail')->default('0');

            $table->string('created_by');
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
        Schema::dropIfExists('gz_history');
    }
};
