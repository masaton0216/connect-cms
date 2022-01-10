<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnViewPageIdViewFrameIdFromDatabasesFrames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('databases_frames', function (Blueprint $table) {
            $table->dropColumn('view_page_id');
            $table->dropColumn('view_frame_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('databases_frames', function (Blueprint $table) {
            $table->integer('view_page_id')->nullable()->comment('表示ページ')->after('default_hide');
            $table->integer('view_frame_id')->nullable()->comment('表示フレーム')->after('view_page_id');
        });
    }
}
