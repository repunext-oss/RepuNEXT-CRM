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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incoming_msg_id');
            $table->unsignedBigInteger('outgoing_msg_id');
            $table->text('msg')->nullable();
            $table->string('attach')->nullable();
            $table->bigInteger('status')->default(0);
            $table->bigInteger('isdeleted')->default(0);
            $table->timestamps();

            
            $table->foreign('incoming_msg_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('outgoing_msg_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
