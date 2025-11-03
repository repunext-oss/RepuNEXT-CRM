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
        Schema::table('revenues', function (Blueprint $table) {
    
            $table->date('entry_date')->nullable()->after('payment_method');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->text('message')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('revenues', function (Blueprint $table) {
            $table->dropColumn('entry_date');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->text('message')->nullable(false)->change();

        });
    }
};