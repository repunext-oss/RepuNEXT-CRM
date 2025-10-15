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
            // Add r_name column if it doesn't exist
            if (!Schema::hasColumn('revenues', 'r_name')) {
                $table->string('r_name')->nullable()->after('id');
            }
            // Add payment method column
            $table->string('payment_method')->nullable()->after('subcategory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropColumn(['payment_method']);
            // Don't drop r_name as it might be used elsewhere
        });
    }
};
