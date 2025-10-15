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
        Schema::table('expense', function (Blueprint $table) {
            // Add e_name column if it doesn't exist
            if (!Schema::hasColumn('expense', 'e_name')) {
                $table->string('e_name')->nullable()->after('id');
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
        Schema::table('expense', function (Blueprint $table) {
            $table->dropColumn(['payment_method']);
            // Don't drop e_name as it might be used elsewhere
        });
    }
};
