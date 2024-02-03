<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuzzleWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puzzle_words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('word_puzzle_id');
            $table->text('clue');
            $table->string('answer');
            $table->enum('orrientation', ['across', 'down'])->default('across');
            $table->timestamps();

            $table->foreign('word_puzzle_id')->references('id')->on('word_puzzles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puzzle_words');
    }
}
