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
        Schema::create('daily_exam', function (Blueprint $table) {
            $table->id('dId');
            $table->string('examName');
            $table->date('examdate');
            $table->string('timeFrom');
            $table->string('timeTo');
            $table->string('modulesId')->comment('exam modules');
            $table->integer('noOfQuestions')->comment('total Qusetion for exam');
            $table->string('postiveMark')->comment('exam positive mark(1 or .5)');
            $table->string('negativeMark')->comment('exam negative mark');
            $table->integer('isExpired')->comment('0->Active,1->Expired')->default('0');
           
          
            
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
        Schema::dropIfExists('daily_exam');
    }
};
