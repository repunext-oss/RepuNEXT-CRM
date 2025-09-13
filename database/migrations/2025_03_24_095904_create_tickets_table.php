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
            $table->string('client_user_id');
            $table->string('ticket_subject');
            $table->string('ticket_description');
            $table->string('product')->nullable();
            $table->string('ticket_prority')->nullable();
            $table->string('attachments')->nullable();
            $table->bigInteger('ticket_status')->default(0);
            $table->bigInteger('isdeleted')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
