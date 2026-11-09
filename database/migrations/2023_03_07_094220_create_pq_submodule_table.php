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
        Schema::create('pq_submodule', function (Blueprint $table) {
            $table->id('pqsmId');
           // $table->integer('pqmId');
            $table->unsignedBigInteger('pqmId');
            $table->foreign('pqmId')->references('pqmId')->on('pq_module')->onDelete('cascade');

            $table->text('pqsmName');

            $table->tinyInteger('isAvail')->default('0');
           
            
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
        Schema::dropIfExists('pq_submodule');
    }
};
