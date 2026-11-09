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
        Schema::create('gz_initialization', function (Blueprint $table) {
            $table->id('giId');
            $table->string('gameType')->comment('One to One,One to Many');
            $table->date('date_time');            
            $table->Integer('moduleId');
            $table->string('chapterId');

            $table->Integer('gameMode')->comment('1=>Easy,2=>Medium,3=>Hard');
            $table->Integer('noOfQuestions')->comment('20 0r 40');

            $table->Integer('playerId');
            $table->string('opponentId');

            $table->Integer('firstOpponentId');


            $table->Integer('isAccepted')->comment('Accepted=>1,notAccepted=>0');
            $table->Integer('isExpired')->comment('expired=>1,not=>0');
            
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
        Schema::dropIfExists('gz_initialization');
    }
};
