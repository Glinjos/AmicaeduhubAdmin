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
        Schema::create('course_master', function (Blueprint $table) {
            $table->id('cmId');
            $table->string('coName')->comment('course name');
            $table->string('coDescription')->comment('course description');
            $table->double('coActivePrice');
            $table->double('coOfferPrice');
            $table->double('coDays')->comment('course duration');

            $table->tinyInteger('isClosed')->default('0')->comment('course_Not_close ->0,course_close ->1');
           
            
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
        Schema::dropIfExists('course_master');
    }
};
