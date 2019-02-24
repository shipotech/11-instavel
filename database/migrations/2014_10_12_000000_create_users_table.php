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
            $table->increments('id');
            $table->string('role', 20)->default('user');
            $table->string('name', 100);
            $table->string('surname', 200)->nullable();
            $table->string('nick', 100);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('image', 255)->nullable();
            $table->string('drive_id', 255)->nullable();
            $table->timestamps();
            $table->rememberToken();

            // Commands (Charset and collation is for work with emojis)
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_520_ci';
//            $table->timestamp('email_verified_at')->nullable();
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
