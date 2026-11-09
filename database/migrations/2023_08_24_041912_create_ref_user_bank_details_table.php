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
        Schema::create('ref_user_bank_details', function (Blueprint $table) {
            $table->id('userbank_Id');

            $table->integer('b_userId')->comment('user dtails table uId');

            $table->integer('ac_number')->comment('user account number');
            $table->string('upi_number')->comment('user upi number');
            $table->string('upi_id')->comment('user upi id');
            $table->string('ifc_code')->comment('user ifc code');

            $table->string('ac_holder_name')->comment('account holder name');

            $table->text('remark')->nullable();

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
        Schema::dropIfExists('ref_user_bank_details');
    }
};
