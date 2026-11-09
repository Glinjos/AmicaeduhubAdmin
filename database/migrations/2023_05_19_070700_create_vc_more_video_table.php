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
        Schema::create('vc_more_videos', function (Blueprint $table) {
            $table->id('vcVDId');
            $table->Integer('vcChapterId')->comment('fk_vc_chapters');
            $table->string('videoHeading');
            $table->string('videoLink');
            $table->string('description');

            $table->tinyInteger('isPublished')->default('0');


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
        Schema::dropIfExists('vc_more_video');
    }
};
