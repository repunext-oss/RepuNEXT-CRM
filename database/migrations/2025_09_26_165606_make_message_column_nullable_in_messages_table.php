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
<<<<<<<< HEAD:database/migrations/2025_10_16_100136_add_entry_date_to_revenues_table.php
        Schema::table('revenues', function (Blueprint $table) {
            $table->date('entry_date')->nullable()->after('payment_method');
========
        Schema::table('messages', function (Blueprint $table) {
            $table->text('message')->nullable()->change();
>>>>>>>> arvindkumar:database/migrations/2025_09_26_165606_make_message_column_nullable_in_messages_table.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2025_10_16_100136_add_entry_date_to_revenues_table.php
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropColumn('entry_date');
========
        Schema::table('messages', function (Blueprint $table) {
            $table->text('message')->nullable(false)->change();
>>>>>>>> arvindkumar:database/migrations/2025_09_26_165606_make_message_column_nullable_in_messages_table.php
        });
    }
};