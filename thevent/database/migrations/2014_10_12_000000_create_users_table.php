<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('first_name');
            $table->string('second_name');
            $table->string('third_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->unique();
            $table->string('password');
            $table->string('image', 300)->default('./images/thevent.jpg');
            $table->string('specialization')->nullable();
            $table->longText('info')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('sex');
            $table->date('birth_date')->nullable();
            $table->boolean('allow_status')->default(false);
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
