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
        Schema::table('rooms', function (Blueprint $table) {
            // Add columns only if they don't exist
            if (!Schema::hasColumn('rooms', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('rooms', 'room_type')) {
                $table->enum('room_type', ['general', 'project', 'department'])->default('general')->after('description');
            }
            if (!Schema::hasColumn('rooms', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('room_type');
            }
            if (!Schema::hasColumn('rooms', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('created_by');
            }
            if (!Schema::hasColumn('rooms', 'r_isdeleted')) {
                $table->boolean('r_isdeleted')->default(false)->after('is_active');
            }
        });
        
        // Add foreign key constraint if created_by column exists
        if (Schema::hasColumn('rooms', 'created_by')) {
            Schema::table('rooms', function (Blueprint $table) {
                try {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::table('rooms', function (Blueprint $table) {
            // Drop foreign key first
            try {
                $table->dropForeign(['created_by']);
            } catch (Exception $e) {
                // Foreign key might not exist
            }
            
            // Drop columns if they exist
            if (Schema::hasColumn('rooms', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('rooms', 'room_type')) {
                $table->dropColumn('room_type');
            }
            if (Schema::hasColumn('rooms', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('rooms', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('rooms', 'r_isdeleted')) {
                $table->dropColumn('r_isdeleted');
            }
        });
    }
};
