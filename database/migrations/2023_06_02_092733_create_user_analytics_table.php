<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_analytics', function (Blueprint $table) {
            $table->id('aId');
            $table->date('dateAndTime');
            $table->integer('courseType')->comment('1 = Main Exam, 2 = Previous Questions, 3 = Video Classes, 4 = Game Zone');
            $table->integer('userId');
            $table->integer('examTypeId')->comment('Main Category ex: pqmain (ex: cseb, psc)');
            $table->integer('examModuleId')->comment('Category ex: Module (ex: 2018 (year))');
            $table->integer('examSubModuleId')->comment('Sub Category ex: Sub Module (ex: Junior Clerk 2018)');
            $table->integer('vcChapterVideoId')->comment('For Video Courses, Id of video from a chapter')->default('0');
            $table->integer('totalQuestions')->comment('No. of Total questions in the exam');
            $table->integer('QuestionsAttended')->comment('No. of QuestionsAttended in the exam')->default('0');
            $table->integer('rightAns')->comment('No. of Right Answer in the exam')->default('0');
            $table->integer('wrongAns')->comment('No. of Wrong Answer in the exam')->default('0');
            $table->string('score')->comment('Total Score in the exam')->default('0');
            $table->string('percentage')->comment('Percentage in the exam')->default('0');
            $table->integer('playerId')->comment('Only for GZ')->default('0');
            $table->integer('opponentId')->comment('Only for GZ')->default('0');
            $table->integer('playerAttended')->comment('Only for GZ')->default('0');
            $table->integer('playerRightAns')->comment('Only for GZ')->default('0');
            $table->integer('playerWrongAns')->comment('Only for GZ')->default('0');
            $table->string('playerScore')->comment('Only for GZ')->default('0');
            $table->string('playerPercentage')->comment('Only for GZ')->default('0');
            $table->integer('opponentAttended')->comment('Only for GZ')->default('0');
            $table->integer('opponentRightAns')->comment('Only for GZ')->default('0');
            $table->integer('opponentWrongAns')->comment('Only for GZ')->default('0');
            $table->string('opponentScore')->comment('Only for GZ')->default('0');
            $table->string('opponentPercentage')->comment('Only for GZ')->default('0');
            $table->integer('winnerId')->comment('Only for GZ')->default('0');
            
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
        Schema::dropIfExists('user_analytics');
    }
};
