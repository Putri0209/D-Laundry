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
        Schema::create('trans_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete()->nullable();
            $table->string('order_code')->unique();
            $table->date('order_date');
            $table->date('order_end_date');
            $table->tinyInteger('order_status');
            $table->double('order_pay',10,2);
            $table->double('order_change',10,2);
            $table->double('tax',10,2);
            $table->double('total',10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_orders');
    }
};
