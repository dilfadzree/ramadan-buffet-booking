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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->default(0)->after('total_pax');
            $table->string('payment_status')->default('unpaid')->after('status');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->string('transaction_id')->nullable()->after('payment_method');
            $table->string('senangpay_reference')->nullable()->after('transaction_id');
            $table->timestamp('paid_at')->nullable()->after('senangpay_reference');

            $table->index('payment_status');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'total_amount',
                'payment_status',
                'payment_method',
                'transaction_id',
                'senangpay_reference',
                'paid_at',
            ]);
        });
    }
};
