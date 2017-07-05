<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAggregatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aggregates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aggregator_id');
            $table->foreign('aggregator_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unsignedInteger('aggregatee_id');
            $table->foreign('aggregatee_id')->references('id')->on('organizations')->onDelete('cascade');;

            $table->index(['aggregator_id', 'aggregatee_id']);

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
        Schema::dropIfExists('aggregates');
    }
}
