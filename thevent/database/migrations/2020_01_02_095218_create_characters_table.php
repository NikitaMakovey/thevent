<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->bigInteger('role_id');
            $table->bigInteger('user_id');
            $table->bigInteger('event_id');
            $table->boolean('status')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['role_id', 'user_id', 'event_id']);
            $table->index('event_id');
            $table->index('role_id');
            $table->index('user_id');
            $table
                ->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
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
        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('role_id');
            $table->dropForeign('event_id');
            $table->dropIndex('characters_role_id_index');
            $table->dropIndex('characters_event_id_index');
            $table->dropIndex('characters_user_id_index');
            $table->dropColumn('role_id');
            $table->dropColumn('event_id');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('characters');
    }
}
