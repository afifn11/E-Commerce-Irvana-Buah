<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('midtrans_snap_token')->nullable()->after('discount_amount');
            $table->string('midtrans_transaction_id')->nullable()->after('midtrans_snap_token');
            $table->integer('points_earned')->default(0)->after('midtrans_transaction_id');
            $table->integer('points_redeemed')->default(0)->after('points_earned');
        });
    }
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['midtrans_snap_token','midtrans_transaction_id','points_earned','points_redeemed']);
        });
    }
};
