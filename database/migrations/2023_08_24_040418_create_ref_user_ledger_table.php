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
        Schema::create('ref_user_ledger', function (Blueprint $table) {
            $table->id('userledger_Id');
            $table->date('date');
            $table->integer('user_Id')->comment('user_details table uId');

            $table->double('user_debit')->nullable();
            $table->double('user_credit')->nullable();

            $table->integer('request_Id')->default('0')->comment('payment requested id');

            $table->tinyInteger('payment_mode')->default('0')->comment('0->coin,1->Gpay');

            $table->text('remark')->nullable();

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
        Schema::dropIfExists('ref_user_ledger');
    }
};
