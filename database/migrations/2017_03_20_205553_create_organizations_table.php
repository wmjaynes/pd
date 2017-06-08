<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postalCode')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('contactName')->nullable();
            $table->string('url')->comment("Web address of the organization web site")->nullable();
            $table->string('logoUrl')->nullable();
            $table->string('facebookUrl')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
