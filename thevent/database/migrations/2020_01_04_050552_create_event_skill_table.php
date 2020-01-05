<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_skill', function (Blueprint $table) {
            $table->bigInteger('event_id');
            $table->bigInteger('skill_id');
            $table->integer('skill_factor');
            $table->unique(['event_id', 'skill_id']);
            $table->index('event_id');
            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
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
        Schema::table('event_skill', function (Blueprint $table) {
            $table->dropForeign('event_id');
            $table->dropForeign('skill_id');
            $table->dropIndex('event_skill_user_id_index');
            $table->dropColumn('event_id');
            $table->dropColumn('skill_id');
        });
        Schema::dropIfExists('event_skill');
    }
}
