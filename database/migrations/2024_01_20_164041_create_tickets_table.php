<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("event_id");
            $table->unsignedBigInteger('ticket_type_id');
            $table->unsignedBigInteger('user_id');
            $table->string("seat");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("ticket_type_id")->references("id")->on("ticket_types")->onDelete("cascade");
            $table->foreign("event_id")->references("id")->on("events")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
