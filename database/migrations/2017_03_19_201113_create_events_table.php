<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('venue_id')->nullable();
            $table->unsignedInteger('organization_id');
            $table->string('name');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->boolean('allDay')->default(0);
            $table->unsignedSmallInteger('repeatType')->default(0);
            $table->date('repeatEnd')->nullable();
            $table->string('timeInfo')->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('category')->nullable();
            $table->string('contactName')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
            $table->string('ticketInfo')->nullable();
            $table->boolean('free')->default(0);
            $table->text('imageUrl')->nullable()->comment("Web address of a logo for the organization or event");
            $table->text('flyerUrl')->nullable();
            $table->text('ticketUrl')->nullable();
            $table->text('altMapUrl')->nullable();
            $table->string('venueDetail')->nullable()->comment('Details about venue beyond the address. Like room number');
            $table->boolean('published')->default(0)->comment('Is event visible to world');
            $table->string('tags')->nullable();
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
        Schema::dropIfExists('events');
    }
}
