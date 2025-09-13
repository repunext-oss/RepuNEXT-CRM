<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('leaves', function (Blueprint $table) {
        $table->text('reasons')->nullable();  // Add the reason column for rejection reason
    });
}

public function down()
{
    Schema::table('leaves', function (Blueprint $table) {
        $table->dropColumn('reasons');  // Drop reason column if the migration is rolled back
    });
}
};
