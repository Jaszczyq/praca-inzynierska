<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEventCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('event_event_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('category_id');

            // Klucze obce do 'events' i 'event_categories'
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('category_id')->references('id')->on('event_categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_event_category');
    }
}
;
