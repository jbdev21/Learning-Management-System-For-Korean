<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnailDetailsInAudioBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_books', function (Blueprint $table) {
            $table->enum('thumbnail_source_type', ['uploaded', 'link'])->after('source_folder')->default('uploaded'); // uploaded or link
            $table->string('thumbnail_source')->after('thumbnail_source_type')->nullable(); // its either link or in the server
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_books', function (Blueprint $table) {
            $table->dropColumn('thumbnail_source_type');
            $table->dropColumn('thumbnail_source');
        });
    }
}
