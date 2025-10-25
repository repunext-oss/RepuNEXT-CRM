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
        Schema::table('messages', function (Blueprint $table) {
            // Add columns only if they don't exist
            if (!Schema::hasColumn('messages', 'attachment')) {
                $table->string('attachment')->nullable()->after('message');
            }
            if (!Schema::hasColumn('messages', 'attachment_type')) {
                $table->string('attachment_type')->nullable()->after('attachment');
            }
            if (!Schema::hasColumn('messages', 'is_deleted')) {
                $table->boolean('is_deleted')->default(false)->after('attachment_type');
            }
            if (!Schema::hasColumn('messages', 'reply_to_message_id')) {
                $table->unsignedBigInteger('reply_to_message_id')->nullable()->after('is_deleted');
            }
        });
        
        // Add foreign key constraint if reply_to_message_id column exists
        if (Schema::hasColumn('messages', 'reply_to_message_id')) {
            Schema::table('messages', function (Blueprint $table) {
                try {
                    $table->foreign('reply_to_message_id')->references('id')->on('messages')->onDelete('set null');
                } catch (Exception $e) {
                    // Foreign key might already exist
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop foreign key first
            try {
                $table->dropForeign(['reply_to_message_id']);
            } catch (Exception $e) {
                // Foreign key might not exist
            }
            
            // Drop columns if they exist
            if (Schema::hasColumn('messages', 'attachment')) {
                $table->dropColumn('attachment');
            }
            if (Schema::hasColumn('messages', 'attachment_type')) {
                $table->dropColumn('attachment_type');
            }
            if (Schema::hasColumn('messages', 'is_deleted')) {
                $table->dropColumn('is_deleted');
            }
            if (Schema::hasColumn('messages', 'reply_to_message_id')) {
                $table->dropColumn('reply_to_message_id');
            }
        });
    }
};
