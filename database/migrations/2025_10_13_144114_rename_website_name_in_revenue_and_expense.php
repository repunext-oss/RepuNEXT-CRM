<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        // --- revenues: website_name -> r_name ---
        if (Schema::hasTable('revenues')) {
            Schema::table('revenues', function (Blueprint $table) {
                if (Schema::hasColumn('revenues', 'website_name') && ! Schema::hasColumn('revenues', 'r_name')) {
                    // rename column
                    $table->renameColumn('website_name', 'r_name');
                } elseif (! Schema::hasColumn('revenues', 'r_name')) {
                    // fallback: create if it never existed
                    $table->string('r_name', 191)->nullable()->after('amount');
                }
            });
        }

        // --- expense: website_name -> e_name ---
        if (Schema::hasTable('expense')) {
            Schema::table('expense', function (Blueprint $table) {
                if (Schema::hasColumn('expense', 'website_name') && ! Schema::hasColumn('expense', 'e_name')) {
                    $table->renameColumn('website_name', 'e_name');
                } elseif (! Schema::hasColumn('expense', 'e_name')) {
                    $table->string('e_name', 191)->nullable()->after('amount');
                }
            });
        }
    }

    public function down(): void
    {
        // reverse revenues r_name -> website_name
        if (Schema::hasTable('revenues')) {
            Schema::table('revenues', function (Blueprint $table) {
                if (Schema::hasColumn('revenues', 'r_name') && ! Schema::hasColumn('revenues', 'website_name')) {
                    $table->renameColumn('r_name', 'website_name');
                }
            });
        }

        // reverse expense e_name -> website_name
        if (Schema::hasTable('expense')) {
            Schema::table('expense', function (Blueprint $table) {
                if (Schema::hasColumn('expense', 'e_name') && ! Schema::hasColumn('expense', 'website_name')) {
                    $table->renameColumn('e_name', 'website_name');
                }
            });
        }
    }
};
