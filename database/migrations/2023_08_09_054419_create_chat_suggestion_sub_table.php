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
        Schema::create('chat_suggestion_sub', function (Blueprint $table) {

            $table->id('cssubId');

            $table->unsignedBigInteger('chatQuestionId')->comment('chat question main id');
            $table->foreign('chatQuestionId')->references('chatQuestionId')->on('chat_questions_main')->onDelete('cascade');

        
            $table->text('suggestions');

            $table->dateTime('chatDateTime');
          

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
        Schema::dropIfExists('chat_suggestion_sub');
    }
};
