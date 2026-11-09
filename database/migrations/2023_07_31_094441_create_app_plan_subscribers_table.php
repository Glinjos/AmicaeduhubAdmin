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
        Schema::create('app_plan_subscribers', function (Blueprint $table) {
           
            
            $table->id('apsId');

            $table->unsignedBigInteger('planId')->comment('subscriptions table plan Id');
            $table->foreign('planId')->references('planId')->on('subscriptions')->onDelete('cascade');
  
            $table->unsignedBigInteger('uId')->comment('User_details table users Id');
            $table->foreign('uId')->references('uId')->on('user_details')->onDelete('cascade');
           
            $table->date('startDate')->comment('User added plan start date');
            $table->date('endDate')->comment('User added plan end date');
        
            $table->tinyInteger('isExpired')->default('0')->comment('not_EXPIRED ->0,EXPIRED->1');
    
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
        Schema::dropIfExists('app_plan_subscribers');
    }
};
