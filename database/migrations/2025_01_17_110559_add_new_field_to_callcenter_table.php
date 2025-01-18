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
        Schema::table('callcenter', function (Blueprint $table) {
            $table->bigInteger('c_isdeleted')->after('Status'); // Corrected the syntax
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('callcenter', function (Blueprint $table) {
            $table->dropColumn('c_isdeleted'); // Added dropColumn for rollback
        });
    }
};
