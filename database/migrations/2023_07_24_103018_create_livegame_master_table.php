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
        Schema::create('livegame_master', function (Blueprint $table) {
            $table->id('lgmId');
            $table->longText('questionId');
            $table->dateTime('dateTime');
            $table->integer('playerId');
            $table->string('playerNickname');
            $table->integer('opponentId');
            $table->string('opponentNickname');
            $table->tinyInteger('isAvail')->default('0')->comment('user (player) those who are, ie. the whole game is not live, live, completed, or exited by user ; 0 => notLive, 1=> isLive, 2=> Completed, 3=> Exited');

            $table->string('created_by')->default('0');
            $table->timestamp('created_at')->useCurrent();
            $table->string('updated_by')->default('0');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livegame_master');
    }
};
