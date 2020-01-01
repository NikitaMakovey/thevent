<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('role_id');
            $table->primary(['user_id', 'role_id']);
            $table->index('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->foreign('role_id')
                ->references('id')
                ->on('roles')
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
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('role_id');
            $table->dropIndex('user_roles_user_id_index');
            $table->dropColumn('user_id');
            $table->dropColumn('role_id');
        });
        Schema::dropIfExists('user_roles');
    }
}
