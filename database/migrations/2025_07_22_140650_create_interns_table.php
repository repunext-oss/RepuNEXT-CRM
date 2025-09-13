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
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Mobile');
            $table->date('Startdate');
            $table->date('Enddate');
            $table->string('Duration')->nullable();
            $table->string('Slot')->nullable();
            $table->string('Course')->nullable();
            $table->string('Source')->nullable();
            $table->string('Letter')->nullable();
            $table->string('Certificate')->nullable();
            $table->string('Documentation')->nullable();
            $table->string('Collage')->nullable();
            $table->string('Department')->nullable();
            $table->string('year')->nullable();
            $table->text('Area')->nullable();
            $table->string('City')->nullable();
            $table->string('Type')->nullable();
            $table->integer('Amount')->nullable();
            $table->string('amt')->nullable();
            $table->bigInteger('Status')->default(0);
            $table->bigInteger('i_isdeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
