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
        Schema::table('trans_orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('customer_id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->text('customer_address')->nullable()->after('customer_phone');
            $table->boolean('is_new_member')->default(false)->after('customer_address');
            $table->double('subtotal', 10, 2)->default(0)->after('payment_status');
            $table->integer('discount_percent')->nullable()->after('subtotal');
            $table->double('discount_nominal', 10, 2)->default(0)->after('discount_percent');
            $table->string('voucher_code')->nullable()->after('discount_nominal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trans_orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name', 
                'customer_phone', 
                'customer_address', 
                'is_new_member', 
                'subtotal', 
                'discount_percent', 
                'discount_nominal', 
                'voucher_code'
            ]);
        });
    }
};
