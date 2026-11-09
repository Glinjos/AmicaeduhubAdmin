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
        Schema::create('p_questions', function (Blueprint $table) {
            $table->id('pqId');
           // $table->integer('pqmId');
           // $table->integer('pqsmId');
            $table->unsignedBigInteger('pqsmId');
            $table->foreign('pqsmId')->references('pqsmId')->on('pq_submodule')->onDelete('cascade');

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
        Schema::dropIfExists('p_questions');
    }
};
