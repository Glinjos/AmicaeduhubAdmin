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
        Schema::create('course_batch_days', function (Blueprint $table) {
        
            $table->id('cbdId');

            $table->string('dayName')->comment('activity day name eg:DAY-1');
            $table->date('Date')->comment('day added date');

            $table->unsignedBigInteger('mId')->comment('which module->id');
            $table->foreign('mId')->references('mId')->on('module')->onDelete('cascade');

        
            $table->string('smId')->comment('which sub module->id');
           
            $table->unsignedBigInteger('cbId')->comment('course batch Id');
            $table->foreign('cbId')->references('cbId')->on('course_batches')->onDelete('cascade');
           
           

             $table->tinyInteger('isActive')->default('0')->comment('Active ->0,Not_active ->1');

             $table->tinyInteger('isExam')->default('0')->comment('not_EXAM ->0,EXAM->1');
           
            
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
        Schema::dropIfExists('course_batch_days');
    }
};
