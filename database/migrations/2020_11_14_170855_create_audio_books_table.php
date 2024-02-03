<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudioBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->string('title')->nullable();
            $table->integer('book_number')->nullable();
            $table->string('type')->default('series')->nullable();
            $table->string('type_name')->nullable();
            $table->text('author')->nullable();
            $table->text('ar_level')->nullable();
            $table->boolean('is_available')->default(1);
            $table->string('source_folder')->nullable();
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
        Schema::dropIfExists('audio_books');
    }
}
