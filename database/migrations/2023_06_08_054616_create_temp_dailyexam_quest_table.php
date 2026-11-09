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
        Schema::create('temp_dailyexam_quest', function (Blueprint $table) {
            $table->id('tdqId');
          
            $table->unsignedBigInteger('dId');
            $table->foreign('dId')->references('dId')->on('daily_exam')->onDelete('cascade');

            $table->text('question');

            $table->text('optionA');
            $table->text('optionB');
            $table->text('optionC');
            $table->text('optionD');

           
            
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
        Schema::dropIfExists('temp_dailyexam_quest');
    }
};
