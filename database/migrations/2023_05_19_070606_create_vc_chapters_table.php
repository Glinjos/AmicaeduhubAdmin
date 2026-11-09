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
        Schema::create('vc_chapters', function (Blueprint $table) {
            $table->id('vcChapterId');
            $table->Integer('vcmId')->comment('fk_vc_module');
            $table->string('vcChapterName');

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
        Schema::dropIfExists('vc_chapters');
    }
};
