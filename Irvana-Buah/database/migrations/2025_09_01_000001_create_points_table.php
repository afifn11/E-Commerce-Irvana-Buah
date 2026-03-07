<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('balance')->default(0); // current total
            $table->timestamps();
            $table->unique('user_id');
        });

        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('amount');        // + earn, - redeem
            $table->string('type');           // earn_order, redeem_coupon, bonus, expire
            $table->string('description');
            $table->nullableMorphs('reference'); // polymorphic: order, coupon, etc
            $table->integer('balance_after');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('point_transactions');
        Schema::dropIfExists('user_points');
    }
};
