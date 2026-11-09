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
        Schema::create('ref_payment_request', function (Blueprint $table) {
            $table->id('request_Id');
            $table->date('req_date')->comment('requested date');
            $table->integer('req_user_Id')->comment('user Id');

            $table->integer('req_coin')->comment('radeem all coin');

            $table->tinyInteger('isRequested')->default('0')->comment('0->pending,1->accepted,2->approved');
            $table->date('req_accepted_date')->comment('request Accepted date')->nullable();

            $table->text('remark')->nullable();

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
        Schema::dropIfExists('ref_payment_request');
    }
};
