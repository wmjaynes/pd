<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->string('name');
            $table->string('streetAddress')->nullable();
            $table->string('addressLocality')->comment('Probably the city');
            $table->string('addressRegion');
            $table->string('addressCountry')->nullable();
            $table->string('postalCode')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->boolean('approved')->default(0);
            $table->unsignedInteger('created_by')->default(135)->references('id')->on('users');
            $table->unsignedBigInteger('event_id')->nullable()->references('id')->on('events');
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
        Schema::dropIfExists('venues');
    }
}
