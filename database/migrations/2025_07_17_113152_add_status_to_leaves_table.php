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
        $table->string('status')->default('pending');  // Adding the status column with a default value
    });
}

public function down()
{
    Schema::table('leaves', function (Blueprint $table) {
        $table->dropColumn('status');  // Drop status column if the migration is rolled back
    });
}
};
