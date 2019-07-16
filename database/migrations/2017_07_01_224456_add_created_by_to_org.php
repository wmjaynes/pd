<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByToOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->references('id')->on('users');
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('last_updated_by')->nullable()->references('id')->on('users');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->references('id')->on('users');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('last_updated_by')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            //
        });
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
}
