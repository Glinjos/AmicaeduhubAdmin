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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id('planId');
            $table->string('planName');
            $table->decimal('actualPrice');
            $table->decimal('offerPrice');
            $table->string('planDescription');
            $table->Integer('planValidity')->comment('In the context of subscriptions');
            $table->Integer('isExpired')->comment('expired=>1,not=>0');
            $table->Integer('previousQuestion');
            $table->Integer('videoClass');
            $table->Integer('crashCourse');
            $table->Integer('gameZone');
            $table->Integer('modelExams');


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
        Schema::dropIfExists('subscriptions');
    }
};
