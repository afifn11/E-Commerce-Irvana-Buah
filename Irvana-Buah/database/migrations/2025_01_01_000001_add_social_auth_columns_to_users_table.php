<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Password nullable supaya user yg daftar via OAuth tidak wajib punya password
            $table->string('password')->nullable()->change();

            // Kolom OAuth
            $table->string('google_id')->nullable()->unique()->after('address');
            $table->string('avatar')->nullable()->after('google_id'); // foto profil dari OAuth
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();
            $table->dropColumn(['google_id', 'avatar']);
        });
    }
};
