<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('username', 'email');

            $table->dropColumn('remember_me');
            $table->dropColumn('active');
            $table->dropColumn('password_reset_token');
            $table->dropColumn('password_reset_expires');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('email', 'username');

            $table->string('remember_me')->nullable();
            $table->integer('active', false, true)->default(0);
            $table->string('password_reset_token', 64)->nullable();
            $table->dateTime('password_reset_expires')->nullable();

            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
        });
    }
}
