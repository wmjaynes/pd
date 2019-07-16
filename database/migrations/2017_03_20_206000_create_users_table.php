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
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
//            $table->string('userId')->unique();
            $table->string('password', 256)->nullable();
            $table->rememberToken();
            $table->timestamp('lastLoggedIn')->nullable();
            $table->boolean('blocked')->default(false);
            $table->boolean('activated')->default(true);
            $table->boolean('superuser')->default(false);
            $table->unsignedInteger('activeOrganization')->nullable();
            $table->foreign('activeOrganization')->references('id')->on('organizations');
            $table->timestamp('email_verified_at')->nullable();
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
