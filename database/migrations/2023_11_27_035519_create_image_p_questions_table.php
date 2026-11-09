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
        Schema::create('image_p_questions', function (Blueprint $table) {
             $table->id('ipqId');
             $table->integer('pqsmId');

            // $table->string('image_url')->comment('the question image path')->nullable();
           
             $table->text('question');
 
             $table->text('optionA');
             $table->text('optionB');
             $table->text('optionC');
             $table->text('optionD');
 
             $table->tinyInteger('isAvail')->default('0');
            
             
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
        Schema::dropIfExists('image_p_questions');
    }
};
