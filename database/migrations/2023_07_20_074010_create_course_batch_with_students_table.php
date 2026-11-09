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
        Schema::create('course_batch_with_students', function (Blueprint $table) {

            $table->id('cbwsId');

             $table->unsignedBigInteger('cbId')->comment('course Batches table id');
             $table->foreign('cbId')->references('cbId')->on('course_batches')->onDelete('cascade');

             $table->unsignedBigInteger('uId')->comment('User_details table users Id');
             $table->foreign('uId')->references('uId')->on('user_details')->onDelete('cascade');
           
            //  $table->unsignedBigInteger('csId')->comment('course subscriber Id');
            //  $table->foreign('csId')->references('csId')->on('course_subscribers')->onDelete('cascade');
           
            // $table->date('Active_Date')->comment('added to the batch');
           

             $table->tinyInteger('isActive')->default('0')->comment('Active ->0,Not_active ->1');
           
            
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
        Schema::dropIfExists('course_batch_with_students');
    }
};
