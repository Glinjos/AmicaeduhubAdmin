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
        Schema::create('course_batches', function (Blueprint $table) {

                $table->id('cbId');

                $table->unsignedBigInteger('cmId')->comment('course master id');
                $table->foreign('cmId')->references('cmId')->on('course_master')->onDelete('cascade');
    
                $table->string('cbatchName')->comment('course batch');
                $table->date('cbatchStartDate')->comment('batch starting date');
                $table->date('cbatchEndDate')->comment('batch end date');
              
                $table->double('cbatchDays')->comment('Number Of Days');
    
                $table->tinyInteger('isClosed')->default('0')->comment('batch_Not_close ->0,batch_close ->1');
               
                
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
        Schema::dropIfExists('course_batches');
    }
};
