<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('name');
            $table->integer('branch_id')->nullable();
            $table->string('contact_number')->nullable();
            $table->enum('type', ['administrator', 'sub-administrator', 'teacher' ,'student'])->default('teacher');

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(bcrypt('password'));
            
            // parent contact
            $table->string('parent_contact_number')->nullable();


            $table->boolean('is_active')->default(1);
            $table->string('status')->default('waiting'); // for teacher only
            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
