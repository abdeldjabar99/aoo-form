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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('advance')->default(false); // Do you have an advance?
            $table->boolean('murabaha_purchase')->default(false); // Do you have a purchase in Islamic Murabaha?
            $table->string('management')->nullable();
            $table->string('department')->nullable();
            $table->string('workplace')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['advance', 'murabaha_purchase', 'management', 'department', 'workplace']);
        });
    }
};
