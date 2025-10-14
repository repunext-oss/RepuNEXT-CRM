<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        if (Schema::hasTable('revenues') && ! Schema::hasColumn('revenues', 'website_name')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->string('website_name', 191)->nullable()->after('amount');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('revenues') && Schema::hasColumn('revenues', 'website_name')) {
            Schema::table('revenues', function (Blueprint $table) {
                $table->dropColumn('website_name');
            });
        }
    }
};
