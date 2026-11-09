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
        Schema::create('refer_users_details', function (Blueprint $table) {
            $table->id('referUserdetails_Id');
            $table->date('date');
            $table->integer('refered_user_Id')->comment('refered user');
            $table->integer('refer_user_Id')->comment('refer user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reffer_users_details');
    }
};
