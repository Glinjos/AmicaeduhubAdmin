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
        Schema::create('users_revisions', function (Blueprint $table) {
            $table->id('u_RevId');
            $table->date('dateAndTime');
            $table->integer('userId');
            $table->integer('totalQuestions')->comment('No. of Total questions in the revison');
            $table->integer('QuestionsAttended')->comment('No. of QuestionsAttended in the revision');
            $table->integer('rightAns')->comment('No. of Right Answer in the revision');
            $table->string('percentage')->comment('Percentage in the revision');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('users_revisions');
    }
};
