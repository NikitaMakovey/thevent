<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('short_description');
            $table->string('image', 300);
            $table->longText('full_description');
            $table->bigInteger('user_id');
            $table->bigInteger('topic_id');
            $table->boolean('status')->nullable();
            $table->date('event_date');
            $table->time('time_interval');
            $table->string('address');
            $table->timestamps();
            $table->index('topic_id');
            $table->index('event_date');
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
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('topic_id');
            $table->dropIndex('events_user_id_index');
            $table->dropIndex('events_topic_id_index');
            $table->dropColumn('user_id');
            $table->dropColumn('topic_id');
        });
        Schema::dropIfExists('events');
    }
}
