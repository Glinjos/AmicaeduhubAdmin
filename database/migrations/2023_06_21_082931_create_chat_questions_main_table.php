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
        Schema::create('chat_questions_main', function (Blueprint $table) {
            $table->id('chatQuestionId');

            $table->unsignedBigInteger('uId')->comment('User details. table user Id');
            $table->foreign('uId')->references('uId')->on('user_details')->onDelete('cascade');

            $table->unsignedBigInteger('chatTypeId')->comment('Chat Type. table type Id');
            $table->foreign('chatTypeId')->references('chatTypeId')->on('chat_type')->onDelete('cascade');

            // $table->unsignedBigInteger('mId')->comment('Main Exam Module. table module Id');
            // $table->foreign('mId')->references('mId')->on('module')->onDelete('cascade');
            $table->integer('mId')->nullable();
            // $table->text('question');

            // $table->dateTime('chatDateTime');
          

            $table->integer('isClosed')->default('0');
            $table->integer('assigned')->default('0');

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
        Schema::dropIfExists('chat_questions_main');
    }
};
