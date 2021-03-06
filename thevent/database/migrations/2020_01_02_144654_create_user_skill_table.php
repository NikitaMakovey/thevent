<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_skill', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('skill_id');
            $table->integer('skill_factor');
            $table->unique(['user_id', 'skill_id']);
            $table->index('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_skill', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('skill_id');
            $table->dropIndex('user_skill_user_id_index');
            $table->dropColumn('user_id');
            $table->dropColumn('skill_id');
        });
        Schema::dropIfExists('user_skill');
    }
}
