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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id('uId');

           // $table->string('planId');
            $table->unsignedBigInteger('planId')->default('0');
            $table->foreign('planId')->references('planId')->on('subscriptions')->onDelete('cascade');
       
            $table->string('name');
            $table->bigInteger('mobile');

            $table->integer('userGender')->nullable();
            $table->string('userAddress')->nullable();

            $table->integer('otp');
            $table->string('userImage')->nullable();
            $table->string('userEmail')->nullable();

            $table->date('dob')->comment('date of birth')->nullable();
            $table->bigInteger('district_Id')->nullable();

            $table->string('onlinetoken');

            $table->tinyInteger('ActiveUser')->comment('not_Active->0,Active->1')->default('0');
            
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
        Schema::dropIfExists('user_details');
    }
};
