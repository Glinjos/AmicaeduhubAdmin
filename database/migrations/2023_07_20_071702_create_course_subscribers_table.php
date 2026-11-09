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
        Schema::create('course_subscribers', function (Blueprint $table) {
            $table->id('csId');

            $table->unsignedBigInteger('cmId')->comment('course master id');
            $table->foreign('cmId')->references('cmId')->on('course_master')->onDelete('cascade');

            $table->unsignedBigInteger('uId')->comment('User_details table users Id');
            $table->foreign('uId')->references('uId')->on('user_details')->onDelete('cascade');
           
            $table->date('csDate')->comment('course subscribed date');
            

             $table->tinyInteger('isAddtoBatch')->default('0')->comment('not added->0,added->1');
           
            
           
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
        Schema::dropIfExists('course_subscribers');
    }
};
