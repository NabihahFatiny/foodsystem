<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('delivery_address')->nullable()->after('customer_name');
            $table->string('phone', 20)->nullable()->after('delivery_address');
            $table->unsignedBigInteger('user_id')->nullable()->after('phone');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        // Allow more status values (preparing, out_for_delivery, cancelled)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(30) NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['delivery_address', 'phone', 'user_id']);
        });
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'delivered') NOT NULL DEFAULT 'pending'");
    }
};
