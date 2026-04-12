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
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('is_invalid_address')->default(false)->after('is_active');
        });

        Schema::table('tutors', function (Blueprint $table) {
            $table->boolean('is_invalid_address')->default(false)->after('is_visible');
        });

        Schema::table('vip_addresses', function (Blueprint $table) {
            $table->boolean('is_invalid_address')->default(false)->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('is_invalid_address');
        });

        Schema::table('tutors', function (Blueprint $table) {
            $table->dropColumn('is_invalid_address');
        });

        Schema::table('vip_addresses', function (Blueprint $table) {
            $table->dropColumn('is_invalid_address');
        });
    }
};
