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
        Schema::create('chat_questions_ans', function (Blueprint $table) {
            $table->id('chatQuestionAnsId');

            $table->unsignedBigInteger('chatQuestionId')->comment('chat question(doubt). table  Id');
            $table->foreign('chatQuestionId')->references('chatQuestionId')->on('chat_questions_main')->onDelete('cascade');

           

            $table->integer('AssignedTo')->comment('super Admin assigning admin')->default('0');
            $table->integer('AssignedBy');

            $table->text('Answer')->nullable();

            $table->string('created_by');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('updated_by')->default('0');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_questions_ans');
    }
};
