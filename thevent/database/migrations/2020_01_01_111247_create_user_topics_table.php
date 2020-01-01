<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_topics', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('topic_id');
            $table->primary(['user_id', 'topic_id']);
            $table->index('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->foreign('topic_id')
                ->references('id')
                ->on('topics')
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
        Schema::table('user_topics', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('topic_id');
            $table->dropIndex('user_topics_user_id_index');
            $table->dropColumn('user_id');
            $table->dropColumn('topic_id');
        });
        Schema::dropIfExists('user_topics');
    }
}
