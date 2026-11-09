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
        Schema::create('vc_exams', function (Blueprint $table) {
            $table->id('vcExamId');
          
            $table->unsignedBigInteger('vcVDId');
            $table->foreign('vcVDId')->references('vcVDId')->on('vc_more_videos')->onDelete('cascade');

            $table->text('question');

            $table->text('optionA');
            $table->text('optionB');
            $table->text('optionC');
            $table->text('optionD');

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
        Schema::dropIfExists('vc_exams');
    }
};
