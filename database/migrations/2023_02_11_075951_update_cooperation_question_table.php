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
        Schema::create('cooperation_question', function (Blueprint $table) {
            $table->id('cqId');
            $table->integer('smId');
            $table->string('qCode');
            $table->string('question');
            $table->string('optA');
            $table->string('optB');
            $table->string('optC');
            $table->string('optD');
            $table->integer('question_level');
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
        Schema::dropIfExists('cooperation_question'); 
    }
};
